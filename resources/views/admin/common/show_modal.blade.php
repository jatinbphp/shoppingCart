<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="commonModalLabel">{{ ucwords(str_replace('_', ' ', $type)) }} Details</h5>
    {!! Form::button('<span aria-hidden="true">&times;</span>', [
        'type' => 'button',
        'class' => 'close',
        'data-dismiss' => 'modal',
        'aria-label' => 'Close'
    ]) !!}
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    @foreach ($required_columns as $key)
                                        @if (array_key_exists($key, $section_info))
                                            <tr>
                                                <th style="width: 25%;">
                                                    @switch($key)
                                                        @case('created_at')
                                                            {!! 'Date Created' !!} :
                                                            @break
                                                        @case('parent')
                                                            {!! 'Parent Category' !!} :
                                                            @break
                                                        @default
                                                            {!! ucwords(str_replace('_', ' ', $key)) !!} :
                                                    @endswitch
                                                </th>
                                                <td>
                                                    @switch($key)
                                                        @case('image')
                                                            {!! renderImageColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('created_at')
                                                            {!! formatDate($section_info[$key]) !!}
                                                            @break
                                                        @case('id')
                                                            {!! renderIdColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('status')
                                                            {!! renderStatusColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('role')
                                                            {{ ucwords(str_replace('_', ' ', $section_info[$key])) }}
                                                            @break
                                                        @case('price')
                                                            {{ env('CURRENCY') }}{{ number_format($section_info[$key], 2) }}
                                                            @break
                                                        @case('parent')
                                                            @if(is_array($section_info[$key]))
                                                                {{ $section_info[$key]['name'] }}
                                                            @else
                                                                -
                                                            @endif
                                                            @break
                                                        @case('category')
                                                            @if(is_array($section_info[$key]))
                                                                {{ $section_info[$key]['name'] }}
                                                            @else
                                                                -
                                                            @endif
                                                            @break
                                                        @case('categories')
                                                            @if(!empty($section_info[$key]))
                                                                @foreach($section_info[$key] as $category)
                                                                    <span class="badge badge-success">{{$category['full_name']}}</span>
                                                                @endforeach
                                                            @endif
                                                            @break
                                                        @case('product_images')
                                                            @if(!empty($section_info[$key]))
                                                                <div class="row">
                                                                    @foreach($section_info[$key] as $image)
                                                                        <div class="col-md-2">
                                                                            <img src="{{ asset($image['image']) }}" style="width:100%"/>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            @break
                                                        @case('options')
                                                            @if(!empty($section_info[$key]))
                                                                @foreach ($section_info[$key] as $option)
                                                                    <strong>{{ $option['option_name'] }}:</strong>

                                                                    @if($option['option_name']=='COLOR')
                                                                        @if(!empty($option['product_option_values']))
                                                                            @foreach ($option['product_option_values'] as $index => $value)
                                                                                <i class="fas fa-square mr-2" style="color: {{ $value['option_value'] }}"></i>
                                                                            @endforeach
                                                                        @endif
                                                                    @else
                                                                        @if(!empty($option['product_option_values']))
                                                                            @foreach ($option['product_option_values'] as $index => $value)
                                                                                {{ $value['option_value'] }}
                                                                                @if (!$loop->last)
                                                                                    ,
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                                    <br>
                                                                @endforeach
                                                            @endif
                                                            @break
                                                        @default
                                                            {!! $section_info[$key] !!}
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    {!! Form::button('<i class="fa fa-times pr-1"></i> Close', [
        'type' => 'button',
        'class' => 'btn btn-sm btn-secondary',
        'data-dismiss' => 'modal'
    ]) !!}
</div>

@php
function renderImageColumn($info) {
    if (!empty($info) && file_exists($info)) {
        return '<img src="' . url($info) . '" height="50">';
    } else {
        return '<img src="' . url('assets/admin/dist/img/no-image.png') . '" height="50">';
    }
}

function formatDate($info) {
    return date('Y-m-d H:i:s', strtotime($info));
}

function renderIdColumn($info) {
    return '#' . $info;
}

function renderStatusColumn($info) {
    $class = $info == 'active' ? 'success' : 'danger';
    return '<span class="badge badge-' . $class . '">' . ucfirst($info) . '</span>';
}
@endphp
