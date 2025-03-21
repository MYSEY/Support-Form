@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Employee
                </h2>
            </div>
            
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>StaffID</th>
                                <th>Name_in_KH</th>
                                <th>Name_in_Eng</th>
                                <th>Gender</th>
                                <th>Position_in_KH</th>
                                <th>Position_in_Eng</th>
                                <th>Duty_Station</th>
                                <th>Department</th>
                                <th>Date_of_Employment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->number_employee}}</td>
                                        <td>{{$item->employee_name_kh}}</td>
                                        <td>{{$item->employee_name_en}}</td>
                                        <td>{{$item->gender}}</td>
                                        <td>{{$item->name_khmer}}</td>
                                        <td>{{$item->name_english}}</td>
                                        <td>{{$item->abbreviations}}</td>
                                        <td>{{$item->depart_name}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->date_of_commencement)->format('d-M-Y') ?? ''}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    @include('includs.datatable_basic')
@endsection
