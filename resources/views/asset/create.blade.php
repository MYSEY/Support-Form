@extends('layouts.admin')
@section('content')
    <style>
        .rating {
            font-size: 24px;
            color: gold; /* Default color of stars */
            display: inline-block;
        }

        .rating .star {
            cursor: pointer;
            float: left;
            font-size: 24px;
            color: #ccc; /* Default color of inactive stars */
        }

        .rating .star:hover,
        .rating .star.active {
            color: gold; /* Color of active stars */
        }
    </style>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Asset Create
                    </h2>
                </div>
                
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row mb-2">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">Serial: <span class="text-danger">*</span></label>
                                    <input type="text" name="Serial" class="form-control required" id="Serial" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">Category: <span class="text-danger">*</span></label>
                                    <select class="select2 custom-select form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($cateagory as $item)
                                            <option value="{{$item->id}}">{{ $item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">Device Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="Serial" class="form-control required" id="Serial" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">Office: <span class="text-danger">*</span></label>
                                    <select class="custom-select form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Select --</option>
                                        {{-- @foreach ($task as $item)
                                            <option value="{{$item->id}}">{{ $item->name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">Location: <span class="text-danger">*</span></label>
                                    <select class="custom-select form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Select --</option>
                                        {{-- @foreach ($task as $item)
                                            <option value="{{$item->id}}">{{ $item->name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">End User: <span class="text-danger">*</span></label>
                                    <select class="custom-select form-control" id="category_id" name="category_id" required>
                                        <option value="">-- Select --</option>
                                        {{-- @foreach ($task as $item)
                                            <option value="{{$item->id}}">{{ $item->name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Serial">date: <span class="text-danger">*</span></label>
                                    <input type="date" name="Serial" class="form-control required" id="Serial" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label" for="Lifecycle">Lifecycle (Month): <span class="text-danger">*</span></label>
                                    <input type="text" name="Lifecycle" class="form-control required" id="Lifecycle" required>
                                </div>
                            </div>
                        </div>
        
                        <div class="text-md-right">
                            <div class="btn-hidden-show">
                                <a class="btn btn-secondary waves-effect waves-themed mt-3 mb-3"  href="{{url('admin/ticket')}}"  type="button">Cancel</a>
                                <button class="btn btn-danger waves-effect waves-themed mt-3 mb-3" id="btn-save" type="button">Submit</button>
                            </div>
                            <input type="hidden" value="{{csrf_token()}}" id="token"/>
                            <div class="btn-loading mt-3" style="display: none">
                                <button  class="btn btn-danger waves-effect waves-themed" type="button" disabled="">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
    </script>
@endsection