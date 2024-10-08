@extends('layouts.app')
@section('content')
    <!-- page content -->
    <?php $userid = Auth::user()->id; ?>
    @can('viewAny',\App\Models\LaboratoryResult::class)
        <div class="section">
            <!-- PAGE-HEADER -->
            <div class="page-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fe fe-life-buoy mr-1"></i>&nbsp {{trans('app.Sertifikatlashtirish bo\'yicha sinov ko\'rsatkichlar ro\'yxati')}}
                    </li>
                </ol>
            </div>
            @if(session('message'))
                <div class="row massage">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-success text-center">
                            @if(session('message') == 'Successfully Submitted')
                                <label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}</label>
                            @elseif(session('message')=='Successfully Updated')
                                <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
                            @elseif(session('message')=='Successfully Deleted')
                                <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
                            @endif
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
                                        <li class="active">
                                            <a href="{!! url('/tests-laboratory/report')!!}">
                                                <span class="visible-xs"></span>
                                                <i class="fa fa-list fa-lg">&nbsp;</i>
                                                {{ trans('app.Ro\'yxat')}}
                                            </a>
                                        </li>
                                        <li>
                                            <a  href="{{ URL::previous() }}">
                                                <span class="visible-xs"></span>
                                                <i class="fa fa-arrow-left fa-lg">&nbsp;</i> <b>
                                                    {{ trans('app.Orqaga')}}</b>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <form id="invoice-form" method="post" action="{!! url('tests-laboratory/store') !!}" enctype="multipart/form-data"
                                  data-parsley-validate class="form-label-left form-horizontal upperform">
                                @csrf
                                <input type="hidden" name="id" value="{{$test->id}}">
                                <div class="row">
                                    <div class="col-md-4 form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                                        <label class="form-label">{{trans('app.Sinov boshlangan sana')}} <label class="text-danger">*</label></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="date_of_birth" class="form-control start_date" placeholder="<?php echo getDatepicker();?>" name="start_date" value="{{ old('start_date') }}" onkeypress="return false;" required />
                                        </div>
                                        @if ($errors->has('start_date'))
                                            <span class="help-block">
											<strong style="margin-left:27%;">Sana noto'g'ti shaklda kiritilgan</strong>
										</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                                        <label class="form-label">{{trans('app.Sinov tugatilgan sana')}} <label class="text-danger">*</label></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="date_of_birth" class="form-control end_date" placeholder="<?php echo getDatepicker();?>" name="end_date" value="{{ old('end_date') }}" onkeypress="return false;" required />
                                        </div>
                                        @if ($errors->has('start_date'))
                                            <span class="help-block">
											<strong style="margin-left:27%;">Sana noto'g'ti shaklda kiritilgan</strong>
										</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 form-group has-feedback {{ $errors->has('namlik') ? ' has-error' : '' }}">
                                        <label for="number" class="form-label ">Nisbiy namlik % <label class="text-danger">*</label></label>
                                        <input type="number" class="form-control" id="namlik" value="{{ old('namlik')}}"  name="namlik" required>
                                        @if ($errors->has('namlik'))
                                            <span class="help-block">
											 <strong>
                                                 Namlik no'to'gri shaklda kiritilgan</strong>
										   </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 form-group has-feedback {{ $errors->has('harorat') ? ' has-error' : '' }}">
                                        <label for="number" class="form-label ">Xona harorati °C<label class="text-danger">*</label></label>
                                        <input type="number" class="form-control" id="harorat" value="{{ old('harorat')}}"  name="harorat" required >
                                        @if ($errors->has('harorat'))
                                            <span class="help-block">
											 <strong>
                                                 Harorat no'to'gri shaklda kiritilgan</strong>
										   </span>
                                        @endif
                                    </div>
                                    {{-- <div class="col-md-4 form-group has-feedback">
                                        <label class="form-label">Mahsulot sifati <label class="text-danger">*</label></label>
                                        <div class=" gender">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"  name="type" value="0" >
                                                <span class="custom-control-label">Nomuvofiq </span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio"  class="custom-control-input" name="type" value="1" checked >
                                                <span class="custom-control-label">Muvofiq </span>
                                            </label>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-4 form-group has-feedback">
                                        <label class="form-label">Sinov bo'yicha mutaxassislar <label class="text-danger">*</label></label>
                                        @foreach($users as $user)
                                            <label>{{$user['fullname']}}</label>
                                            <input type="checkbox" checked name="checkbox[]" value="{{$user['id']}}"><br>
                                        @endforeach
                                    </div> --}}


                                <div class="col-md-6 form-group has-feedback">
                                    <label for="data" class="form-label">Qo'shimcha ma'lumotlar:<label class="text-danger">*</label></label>
                                        <textarea id="data" name="data" class="form-control" rows="2" cols="50">{{ old('data')}} </textarea>
                                    {{-- @if ($errors->has('data'))
                                        <span class="help-block">
											<strong style="color: red">Xulosa kiritilishi kerak</strong>
										</span>
                                    @endif --}}
                                </div>
                                </div>
                                {{-- <div class="col-md-12 form-group has-feedback">
                                    <label for="data" class="form-label">Xulosa:<label class="text-danger">*</label></label>
                                        <textarea id="data" name="data" class="form-control" rows="2" cols="50" required>{{ old('data')}} </textarea>
                                    @if ($errors->has('data'))
                                        <span class="help-block">
											<strong style="color: red">Xulosa kiritilishi kerak</strong>
										</span>
                                    @endif
                                </div> --}}

                                <div class="form-group col-md-12 col-sm-12">
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                                        <button type="submit" onclick="disableButton()" id="invoice-form-submitter" class="btn btn-success">{{ trans('app.Submit')}}</button>
                                    </div>
                                </div>
                        </form>
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
    @endcan
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
            <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
            <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
            <script type="text/javascript">
                $("input.start_date").datetimepicker({
                    format: "dd-mm-yyyy",
                    autoclose: 1,
                    minView: 2,
                    startView:'decade',
                    endDate: new Date(),
                });
                $("input.end_date").datetimepicker({
                    format: "dd-mm-yyyy",
                    autoclose: 1,
                    minView: 2,
                    startView:'decade',
                    endDate: new Date(),
                });
                function disableButton() {
                    var button = document.getElementById('submitter');
                    button.disabled = true;
                    button.innerText = 'Yuklanmoqda...'; // Optionally, change the text to indicate processing
                    setTimeout(function() {
                        button.disabled = false;
                        button.innerText = 'Saqlash'; // Restore the button text
                    }, 1000);
                }
</script>

@endsection


