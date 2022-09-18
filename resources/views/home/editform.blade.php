
<div class="form-group">
    <input type="text" placeholder="{{__('text.phone')}}" name="phone" id="phone" required
    value="{{old('phone')}}" class="form-control"  onchange="searchOldOrders()">

    <div id="phone_error" style="color: red">{{$errors->first("phone")}}</div>
</div>

<div class="form-group">
    <input type="text" placeholder="{{__('text.name')}}" name="name" id="name" required
    value="{{old('name')}}" class="form-control">
    <div id="name_error" style="color: red">{{$errors->first("name")}}</div>
</div>


<div class="form-group">
    <input type="text" placeholder="{{__('text.settlement')}}" name="settlement" 
    id="settlement" value="{{old('settlement')}}" class="form-control">
    <div id="settlement_error" style="color: red">{{$errors->first("settlement")}}</div>
</div>


<div class="form-group">
    <input type="text" placeholder="{{__('text.address_street')}}" name="address" 
    id="address" value="{{old('address')}}" class="form-control">
    <div id="address_error" style="color: red">{{$errors->first("address")}}</div>
</div>

<div class="form-group">
    <input type="text" placeholder="{{__('text.comment')}}" name="comment" 
    id="comment" value="{{old('comment')}}" class="form-control">
    <div id="comment_error" style="color: red">{{$errors->first("comment")}}</div>
</div>


@csrf

<button type="submit" class="btn btn-outline-dark pl-5 pr-5">{{__('text.save')}}</button>

