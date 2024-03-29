@extends('layouts.app')
@section('content')
    <style>
        .checkbox-success {
            background-color: #cad0cc !important;
            color: red;
        }
    </style>
    <?php $userid = Auth::user()->id; ?>
    @can('delete', \App\Models\OrganizationCompanies::class)

            <div class="section">
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/"><i class="fe fe-life-buoy mr-1"></i>&nbsp {{trans('app.Mahsulot navi')}}
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="clearfix"></div>
                @if(session('message'))
                    <div class="row massage">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-success text-center">
                                <label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data')}} </label>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="panel panel-primary">
                                    <div class="tab_wrapper page-tab">
                                        <ul class="tab_list">
                                            <li>
                                                <a href="{!! url('/nds/list' )!!}">
                                                    <span class="visible-xs"></span>
                                                    <i class="fa fa-list fa-lg">&nbsp;</i>
                                                    {{ trans('app.Ro\'yxat')}}
                                                </a>
                                            </li>
                                            <li class="active">
                                                <a href="{!! url('/nds/list/edit/'.$editid )!!}">
                                                    <span class="visible-xs"></span>
                                                    <i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
                                                        {{ trans('app.Tahrirlash')}}</b>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form action="update/{{ $nd->id }}" method="post"
                                              enctype="multipart/form-data" data-parsley-validate
                                              class="form-horizontal form-label-left">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="type">{{trans('app.Hujjat turi')}} <label
                                                                class="text-danger">*</label>
                                                        </label>
                                                        <select name="type" class="form-select" required>
                                                            @if(!empty($types))
                                                                @foreach($types as $k => $type)
                                                                    <option
                                                                        value="{{ $k }}" @if(!empty($nd->type_id) && $nd->type_id == $k) selected="selected" @endif
                                                                    >{{ $type }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="number">{{trans('app.Hujjat raqami')}} <label
                                                                class="text-danger">*</label>
                                                        </label>
                                                        <input type="text" required="required" name="number"
                                                               value="{{ $nd->number }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="name">{{trans('app.Hujjat nomi')}} <label
                                                                class="text-danger">*</label>
                                                        </label>
                                                        <input type="text" required="required" name="name"
                                                               class="form-control" value="{{ $nd->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="crop">{{trans('app.Mahsulot turi')}} <label
                                                                class="text-danger">*</label>
                                                        </label>
                                                        <select name="crop" class="form-select" required>
                                                            @if(!empty($crops))
                                                                @foreach($crops as $crop)
                                                                    <option
                                                                        value="{{ $crop->id }}"  @if(!empty($nd->crop_id) && $nd->crop_id == $crop->id) selected="selected" @endif
                                                                    >{{ $crop->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label" style="visibility: hidden;">label</label>
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <a class="btn btn-primary"
                                                       href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                                                    <button type="submit"
                                                            class="btn btn-success">{{ trans('app.Update')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @else
        <div class="section" role="main">
            <div class="card">
                <div class="card-body text-center">
                    <span class="titleup text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
                </div>
            </div>
        </div>
    @endif
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.crop').select2({
                minimumResultsForSearch: Infinity
            });
        })
    </script>
@endsection
