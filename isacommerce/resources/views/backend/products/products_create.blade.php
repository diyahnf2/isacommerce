@extends('backend.layout.layout')
@section('singlecss')
<link href="{{ url('theme/backend/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ url('theme/backend/plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>

@endsection
@section('content')
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        @include('backend.layout.navigation')
        <div class="page-inner">
            <div class="page-title">
                <h3>Products</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/isa-cms/products') }}">Products</a></li>
                        <li class="active">Create</li>
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
                        <form method="post" action="{{ url('/isa-cms/products/store') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title">Add Product</h3>
                                </div>
                                <div class="panel-body form-horizontal">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab">General Information</a></li>
                                            <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">SEO</a></li>
                                            <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Discount</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                                <div class="form-body">
                                                    <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Product Name<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}">
                                                            @if ($errors->has('product_name'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Brand</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="brand_id" required id="province">
                                                                    @foreach($brand as $b)
                                                                        @if($b->is_active == 'Y')
                                                                            <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('product_description') ? ' has-error' : '' }}">
                                                        <label class="col-md-2 control-label">Product Description:
                                                            <span class="text-danger"> * </span>
                                                        </label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control summernote" name="product_description">{{ old('product_description') }}</textarea>
                                                            @if ($errors->has('product_description'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_description') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('product_detail') ? ' has-error' : '' }}">
                                                        <label class="col-md-2 control-label">Product Detail:
                                                            <span class="text-danger"> * </span>
                                                        </label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control summernote" name="product_detail">{{ old('product_detail') }}</textarea>
                                                            @if ($errors->has('product_detail'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_detail') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('product_spesification') ? ' has-error' : '' }}">
                                                        <label class="col-md-2 control-label">Product Spesification:</label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control summernote" name="product_spesification">{{ old('product_spesification') }}</textarea>
                                                            @if ($errors->has('product_spesification'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_spesification') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('product') ? ' has-error' : '' }}">
                                                        <label class="col-md-2 control-label">Categories:
                                                            <span class="text-danger"> * </span>
                                                        </label>
                                                        <div class="col-md-10">
                                                            <div class="form-control height-auto">
                                                                <div class="scroller" style="height:425px;" data-always-visible="1">
                                                                    <ul class="list-unstyled">
                                                                        <li>
                                                                            <label>
                                                                            <?php $i = 0; ?>
                                                                             @foreach($category as $c)
                                                                                @if ($c->parent_id == 0)
                                                                                    <?php $i++; 
                                                                                    $x = $c->id; ?>
                                                                                    <input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $c->id }}">
                                                                                    {{ $c->category_name }}</label><br/>
                                                                                    <ul class="list-unstyled">
                                                                                        <li>
                                                                                            
                                                                                            @foreach($category as $ca)
                                                                                                @if ($ca->parent_id == $x)
                                                                                                    <?php $i++; ?>
                                                                                                    <?php $y = $ca->id; ?>
                                                                                                    <label>
                                                                                                    <input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $ca->id }}">{{ $ca->category_name }}
                                                                                                    </label><br/>
                                                                                                    <ul class="list-unstyled">
                                                                                                        <li>
                                                                                                            
                                                                                                            @foreach($category as $caa)
                                                                                                                @if ($caa->parent_id == $y)
                                                                                                                    <?php $i++; ?>
                                                                                                                    <label>
                                                                                                                    <input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $caa->id }}">
                                                                                                                    {{ $caa->category_name }}
                                                                                                                    </label><br/>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </li>
                                                                                    </ul>
                                                                                @endif
                                                                           @endforeach
                                                                           <input type="hidden" name="lenght" value="{{ $i }}">
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <span class="help-block"> select one or more categories </span>
                                                            @if ($errors->has('product'))
                                                                <span class="help-block">
                                                                    <strong>at least one category required</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>        
                                                    <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">SKU<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="sku" value="{{ old('sku') }}">
                                                            @if ($errors->has('sku'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('sku') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('upc') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">UPC<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="upc" value="{{ old('upc') }}">
                                                            @if ($errors->has('upc'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('upc') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Price<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                                            @if ($errors->has('price'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('price') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Weight (kg)<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="weight" value="{{ old('weight') }}">
                                                            @if ($errors->has('weight'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('weight') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Quantity<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}">
                                                            @if ($errors->has('quantity'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('min_quantity') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Minimum Quantity<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="min_quantity" value="{{ old('min_quantity') }}">
                                                            @if ($errors->has('min_quantity'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('min_quantity') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Subtract Quantity<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <label class="radio-inline">
                                                              <input type="radio" name="subtract_quantity" id="inlineRadio1" value="Y" checked> Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" name="subtract_quantity" id="inlineRadio2" value="N"> No
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Status<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <label class="radio-inline">
                                                              <input type="radio" name="status" id="inlineRadio1" value="Y" checked> Enable
                                                            </label>
                                                            <label class="radio-inline">
                                                              <input type="radio" name="status" id="inlineRadio2" value="N"> Disable
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab2">
                                                <div class="form-body">  
													<div class="form-group{{ $errors->has('product_meta_title') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">Meta Tag Title<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<input type="text" class="form-control" name="product_meta_title" value="{{ old('product_meta_title') }}">
															@if ($errors->has('product_meta_title'))
																<span class="help-block">
																	<strong>{{ $errors->first('product_meta_title') }}</strong>
																</span>
															@endif
														</div>
													</div> 
													<div class="form-group{{ $errors->has('product_meta_description') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">Meta Tag Description<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<textarea class="form-control maxlength-handler" rows="8" name="product_meta_description" maxlength="255">{{ old('product_meta_description') }}</textarea>
															<span class="help-block"> max 255 chars </span>
															@if ($errors->has('product_meta_description'))
																<span class="help-block">
																	<strong>{{ $errors->first('product_meta_description') }}</strong>
																</span>
															@endif
														</div>
													</div>
													<div class="form-group{{ $errors->has('meta_keyword') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">Meta Keyword<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<textarea class="form-control maxlength-handler" rows="8" name="meta_keyword" maxlength="255">{{ old('meta_keyword') }}</textarea>
															<span class="help-block"> max 255 chars </span>
															@if ($errors->has('meta_keyword'))
																<span class="help-block">
																	<strong>{{ $errors->first('meta_keyword') }}</strong>
																</span>
															@endif
														</div>
													</div>
												</div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab3">
                                                <div class="form-body">  
                                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Amount</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="discount[amount]" value="{{ old('discount[amount]') }}">
                                                            @if ($errors->has('amount'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Type</label>
                                                        <div class="col-sm-10">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[type]" value="-" checked> Decrease
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[type]" value="%"> Percentage
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[type]" value="s"> Replace
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Active</label>
                                                        <div class="col-sm-10">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[active]" value="Y" checked> Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[active]" value="N"> No
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('expiry') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Expiry</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control date-picker" name="discount[expiry]" value="{{ old('discount[expiry]') }}">
                                                            @if ($errors->has('expiry'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('expiry') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="panel-footer">
									<button class="btn btn-success btn-space" type="submit">Submit</button>
									<a class="btn btn-danger btn-space" href="{{ url('/cms/services') }}">Cancel</a>
								</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('backend.layout.footer')
        </div><!-- Page Inner -->
    </main><!-- Page Content -->
    @include('backend.layout.hide-menu')
    <div class="cd-overlay"></div>
    @include('backend.layout.javascript')
    <script src="{{ url('theme/backend/plugins/summernote-master/summernote.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150
        });
    });
    </script>
    <script src="{{ url('theme/backend/isa-cms/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    
    <script src="{{ url('theme/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.date-picker').datepicker({
                orientation: "top auto",
                autoclose: true
            });
        }); 
    </script>
</body>
@endsection