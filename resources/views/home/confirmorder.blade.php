<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>

        @foreach(Cart::content() as $row)

            <tr>
                <td>
                    <p><strong>{{$row->name}}</strong></p>
                </td>
                <td>
                	{{$row->qty}}
                </td>
                <td>
                    {{$row->price}}
                </td>
                <td>{{$row->total}}</td>
            </tr>

        @endforeach

    </tbody>
    
    <tfoot>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Subtotal</td>
            <td>{{Cart::subtotal()}}</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Tax</td>
            <td>{{Cart::tax()}}</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td>Total</td>
            <td>{{Cart::total()}}</td>
        </tr>
    </tfoot>
</table>

