<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

class TicketExport implements FromCollection, WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
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
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $query = Ticket::with([
            'fromDepartment',
            'department',
            'branch',
            'lastReplier',
            'CustomStatus',
            'assignedBy',
            'priorities',
            'createdBy',
            'issueType',
            'assignedTo'
        ])->when($request->tracking_id, function ($query, $tracking_id) {
            $query->where('trackid', $tracking_id);
        })->when($request->name, function ($query, $name) {
            $query->where('name', $name);
        })->when($request->priority, function ($query, $priority) {
            $query->where('priority', $priority);
        })->when($request->status, function ($query, $status) {
            $query->whereIn('status', $status);
        });
        if ($from_date && $to_date) {
            $query->whereBetween('tickets.updated_at',  [$from_date, Carbon::parse($to_date)->endOfDay()]);
        }
        
        if (Auth::user()->RolePermission == 'Staff') {
            $query->where('tickets.created_by',Auth::user()->id);
        }
        if (Auth::user()->RolePermission == 'admin_branch') {
            $query->where('tickets.branch_id', Auth::user()->branch_id);
        }
        $data = $query->orderBy('id', 'DESC')->get();
        
        $i = 0;
        foreach ($data as $key=>$value) {
            $i++;
            $this->num = $i;
            $this->submittedDate = $value->dt;
            $ticket_type = "Normal";
            if ($value->ticket_type == 1) {
                $ticket_type = "Specail Case";
            };
            $from_department_branch = ($value->fromDepartment ? $value->fromDepartment->name_english : "").($value->branch ? $value->branch->branch_name_en : "");
            $dataExport[] = [
                "id"                        => $key+1,
                "trackid"                   => $value->trackid,
                "submitted"                 => $value->dt,
                "from_department_branch"    => $from_department_branch,
                "create_by"                 => $value->name, 
                'to_department'             => ($value->department ? $value->department->name_english: ""),
                "subject"                   => $value->subject,
                "status"                    => $value->CustomStatus->name,
                'ticket_type'               => $ticket_type,

                "issue_type"                => ($value->issueType ? $value->issueType->name : ""),
                "Classification"            => ($value->issueType?->Classification?->name ?? ""),

                "Priority"                  => ($value->priorities ? $value->priorities->name : ""),
                'assigned'                  => ($value->assignedTo ? $value->assignedTo->name : $value->owner),
                'aast_replier'              => ($value->lastReplier ? $value->lastReplier->name : $value->name),
                'due_date'                  => $value->due_date,
                "close_date"                => $value->updated_at,
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
            'Tracking ID',
            'Submitted Date',
            'From Department/Branch',
            'Create By',
            'To Department',
            'Subjesct',
            'Status',
            'Ticket Type',
            'Sub Issue Type',
            'Classification',
            'Priority',
            'Assigned',
            'Last Replier',
            'Ticket Due Date',
            'Close Date'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 10,
            'C' => 20,
            'D' => 20,
            'E' => 26,
            'F' => 14,
            'G' => 30,
            'H' => 10,
            'I' => 17,
            'J' => 30,
            'K' => 30,
            'L' => 10,
            'M' => 15,
            'N' => 15,
            'O' => 18,
            'P' => 18,
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
                $event->sheet->getStyle('A5:P5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':P'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':P'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getDelegate()->getStyle('A5:P5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A5:P5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A5:O5')->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:P2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:P2')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A2:P2')->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:P2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:P3');
                $sheet->setCellValue('A3', "Ticket Summay IT Helpdesk");
                $sheet->getDelegate()->getStyle('A3:P3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:M3');
                $event->sheet->getDelegate()->getStyle('A3:P3')->getAlignment()->setWrapText(true)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::parse($this->submittedDate)->format('d-M-Y');
                $sheet->mergeCells('A4:P4');
                $sheet->setCellValue('A4',"As of :" .$month);
                $sheet->getDelegate()->getStyle('A4:P4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:P4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
