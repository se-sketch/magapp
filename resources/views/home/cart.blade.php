<form action="{{route('home.confirmorder')}}" method="post">
    @csrf

    

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
                    <input type="hidden" name="names[{{$row->id}}][name]" 
                    id="name_{{$row->id}}" 
                    value="{{$row->name}}">
                </td>
                <td>
                    <input type="number" 
                    name="nomenclatures[{{$row->id}}][qty]" 
                    id="nomenclature_{{$row->id}}" 
                    value="{{$row->qty}}" 
                    class="border-2 focus:border-blue-500 bg-gray-100">                    
                </td>
                <td>
                    {{$row->price}}
                    <input type="hidden" name="prices[{{$row->id}}][price]" 
                    id="price_{{$row->id}}" 
                    value="{{$row->price}}">
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


    <button type="submit">confirm order</button>
</form>
