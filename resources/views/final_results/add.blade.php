@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@can('view',\App\Models\Application::class)
   <div class="section">
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<i class="fe fe-life-buoy mr-1"></i>&nbsp {{trans('app.Qo\'shish')}}
				</li>
			</ol>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="panel panel-primary">
							<div class="tab_wrapper page-tab">
								<ul class="tab_list">
									<li>
										<a href="{!! url('/final_results/search')!!}">
											<span class="visible-xs"></span>
											<i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Ro\'yxat')}}
										</a>
									</li>
									<li class="active">
										<span class="visible-xs"></span>
										<i class="fa fa-plus-circle fa-lg">&nbsp;</i>
										<b>{{ trans('app.Qo\'shish')}}</b>
									</li>
								</ul>
							</div>
						</div>
						<form id="invoice-form" method="post" action="{!! url('final_results/store') !!}" enctype="multipart/form-data"
                              data-parsley-validate class="form-horizontal form-label-left">
                            @csrf
							<div class="row" >

								<input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden"  name="test_id" value="{{ $test->id}}" >
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" >{{trans("app.Qaror raqami")}} <label class="text-danger">*</label></label>
                                    <input type="number" readonly name="app_number" value="{{ $test->application->app_number}}" class="form-control">
                                </div>
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label">{{ trans('app.Sertifikatlashtirish sxemasi') }}<label class="text-danger">*</label></label>
                                    <input type="number" readonly value="{{ $test->application->crops->sxeme_number}}" class="form-control">
                                </div>
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label">{{ trans('app.Me\'yoriy hujjat') }}<label class="text-danger">*</label></label>
                                    <input type="text" readonly value="@php
                                    foreach ($test->application->crops->name->nds as $value) {
                                        echo \App\Models\Nds::getType()[$value->type_id] . '.' . $value->number . ' ' . $value->name . ', ';
                                    } @endphp" class="form-control">
                                </div>
                               {{-- \App\Models\Nds::getType()[$test->application->crops->name->nds->type_id] . '.' . $test->application->crops->name->nds->number . ' ' . $test->application->crops->name->nds->name  --}}
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" >{{trans("app.Mahsulot nomi")}} <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="product_name" value="{{ optional($test->application->crops)->name->name}}" class="form-control">
                                </div>
                                @if ($test->application->crops->type)
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" >{{trans("app.Mahsulot navi")}} <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="product_type" value="{{ optional($test->application->crops)->type->name}}" class="form-control">
                                </div>
                                @endif
                                {{-- <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" >Mahsulot avlodi <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="product_generation" value="{{ optional($test->application->crops)->generation->name}}" class="form-control">
                                </div> --}}
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" >{{trans("app.Sinov dasturi sanasi")}} <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="app_number" value="{{ $test->application->date}}" class="form-control">
                                </div>

                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label">{{trans("app.Mahsulotga sertifikat taqdim etish")}}<label class="text-danger">*</label></label>
                                    <div class=" gender">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input given_certificate"  name="given_certificate" value="1" checked required >
                                            <span class="custom-control-label">{{trans("app.Ha")}} </span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio"  class="custom-control-input given_certificate" name="given_certificate" value="0" required>
                                            <span class="custom-control-label">{{trans("app.Yo'q")}} </span>
                                        </label>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 form-group has-feedback {{ $errors->has('number') ? ' has-error' : '' }}">
                                    <label for="number" class="form-label certificate">Sinov bayonnoma raqami <label class="text-danger">*</label></label>
                                    <label for="number" style="display: none" class="form-label nocertificate">Taxlil natija raqami <label class="text-danger">*</label></label>
                                    <input type="number" class="form-control" maxlength="10" value="{{ old('number')}}"  name="number" required>
                                    @if ($errors->has('number'))
                                        <span class="help-block">
											 <strong>Natija raqami noto'g'ri shaklda kiritilgan</strong>
										   </span>
                                    @endif
                                </div>
                                <div class="col-md-4 form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                    <label class="form-label certificate">Bayonnoma sanasi <label class="text-danger">*</label></label>
                                    <label style="display: none" class="form-label nocertificate"> Tahlil natija sanasi<label class="text-danger">*</label></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="dd.mm.yyyy" name="date"  data-mask="00.00.0000" value="{{ old('date') }}" required />
                                    </div>
                                    @if ($errors->has('date'))
                                        <span class="help-block">
                                                    <strong class="text-danger">Ariza sanasi noto'g'ri shaklda kiritilgan</strong>
                                            </span>
                                    @endif
                                </div> --}}
                                <div class="col-md-4">
                                    <label class="form-label certificate">{{trans("app.Bayonnoma faylini yuklang")}}</label>
                                    <label style="display: none" class="form-label nocertificate">{{trans("app.Labaratoriya faylini yuklang")}}</label>
                                    <input class="form-control" type="file" placeholder="Asos hujjatni yuklang..."
                                           required name="reason-file"
                                           accept="application/pdf"
                                    />
                                </div>
                                <div class="certificate row">
                                    <div class="col-md-6 form-group has-feedback {{ $errors->has('reestr_number') ? ' has-error' : '' }}">
                                        <label for="reestr_number" class="form-label ">{{trans("app.Sertifikat reestr raqami")}} <label class="text-danger">*</label></label>
                                        <input type="number" class="form-control" id="reestr_number" size="10" value="{{ old('reestr_number')}}"  name="reestr_number" >
                                        @if ($errors->has('reestr_number'))
                                            <span class="help-block">
											 <strong>{{trans("app.Sertifikat raqami noto'g'ri shaklda kiritilgan")}}</strong>
										   </span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 form-group {{ $errors->has('given_date') ? ' has-error' : '' }}">
                                        <label class="form-label ">{{trans("app.Sertifikat berilgan sana")}} <label class="text-danger">*</label></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="dd.mm.yyyy" name="given_date"  data-mask="00.00.0000" value="{{ old('given_date') }}"  />
                                        </div>
                                        @if ($errors->has('given_date'))
                                            <span class="help-block">
                                                    <strong class="text-danger">{{trans("app.Ariza sanasi noto'g'ri shaklda kiritilgan")}}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="nocertificate row" style="display: none">
                                    <div class="col-md-4 form-group has-feedback">
                                        <label class="form-label">{{trans("app.Mahsulot sifati")}} <label class="text-danger">*</label></label>
                                        <div class=" gender">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"  name="type" value="0" checked >
                                                <span class="custom-control-label">{{trans("app.Nomuvofiq")}} </span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio"  class="custom-control-input" name="type" value="1" >
                                                <span class="custom-control-label">{{trans("app.Muvofiq")}} </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group has-feedback {{ $errors->has('folder_number') ? ' has-error' : '' }}">
                                        <label class="form-label ">{{trans("app.Tikilgan papka raqami")}} <label class="text-danger">*</label></label>
                                        <input type="text" class="form-control"  maxlength="25" value="{{ old('folder_number')}}"  name="folder_number" >
                                        @if ($errors->has('folder_number'))
                                            <span class="help-block">
											 <strong>{{trans("app.Papka raqami noto'g'ri shaklda kiritilgan")}}</strong>
										   </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 form-group has-feedback">
                                        <label class="form-label" >{{trans("app.Izoh:")}}<label class="text-danger">*</label></label>
                                        <div class="">
                                            <textarea id="comment" name="comment" class="form-control" maxlength="200" >{{ old('comment')}}</textarea>
                                        </div>
                                    </div>
                                </div>


								<div class="form-group col-md-12 col-sm-12">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group overflow-hidden">
                                            <label class="form-label">{{trans("app.Mustaqil baholovchi")}}<label class="text-danger">*</label></label>
                                            <select class="w-100 form-control" name="maker" required>
                                                @if(count($makers))
                                                    <option value="">{{trans("app.Mustaqil baholovchi tanlang")}}</option>
                                                @endif
                                                @foreach($makers as $maker)
                                                    <option value="{{$maker->id}}" @if($maker->id == old('maker')) selected @endif
                                                    > {{$maker->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-md-6 col-sm-6">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" onclick="disableButton()" id="submitter" class="btn btn-success">{{ trans('app.Submit')}}</button>
									</div>
								</div>
							</div>
						</form>
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
@endcan
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
	<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">

    $("input.date").datetimepicker({
        format: "dd-mm-yyyy",
        autoclose: 1,
        minView: 2,
        startView:'decade',
        endDate: new Date(),
    });
    $("input.given_date").datetimepicker({
        format: "dd-mm-yyyy",
        autoclose: 1,
        minView: 2,
        startView:'decade',
        endDate: new Date(),
    });
    //get sertificate type
    $(document).ready(function() {
        const certificate = document.getElementsByClassName("certificate");
        const nocertificate = document.getElementsByClassName("nocertificate");
        // Attach event listener to radio button group
        $('input[name="given_certificate"]').click(function() {
            var selectedValue = $(this).val();


            // Show the notes based on the selected value
            if (selectedValue == 0) {
                for (let i = 0; i < certificate.length; i++) {
                    certificate[i].style.display = 'none';
                }
                for (let i = 0; i < nocertificate.length; i++) {
                    nocertificate[i].style.display = 'flex';
                }
                $('#reestr_number').prop('required', false);
                $('#given_date').prop('required', false);
                $('#comment').prop('required', true);
            } else {
                for (let i = 0; i < nocertificate.length; i++) {
                    nocertificate[i].style.display = "none";
                }
                for (let i = 0; i < certificate.length; i++) {
                    certificate[i].style.display = "flex";
                }
                $('#reestr_number').prop('required', true);
                $('#given_date').prop('required', true);
                $('#comment').prop('required', false);
            }
        });
    });
</script>
<script>
    $(document).ready(function(){

        $('input[name="fake-image"]').on('click', function(){
            $('input[name="image"]').click();
        });
        $('input[name="image"]').on('change',function(){
            $('textarea[name="file-name"]').text($('input[name="image"]').val());
        });

    });
</script>
<script>
    function disableButton() {
        var button = document.getElementById('submitter');
        button.disabled = true;
        button.innerText = '{{trans("app.Yuklanmoqda...")}}'; // Optionally, change the text to indicate processing
        setTimeout(function() {
            button.disabled = false;
            button.innerText = '{{trans("app.Saqlash")}}'; // Restore the button text
        }, 1000);
    }
</script>
@endsection

