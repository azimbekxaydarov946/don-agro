@extends('layouts.app')
@section('content')
    <!-- page content -->
    <?php $userid = Auth::user()->id; ?>
    @if (getAccessStatusUser('Vehicles', $userid) == 'yes')
        @if (getActiveCustomer($userid) == 'yes' || getActiveEmployee($userid) == 'yes')

            <div class="section">
                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fe fe-life-buoy mr-1"></i>&nbsp {{ trans('message.Mahsulotlar ro\'yxati') }}
                        </li>
                    </ol>
                </div>
                @if (session('message'))
                    <div class="row massage">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div
                                class="alert @php echo (session('message')=='Cannot Deleted') ? 'alert-danger' : 'alert-success' @endphp text-center">
                                @if (session('message') == 'Successfully Submitted')
                                    <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Submitted') }} </label>
                                @elseif(session('message') == 'Successfully Updated')
                                    <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated') }} </label>
                                @elseif(session('message') == 'Successfully Deleted')
                                    <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted') }} </label>
                                @elseif(session('message') == 'Cannot Deleted')
                                    <label for="checkbox-10 "> {{ trans('app.Cannot Deleted') }} </label>
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
                                                <a href="{!! url('/crops_name/list') !!}">
                                                    <span class="visible-xs"></span>
                                                    <i class="fa fa-list fa-lg">&nbsp;</i>
                                                    {{ trans('app.Ro\'yxat') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{!! url('/crops_name/add') !!}">
                                                    <span class="visible-xs"></span>
                                                    <i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>
                                                        {{ trans('app.Qo\'shish') }}</b>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered "
                                        style="margin-top:20px; width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="max-width: 2%">№</th>
                                                <th style="width: 8%">{{ trans('app.Image') }}</th>
                                                <th style="width: 45%">{{ trans('app.Nomlari') }}</th>
                                                {{-- <th style="width: 20%">{{ trans('app.Mahsulot toifasi') }}</th> --}}
                                                <th style="width: 10%">{{ trans('app.Kod TN VED') }}</th>
                                                <th style="width: 15%">{{ trans('app.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($crops as $crop)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td><img src="{{ URL::asset('crops/' . $crop->img) }}" width="50px" height="50px" class="img-circle"></td>
                                                    <td>{{ $crop->name }}</td>
                                                    {{-- <td>{{ $crop->parent[0]->name??''}}</td> --}}
                                                    <td>{{ $crop->kodtnved }}</td>
                                                    <td>
                                                        <a href="{!! url('/crops_name/list/edit/' . $crop->id) !!}"> <button type="button"
                                                                class="btn btn-round btn-success">{{ trans('app.Edit') }}</button></a>

                                                        <a url="{!! url('/crops_name/list/delete/' . $crop->id) !!}" class="sa-warning"> <button
                                                                type="button"
                                                                class="btn btn-round btn-danger dgr">{{ trans('app.Delete') }}</button></a>
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
        @endif
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
    <!-- delete vehicalbrand -->
    <script>
        $(function(e) {
            $('#examples1').DataTable({
                "searching": false,
                "pageLength": 50,
                "paging": false,
                "info": false,
                "language": {
                    "search": "<?= trans('app.Qidirish') ?>",
                    "lengthMenu": "<?= trans('app.Sahifada  _MENU_  ta qayd') ?>",
                    "zeroRecords": "<?= trans('app.Ma\'lumot topilmadi') ?>",
                    "info": "<?= trans('app._PAGES_ ta sahifadan _PAGE_ chisi') ?>",
                    "infoFiltered": "",
                    "infoEmpty": "<?= trans('app.Ma\'lumot mavjud emas') ?>",
                    "paginate": {
                        "previous": "<?= trans('app.Avvalgi sahifa') ?>",
                        "next": "<?= trans('app.Keyingi sahifa') ?>"
                    }
                }
            });
            var table = $('#example1').DataTable();
            $('#example2').DataTable({
                "scrollY": "200px",
                "scrollCollapse": true,
                "paging": false,
                "pageLength": 50,
                "language": {
                    "search": "<?= trans('app.Qidirish') ?>",
                    "lengthMenu": "<?= trans('app.Sahifada  _MENU_  ta qayd') ?>",
                    "zeroRecords": "<?= trans('app.Ma\'lumot topilmadi') ?>",
                    "info": "<?= trans('app._PAGES_ ta sahifadan _PAGE_ chisi') ?>",
                    "infoFiltered": "",
                    "infoEmpty": "<?= trans('app.Ma\'lumot mavjud emas') ?>",
                    "paginate": {
                        "previous": "<?= trans('app.Avvalgi sahifa') ?>",
                        "next": "<?= trans('app.Keyingi sahifa') ?>"
                    }
                }
            });
            $('#example3').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details for ' + data[0] + ' ' + data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }
            });
            var table = $('#example').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'colvis']
            });
            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');

            //sample datatable
            $('#example-2').DataTable();

            //Details display datatable
            $('#example-1').DataTable({
                "pageLength": 50,
                "language": {
                    "search": "<?= trans('app.Qidirish') ?>",
                    "lengthMenu": "<?= trans('app.Sahifada  _MENU_  ta qayd') ?>",
                    "zeroRecords": "<?= trans('app.Ma\'lumot topilmadi') ?>",
                    "info": "<?= trans('app._PAGES_ ta sahifadan _PAGE_ chisi') ?>",
                    "infoFiltered": "",
                    "infoEmpty": "<?= trans('app.Ma\'lumot mavjud emas') ?>",
                    "paginate": {
                        "previous": "<?= trans('app.Avvalgi sahifa') ?>",
                        "next": "<?= trans('app.Keyingi sahifa') ?>"
                    }
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return data[1];
                            }
                        }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                            tableClass: 'table'
                        })
                    }
                }

            });
            $('#datatable').DataTable({
                "pageLength": 50,
                "language": {
                    "search": "<?= trans('app.Qidirish') ?>",
                    "lengthMenu": "<?= trans('app.Sahifada  _MENU_  ta qayd') ?>",
                    "zeroRecords": "<?= trans('app.Ma\'lumot topilmadi') ?>",
                    "infoFiltered": "",
                    "info": "<?= trans('app._PAGES_ ta sahifadan _PAGE_ chisi') ?>",
                    "infoEmpty": "<?= trans('app.Ma\'lumot mavjud emas') ?>",
                    "paginate": {
                        "previous": "<?= trans('app.Avvalgi sahifa') ?>",
                        "next": "<?= trans('app.Keyingi sahifa') ?>"
                    }
                }
            });



            $('#datatable-1').DataTable({
                "pageLength": Infinity,
                "language": {
                    "search": "<?= trans('app.Qidirish') ?>",
                    "lengthMenu": "<?= trans('app.Sahifada  _MENU_  ta qayd') ?>",
                    "zeroRecords": "<?= trans('app.Ma\'lumot topilmadi') ?>",
                    "info": "<?= trans('app._PAGES_ ta sahifadan _PAGE_ chisi') ?>",
                    "infoFiltered": "",
                    "infoEmpty": "<?= trans('app.Ma\'lumot mavjud emas') ?>",
                    "paginate": {
                        "previous": "<?= trans('app.Avvalgi sahifa') ?>",
                        "next": "<?= trans('app.Keyingi sahifa') ?>"
                    }
                }
            });
            $('#example-3').DataTable({
                "pageLength": Infinity,
                "language": {
                    "search": "<?= trans('app.Qidirish') ?>",
                    "lengthMenu": "<?= trans('app.Sahifada  _MENU_  ta qayd') ?>",
                    "zeroRecords": "<?= trans('app.Ma\'lumot topilmadi') ?>",
                    "info": "<?= trans('app._PAGES_ ta sahifadan _PAGE_ chisi') ?>",
                    "infoFiltered": "",
                    "infoEmpty": "<?= trans('app.Ma\'lumot mavjud emas') ?>",
                    "paginate": {
                        "previous": "<?= trans('app.Avvalgi sahifa') ?>",
                        "next": "<?= trans('app.Keyingi sahifa') ?>"
                    }
                }
            });
        });

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
