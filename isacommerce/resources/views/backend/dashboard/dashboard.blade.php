@extends('backend.layout.layout')
@section('singlecss')
<link href="{{ url('theme/backend/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/> 
<link href="{{ url('theme/backend/plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        @include('backend.layout.navigation')
        <div class="page-inner">
            <div class="page-title">
                <h3>Dashboard</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{ $data['count_users'] }}</p>
                                    <span class="info-box-title">Total Customers</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{ $data['count_orders'] }}</p>
                                    <span class="info-box-title">Total Orders</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-tag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p><span class="counter">{{ $data['count_products'] }}</span></p>
                                    <span class="info-box-title">Total Products</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-basket"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel info-box panel-white">
                            <div class="panel-body">
                                <div class="info-box-stats">
                                    <p class="counter">{{ 70 }}</p>
                                    <span class="info-box-title">Total Categories</span>
                                </div>
                                <div class="info-box-icon">
                                    <i class="icon-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if (session('status'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="panel panel-white">
                        <div>
                            <div class="pull-right export">
                                <a class="btn btn-info" role="button" href="#" onClick ="$('#example').tableExport({type:'json',escape:'false'});">JSON</a>
                                <a class="btn btn-info" role="button" href="#" onClick ="$('#example').tableExport({type:'excel',escape:'false'});">XLS</a>
                                <a class="btn btn-info" role="button" href="#" onClick ="$('#example').tableExport({type:'csv',escape:'false'});">CSV</a>
                                <a class="btn btn-info" role="button" href="#" onClick ="$('#example').tableExport({type:'pdf',escape:'false'});">PDF</a>
                            </div>
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">Last Orders</h4>
                            </div>
                        </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                     <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Invoice No</th>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th width="25">No</th>
                                                <th>Invoice No</th>
                                                <th>Name</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $no=1; ?>
                                            @foreach($data['orders'] as $o)
                                                <tr>
                                                    <td>{{ $no }}.</td>
                                                    <td>{{ $o->invoice_no }}</td>
                                                    <td>{{ $o->firstname }} {{ $o->lastname }}</td>
                                                    <td>{{ number_format($o->total,2,',','.') }}</td>
                                                    <td>{{ $o->status }}</td>
                                                    <td>{{ date('F d, Y', strtotime($o->created_at)) }}</td>
                                                </tr>
                                                <?php $no++; ?>
                                            @endforeach
                                        </tbody>
                                   </table>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Row -->
            </div><!-- Main Wrapper -->
            @include('backend.layout.footer')
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    @include('backend.layout.hide-menu')
    <div class="cd-overlay"></div>
    <div class="modal fade modal-danger" id="modal-delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="delete-confirmation-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to complete this task? 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-github" data-dismiss="modal">Cancel</button>
                    <a id="delete" href="" class="btn btn-success"> Yes</a>
                </div>
            </div>
        </div>
    </div>
    @include('backend.layout.javascript')
    <script src="{{ url('theme/backend/plugins/datatables/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ url('theme/backend/js/pages/table-data.js') }}"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#modal-delete-confirmation').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var actionTarget = button.data('action-target');
                var modal = $(this);
                modal.find('#delete').attr('href', actionTarget);
            });
        });
    </script>
</body>
@endsection