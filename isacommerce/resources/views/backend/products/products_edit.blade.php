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
                        <li class="active">Edit</li>
                    </ol>
                    <div class="panel-heading clearfix">
                        <!-- <span><a class="btn btn-danger pull-right btn-space" href="{{ url('/isa-cms/services') }}">Cancel</a></span>
                        <button class="btn btn-success pull-right btn-space" type="submit">&nbsp; Save &nbsp;</button> -->
                    </div>
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
						<form method="post" action="{{ url('/isa-cms/products/update') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          	<input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title">Edit Product</h3>
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
															<input type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" required>
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
                                                            <select class="form-control" name="brand_id">
                                                            <option value="" selected>Select Brand</option>
                                                                    @foreach($brand as $b)
                                                                        @if($b->is_active == 'Y')
                                                                        	@if($b->id == $product->brand_id)
                                                                        		<option value="{{ $b->id }}" selected>{{ $b->name }}</option>
                                                                        	@else
                                                                            	<option value="{{ $b->id }}">{{ $b->name }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="form-group{{ $errors->has('product_description') ? ' has-error' : '' }}">
														<label class="col-md-2 control-label">Product Description:
															<span class="required text-danger"> * </span>
														</label>
														<div class="col-md-10">
															<textarea class="form-control summernote" name="product_description">{{ $product->product_description }}</textarea>
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
                                                            <textarea class="form-control summernote" name="product_detail">{{ $product->product_detail }}</textarea>
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
                                                            <textarea class="form-control summernote" name="product_spesification">{{ $product->product_spesification }}</textarea>
                                                            @if ($errors->has('product_spesification'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_spesification') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
													<div class="form-group">
														<label class="col-md-2 control-label">Categories:
															<span class="required text-danger"> * </span>
														</label>
														<div class="col-md-10">
															<div class="form-control height-auto">
																<div class="scroller" style="height:425px;" data-always-visible="1">
																	<ul class="list-unstyled">
																		<li>
																			
																			 <?php $i = 0; ?>
																			 @foreach($category as $c)
																				@if ($c->parent_id == 0)
																					<?php $i++; ?>
																					<?php $x = $c->id; $checked_1 = 0;?>
																					@foreach($product_cat as $pc)
																						@if ($pc->category_id == $x)
																							<?php $checked_1++; ?>
																						@endif
																					@endforeach

																					@if ($checked_1 > 0)
																						<label>
																						<input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $c->id }}" checked>{{ $c->category_name }}</label><br/>
																					@else
																						<label>
																						<input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $c->id }}">{{ $c->category_name }}</label><br/>
																					@endif
																						<ul class="list-unstyled">
																						<li>
																							@foreach($category as $ca)
																								@if ($ca->parent_id == $x)
																									<?php $i++; ?>
																									<?php $y = $ca->id; $checked_2 = 0;?>
																									@foreach($product_cat as $pc)
																										@if ($pc->category_id == $y)
																											<?php $checked_2++; ?>
																										@endif
																									@endforeach

																									@if ($checked_2 > 0)
																										<label>
																										<input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $ca->id }}" checked>{{ $ca->category_name }}
																										</label><br/>
																									@else
																										<label>
																										<input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $ca->id }}">
																										{{ $ca->category_name }}
																										</label><br/>
																									@endif
																									<ul class="list-unstyled">
																										<li>
																										   
																											@foreach($category as $caa)
																												@if ($caa->parent_id == $y)
																													<?php $i++; ?>
																													<?php $z = $caa->id; $checked_3 = 0;?>
																													@foreach($product_cat as $pc)
																														@if ($pc->category_id == $z)
																															<?php $checked_3++; ?>
																														@endif
																													@endforeach

																													@if ($checked_3 > 0)
																														<label>
																														<input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $caa->id }}" checked>
																														{{ $caa->category_name }}
																														</label><br/>
																													@else
																														<label>
																														<input type="checkbox" name="product[{{ $i }}][categories]" value="{{ $caa->id }}">
																														{{ $caa->category_name }}
																														</label><br/>
																													@endif
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
														</div>
													</div>        
													<div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">SKU<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<input type="text" class="form-control" name="sku" value="{{ $product->sku }}" required>
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
															<input type="text" class="form-control" name="upc" value="{{ $product->upc }}" required>
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
															<input type="text" class="form-control" name="price" value="{{ $product->price }}" required>
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
															<input type="text" class="form-control" name="weight" value="{{ $product->weight }}" required>
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
															<input type="text" class="form-control" name="quantity" value="{{ $product->quantity }}" required>
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
															<input type="text" class="form-control" name="min_quantity" value="{{ $product->min_quantity }}" required>
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
															@if ($product->subtract_quantity == "Y")
																<label class="radio-inline">
																	<input type="radio" name="subtract_quantity" id="inlineRadio1" value="Y" checked> Yes
																</label>
																<label class="radio-inline">
																	<input type="radio" name="subtract_quantity" id="inlineRadio2" value="N"> No
																</label>
															@endif
															@if ($product->subtract_quantity == "N")
																<label class="radio-inline">
																	<input type="radio" name="subtract_quantity" id="inlineRadio1" value="Y"> Yes
																</label>
																<label class="radio-inline">
																	<input type="radio" name="subtract_quantity" id="inlineRadio2" value="N" checked> No
																</label>
															@endif
															
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-2 control-label">Status<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															@if ($product->status == "Y")
																<label class="radio-inline">
																	<input type="radio" name="status" id="inlineRadio1" value="Y" checked> Enable
																</label>
																<label class="radio-inline">
																	<input type="radio" name="status" id="inlineRadio2" value="N"> Disable
																</label>
															@endif
															@if ($product->status == "N")
																<label class="radio-inline">
																	<input type="radio" name="status" id="inlineRadio1" value="Y"> Enable
																</label>
																<label class="radio-inline">
																	<input type="radio" name="status" id="inlineRadio2" value="N" checked> Disable
																</label>
															@endif
															
														</div>
													</div>
												</div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab2">
                                                <div class="form-body">  
													<div class="form-group{{ $errors->has('product_meta_title') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">Meta Tag Title<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<input type="text" class="form-control" name="product_meta_title" value="{{ $product->product_meta_title }}" required>
															@if ($errors->has('product_meta_title'))
																<span class="help-block">
																	<strong>{{ $errors->first('product_meta_title') }}</strong>
																</span>
															@endif
														</div>
													</div>   
													<div class="form-group{{ $errors->has('product_meta_keyword') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">Meta Tag Keyword<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<textarea class="form-control maxlength-handler" rows="8" name="product_meta_keyword" maxlength="255">{{ $product->product_meta_keyword }}</textarea>
															<span class="help-block"> max 255 chars </span>
															@if ($errors->has('product_meta_keyword'))
																<span class="help-block">
																	<strong>{{ $errors->first('product_meta_keyword') }}</strong>
																</span>
															@endif
														</div>
													</div>
													<div class="form-group{{ $errors->has('product_meta_description') ? ' has-error' : '' }}">
														<label class="col-sm-2 control-label">Meta Tag Description<span class="text-danger">*</span></label>
														<div class="col-sm-10">
															<textarea class="form-control maxlength-handler" rows="8" name="product_meta_description" maxlength="255">{{ $product->product_meta_description }}</textarea>
															<span class="help-block"> max 255 chars </span>
															@if ($errors->has('product_meta_description'))
																<span class="help-block">
																	<strong>{{ $errors->first('product_meta_description') }}</strong>
																</span>
															@endif
														</div>
													</div>
												</div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab3">
                                            	<?php $discount_id = (!empty($product->discount->id) ? $product->discount->id : '-'); ?>
                                            	<input type="hidden" name="discount[discount_id]" value="{{ $discount_id }}">
                                                <div class="form-body">  
                                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Amount</label>
                                                        <div class="col-sm-10">
                                                        	<?php $amount = (!empty($product->discount->discount_amount) ? $product->discount->discount_amount : ''); ?>
                                                            <input type="text" class="form-control" name="discount[amount]" value="{{ $amount }}">
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
	                                                        <?php   
	                                                        	$checked_1 = 'checked';
	                                                        	$checked_2 = '';
	                                                        	$checked_3 = '';
	                                                        	if(!empty($product->discount->discount_operation)){
	                                                        		if($product->discount->discount_operation == '%'){
																		$checked_1 = '';
																		$checked_2 = 'checked';
																	}elseif($product->discount->discount_operation == 's'){
																		$checked_1 = '';
																		$checked_3 = 'checked';
																	}
	                                                        	}
	                                                        ?>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[type]" value="-" {{ $checked_1 }}> Decrease
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[type]" value="%" {{ $checked_2 }}> Percentage
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[type]" value="s" {{ $checked_3 }}> Replace
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Active</label>
                                                        <div class="col-sm-10">
                                                        	<?php   
	                                                        	$checked_1 = 'checked';
	                                                        	$checked_2 = '';
	                                                        	if(!empty($product->discount->is_active)){
	                                                        		if($product->discount->is_active == 'N'){
																		$checked_1 = '';
																		$checked_2 = 'checked';
																	}
	                                                        	}
	                                                        ?>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[active]" value="Y" {{$checked_1}}> Yes
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="discount[active]" value="N" {{$checked_2}}> No
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('expiry') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Expiry</label>
                                                        <div class="col-sm-10">
                                                        	<?php $expiry = (!empty($product->discount->expiry) ? $product->discount->expiry : ''); ?>
                                                            <input type="text" class="form-control date-picker" name="discount[expiry]" value="{{ $expiry }}">
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