<?php

namespace App\Exports;

use App\Models\Maintenance;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class MaintenanceExport implements FromCollection,WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $export_datas;
    protected $num;
    protected $maintenance_date;
    protected $staffName;
    protected $serial;
    protected $office;

    public function __construct($request)
    {
        $this->serial = $request->serial;
        $this->office = $request->office;
        $this->staffName = $request->staff_name;
        $maintenance_date = $request->maintenance_date;

        if ($request->maintenance_date) {
            $maintenance_date = Carbon::createFromDate($request->maintenance_date)->format('Y-m-d');
        }
        // $data = Maintenance::leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
        // ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        // ->leftJoin('maintenance_details', 'maintenances.id', '=', 'maintenance_details.maintenance_id')
        // ->select(
        //     'maintenances.*',
        //     'maintenance_details.note',
        //     'assets.serial',
        // )->where('maintenances.deleted_at',null)
        // ->when($request->serial, function ($query, $serial) {
        //     $query->where('assets.serial', $serial);
        // })->when($request->office, function ($query, $office) {
        //     $query->where('branchs.id', $office);
        // })->when($request->staff_name, function ($query, $staff_name) {
        //     return $query->where('users.employee_name_en', 'LIKE', "%{$staff_name}%");
        // })->when($maintenance_date, function ($query, $maintenance_date) {
        //     $query->where('maintenances.maintenance_date', $maintenance_date);
        // })->get();
        
        $data = Maintenance::leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
        ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('maintenance_details', 'maintenances.id', '=', 'maintenance_details.maintenance_id')
        ->select(
            'maintenances.*',
            'assets.serial',
            DB::raw('GROUP_CONCAT(DISTINCT maintenance_details.note SEPARATOR ", ") as notes') // Merge notes
        )
        ->whereNull('maintenances.deleted_at')
        ->when($request->serial, function ($query, $serial) {
            return $query->where('assets.serial', $serial);
        })
        ->when($request->office, function ($query, $office) {
            return $query->where('branchs.id', $office);
        })
        ->when($request->staff_name, function ($query, $staff_name) {
            return $query->where('users.employee_name_en', 'LIKE', "%{$staff_name}%");
        })
        ->when($maintenance_date, function ($query, $maintenance_date) {
            return $query->where('maintenances.maintenance_date', $maintenance_date);
        })->groupBy('maintenances.id')->get();
    
        $i = 0;
        $dataExport = []; 
        foreach ($data as $key=>$value) {
            $cleanedDescription = Str::limit(
                preg_replace(
                    [
                        '/<[^>]*>/',               // Remove all HTML tags
                        '/(\s*\n\s*)+/',           // Handle newlines
                        '/\s*,\s*/',               // Clean up commas
                    ],
                    [
                        ' ',                       // Replace tags with space
                        "\n",                      // Preserve single newline
                        ', ',                      // Proper comma spacing
                    ],
                    $value->description ?? ''
                ),
                255,
                '...' // Add ellipsis if truncated
            );
            $cleanedDescription = trim($cleanedDescription, " ,\n\r\t");
            

            $i++;
            $this->num = $i;
            $dataExport[] = [
                "id"    => $key + 1,
                'serial' => $value->serial . "\n" . $value->notes.', '.'Maintenanced By'.' '.$value->maintenace_by,
                "description" => $cleanedDescription
                // "description" => Str::limit(
                //     preg_replace('/<\/div>\s*<div>/', ', ', strip_tags(html_entity_decode($value->description ?? ''))),
                //     255
                // )
            ];
        }
        $this->export_datas = $dataExport;
    }
 
    public function collection()
    {
        return new Collection([
            $this->export_datas,
        ]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Asset Numbers',
            'Note or Comment',
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 40,
            'C' => 60,
        ];
    }
    public function startCell(): string
    {
        return 'A5';
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $rows = count($this->export_datas) + 5 + 1;
                $event->sheet->getStyle('B6:B' . (5 + $this->num))->getAlignment()->setWrapText(true);

                // Insert Logo
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Company Logo');
                $drawing->setPath(public_path('/admins/img/logo/commalogo1.png')); // Change this path to your logo
                $drawing->setHeight(90); // Adjust height

               // Set the column and row to center the logo
                $centerColumn = 'A'; // Adjust based on your sheet width
                $centerRow = 1;
                $drawing->setCoordinates($centerColumn . $centerRow);

                // Adjust offsets to fine-tune centering
                $drawing->setOffsetX(70); // Adjust X Offset
                $drawing->setOffsetY(5); // Adjust Y Offset
                $drawing->setWorksheet($sheet->getDelegate());

                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');

                $event->sheet->getStyle('A5:C5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $n=5;
                if ($this->num > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':C'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                //Hearder
                $sheet->getDelegate()->getStyle('A5:C5')->getFont()->getColor()->setARGB('000000');
                $sheet->getDelegate()->getStyle('A5:C5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                // $event->sheet->getDelegate()->getStyle('A5:C5');
                $event->sheet->getDelegate()->getStyle('A5:I5')->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:C2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:C2')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A2:C2')->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:C2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:C3');
                $sheet->setCellValue('A3', "Maintainance Report");
                $sheet->getDelegate()->getStyle('A3:C3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:L3');
                $event->sheet->getDelegate()->getStyle('A3:C3')->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // $date = Carbon::parse($this->maintenance_date)->format('d-M-Y');
                if (!empty($this->maintenance_date)) {
                    // If maintenance date is set
                    $sheet->setCellValue('B4',"By Date:" . Carbon::parse($this->maintenance_date)->format('d-M-Y'));
                } elseif (!empty($this->staffName)) {
                    // If staff name is set
                    $sheet->setCellValue('B4',"ByStaff Name:" . $this->staffName);
                } elseif (!empty($this->office)) {
                    // If office is set
                    $sheet->setCellValue('B4',"By Branches or Department:" . $this->office);
                } elseif (!empty($this->serial)) {
                    // If serial number is set
                    $sheet->setCellValue('B4',"By Asset Number:" . $this->serial);
                } else {
                    // If none of the conditions are met, you can add a default value or message
                    $sheet->setCellValue('B4',"No filter applied");
                }
                $sheet->getDelegate()->getStyle('B4:C4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('B4:C4');
                // $sheet->mergeCells('A4:I4');
                // $event->sheet->getDelegate()->getStyle('A4:I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


                $sheet = $event->sheet;
                $lastRow = $sheet->getHighestRow();
                // Add signature table
                $sheet->setCellValue('B'.($lastRow+2), 'Acknowledged by:');
                $sheet->setCellValue('C'.($lastRow+2), 'Prepared By:');
                
                // Add date cells
                $sheet->setCellValue('B'.($lastRow+6), 'Date: 01/01/2025');
                $sheet->setCellValue('C'.($lastRow+6), 'Date: 01/01/2025');
                
                // Style the section
                $sheet->getStyle('A'.($lastRow+3).':C'.($lastRow+8))->applyFromArray([
                    'font' => [
                        'size' => 12,
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ]
                ]);
            },
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Acknowledgment section style
            $sheet->getHighestRow()+1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'left']
            ],
            $sheet->getHighestRow()+4 => [
                'font' => ['size' => 14]
            ],
        ];
    }
}
