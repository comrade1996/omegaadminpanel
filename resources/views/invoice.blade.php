
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="/css/invoice.css">
</head>
<body>
<?php
date_default_timezone_set('Africa/Cairo');
$date = date('m/d/Y h:i:s a', time());
$id = \Request::get('id');

$sells= \Request::get('sells');
$sells = json_decode($sells);
$subtotal = \Request::get('subtotal');
$discount = \Request::get('discount');
$grandtotal = \Request::get('grandtotal');
?>
<div id="app">
    <header>
        <h1> Almohebeen Invoice</h1>
</header>
<article>
    <address>
        <p>Khartoum,alkalakla sharg<br>
        <p>(249) 27549029</p>
    </address>
    <table class="meta">
        <tr>
            <th><span >Invoice ID</span></th>
            <td><span >{{$id}}</span></td>
        </tr>
        <tr>
            <th><span >Date</span></th>
            <td><span >{{$date}}</span></td>
        </tr>
        <tr>
            <th><span>Created by</span></th>
            <td><span>{{Auth::user()->name}}</span></td>
        </tr>
    </table>
    <table class="inventory">
        <thead>
        <tr>
            <th><span >Item</span></th>
            <th><span >Quantity</span></th>
            <th><span >Price</span></th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($sells);$i++)
        <tr >
            <td><span >{{$sells[$i]->name}}</span></td>
            <td><span >{{$sells[$i]->quantity}}</span></td>
            <td><span data-prefix></span><span>{{$sells[$i]->sellingprice}}</span></td>
        </tr>

        @endfor
        </tbody>
    </table>
    <table class="balance">
        <tr>
            <th><span >Sub Total</span></th>
            <td><span data-prefix></span><span>{{$subtotal}}</span></td>
        </tr>
        <tr>
            <th><span >Discount</span></th>
            <td><span data-prefix></span><span >{{$discount}}</span></td>
        </tr>
        <tr>
            <th><span >Grand Total</span></th>
            <td><span data-prefix></span><span> {{   $grandtotal }}</span></td>
        </tr>
    </table>
</article>
<aside>
    <h1><span >Additional Notes</span></h1>
    <div contenteditable>
        <p contenteditable> notes</p>
    </div>
</aside>
</div>
<script>

</script>
</body>
</html>
