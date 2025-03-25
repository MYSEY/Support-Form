@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <span><a href="{{url('admin/category')}}"><< Category Detail</a></span>
                    </h2>
                </div>
                
                <div class="panel-container">
                    <div class="panel-content">
                        <div class="row mb-2">
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label class="form-label" for="">Category</label>
                                    <input type="text" name="" class="form-control" id="" value="{{$data->name}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <h3>Hardware</h3>
                                    <table id="tbl_hardware" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($groupedTasks['Hardware']))
                                                @foreach($groupedTasks['Hardware'] as $index => $categoryTask)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $categoryTask->task->name }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">No Hardware tasks found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <h3>Software</h3>
                                    <table id="tbl_software" class="table table-bordered table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($groupedTasks['Software']))
                                                @foreach($groupedTasks['Software'] as $index => $categoryTask)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $categoryTask->task->name }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">No Software tasks found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('includs.datatable_basic')
    <script type="text/javascript">
        
    </script>
@endsection