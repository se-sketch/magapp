<div class="form-group">
    <label for="name">{{__('text.nameitem')}} <font color="red">*</font></label>
    <input type="text" name="name" value="{{old('name') ?? $nomenclature->name }}" class="form-control">
    <div>{{$errors->first("name")}}</div>
</div>

<div class="form-group">
    <label for="price">{{__('text.price')}} <font color="red">*</font> </label>
    <input type="number" step="0.01" name="price" value="{{old('price') ?? $nomenclature->price }}" class="form-control">
    <div>{{$errors->first("price")}}</div>
</div>

<div class="form-group">
    <input type="checkbox" name="balance" {{old('balance', $nomenclature->balance) ? 'checked="checked"' : ''}} 
    id="balance" value="1">
    <label for="balance">{{__('text.rest')}}</label>
</div>

<div class="form-group">
    <input type="checkbox" name="active" 
    {{ old('active', $nomenclature->active) ? 'checked="checked"' : '' }}
    id="active" value="1">
    <label for="active">{{__('text.active')}}</label>
</div>


<div class="form-group">
    <label for="description">{{__('text.description')}}</label>

    <textarea name="description" id="description" class="form-control">
        {{old('description', $nomenclature->description)}}
    </textarea>
    <div>{{$errors->first("description")}}</div>
</div>


<div class="row">
    @foreach($images as $image)
        <div class="col-sm-4" id="image_{{$image->id}}">
            <p>
                <img src="{{ URL::to($image->getPathName()) }}" 
                    width="200" height="200">
            </p>
            
            <button type="button" style="color: red" 
            onclick="DeleteNomenclatureImage({{$image->id}})">
                X
            </button>

            <button type="button" onclick="SetMainImage({{$image->id}})" 
                id="button_main_{{$image->id}}" 
                class="mainButton_{{$image->main}}">
                M
            </button>
        </div>
    @endforeach
</div>

<br>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <input type="file" name="images[]" placeholder="Choose file" 
            id="images" multiple>
            @error('images')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror

            <div>{{$errors->first("images")}}</div>
        </div>
    </div>
     
</div>   


@csrf

<button type="submit" class="btn btn-primary">{{__('text.save')}}</button>