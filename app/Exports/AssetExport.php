<?php

namespace App\Exports;

use App\Models\Asset;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class AssetExport implements FromCollection, WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $num;
    protected $export_datas;
    protected $submittedDate;
    
    public function __construct($request)
    {
        $dataExport = [];
        $query = Asset::leftJoin('categories', 'assets.category_id', '=', 'categories.id')
        ->leftJoin('rooms', 'assets.location', '=', 'rooms.id')
        ->leftJoin('branchs', 'assets.office', '=', 'branchs.id')
        ->leftJoin('departments', 'assets.department_id', '=', 'departments.id')
        ->leftJoin('db_hr-production.users', 'assets.end_user', '=', 'users.id')
        ->leftJoin('db_hr-production.positions', 'db_hr-production.users.position_id', '=', 'db_hr-production.positions.id')
        ->select(
            'assets.*', 
            'assets.serial',
            'assets.date',
            'assets.device_name',
            'categories.name as category_name',
            'users.number_employee',
            'users.employee_name_kh',
            'users.employee_name_en',
            'positions.name_english',
            'branchs.branch_name_kh',
            'branchs.branch_name_en',
            'rooms.name as location_name',
            'departments.name_english as depart_name',
        )->where('assets.deleted_at',null)
        ->when($request->serial, function ($query, $serial) {
            $query->where('assets.serial', $serial);
        })
        ->when($request->department_id, function ($query, $department_id) {
            $query->where('assets.department_id', $department_id);
        })
        ->when($request->branch_id, function ($query, $branch_id) {
            $query->where('assets.office', $branch_id);
        });
        $data = $query->orderBy('assets.id', 'DESC')->get();
        $i = 0;
        foreach ($data as $key=>$value) {
            $i++;
            $this->num = $i;
            $dataExport[] = [
                "id"    => $key+1,
                "serial"    => $value->serial,
                "Category"  => $value->category_name,
                "Device Name"   => $value->device_name,
                "Office"    => $value->branch_name_en, 
                'Department'    => $value->depart_name,
                "Location"  => $value->location_name,
                "End User"  => $value->employee_name_en,
                'Postion'   => $value->name_english,
                "Asset Date"    => $value->date,
                "Lifecycle(Month)"  => $value->LifecycleMonthDiff,
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
            'Serial',
            'Category',
            'Device Name',
            'Office',
            'Department',
            'Location',
            'End User',
            'Postion',
            'Asset Date',
            'Lifecycle(Month)'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 20,
            'D' => 30,
            'E' => 26,
            'F' => 14,
            'G' => 30,
            'H' => 15,
            'I' => 17,
            'J' => 20,
            'K' => 15
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

                // Insert Logo
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Company Logo');
                $drawing->setPath(public_path('/admins/img/logo/commalogo1.png')); // Change this path to your logo
                $drawing->setHeight(90); // Adjust height

               // Set the column and row to center the logo
                $centerColumn = 'F'; // Adjust based on your sheet width
                $centerRow = 2;
                $drawing->setCoordinates($centerColumn . $centerRow);

                // Adjust offsets to fine-tune centering
                $drawing->setOffsetX(70); // Adjust X Offset
                $drawing->setOffsetY(5); // Adjust Y Offset

                $drawing->setWorksheet($sheet->getDelegate());

                
                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');
                $event->sheet->getStyle('A5:K5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':K'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':K'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getDelegate()->getStyle('A5:K5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:K5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:K5')->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:K2')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A2:K2')->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:K2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
