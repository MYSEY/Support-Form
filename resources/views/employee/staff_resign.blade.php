@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card mb-2">
            <div class="card-body">
                <div class="row filter-btn float-lg-right">
                    <a href="javascript:void(0)" class="btn btn-outline-success btn-sm waves-effect waves-themed mr-1" id="btn-export" tabindex="0" aria-controls="dt-basic-example" type="button" title="Generate Excel"><span>Excel</span></a>
                    
                </div>
            </div>
        </div>
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Staff Resigned
                </h2>
            </div>
            
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100 tbl-staff_resigns">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>StaffID</th>
                                <th>Name_KH</th>
                                <th>Name_En</th>
                                {{-- <th>Gender</th> --}}
                                <th>Position_KH</th>
                                <th>Position_En</th>
                                <th>Location</th>
                                <th>Department</th>
                                <th>Resign_Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data)>0)
                                @foreach ($data as $key=>$item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->number_employee}}</td>
                                        <td>{{$item->employee_name_kh}}</td>
                                        <td>{{$item->employee_name_en}}</td>
                                        {{-- <td>{{$item->gender}}</td> --}}
                                        <td>{{$item->name_khmer}}</td>
                                        <td>{{$item->name_english}}</td>
                                        <td>{{$item->branch_name_en}}</td>
                                        <td>{{$item->depart_name}}</td>
                                        <td>{{\Carbon\Carbon::parse($item->resign_date)->format('d-M-Y') ?? ''}}</td>
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
    <script>
        $(document).ready(function(){
            $('#btn-export').on('click',function(){
                if ($.fn.DataTable.isDataTable('.tbl-staff_resigns')) {
                    $('.tbl-staff_resigns').DataTable().clear().destroy();
                }
                let query = {};
                var url = "{{URL::to('admin/staff/resign/export')}}?" + $.param(query)
                window.location = url;
            });
        });
    </script>
@endsection
