<!DOCTYPE html>

<html>

<head>

    @include('frontend.default.partials.meta')

    <title>ISA Commerce - Best Ecommerce Platform</title>

</head>

<body class="option6 category-page">

@include('frontend.default.partials.header')



<!-- page wapper-->

<div class="columns-container">

    <div class="container" id="columns">

        <!-- breadcrumb -->

        <div class="breadcrumb clearfix">

            <a class="home" href="{{url('/')}}" title="Return to Home">Home</a>

            <span class="navigation-pipe">&nbsp;</span>

            <span class="navigation_page">Your shopping cart</span>

            <input type="hidden" name="baseurl" id="baseurl" value="{{ url('/') }}">

        </div>

        <!-- ./breadcrumb -->

        <!-- page heading-->

        <h2 class="page-heading no-line">

            <span class="page-heading-title2">Shopping Cart Summary</span>

        </h2>

        <!-- ../page heading-->

        <div class="page-content page-order">

            <ul class="step">

                <li class="current-step"><span>01. Summary</span></li>

                <li><span>02. Sign in</span></li>

                <li><span>03. Address</span></li>

                <li><span>04. Shipping</span></li>

                <li><span>05. Payment</span></li>

            </ul>

            <?php $cart = ($data['cart'] != 0 ? count($data['cart']) : 0); ?>

            <div class="heading-counter warning">Your shopping cart contains:

                <span>{{$cart}} Products</span>

            </div>

            <div class="order-detail-content">

                <table class="table table-bordered table-responsive cart_summary">

                    <thead>

                        <tr>

                            <th class="cart_product">Product</th>

                            <th>Description</th>

                            <th>Avail.</th>

                            <th>Unit price</th>

                            <th>Qty</th>

                            <th>Total</th>

                            <th  class="action"><i class="fa fa-trash-o"></i></th>

                        </tr>

                    </thead>

                    <tbody id="cartTable">
                        <?php 
                        $total = 0;
                        $tax = 0; 
                        $grand_total = 0;
                        $i=0; 
                        ?>
                        <form method="post" action="checkout/quantity" name="cartForm" id="cartForm">
                        {{ csrf_field() }}
                        @foreach($data['cart'] as $c)
                            <?php 
                                $date = date('Y-m-d 00:00:00');
                                if(!empty($c->discount_amount ) && ($c->discount_amount !=0 ) && ($c->is_active == 'Y') && ($c->expiry >= $date )){
                                    if($c->discount_operation == '-'){
                                        $price = $c->price - $c->discount_amount;
                                    }elseif($c->discount_operation == '%'){
                                        $price = $c->price - ($c->price*$c->discount_amount/100);
                                    }elseif($c->discount_operation == 's'){
                                        $price = $c->discount_amount;
                                    }
                                }else{
                                    $price = $c->price;
                                }
                            ?>
                            <tr>
                                <td class="cart_product">
                                    <a href="#"><img src="{{ url('theme/backend/images/product/', [$c->image])}}" alt="Product"></a>
                                </td>
                                <td class="cart_description">
                                    <p class="product-name"><a href="#">{{$c->product_name}}</a></p>
                                    <small class="cart_ref">SKU : {{$c->sku}}</small><br>
                                    @foreach($data['value_pair'] as $v)
                                        @if($v->product_id == $c->product_id)
                                            <small>{{ $v->attribute_name }} : {{ $v->value_name }}</small><br/>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="cart_avail"><span class="label label-success" id="stock-availability_{{$i}}">In stock</span></td>
                                <td class="price"><span>{{number_format($price, 2)}}</span></td>
                                <td class="qty">
                                        <?php $qty = ($c->quantity != 0 ? $c->quantity : 1); ?>
                                        <input class="form-control input-sm" type="number" id="quantity_{{$i}}" name="quantity[{{ $i }}]" value="{{ $qty }}" onchange="cartQty({{$i}})">
                                        <!--
                                        <input class="form-control input-sm" type="number" id="quantity_{{$i}}" name="quantity[{{ $i }}]" value="{{ $qty }}">
                                        -->
                                        <input class="form-control input-sm" type="hidden" id="price_{{$i}}" name="price[{{ $i }}]" value="{{ $price }}">
                                        @if ($errors->has('quantity'))
                                            <p class="text-danger">
                                                {{ $errors->first('quantity') }}
                                            </p>
                                        @endif
                                        <input class="form-control input-sm" type="hidden" name="i" value="{{ $i }}"> 
                                        <input class="form-control input-sm" type="hidden" id="cart_{{$i}}" name="cart[{{ $i }}]" value="{{ $c->cart_id }}"> 
                                </td>
                                <td class="price">
                                    <span id="subtotal_{{$i}}">{{number_format($price*$c->quantity, 2)}}</span>
                                </td>
                                <td class="action">
                                    <a data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ url('cart/delete',[$c->cart_id]) }}">Delete item</a>
                                </td>
                            </tr>
                            <?php 
                            $total += $price*$c->quantity;
                            $tax = $total*0.1; 
                            $grand_total = $total + $tax;
                            $i++; 
                            ?>
                        @endforeach
                        <input class="form-control input-sm" type="hidden" name="val" id="val" value="{{ $i }}"> 
                        </form>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" rowspan="3"></td>
                            <td colspan="3">Total</td>
                            <td colspan="2" id="cart_total">{{number_format($total, 2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Total products (tax incl.)</strong></td>
                            <td colspan="2" id="tax">{{number_format($tax, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Grand Total (IDR)</strong></td>
                            <td colspan="2" id="grand_total"><strong>{{number_format($grand_total, 2)}}</strong></td>
                        </tr>
                    </tfoot>  
                </table>
                <div class="cart_navigation">
                    <a class="prev-btn" href="{{ url('/') }}">Continue shopping</a>
                    <a class="next-btn" href="#" id="proceed-to-checkout">Proceed to checkout</a>            
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ./page wapper-->

<div class="modal fade modal-danger" id="modal-delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="delete-confirmation-title" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                    <h4 class="modal-title" id="delete-confirmation-title">Confirmation</h4>

                </div>

                <div class="modal-body">

                    Are you sure you want to delete this item? 

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-github" data-dismiss="modal">Cancel</button>

                    <a id="delete" href="" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>

                </div>

            </div>

        </div>

    </div>



@include('frontend.default.partials.footer')

@include('frontend.default.partials.javascript')

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

<script type="text/javascript" src="{{ url('theme/frontend/default/assets/js/accounting.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
            var $tr       = $('input[name^="quantity"]').on('change', function() {
            var i         = $tr.index(this);
            var quantity  = $(this).val();
            var cart_id   = $('#cart_'+i).val();
            var baseUrl = $("#baseurl").val();
            $.ajax({
                url: baseUrl+'/update-quantity/'+cart_id+'/'+quantity,
                type: "GET",
                dataType: "json",
                success:function(data){
                    $("span#stock-availability_"+i).empty();
                    $("span#stock-availability_"+i).append(data);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#proceed-to-checkout').click(function() {
            var l;
            var k =0;
            var rowCount = $('#cartTable tr').length;
            
            for(l=0; l<rowCount; l++){
                var stock = $("span#stock-availability_"+l).text();
                if(stock == 'Out of stock'){
                    k++;
                }
            }
            if(k > 0){
                alert('Sorry, your cart contain(s) out of stock product');
            }else{
                $("#cartForm" ).submit();
            }
        });
    });
</script>
<script>
function cartQty(i){
    var total = 0;
    var qty   = document.getElementById('quantity_'+i).value;
    var prc   = document.getElementById('price_'+i).value;
    var k     = document.getElementById('val').value;
    var subtotal = qty*prc;
    if(qty < 1){
        document.getElementById('quantity_'+i).value = 1;
        alert("Minimum quantity allowed is 1");
        document.getElementById('subtotal_'+i).innerHTML = accounting.formatMoney(1*prc, "", 2, ",", ",");
    }else{
        document.getElementById('subtotal_'+i).innerHTML = accounting.formatMoney(subtotal, "", 2, ",", ",");
    }

    for (j = 0; j < k; j++) {
        var qty_tmp = document.getElementById('quantity_'+j).value;
        var prc_tmp = document.getElementById('price_'+j).value;
        total       = total + (qty_tmp*prc_tmp);
    }
    var tax         = 0.1 * total;
    var grand_total = tax + total;

    document.getElementById('cart_total').innerHTML  = accounting.formatMoney(total, "", 2, ",", ",");
    document.getElementById('tax').innerHTML         = accounting.formatMoney(tax, "", 2, ",", ",");
    document.getElementById('grand_total').innerHTML = accounting.formatMoney(grand_total, "", 2, ",", ",");
}

</script>



</body>

</html>