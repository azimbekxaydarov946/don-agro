@extends('layouts.app')
@section('content')
    <!-- page content -->
    <?php $userid = Auth::user()->id; ?>
        @if (getAccessStatusUser('Employees', $userid) == 'yes')
            <div class="section">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('app.Employees') }}
                        </li>
                    </ol>
                </div>
                @if (session('message'))
                    <div class="row massage">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-success text-center">
                                @if (session('message') == 'Successfully Submitted')
                                    <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Submitted') }}</label>
                                @elseif(session('message') == 'Successfully Updated')
                                    <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated') }} </label>
                                @elseif(session('message') == 'Successfully Deleted')
                                    <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted') }} </label>
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
                                                <a href="{!! url('/employee/list') !!}">
                                                    <span class="visible-xs"></span>
                                                    <i class="fa fa-list fa-lg">&nbsp;</i>
                                                    {{ trans('app.Ro\'yxat') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{!! url('/employee/add') !!}">
                                                    <span class="visible-xs"></span>
                                                    <i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
                                                        {{ trans('app.Qo\'shish') }}</b>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="examples1" class="table table-striped table-bordered nowrap"
                                        style="margin-top:20px;">
                                        <thead>


                                            <tr>
                                                <th>#</th>
                                                <th></th>
                                                <th>{{ trans('app.Image') }}</th>
                                                <th>{{ trans('app.Name') }}</th>
                                                <th>{{ trans('app.Last Name') }}</th>
                                                <th>{{ trans('app.Lavozim') }}</th>
                                                <th>{{ trans('app.Email') }}</th>
                                                <th>{{ trans('app.Mobile Number') }}</th>
                                                <th>{{ trans('app.Action') }}</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>
                                                        @if ($user->api_token)
                                                            <button onclick="copyText()" class="btn btn-success">
                                                                Copy to API
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td><img src="{{ URL::asset('employee/' . $user->image) }}" width="50px"
                                                            height="50px" class="img-circle"></td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->lastname }}</td>
                                                    <td>{{ $user->position }}</td>
                                                    <p hidden id="textToCopy">{{ $user->api_token }}</p>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->mobile_no }}</td>
                                                    <td>

                                                        <?php $userid = Auth::User()->id; ?>
                                                        @if (CheckAdmin($userid) == 'yes')
                                                            <a href="{!! url('/employee/view/' . $user->id) !!}"><button type="button"
                                                                    class="btn btn-round btn-info">{{ trans('app.View') }}</button></a>
                                                            <a href="{!! url('/employee/edit/' . $user->id) !!}"><button type="button"
                                                                    class="btn btn-round btn-success">{{ trans('app.Edit') }}</button></a>
                                                            <a url="{!! url('/employee/list/delete/' . $user->id) !!}" class="sa-warning"><button
                                                                    type="button"
                                                                    class="btn btn-round btn-danger">{{ trans('app.Delete') }}</button></a>
                                                        @else
                                                            <a href="{!! url('/employee/view/' . $user->id) !!}"><button type="button"
                                                                    class="btn btn-round btn-info">{{ trans('app.View') }}</button></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    @endcan
    <!-- /page content -->
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>

    {{-- start --}}
        <script>
            function copyText() {
                var textToCopy = document.getElementById('textToCopy');
                var text = textToCopy.innerText.trim();

                if (text.length > 0) {
                    var tempInput = document.createElement('input');
                    tempInput.value = text;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                }
                // else {
                //     textToCopy.classList.add('btn btn-danger');
                // }
            }
        </script>
    {{-- end --}}

    <script>
        $('body').on('click', '.sa-warning', function() {

            var url = $(this).attr('url');


            swal({
                title: "{{ trans('app.O\'chirishni istaysizmi?') }}",
                text: "{{ trans('app.O\'chirilgan ma\'lumotlar qayta tiklanmaydi!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#297FCA",
                confirmButtonText: "{{ trans('app.Ha, o\'chirish!') }}",
                cancelButtonText: "{{ trans('app.O\'chirishni bekor qilish') }}",
                closeOnConfirm: false
            }).then((result) => {
                window.location.href = url;

            });
        });
    </script>

@endsection
