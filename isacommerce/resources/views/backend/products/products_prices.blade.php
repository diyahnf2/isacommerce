@extends('backend.layout.layout')
@section('singlecss')
<link href="{{ url('theme/backend/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('theme/backend/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        @include('backend.layout.navigation')
        <div class="page-inner">
            <div class="page-title">
                <h3>Prices</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/isa-cms/services') }}">Services</a></li>
                        <li class="active">Add Prices</li>
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
                        @if($errors->has())
                            <div role="alert" class="alert alert-danger alert-dismissible">
                                <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ url('/isa-cms/services/store-prices') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Add Default Prices</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row form-group">
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="type" placeholder="Price type" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text"  class="form-control" name="local" placeholder="Local Rate" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="foreign" placeholder="Foreign Rate" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="min_order" placeholder="Min Order" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="warning" placeholder="Min Stock Alert">
                                        </div>
                                        <div class="col-md-1">
                                            <input type="text" class="form-control" name="stock" placeholder="Stock">
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-success btn-block" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">Type of Price Available</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table" id="editable">
                                            <thead>
                                                <tr>
                                                    <th width="25">No</th>
                                                    <th>Type</th>
                                                    <th>Local Rate</th>
                                                    <th>Foreign Rate</th>
                                                    <th>Is Stock</th>
                                                    <th>Stock</th>
                                                    <th>Min Order</th>
                                                    <th>Min Stock Alert</th>
                                                    <th width="120">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; ?>
                                                @foreach($prices as $p)
                                                    <tr>
                                                        <td>{{ $no }}.</td>
                                                        <td><a href="#" data-pk="{{ $p->id }}" data-name="title">{{ $p->title }}</a></td>
                                                        <td>IDR <a href="#" data-pk="{{ $p->id }}" data-name="rate_local">{{ $p->rate_local }}</a></td>
                                                        <td>IDR <a href="#" data-pk="{{ $p->id }}" data-name="rate_wna">{{ $p->rate_wna }}</a></td>
                                                        <td><a href="#" data-pk="{{ $p->id }}" data-name="is_stock" data-title="Use Stock">{{ $p->is_stock }}</a></td>
                                                        <td><a href="#" data-pk="{{ $p->id }}" data-name="stock">{{ $p->stock }}</a></td>
                                                        <td><a href="#" data-pk="{{ $p->id }}" data-name="min_order">{{ $p->min_order }}</a></td>
                                                        <td><a href="#" data-pk="{{ $p->id }}" data-name="warning">{{ $p->warning }}</a></td>
                                                        <td>
                                                            <div aria-label="Justified button group" role="group" class="btn-group btn-group-justified">
                                                                <a role="button" class="btn btn-primary" href="{{ url('/isa-cms/services/daily-prices',[$p->id]) }}" data-toggle="tooltip" data-placement="top" title="Add Daily Prices"><i class="fa fa fa-tags" aria-hidden="true"></i></a>
                                                                <a role="button" class="btn btn-danger" href="#" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ url('/isa-cms/services/delete-prices',[$p->id]) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
    <script src="{{ url('theme/backend/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
    <script>
    $(document).ready(function() { 
        //turn to inline mode
        $.fn.editable.defaults.mode = 'inline';
        
        //editables 
        $('#editable td a').editable({
            params: {
                _token: '{{ csrf_token() }}'
            },
            type: 'text',
            url: '{{ url('/isa-cms/services/update-prices') }}',
            ajaxOptions: {
                type: 'post'
            }   
        });
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