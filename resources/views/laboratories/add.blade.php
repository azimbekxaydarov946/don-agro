@extends('layouts.app')
@section('content')
    <style>
        .checkbox-success {
            background-color: #cad0cc !important;
            color: red;
        }
    </style>
    <?php $userid = Auth::user()->id; ?>
    @if (CheckAdmin($userid) == 'yes')
        <div class="section">
            <div class="page-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Laboratoriylar') }}
                    </li>
                </ol>
            </div>
            <div class="clearfix"></div>
            @if (session('message'))
                <div class="row massage">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-success danger text-center">

                            <label for="checkbox-10 colo_success"> {{ trans('app.Duplicate Data') }} </label>
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
                                            <a href="{!! url('/laboratories/list') !!}">
                                                <span class="visible-xs"></span>
                                                <i class="fa fa-list fa-lg">&nbsp;</i>
                                                {{ trans('app.Ro\'yxat') }}
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="{!! url('/laboratories/add') !!}">
                                                <span class="visible-xs"></span>
                                                <i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
                                                    {{ trans('app.Qo\'shish') }}</b>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form action="{{ url('/laboratories/store') }}" method="post"
                                        enctype="multipart/form-data" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="first-name">{{ trans('app.Nomi') }}
                                                        <label class="text-danger">*</label>
                                                    </label>
                                                    <input type="text" required="required" name="name"
                                                        placeholder="{{ trans('app.Nomini kiriting') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="first-name">{{ trans('app.Sertifikat') }}
                                                        <label class="text-danger">*</label>
                                                    </label>
                                                    <input type="text" required="required" name="certificate"
                                                        placeholder="{{ trans('app.Sertifikatni kiriting') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="first-name">{{ trans('app.Manzil') }}
                                                        <label class="text-danger">*</label>
                                                    </label>
                                                    <input type="text" required="required" name="address"
                                                        placeholder="{{ trans('app.Manzilni kiriting') }}"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="form-label" style="visibility: hidden;">label</label>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <a class="btn btn-primary"
                                                    href="{{ URL::previous() }}">{{ trans('app.Cancel') }}</a>
                                                <button type="submit"
                                                    class="btn btn-success">{{ trans('app.Update') }}</button>
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
                    <span class="titleup text-danger"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>&nbsp
                        {{ trans('app.You Are Not Authorize This page.') }}</span>
                </div>
            </div>
        </div>
    @endif
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.region').select2({
                minimumResultsForSearch: Infinity
            });
        })
    </script>
@endsection