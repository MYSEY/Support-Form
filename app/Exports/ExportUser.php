<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportUser implements FromCollection, WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $num;
    protected $export_datas;
    
    public function __construct($request)
    {
        $query = DB::table('users')
            ->leftJoin('departments','users.department_id','=','departments.id')
            ->leftJoin('branchs','users.branch_id','=','branchs.id')
            ->leftJoin('roles','users.role_id','=','roles.id')
            ->leftJoin('users as created_by_user', 'users.created_by', '=', 'created_by_user.id')
            ->leftJoin('users as updated_by_user', 'users.updated_by', '=', 'updated_by_user.id')
            ->select(
                'users.*',
                'departments.name_khmer',
                'departments.name_english',
                'branchs.branch_name_en',
                'branchs.branch_name_kh',
                'roles.name as role_name',
                'created_by_user.name as created_by_name',
                'updated_by_user.name as updated_by_name',
            )->when($request->department_id, function ($query, $department_id) {
                $query->where('users.department_id', $department_id);
            })->when($request->branch_id, function ($query, $branch_id) {
                $query->where('users.branch_id', $branch_id);
            });

            // Apply additional filtering for role
            if (Auth::user()->RolePermission=='staff') {
                $query->where("users.id", Auth::user()->id);
            }else if(Auth::user()->RolePermission=='admin_support' || Auth::user()->RolePermission=='admin'){
                $query->where('users.department_id', Auth::user()->department_id);
            }else if(Auth::user()->RolePermission=="admin_branch"){
                $query->where('users.branch_id', Auth::user()->branch_id);
            }
            $data = $query->orderBy('id','DESC')->get();
        $dataExport = [];
        foreach ($data as $key=>$value) {

            $dataExport[] = [
                "id"                        => $key+1,
                "name"                      => $value->name,
                "user_name"                 => ($value->user ? $value->user : ""),
                "role"                      => ($value->role_name ? $value->role_name : ""),
                'Department'                => ($value->name_english ? $value->name_english : ""),
                'Branch'                    => ($value->branch_name_en ? $value->branch_name_en : ""),
                'Created By'                => ($value->created_by_name ? $value->created_by_name : ""),
                'Created At'                => ($value->created_at ? $value->created_at : ""),
                'Updated By'                => ($value->updated_by_name ? $value->updated_by_name : ""),
                'Updated At'                => ($value->updated_at ? $value->updated_at : ""),
                'Status'                    => ($value->status ? $value->status : ""),
                'Email'                     => ($value->email ? $value->email : ""),
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
            'Name',
            'User Name',
            'Role',
            'Department',
            'Branch',
            'Created By',
            'Created At',
            'Updated By',
            'Updated At',
            'Status',
            'Email',
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
                $sheet->setCellValue('A3', "User Support Form");
                $sheet->getDelegate()->getStyle('A3:L3')->getFont()->setName('Khmer OS Muol Light')->setSize(12)->setUnderline('A3:L3');
                $event->sheet->getDelegate()->getStyle('A3:L3')->getAlignment()
                ->setWrapText(true)
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $month = Carbon::now()->format('d-M-Y');
                $sheet->mergeCells('A4:L4');
                $sheet->setCellValue('A4',"As of :" .$month);
                $sheet->getDelegate()->getStyle('A4:L4')->getFont()->setSize(9)->setName('Khmer OS Fasthand')->setSize(10);
                $event->sheet->getDelegate()->getStyle('A4:L4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
