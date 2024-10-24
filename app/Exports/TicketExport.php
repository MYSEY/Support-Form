<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
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
    protected $export_datas;
    
    public function __construct($request)
    {
        $dataExport = [];
        $from_date = null;
        $to_date = null;
        if ($request->from_date || $request->to_date) {
            $from_date = Carbon::createFromDate($request->from_date)->format('Y-m-d H:i:s'); //2023-05-09 00:00:00
            $to_date = Carbon::createFromDate($request->to_date.' '.'23:59:59')->format('Y-m-d H:i:s'); //2023-05-09 23:59:59
        }
        $data = Ticket::
        with("fromDepartment")
        ->with("department")
        ->with("branch")->with("lastReplier")
        ->with("CustomStatus")->with("assignedBy")
        ->with("priorities")->with("createdBy")
        ->with("issueType")->with("assignedTo")
        ->when($request->tracking_id, function ($query, $tracking_id) {
            $query->where('trackid', $tracking_id);
        })
        ->when($request->name, function ($query, $name) {
            $query->where('name', $name);
        })
        ->when($request->priority, function ($query, $priority) {
            $query->where('priority', $priority);
        })
        ->when($from_date, function ($query, $from_date) {
            $query->where('dt', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            $query->where('dt','<=', $to_date);
        })
        ->when($request->status, function ($query, $status) {
            $query->whereIn('status', $status);
        })
        ->when(Auth::user()->RolePermission, function($query, $RolePermission){
            if ($RolePermission=='staff') {
                $query->where("created_by", Auth::user()->id);
            }else if($RolePermission=='admin_support'){
                $query->where('department_id', Auth::user()->department_id)
                ->orWhere("created_by", Auth::user()->id)
                ->orWhere("owner", Auth::user()->id);
            }else if($RolePermission=='admin'){
                $query->where('department_id', Auth::user()->department_id)
                ->orWhere('department_id_from', Auth::user()->department_id);
            }else if($RolePermission=="admin_branch"){
                $query->where('branch_id', Auth::user()->branch_id);
            }
        })->orderBy('id','DESC')->get();

        foreach ($data as $key=>$value) {
            $ticket_type = "Normal";
            if ($value->ticket_type == 1) {
                $ticket_type = "Specail Case";
            };
            $from_department_branch = ($value->fromDepartment ? $value->fromDepartment->name_english : "").($value->branch ? $value->branch->branch_name_en : "");
            $dataExport[] = [
                "id"                        => $key+1,
                "trackid"                   => $value->trackid,
                "submitted"                 => $value->created_at,
                "from_department_branch"    => $from_department_branch,
                "create_by"                 => $value->name, 
                'to_department'             => ($value->department ? $value->department->name_english: ""),
                "subject"                   => $value->subject,
                "status"                    => $value->CustomStatus->name,
                'ticket_type'               => $ticket_type,
                "issue_type"                => ($value->issueType ? $value->issueType->name : ""),
                "Priority"                  => ($value->priorities ? $value->priorities->name : ""),
                'assigned'                  => ($value->assignedTo ? $value->assignedTo->name : $value->owner),
                'aast_replier'              => ($value->lastReplier ? $value->lastReplier->name : $value->name),
                'due_date'                  => $value->due_date,
                "close_date"                => $value->closedat,
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
            'Submitted',
            'From Department/Branch',
            'Create By',
            'To Department',
            'Subjesct',
            'Status',
            'Ticket Type',
            'Sub Issue Type',
            'Priority',
            'Assigned',
            'Last Replier',
            'Due Date',
            'Close Date'
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
            'M' => 10,
            'N' => 10,
            'O' => 10,
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
                $event->sheet->getStyle('A5:O5')->applyFromArray([
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
                        $event->sheet->getStyle('A'.$n.':O'.$n)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                    }
                }
                $event->sheet->getStyle('A'.$rows.':O'.$rows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getDelegate()->getStyle('A6:O5')->getFont()->getColor()->setARGB('3923A9');
                $sheet->getDelegate()->getStyle('A6:O5')->getFont()->setSize(9)->setName('Khmer OS Battambang')->setSize(9);
                $event->sheet->getDelegate()->getStyle('A6:O5')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);


                $sheet->mergeCells('A2:O2');
                $sheet->setCellValue('A2', "ខេមា​ មីក្រូហិរញ្ញវត្ថុ លីមីតធីត");
                $sheet->getDelegate()->getStyle('A2:O2')->getFont()->setName('Khmer OS Muol Light')
                ->setSize(12)->setUnderline('A2:O2');
                $event->sheet->getDelegate()->getStyle('A2:O2')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:O3');
                $sheet->setCellValue('A3', "Ticket Summay IT Helpdesk");
                $sheet->getDelegate()->getStyle('A3:O3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:L3');
                $event->sheet->getDelegate()->getStyle('A3:O3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('d-M-Y');
                $sheet->mergeCells('A4:O4');
                $sheet->setCellValue('A4',"As of :" .$month);
                $sheet->getDelegate()->getStyle('A4:O4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:O4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                //footer
                $sheet->mergeCells('A'.$rows.':O'.$rows);
                $sheet->getDelegate()->getStyle("A".$rows.':O'.$rows)->getFont()->setName('Khmer OS Muol Light')->setSize(9);
                $event->sheet->getDelegate()->getStyle("A".$rows.':O'.$rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            },
        ];
    }
}
