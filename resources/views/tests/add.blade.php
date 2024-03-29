@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@can('create', \App\Models\Application::class)
   <div class="section">
		<div class="page-header">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<i class="fe fe-life-buoy mr-1"></i>&nbsp {{trans("app.Sinov dasturi qo'shish")}}
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
										<a href="{!! url('/tests/search')!!}">
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
						<form id="invoice-form" method="post" action="{!! url('tests/store') !!}" enctype="multipart/form-data"
                              data-parsley-validate class="form-label-left form-horizontal upperform">
                            @csrf
							<div class="row" >

								<input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden"  name="app_id" value="{{ $app->id}}" >
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" for="app_number">{{trans("app.Ariza raqami")}} <label class="text-danger">*</label></label>
                                    <input type="number" readonly name="app_number" value="{{ $app->app_number}}" class="form-control">
                                </div>
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" for="app_number">{{trans("app.Mahsulot nomi")}} <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="product_name" value="{{ $app->crops->name->name??''}}" class="form-control">
                                </div>
                                @if ($app->crops->type)

                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" for="app_number">{{trans("app.Mahsulot navi")}} <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="product_type" value="{{ $app->crops->type->name??''}}" class="form-control">
                                </div>

                                @endif
                                {{-- <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" for="app_number">Mahsulot avlodi <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="product_generation" value="{{ optional($app->crops)->generation->name}}" class="form-control">
                                </div> --}}
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" for="app_number">{{trans("app.Sinov dasturi sanasi")}} <label class="text-danger">*</label></label>
                                    <input type="text" readonly name="app_number" value="{{ $app->date}}" class="form-control">
                                </div>
                                <div class="col-md-4 form-group has-feedback">
                                    <label class="form-label" for="app_number">{{ trans('app.Me\'yoriy hujjatlar') }}<label class="text-danger">*</label></label>
                                    <input type="text" readonly name="app_number" value="{{ $nds }}" class="form-control">
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group overflow-hidden">
                                        <label class="form-label">{{trans("app.Rahbar")}}<label class="text-danger">*</label></label>
                                        <select class="w-100 form-control" name="director_id" required title="{{trans("app.Rahbar tanlanishi kerak")}}">
                                            @if(count($directors))
                                                <option value="">{{trans("app.Rahbarni tanlang")}}</option>
                                            @endif
                                            @foreach($directors as $director)
                                                <option value="{{$director->id}}" @if($director->id == old('director_id')) selected @endif
                                                > {{$director->name.' '.$director->lastname}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 form-group has-feedback {{ $errors->has('count') ? ' has-error' : '' }}">
                                    <label for="middle-name" class="form-label">Sinov na'munalarning soni <label class="text-danger">*</label></label>
                                    <input type="number" class="form-control" maxlength="25"  name="count" value="{{ old('count')}}" required>
                                    @if ($errors->has('count'))
                                        <span class="help-block">
											 <strong>Na'munalar soni noto'g'ri shaklda kiritilgan</strong>
										   </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group overflow-hidden">
                                        <label class="form-label">O'lchov turi <label class="text-danger">*</label></label>
                                        <select class="w-100 form-control" name="measure_type" required>
                                            @if(count($measure_types))
                                                <option value="">O'lchov turini tanlang</option>
                                            @endif
                                            @foreach($measure_types as $key=>$name)
                                                <option value="{{ $key }}"   @if($key == old('measure_type')) selected @endif
                                                > {{$name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group has-feedback {{ $errors->has('amount') ? ' has-error' : '' }}">
                                    <label for="middle-name" class="form-label">Xar bir sinov na'munasining miqdori <label class="text-danger">*</label></label>
                                    <input type="number" step="0.01" class="form-control" maxlength="25" value="{{ old('amount')}}"  name="amount" required>
                                    @if ($errors->has('amount'))
                                        <span class="help-block">
											 <strong>Xar bir sinov na'munasining miqdori noto'g'ri shaklda kiritilgan</strong>
										   </span>
                                    @endif
                                </div> --}}

                                <h4 style="font-weight: bold">{{trans("app.Sifat ko'rsatgich bo'yicha me'yoriy hujjatlar")}}:</h4>
                                <div class="col-md-12">
                                    @foreach($indicators as  $key=>$box)
                                    @php $i = 1; @endphp
                                    <table style="font-weight: bold" class="table table-bordered align-middle">
                                        <br>
                                        <tr>{{\App\Models\Nds::getType($key)??''}}</tr>
                                        @foreach ($box as $k => $indicator)
                                        <tr>
                                            <td>@if(!$indicator->parent_id) {{$i}} @endif</td>
                                            <td>{{$indicator->name}}</td>
                                            <td>{!! nl2br($indicator->nd_name) !!}</td>
                                            <td>
                                            @if($indicator->nd_name)
                                                    <input type="checkbox" checked name="checkbox[]" value="{{$indicator->id}}">
                                            @else
                                                    <input type="checkbox" style="display:none" checked name="checkbox[]" value="{{$indicator->id}}">
                                            @endif
                                            </td>
                                        </tr>
                                        @if(!$indicator->parent_id) @php $i=$i+1; @endphp @endif

                                        @endforeach
                                    </table>
                                    @endforeach
                                </div>
                                <div class="col-md-12 form-group has-feedback">
                                    <label class="form-label" for="data">{{trans("app.Alohida yozuvlar:")}}<label class="text-danger">*</label></label>
                                    <div class="">
                                        <textarea id="data" name="data" class="form-control" maxlength="100" >{{ old('data')}}</textarea>
                                    </div>
                                </div>

								<div class="form-group col-md-12 col-sm-12">
									<div class="col-md-12 col-sm-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" onclick="disableButton()" id="invoice-form-submitter" class="btn btn-success">{{ trans('app.Submit')}}</button>
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

@endsection
@section('scripts')
    <script>
        function disableButton() {
            var button = document.getElementById('invoice-form-submitter');
            button.disabled = true;
            button.innerText = '{{trans("app.Yuklanmoqda...")}}';
            setTimeout(function() {
                button.disabled = false;
                button.innerText = '{{trans("app.Saqlash")}}'; // Restore the button text
            }, 1000);// Optionally, change the text to indicate processing
        }
    </script>
@endsection
