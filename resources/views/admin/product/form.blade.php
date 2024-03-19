<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">General Information</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(!isset($product)) disabled @endif" id="tab2" data-toggle="tab" href="#content2">Product Images</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(!isset($product)) disabled @endif" id="tab3" data-toggle="tab" href="#content3">Options</a>
    </li>
</ul>
<style type="text/css">
.nav-tabs .active {color: #007bff !important;}
</style>
{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="tab-content mt-2">
    <div class="row tab-pane fade show active" id="content1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'category_id', 'labelText' => 'Select Category', 'isRequired' => true])

                                {!! Form::select("category_id", $categories, null, ["class" => "form-control", "id" => "category_id"]) !!}

                                @include('admin.common.errors', ['field' => 'category_id'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'product_name', 'labelText' => 'Product Name', 'isRequired' => true])

                                {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'id' => 'product_name']) !!}

                                @include('admin.common.errors', ['field' => 'product_name'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'sku', 'labelText' => 'SKU', 'isRequired' => true])

                                {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU', 'id' => 'sku']) !!}

                                @include('admin.common.errors', ['field' => 'sku'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'description', 'labelText' => 'Description', 'isRequired' => true])

                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => '4']) !!}

                                @include('admin.common.errors', ['field' => 'description'])
                            </div>
                        </div>                    
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'type', 'labelText' => 'Type', 'isRequired' => false])

                                {!! Form::select("type",  ['' => 'Please select'] + (\App\Models\Products::$type ?? []), null, ["class" => "form-control", "id" => "type"]) !!}

                                @include('admin.common.errors', ['field' => 'type'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'price', 'labelText' => 'Price', 'isRequired' => true])

                                {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Enter Price', 'id' => 'price']) !!}

                                @include('admin.common.errors', ['field' => 'price'])
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])

                                <div class="">
                                    @foreach (\App\Models\Products::$status as $key => $value)
                                        @php $checked = !isset($product) && $key == 'active'?'checked':''; @endphp
                                        <label>
                                            {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                                        </label>
                                    @endforeach                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row tab-pane fade" id="content2">
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
                                                {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                                    'type' => 'button',
                                                    'class' => 'btn btn-danger removeImage',
                                                    'onclick' => "removeAdditionalProductImg('".$value['image']."','".$value['id']."','".$product->id."');"
                                                ]) !!}
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

    @php
    $optionValuesCounter = 1;
    @endphp

    <div class="row tab-pane fade" id="content3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <p class="h5">Add Option Values</p>
                        </div>
                    </div>
                    @if(count($product_options)>0)
                        @foreach ($product_options as $key => $option) 
                        <div class="card product-attribute" id="options_{{ $option->id }}">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                    @include('admin.common.label', ['field' => 'options', 'labelText' => 'Option Name', 'isRequired' => true])

                                                    {!! Form::text("options[old][$option->id]", $option->option_name, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Name",'readonly']) !!}

                                                    @include('admin.common.errors', ['field' => 'options'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8" id="extraValuesOption_{{ $option->id }}_{{ $option->id }}">

                                        @if(count($option->product_option_values)>0)
                                            @foreach ($option->product_option_values as $vkey => $option_value)
                                                @if($vkey==0)
                                                    <div class='row'>
                                                        <div class="col-md-12">
                                                            @include('admin.common.label', ['field' => 'option_values', 'labelText' => 'Option Values', 'isRequired' => true])
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row" id="options_values_{{ $option_value->id }}">

                                                    @if($option->option_name!='COLOR')
                                                        <div class="col-md-5">
                                                            <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                                                                {!! Form::text("option_values[old][$option->id][$option_value->id]", $option_value->option_value, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}

                                                                @include('admin.common.errors', ['field' => 'option_values'])
                                                            </div>
                                                        </div>
                                                    @else 
                                                        <div class="col-md-5">
                                                            <div class="input-group my-colorpicker2 form-group{{ $errors->has('option_values') ? ' has-error' : '' }}" data-id="{{$option_value->id}}">
                                                                {!! Form::text("option_values[old][$option->id][$option_value->id]", $option_value->option_value, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}

                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fas fa-square fa-square_{{$option_value->id}}" style="color: {{$option_value->option_value}};"></i></span>
                                                                </div>

                                                                @include('admin.common.errors', ['field' => 'option_values'])
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-md-2">
                                                        {!! Form::button('<i class="fa fa-trash"></i>', [
                                                            'type' => 'button',
                                                            'class' => 'btn btn-danger',
                                                            'onclick' => "removeOptionRow({$option_value->id}, 1)"
                                                        ]) !!}

                                                        @if($vkey==0)
                                                            {!! Form::button('<i class="fa fa-plus"></i>', [
                                                                'type' => 'button',
                                                                'class' => 'btn btn-info add-option',
                                                                'onclick' => "optionValuesBtn({$option->id}, {$option->id}, '{$option->option_name}')"
                                                            ]) !!}
                                                        @endif
                                                    </div>
                                                </div>
                                                @php
                                                $optionValuesCounter = $option_value->id;
                                                @endphp
                                            @endforeach
                                            <!-- <div id="extraValuesOption_{{ $option->id }}_{{ $option->id }}"></div> -->
                                        @else 
                                            <div class="row" id="options_values_1">
                                                <div class="col-md-12">
                                                    @include('admin.common.label', ['field' => 'option_values', 'labelText' => 'Option Values', 'isRequired' => true])
                                                </div>

                                                @if($option->option_name!='COLOR')
                                                    <div class="col-md-5">
                                                        <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                                                            {!! Form::text("option_values[new][$option->id][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}

                                                            @include('admin.common.errors', ['field' => 'option_values'])
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-5">
                                                        <div class="input-group my-colorpicker2 form-group{{ $errors->has('option_values') ? ' has-error' : '' }}" data-id="1">
                                                            {!! Form::text("option_values[new][$option->id][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value", 'data-id' => 1]) !!}

                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fas fa-square fa-square_1"></i></span>
                                                            </div>

                                                            @include('admin.common.errors', ['field' => 'option_values'])
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-2">
                                                    {!! Form::button('<i class="fa fa-trash"></i>', [
                                                        'type' => 'button',
                                                        'class' => 'btn btn-danger',
                                                        'onclick' => "removeOptionRow({{ $option->id }}, 1)"
                                                    ]) !!}

                                                    {!! Form::button('<i class="fa fa-plus"></i>', [
                                                        'type' => 'button',
                                                        'class' => 'btn btn-info add-option',
                                                        'onclick' => "optionValuesBtn({$option->id}, {$option->id}, '{$option->option_name}')"
                                                    ]) !!}
                                                </div>
                                            </div>                                            
                                            @php
                                            $optionValuesCounter = $option->id;
                                            @endphp
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card product-attribute" id="options_1">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                @include('admin.common.label', ['field' => 'options', 'labelText' => 'Option Name', 'isRequired' => true])

                                                {!! Form::text("options[new][1]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Name"]) !!}

                                                @include('admin.common.errors', ['field' => 'options'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8" id="extraValuesOption_1_1">
                                    <div class='row'>
                                        <div class="col-md-5">
                                            @include('admin.common.label', ['field' => 'option_values', 'labelText' => 'Option Values', 'isRequired' => true])
                                        </div>
                                    </div>
                                    <div class="row" id="options_values_1">
                                        <div class="col-md-5">
                                            <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                                                {!! Form::text("option_values[new][1][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}

                                                @include('admin.common.errors', ['field' => 'option_values'])
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            {!! Form::button('<i class="fa fa-trash"></i>', [
                                                'type' => 'button',
                                                'class' => 'btn btn-danger',
                                                'onclick' => 'removeOptionRow(1, 1)'
                                            ]) !!}

                                            {!! Form::button('<i class="fa fa-plus"></i>', [
                                                'type' => 'button',
                                                'class' => 'btn btn-info add-option',
                                                'onclick' => 'optionValuesBtn(1, 1)'
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                <div id="extraOption"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('jquery')
<script type="text/javascript">
var optionName = {{$optionValuesCounter}};

$('#optionBtn').on('click', function(){
    optionName = optionName + 1;

    var exOptionContent = '<div class="card product-attribute" id="options_'+optionName+'">'+
            '<div class="row p-2">'+
                '<div class="col-md-4">'+
                    '<div class="row">'+
                        '<div class="col-md-10">'+
                            '<label class="control-label" for="options">Option Name :<span class="text-red">*</span></label>'+
                            '<div class="form-group">'+
                                '<input type="text" name="options[new]['+optionName+']" class="form-control" required- placeholder="Enter Option Name">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger" onClick="removeOptionRow('+optionName+', 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-8" id="extraValuesOption_'+optionName+'_'+optionName+'">'+
                    '<div class="row">'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row" id="options_values_'+optionName+'">'+
                        '<div class="col-md-5">'+
                            '<div class="form-group">'+
                                '<input type="text" name="option_values[new]['+optionName+'][]" class="form-control" required- placeholder="Enter Option Value">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-2">'+
                            '<button type="button" class="btn btn-danger mr-1" onClick="removeOptionRow('+optionName+', 1)"><i class="fa fa-trash"></i></button>'+
                            '<button type="button" class="btn btn-info add-option" onclick="optionValuesBtn('+optionName+', '+optionName+')"><i class="fa fa-plus"></i> </button>'+
                        '</div>'+                    
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
});

function optionValuesBtn(option_value_number, option_number, option_name) {
    optionName = optionName + 1;

    var className = '';
    if(option_name=='COLOR'){
        var className = 'input-group my-colorpicker2 ';
    }

    var exOptionContent = `
    <div class="row" id="options_values_${optionName}">
        <div class="col-md-5">
            <div class="${className} form-group" data-id="${optionName}">
                <input type="text" name="option_values[new][${option_value_number}][]" class="form-control" required placeholder="Enter Option Value" data-id="${optionName}">
                ${option_name == 'COLOR' ? `
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-square fa-square_${optionName}"></i></span>
                </div>` : ''}
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger mr-1" onClick="removeOptionRow('${optionName}', 1)"><i class="fa fa-trash"></i></button>
        </div>                    
    </div>`;

    $('#extraValuesOption_'+option_value_number+'_'+option_number).append(exOptionContent);

    // Reinitialize color picker for the newly added elements
    $('.my-colorpicker2').colorpicker(); // Assuming you're using a color picker plugin
}

function removeOptionRow(divId, type){
    const removeRowAlert = createOptionAlert("Are you sure?", "Do want to delete this row", "warning");
    swal(removeRowAlert, function(isConfirm) {
        if (isConfirm) {
            var flag =  deleteRow(divId, type);
            if(flag){
                swal.close();
            }
        } else{
             swal("Cancelled", "Your data safe!", "error");
        }
    });
}

//remove the row
function deleteRow(divId, type){
    if(type==1){
        console.log($('#options_values_'+divId).parent('div').children('div').length);
        if($('#options_values_'+divId).parent('div').children('div').length <= 2){
            swal("Error", "You cannot remove all option values. If you wish to remove them, you must delete the entire option.", "error");
            return 0;
        }
        var mainDiv = $('#options_values_'+divId);
        var divWithAddOptionClass = mainDiv.find('.add-option').closest('.row');
        if(divWithAddOptionClass.length > 0){
            var addButton = divWithAddOptionClass.find('.add-option');
            var secondDiv = mainDiv.next('.row');
            var colMd2Div = secondDiv.find('.col-md-2');
            addButton.detach();
            colMd2Div.append(addButton);
        }
        $('#options_values_'+divId).remove();
    } else {
        $('#options_'+divId).remove();
        if ($(".product-attribute").length == 0) {
            $('#optionBtn').click();
        }
    }
    return 1;  
}

function createOptionAlert(title, text, type) {
    return {
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    };
}

var i = 2;
$(".imgAdd").click(function(){

    var html = '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_'+i+'">'+
                    '<div class="boxImage imgUp">'+
                        '<div class="loader-contetn loader'+i+'"><div class="loader-01"></div></div>'+
                        '<div class="imagePreview">'+
                            '<div class="text-right" style="position: absolute;">'+
                                '<button class="btn btn-danger deleteProdcutImage" data-id="'+i+'"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                            '</div>'+
                        '</div>'+
                        '<label class="btn btn-primary"> Upload<input type="file" id="file-'+i+'" class="uploadFile img" name="file[]" value="Upload Photo" style="width: 0px; height: 0px; overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1" />'+
                        '</label>'+
                    '</div>'+
                '</div>';

    $(this).closest(".row").find('.imgAdd').before(html);

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