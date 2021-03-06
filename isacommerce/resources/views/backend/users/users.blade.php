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
                <h3>Users</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li class="active">Users</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('status'))
                            <div role="alert" class="alert alert-success alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">Users List</h4>
                            </div>
                            <div class="panel-body">
                                <a href="{{ url('/isa-cms/users/create') }}" class="btn btn-success btn-addon m-b-sm"><i class="fa fa-plus"></i> Add New Data</a>
                                <div class="table-responsive">
                                    <table id="example" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th width="25">No</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th width="100">Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php $no=1; ?>
                                            @foreach($users as $c)
                                                <tr>
                                                    <td>{{ $no }}.</td>
                                                    <td>{{ $c->name }}</td>
                                                    <td>{{ $c->role }}</td>
                                                    <td>{{ $c->email }}</td>
                                                    <td>{{ date('F d, Y', strtotime($c->created_at)) }}</td>
                                                    <td>
                                                        <div aria-label="Justified button group" role="group" class="btn-group btn-group-justified">
                                                            <a role="button" class="btn btn-warning" href="{{ url('/isa-cms/users/edit',[$c->id]) }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a role="button" class="btn btn-danger" href="#" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ url('/isa-cms/users/delete',[$c->id]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $no++; ?>
                                            @endforeach
                                        </tbody>
                                   </table>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    Are you sure you want to delete this record? 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-github" data-dismiss="modal">Cancel</button>
                    <a id="delete" href="" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
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