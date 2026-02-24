<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StaffResign implements FromCollection, WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    protected $export_datas;
    public function __construct($datas)
    {
        $dataExport = [];
        foreach ($datas as $key=>$value) {
            $dataExport[] = [
                "id"                      => $key+1,
                "number_employee"         => $value->number_employee,
                "name_kh"                 => ($value->employee_name_kh ),
                "name_en"                 => ($value->employee_name_en),
                'position_KH'             => ($value->name_khmer),
                'position_En'             => ($value->name_english),
                'location'                => ($value->abbreviations),
                'department'              => ($value->depart_name),
                'resign_date'             => ($value->resign_date)
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
            'StaffID',
            'Name_KH',
            'Name_En',
            'Position_KH',
            'Position_En',
            'Location',
            'Department',
            'Resign_Date',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 10,
            'C' => 15,
            'D' => 15,
            'E' => 30,
            'F' => 30,
            'G' => 10,
            'H' => 30,
            'I' => 20,
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

                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');
                $event->sheet->getStyle('A5:I5')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $n=5;
                if (count($this->export_datas) > 0) {
                    foreach ($this->export_datas as $key=>$value) {
                        $n++;
                        $event->sheet->getStyle('A'.$n.':I'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }

                $sheet->getDelegate()->getStyle('A6:I5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A6:I5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A6:I5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);


                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:I2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:I2');
                $event->sheet->getDelegate()->getStyle('A2:I2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:I3');
                $sheet->setCellValue('A3', "Staff Resigned");
                $sheet->getDelegate()->getStyle('A3:I3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:I3');
                $event->sheet->getDelegate()->getStyle('A3:I3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('d-M-Y');
                $sheet->mergeCells('A4:I4');
                $sheet->setCellValue('A4',"As of :" .$month);
                $sheet->getDelegate()->getStyle('A4:I4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
