<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->

  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->

  <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->

  <title>Single Column</title>

  

  <style type="text/css">

body {

  margin: 0;

  padding: 0;

  -ms-text-size-adjust: 100%;

  -webkit-text-size-adjust: 100%;

}



table {

  border-spacing: 0;

}



table td {

  border-collapse: collapse;

}



.ExternalClass {

  width: 100%;

}



.ExternalClass,

.ExternalClass p,

.ExternalClass span,

.ExternalClass font,

.ExternalClass td,

.ExternalClass div {

  line-height: 100%;

}



.ReadMsgBody {

  width: 100%;

  background-color: #ebebeb;

}



table {

  mso-table-lspace: 0pt;

  mso-table-rspace: 0pt;

}



img {

  -ms-interpolation-mode: bicubic;

}



.yshortcuts a {

  border-bottom: none !important;

}



@media screen and (max-width: 599px) {

  .force-row,

  .container {

    width: 100% !important;

    max-width: 100% !important;

  }

}

@media screen and (max-width: 400px) {

  .container-padding {

    padding-left: 12px !important;

    padding-right: 12px !important;

  }

}

.ios-footer a {

  color: #aaaaaa !important;

  text-decoration: underline;

}

</style>

</head>



<body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">



<!-- 100% background wrapper (grey background) -->

<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
  <tr>
    <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">
      <br>
      <!-- 600px container (white background) -->
      <table class="table" border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
        <tr>
          <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
            <br>
            <div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;text-align:center;font-weight:600;color:#282828;" >Hi! <br><br>This is your booking summary :
            </div>
            <hr>
            <div class="body-text" style="font-family:Helvetica, Arial, sans-serif;color:#282828;font-size:14px;line-height:20px;text-align:center;">
            <center>

            <table cellpadding="5" cellspacing="0">
                <tr>
                <td colspan="5">
                <center>
                {{$data['order']->firstname}} {{$data['order']->lastname}} <br>
                {{$data['order']->address}} {{$data['order']->city}}, {{$data['order']->postcode}}  <br>
                {{$data['order']->invoice_no}} - {{$data['order']->status}}
                </center>
                </td>
                </tr>
                <td colspan="5"><hr></td>
                <?php
                $total = 0;
                foreach ($data['detail'] as $d) {
                  $sub =  $d->price * $d->quantity; 
                  $total = $sub + $total;
                  echo "<tr>";
                  echo '<td>'.$d->product_name.'</td>';
                  echo '<td>'.$d->quantity.'</td>';
                  echo '<td> x </td>';
                  echo '<td>'.number_format($d->price, 2).'</td>';
                  echo '<td>'.number_format($sub, 2).'</td>';
                  echo "</tr>";
                }
                echo '<td colspan="5"><hr> <td>+</td></td>';
                echo '<td colspan="5"><hr></td>';
                echo '<tr><td>Total</td><td></td><td></td><td></td><td>'.number_format($total, 2).'</td></tr>';
                echo '<tr><td>Tax</td><td></td><td></td><td></td><td>'.number_format($total*0.1, 2).'</td></tr>';
                ?>
                <td colspan="5"><hr> <td>+</td></td>
                <td colspan="5"><hr></td>
                <tr><td>Grand Total (IDR.)</td><td></td><td></td><td></td>
                <td>{!! number_format($total+($total*0.1), 2) !!}</td>
                </tr>
            </table>
            </center>
            <br>
            <br>
            <div style="font-family:Helvetica, Arial, sans-serif;color:#282828;font-size:14px;line-height:20px;text-align:center;">
            Thank you ! <br>
            </div> 
            <br><br>
          </div>
          </td>
          </tr>
          <tr>
            <td class="container-padding footer-text" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;text-align:center;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">

              <br><br>

              <strong>IsaCommerce</strong><br>

              <span class="ios-footer">

               Managed by Ide Solusi Asia <br>

              </span>

              <a href="http://featours.com/" style="color:#aaaaaa">www.isacommerce.com</a><br>



              <br><br>



            </td>

          </tr>

        </table>

<!--/600px container -->

        </td>

      </tr>

</table>

<!--/100% background wrapper-->



</body>

</html>

