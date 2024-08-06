<h1>{{$title}}</h1>
<hr>
<p>Name: {{$bill->customer_name}}</p>
<p>Phone number: {{$bill->customer_phone}}</p>
<p>Address: {{$bill->customer_address}}</p>
<p>Payment method: {{$bill->payment_method}}</p>
<p>Payment status: <span style="color: red; font-weight:700">{{$bill->is_paid ? 'Paid' : 'Unpaid'}}</span></p>
<p>Order status: <span style="color: red; font-weight:700">{{ucwords($bill->status)}}</span></p>
<p>Total Discount: {{$bill->total_discount}}$</p>
<p>Total Price: {{$bill->total_price}}$</p>
<p>Created at: {{$bill->created_at}}</p>
<p>Note: {{$bill->customer_note}}</p>

<table style="width: 100%" align="center">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Unit price</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody align="center">
        @foreach($bill->billDetails as $key => $billDetail)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$billDetail->product_name}}</td>
            <td>{{$billDetail->product_size}}</td>
            <td>{{$billDetail->product_color}}</td>
            <td>{{$billDetail->unit_price}}$</td>
            <td>{{$billDetail->quantity}}</td>
            <td>{{$billDetail->unit_price * $billDetail->quantity}}$</td>
        </tr>
        @endforeach
</table>