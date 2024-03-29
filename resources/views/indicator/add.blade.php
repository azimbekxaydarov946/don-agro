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
                        <i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Yangi qo\'shish') }}
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
                                            <a href="{!! url('/indicator/list') !!}">
                                                <span class="visible-xs"></span>
                                                <i class="fa fa-list fa-lg">&nbsp;</i>
                                                {{ trans('app.Ro\'yxat') }}
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="{!! url('/indicator/add') !!}">
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
                                    <form action="{{ url('/indicator/store') }}" method="post" enctype="multipart/form-data"
                                        data-parsley-validate class="form-horizontal form-label-left">
                                        <div class="row">
                                            <div class="col-md-6 form-group has-feedback">
                                                <label class="form-label"
                                                    for="name">{{ trans('app.Sifat ko\'rsatkich nomi') }} <label
                                                        class="text-danger">*</label></label>
                                                <div class="">
                                                    <textarea id="data" required name="name" class="form-control" maxlength="500">{{ old('name') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group has-feedback">
                                                <label class="form-label"
                                                    for="nd_name">{{ trans('app.Sifat ko\'rsatkich bo\'yicha me\'yoriy hujjat') }}
                                                    <label class="text-danger">*</label></label>
                                                <div class="">
                                                    <textarea id="data" name="nd_name" class="form-control" maxlength="500">{{ old('nd_name') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="first-name">{{ trans('app.Mahsulot turi') }}<label
                                                            class="text-danger">*</label>
                                                    </label>
                                                    <select name="crop_id" class="w-100 form-control custom-select name_of_crop"
                                                        required data-url="{!! url('/getnds') !!}">
                                                        <option value="">{{ trans('app.Mahsulot turini tanlang') }}
                                                        </option>
                                                        @if (!empty($crops))
                                                            @foreach ($crops as $crop)
                                                                <option value="{{ $crop->id }}"
                                                                    @if ((!empty($ndsCrop) && $ndsCrop->crop_id == $crop->id) || count($crops) == 1) selected="selected" @endif>
                                                                    {{ $crop->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 overflow-hidden">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="first-name">{{ trans('app.Mahsulot normativ hujjati') }}<label
                                                            class="text-danger">*</label>
                                                    </label>
                                                    <select name="nds_id"
                                                        class="form-control w-100 custom-select nds_of_cropName">
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" style="visibility: hidden;">label</label>
                                                <div class="form-group">
                                                    <a class="btn btn-primary"
                                                        href="{{ URL::previous() }}">{{ trans('app.Cancel') }}</a>
                                                    <button type="submit"
                                                        class="btn btn-success">{{ trans('app.Submit') }}</button>
                                                </div>
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

        <script type="text/javascript">
            $(document).ready(function() {
                $('.states').select2({
                    minimumResultsForSearch: Infinity
                });

                $('select.name_of_crop').on('change', function() {
                    getCitiesOfState($(this));
                });

                if ($('select.nds_of_cropName').attr('val')) {
                    getCitiesOfState($('select.name_of_crop'));
                }
            });

            function getCitiesOfState(th) {
                var stateid = th.val();
                var url = th.data('url');
                var citiesMenu = $('select.nds_of_cropName');

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        crop_id: stateid,
                    },
                    success: function(response) {
                        citiesMenu.html(response);
                    }
                });
            }
        </script>
    @endsection
