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
                <h3>Product Combination</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/isa-cms/dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ url('/isa-cms/products') }}">Products</a></li>
                        <li><a href="{{ url('/isa-cms/products/combination/list',[$data['id']]) }}">Combinations</a></li>
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
                         <form method="post" action="{{ url('/isa-cms/products/combination/store') }}" name="formCombination">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="parent_id" value="{{ $data['id'] }}" />
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title">Add Combination</h3>
                                </div>
                                <div class="panel-body form-horizontal">
                                    <div role="tabpanel">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab">General Information</a></li>
                                            <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Discount</a></li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                                <div class="form-body">
                                                    <div class="form-group">
                                                    <label class="col-sm-2 control-label">Attributes<span class="text-danger">*</span></label>
                                                        <div class="col-sm-6">
                                                            <select name="attribute" class="form-control" id="attribute" required>
                                                                <option value="">-- Attribute --</option>
                                                                @foreach($data['attribute'] as $a)
                                                                     <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Values<span class="text-danger">*</span></label>
                                                        <div class="col-sm-6">
                                                            <select name="values" class="form-control" id="values" required>
                                                            <option value=""> -- Select Attribute First --</option></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"><span class="text-danger"></span></label>
                                                        <div class="col-sm-6">
                                                            <button type="button" class="btn green" onclick="appendAttr()">
                                                            <i class="fa fa-check"></i>Add</button>
                                                            <button type="button" class="btn green" onclick="removeAttr()">
                                                            <i class="fa fa-remove"></i> Remove</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('attrVal') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Attribute Value Pair<span class="text-danger">*</span></label>
                                                        <div class="col-sm-6">
                                                            <select multiple class="form-control" name="attrVal[]" id="attrVal"></select>
                                                            @if ($errors->has('attrVal'))
                                                                <span class="help-block">
                                                                    <strong>Attribute value is required</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Quantity<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="quantity" value="{{ $data['product']->quantity }}" required>
                                                            @if ($errors->has('quantity'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('quantity') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Price<span class="text-danger">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="price" value="{{ $data['product']->price }}" required>
                                                            @if ($errors->has('price'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('price') }}</strong>
                                                                </span>
                                                            @endif
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
                                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                                        <label class="col-sm-2 control-label">Amount</label>
                                                        <div class="col-sm-10">
                                                            <?php $amount = (!empty($data['product']->discount->discount_amount) ? $data['product']->discount->discount_amount : ''); ?>
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
                                                                if(!empty($data['product']->discount->discount_operation)){
                                                                    if($data['product']->discount->discount_operation == '%'){
                                                                        $checked_1 = '';
                                                                        $checked_2 = 'checked';
                                                                    }elseif($data['product']->discount->discount_operation == 's'){
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
                                                                if(!empty($data['product']->discount->is_active)){
                                                                    if($data['product']->discount->is_active == 'N'){
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
                                                            <?php $expiry = (!empty($data['product']->discount->expiry) ? $data['product']->discount->expiry : ''); ?>
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
                                    <a class="btn btn-danger btn-space" href="{{ url('/isa-cms/products/combination/list',[$data['id']]) }}">Cancel</a>
                                    <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="attribute"]').on('change', function() {
                var attributeID = $(this).val();
                var baseUrl = $("#baseurl").val();
                if(attributeID) {
                    $.ajax({
                        url: baseUrl+'/values/'+attributeID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="values"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="values"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="values"]').empty();
                }
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150
        });
    });
    </script>
    <script >
        function appendAttr(){
            var attrselect = document.getElementById("attribute");
            var attrText   = attrselect.options[attrselect.selectedIndex].text;
            var attrVal    = attrselect.options[attrselect.selectedIndex].value;

            var valselect = document.getElementById("values");
            var valText   = valselect.options[valselect.selectedIndex].text;
            var valVal    = valselect.options[valselect.selectedIndex].value;

            if(attrVal == '' || valVal == ''){
                alert("Please choose a value !");
            }else{
                //var hasOption = $('#attrVal option[value="' + attrVal+"|"+valVal + '"]');
                var j = 0;
                for (i = 0; i < document.getElementById("attrVal").length; i++){
                    var value     = document.getElementById("attrVal").options[i].value;
                    var splitVal  = value.split("|",1); 
                    if (splitVal == attrVal){
                      j = j + 1;
                    }
                }
                if(j == 0){
                    var x = document.getElementById("attrVal");
                    var option   = document.createElement("option");
                    option.text  = attrText+" : "+valText;
                    option.value = attrVal+"|"+valVal;
                    x.add(option);
                }else{
                    alert("You can only add one combination per attribute type !");
                }
            }
        }

        function removeAttr() {
            var x = document.getElementById("attrVal");
            x.remove(x.selectedIndex);
        }
    </script>
    <script type="text/javascript">
    jQuery('[name="formCombination"]').on("submit",selectAll);

    function selectAll() 
    { 
        jQuery('[name="attrVal[]"] option').prop('selected', true);
    }

    </script>
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