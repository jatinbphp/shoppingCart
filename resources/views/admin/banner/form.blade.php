{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            <label class="control-label" for="title">Title :<span class="text-red">*</span></label>
            {!! Form::text('title', $banner->title ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}
            @if ($errors->has('title'))
                <span class="text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
            <label class="control-label" for="subtitle">Subtitle :<span class="text-red">*</span></label>
            {!! Form::text('subtitle', $banner->subtitle ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Subtitle', 'id' => 'subtitle']) !!}
            @if ($errors->has('subtitle'))
                <span class="text-danger">
                    <strong>{{ $errors->first('subtitle') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label class="control-label" for="address">Description   :<span class="text-red">*</span></label>
            {!! Form::textarea('description', $banner->description ?? null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => 3]) !!}
            @if ($errors->has('description'))
                <span class="text-danger">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row tab-pane">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row additionalImageClass">
                    <div class="col-lg-12 mb-2">
                        <h5>Add Banner Images</h5>
                    </div>
                    @if (isset($banner->image) && !empty($banner->image))
                        @foreach ($banner->image as $key => $value)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_{{ $key }}">
                                <input type="hidden" name="hidden_image[]" value={{ $value ?? null }}>
                                <div class="boxImage imgUp">
                                    <div class="loader-contetn loader1">
                                        <div class="loader-01"> </div>
                                    </div>
                                    <div class="imagePreview" style="background-image: url('{{ url($value) }}');">
                                        <div class="text-right" style="position: absolute;">
                                            <button class="btn btn-danger deleteProdcutImage" data-id="{{ $key }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </div>
                                    </div>

                                    <label class="btn btn-primary">
                                        Upload<input type="file" name="image[]" multiple class="uploadFile img" id="file-1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1">
                                    </label>
                                </div>
                            </div>
                        @endforeach                        
                    @endif

                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                        <div class="boxImage imgUp">
                            <div class="loader-contetn loader1">
                                <div class="loader-01"> </div>
                            </div>
                            <div class="imagePreview"></div>
                            <label class="btn btn-primary">
                                Upload<input type="file" name="image[]" multiple class="uploadFile img" id="file-1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1">
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 imgAdd">
                        <div class="imagePreviewPlus imgUp"><i class="fa fa-plus fa-4x"></i></div>
                    </div>
                </div>
                @error('image')
                    <div>
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="">
                @foreach (\App\Models\Banner::$status as $key => $value)
                        @php $checked = !isset($banner) && $key == 'active'?'checked':''; @endphp
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
@section('jquery')
<script type="text/javascript">
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
            '<label class="btn btn-primary"> Upload<input type="file" id="file-'+i+'" class="uploadFile img" name="image[]" multiple value="Upload Photo" style="width: 0px; height: 0px; overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1" />'+
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
</script>
@endsection