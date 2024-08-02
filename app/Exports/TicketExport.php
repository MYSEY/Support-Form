<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class TicketExport implements FromCollection, WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $num;
    
    public function __construct($request)
    {
        $dataExport = [];
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $data = DB::table('tickets')
        ->select(
            'tickets.*'
        )
        ->when($request->tracking_id, function ($query, $tracking_id) {
            $query->where('tickets.trackid', $tracking_id);
        })
        ->when($request->name, function ($query, $name) {
            $query->where('tickets.name', $name);
        })
        ->when($request->priority, function ($query, $priority) {
            $query->where('tickets.priority', $priority);
        })
        ->when($from_date, function ($query, $from_date) {
            $query->where('tickets.dt', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('tickets.dt','<=', $to_date);
        })
        ->when($request->status, function ($query, $status) {
            $query->whereIn('tickets.status', $status);
        })->OrderBy('id','DESC')->get();

        foreach ($data as $key=>$value) {
            $dataExport[] = [
                "id" => $key+1,
                "trackid" => $value->trackid,
                "subject" => $value->subject,
                "Name" => $value->name,
                "Email" => $value->email,
                "Submited Date" => $value->dt,
                "Category" => $value->category,
                "Priority" => $value->priority,
                "Owner" => $value->owner,
                "Issue Type" => $value->custom1,
                "Status" => $value->status,
                "close_date" => $value->closedat,
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
            'Tranking ID',
            'Subject',
            'Name',
            'Email',
            'Submited Date',
            'Category',
            'Priority',
            'Owner',
            'Issue Type',
            'Status',
            'Close Date',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 10,
            'C' => 40,
            'D' => 20,
            'E' => 26,
            'F' => 14,
            'G' => 30,
            'H' => 10,
            'I' => 17,
            'J' => 30,
            'K' => 10,
            'L' => 10,
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

                $event->sheet->getDelegate()->getStyle('A2')->getFont()->getColor()->setARGB('DD4B39');
                $event->sheet->getDelegate()->getStyle('A3')->getFont()->getColor()->setARGB('0000CC');
                $event->sheet->getDelegate()->getStyle('A4')->getFont()->getColor()->setARGB('3923A9');
                $event->sheet->getStyle('A5:L5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':L'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':L'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getDelegate()->getStyle('A6:L5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A6:L5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A6:L5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);


                $sheet->mergeCells('A2:L2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:L2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:L2');
                $event->sheet->getDelegate()->getStyle('A2:L2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:L3');
                $sheet->setCellValue('A3', "Ticket Summay IT Helpdesk");
                $sheet->getDelegate()->getStyle('A3:L3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:L3');
                $event->sheet->getDelegate()->getStyle('A3:L3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('d-M-Y');
                $sheet->mergeCells('A4:L4');
                $sheet->setCellValue('A4',"As of :" .$month);
                $sheet->getDelegate()->getStyle('A4:L4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:L4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                $sheet->mergeCells('A'.$rows.':L'.$rows);
                $sheet->getDelegate()->getStyle("A".$rows.':L'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':L'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
