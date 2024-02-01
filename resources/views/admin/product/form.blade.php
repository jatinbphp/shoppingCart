{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
            <label class="control-label" for="category_id">Select Category :<span class="text-red">*</span></label>

            <select id="category_id" name="category_id" class="form-control">
                <option value="">--Select Category--</option>
                @foreach ($categories as $key => $val)
                    @php $selected = isset($product) && $product->category_id == $val->id?'selected':''; @endphp
                    <option value="{{$val->id}}" {{$selected}}>{{$val->categoryName}}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
            <label class="control-label" for="product_name">Product Name :<span class="text-red">*</span></label>
            {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'id' => 'product_name']) !!}
            @if ($errors->has('product_name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('product_name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
            <label class="control-label" for="sku">SKU :<span class="text-red">*</span></label>
            {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU', 'id' => 'sku']) !!}
            @if ($errors->has('sku'))
                <span class="text-danger">
                    <strong>{{ $errors->first('sku') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label" for="description">Description :<span class="text-red">*</span></label>
            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => '4']) !!}
            @if ($errors->has('description'))
                <span class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <label class="control-label" for="price">Price :<span class="text-red">*</span></label>
            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Enter Price', 'id' => 'price']) !!}
            @if ($errors->has('price'))
                <span class="text-danger">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Products::$status as $key => $value)
                        @php $checked = !isset($product) && $key == 'active'?'checked':''; @endphp
                    <label>
                        {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                    </label>
                @endforeach
                <br class="statusError">
                @if ($errors->has('status'))
                    <span class="text-danger" id="statusError">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row additionalImageClass">
                    <div class="col-lg-12 mb-2">
                        <h5>Add Product Images</h5>
                    </div>

                    <?php 
                    if(!empty($product)){
                        if (!empty($product->product_images)) {
                            foreach ($product->product_images as $key => $value) { ?>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="imagePreviewPlus">
                                        <div class="text-right">
                                            <button type="button" class="btn btn-danger removeImage" onclick="removeAdditionalProductImg('<?php echo $value['image']; ?>','<?php echo $value['id']; ?>','<?php echo $product->id; ?>');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                        <img style="width: inherit; height: inherit;" @if(!empty($value['image'])) src="{{ url($value['image'])}}" @endif alt="">
                                    </div>
                                </div>
                            <?php 
                            }
                        }
                    } ?>

                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                        <div class="boxImage imgUp">
                            <div class="loader-contetn loader1">
                                <div class="loader-01"> </div>
                            </div>
                            <div class="imagePreview"></div>
                            <label class="btn btn-primary">
                                Upload<input type="file" name="file[]" class="uploadFile img" id="file-1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1">
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 imgAdd">
                        <div class="imagePreviewPlus imgUp"><i class="fa fa-plus fa-4x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-2">
                        <h5>Add Options</h5>
                    </div>

                    <select id="category_id" name="category_id" class="form-control">
                        <option value="">--Select Option--</option>
                        @foreach ($options as $key => $option)                            
                            <option value="{{$option->id}}" {{$selected}}>{{$option->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
var i = 2;
$(".imgAdd").click(function(){
    $(this).closest(".row").find('.imgAdd').before('<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_'+i+'"><div class="boxImage imgUp"><div class="loader-contetn loader'+i+'"><div class="loader-01"> </div></div><div class="imagePreview"><div class="text-right" style="position: absolute;"><button class="btn btn-danger deleteProdcutImage" data-id="'+i+'"><i class="fa fa-trash" aria-hidden="true"></i></button>'+'</div></div><label class="btn btn-primary">Upload<input type="file" id="file-'+i+'" class="uploadFile img" name="file[]" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;" data-overwrite-initial="false" data-min-file-count="1"></label></div></div>');

    i++;
});

$(document).on("click", ".deleteProdcutImage" , function() {
    var id = $(this).data('id');
    $(document).find('#imgBox_'+id).remove(); 
});

$(function() {
    $(document).on("change",".uploadFile", function(){
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAdditionalProductImg(img_name, image_id, product_id){
    swal({
            title: "Are you sure?",
            text: "You want to delete this image",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "{{route('products.removeimage')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    'id': image_id,
                    'product_id': product_id,
                    'img_name': img_name,
                 },
                success: function(data){                        
                    swal("Deleted", "Your image successfully deleted!", "success");
                }
            });
        } else {
            swal("Cancelled", "Your data safe!", "error");
        }
    });
}
</script>
@endsection