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
                        <i class="fe fe-life-buoy mr-1"></i> Laboratoriya natijalari
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
        <!-- filter component -->
            <x-filter :crop="$crop" :city="1" :from="$from" :till="$till"  />
            <!--filter component -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                {{$tests->links()}}
                                <table id="examples1" class="table table-striped table-bordered nowrap" style="margin-top:20px;" >
                                    <thead>
                                    <tr>
                                        <th class="border-bottom-0 border-top-0">№</th>
                                        <th class="border-bottom-0 border-top-0">Sinov dastur raqami</th>
                                        <th class="border-bottom-0 border-top-0">{{trans('app.Yuborilgan sana')}}</th>
                                        <th class="border-bottom-0 border-top-0">{{trans('app.Mahsulot turi')}}</th>
                                        <th class="border-bottom-0 border-top-0">{{trans('app.Mahsulot navi')}}</th>
                                        {{-- <th class="border-bottom-0 border-top-0">Na'munalar raqami</th> --}}                {{-- - labaratoriya number - --}}
                                        <th class="border-bottom-0 border-top-0">{{trans('app.Action')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $offset = (request()->get('page', 1) - 1) * 50;
                                    @endphp
                                    @foreach($tests as $test)
                                        <tr>
                                            <td>{{$offset + $loop->iteration}}</td>
                                            <td>{{  $test->application->app_number }}</a></td>
                                            <td>{{ optional($test)->created_at}}</td>
                                            <td>{{ $test->application->crops->pre_name }} {{ $test->application->crops->name->name }}</td>
                                            <td>{{ optional($test->application)->crops->type->name ?? '' }}</td>
                                            {{-- <td>@if($test->status == \App\Models\TestPrograms::STATUS_ACCEPTED) @foreach($test->laboratory_numbers as $number) {{$number->number}}; @endforeach @endif</td> --}}              {{-- - labaratoriya number - --}}
                                            <td>

                                                @if(isset($test->indicators()->first()->type))
                                                    <a href="{!! url('/laboratory-results/view/'.$test->id) !!}"><button type="button" class="btn btn-round btn-warning"><i class="fa fa-eye"></i> {{trans('app.View')}}</button></a>
                                                    <a href="{!! url('/laboratory-results/edit/'.$test->id) !!}"><button type="button" class="btn btn-round btn-info"><i class="fa fa-pencil"></i> {{trans('app.Edit')}}</button></a>
                                                @else
                                                    <a href="{!! url('/laboratory-results/add/'.$test->id) !!}"><button type="button" class="btn btn-round btn-success"><i class="fa fa-pencil"></i> Natijalarni kiritish</button></a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$tests->links()}}
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
    @endcan
    <!-- /page content -->
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

    <script>
        $('body').on('click', '.sa-warning', function() {
            var url =$(this).attr('url');
            swal({
                title: "{{trans('app.O\'chirishni istaysizmi?')}}",
                text: "{{trans('app.O\'chirilgan ma\'lumotlar qayta tiklanmaydi!')}}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#297FCA",
                confirmButtonText: "{{trans('app.Ha, o\'chirish!')}}",
                cancelButtonText: "{{trans('app.O\'chirishni bekor qilish')}}",
                closeOnConfirm: false
            }).then((result) => {
                window.location.href = url;

            });
        });
    </script>

@endsection
