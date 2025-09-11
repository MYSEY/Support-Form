<?php

namespace App\Exports;

use App\Models\Maintenance;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\MaintenanceStatus;
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

class MaintenanceDownloadExport implements FromCollection,WithColumnWidths, WithHeadings,WithCustomStartCell,WithEvents
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
        $query = Maintenance::with('maintenanceDetail')->leftJoin('assets', 'maintenances.asset_id', '=', 'assets.id')
            ->leftJoin('categories', 'assets.category_id', '=', 'categories.id')
            ->leftJoin('rooms', 'maintenances.location', '=', 'rooms.id')
            ->leftJoin('maintenance_details', 'maintenances.id', '=', 'maintenance_details.maintenance_id')
            ->leftJoin('branchs', 'maintenances.office', '=', 'branchs.id')
            ->leftJoin('db_hr-production.users as users', 'maintenances.end_user', '=', 'users.id')
            ->leftJoin('db_hr-production.positions as positions', 'users.position_id', '=', 'positions.id') // ✅ use full db name
            ->select(
                'maintenances.*',
                'assets.serial',
                'branchs.abbreviations',
                'users.employee_name_en',
                'users.number_employee',
                'categories.name as category_name',
                'rooms.name as location_name',
                'users.employee_name_en as end_user',
                'positions.name_english as postion_name',
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
            $query->whereBetween('maintenances.maintenance_date', [$from_date, Carbon::parse($to_date)->endOfDay()]);
        }

        $data = $query->groupBy('maintenances.id')->get();
        $i = 0;
        $dataExport = []; 
        foreach ($data as $key => $value) {
            // Clean notes
            $i++;
            $this->num = $i;
            $statusMap = MaintenanceStatus::pluck('name', 'id')->toArray();

            $minStatus = $value->maintenanceDetail->max('status'); // should return 2, 3, etc.
            $statusText = $minStatus ? ($statusMap[$minStatus] ?? null) : null;

            $dataExport[] = [
                "reference" => (string)($value->reference),
                "office" => $value->abbreviations,
                "maintenance_date" => $value->maintenance_date,
                "MTechnicain" => $value->number_employee,
                "serial" => $value->serial,
                "category_name" => $value->category_name,
                "device_name" => $value->device_name,
                "location_name" => $value->location_name,
                "end_user" => $value->end_user,
                "postion_name" => $value->postion_name,
                "comment" => trim(strip_tags($value->description)),
                "status"    => $statusText
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
            'Mreference',
            'Office',
            'Mdate',
            'MTechnicain',
            'Serial',
            'Item',
            'Device Name',
            'Location',
            'End User',
            'Postion',
            'Comments',
            'Status',
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'M' => 20,
        ];
    }
    public function startCell(): string
    {
        return 'A1';
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
              
            },
        ];
    }
}
