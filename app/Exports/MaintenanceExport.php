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
    protected $from_date;
    protected $to_date;
    protected $staffName;
    protected $serial;
    protected $office;

    public function __construct($request)
    {
        $this->serial = $request->serial;
        $this->office = $request->office;
        $this->staffName = $request->staff_name;
        $this->from_date = $request->from_date;
        $this->to_date = $request->to_date;

        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromDate($request->to_date)->format('Y-m-d');
        }
        $query = Maintenance::leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
        ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('maintenance_details', 'maintenances.id', '=', 'maintenance_details.maintenance_id')
        ->leftJoin('branchs', 'maintenances.office', '=', 'branchs.id')
        ->leftJoin('db_hr-production.users', 'maintenances.end_user', '=', 'db_hr-production.users.id')
        ->select(
            'maintenances.*',
            'assets.serial',
            'branchs.branch_name_en',
            'users.employee_name_kh',
            'users.employee_name_en',
            // DB::raw('GROUP_CONCAT(DISTINCT maintenance_details.note SEPARATOR ", ") as notes') // Merge notes
        )
        ->whereNull('maintenances.deleted_at')
        ->when($request->serial, function ($query, $serial) {
            return $query->where('assets.serial', $serial);
        })
        ->when($request->office, function ($query, $office) {
            return $query->where('maintenances.office', $office);
        })
        ->when($request->staff_name, function ($query, $staff_name) {
            return $query->where('users.employee_name_en', 'LIKE', "%{$staff_name}%");
        });
        
        if ($from_date && $to_date) {
            $query->whereBetween('maintenances.maintenance_date',  [$from_date, Carbon::parse($to_date)->endOfDay()]);
        }

        $data = $query->groupBy('maintenances.id')->get();

        $i = 0;
        $dataExport = []; 
        foreach ($data as $key => $value) {
            // Clean notes
            $maintenance_date = $value->maintenance_date;
            $office = $value->branch_name_en;
            $end_user = $value->employee_name_en;
            $cleanedDescription = $value->description;
            $maintenanceText = "Name".':'.$end_user.', '.'Office'.':'.$office.', '.'Maintenance Date'.':'.$maintenance_date.', '.'Maintenanced By'.':'. $value->maintenace_by;
            $i++;
            $this->num = $i;
            $dataExport[] = [
                "id" => $key + 1,
                "serial" => $value->serial . ($maintenanceText ? "\n" . $maintenanceText : ''),
                "description" => !empty($cleanedDescription) ? $cleanedDescription : 'N/A'
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
            'B' => 50,
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
                $sheet->getDelegate()->getStyle('A2:C2')->getFont()->setName('Khmer OS Muol Light')->setSize(14)->setUnderline('A2:C2')->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:C2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:C3');
                $sheet->setCellValue('A3', "Maintainance Report");
                $sheet->getDelegate()->getStyle('A3:C3')->getFont()->setName('Khmer OS Muol Light')->setSize(14)->setUnderline('A3:L3');
                $event->sheet->getDelegate()->getStyle('A3:C3')->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                if (!empty($this->from_date)) {
                    // If maintenance date is set
                    $sheet->setCellValue('B4',"From Date:" .' '. Carbon::parse($this->from_date)->format('d-M-Y') .' '.'To Date:' .' '. Carbon::parse($this->to_date)->format('d-M-Y'));
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
                    $sheet->setCellValue('B4',"Maintanance Report All Data");
                }
                $sheet->getDelegate()->getStyle('B4:C4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('B4:C4');
                //Fooder
                $lastRow = $sheet->getHighestRow();
                // Add signature table
                $sheet->setCellValue('B'.($lastRow+2), 'Acknowledged by:');
                $sheet->setCellValue('C'.($lastRow+2), 'Prepared By:');
                // Add date cells
                $sheet->setCellValue('B'.($lastRow+6), 'Date:'.' '.Carbon::parse()->format('d-M-Y'));
                $sheet->setCellValue('C'.($lastRow+6), 'Date:'.' '.Carbon::parse()->format('d-M-Y'));
            },
        ];
    }
}
