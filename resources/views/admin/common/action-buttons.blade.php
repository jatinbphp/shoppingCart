@if (!in_array($section_name, ['contactus', 'cart_products', 'order_products']) && !isset($order_dashboard))
    
    @php
        $title = 'Edit '.$section_title;
        $disabledEdit = ''; 
        if(($section_name == 'orders' && $status != 'pending') || isset($user['deleted_at'])){
            $disabledEdit = 'disabled'; 
            $title = 'You cannot edit this order because its status is '.$status;
        }
    @endphp
    
    <div class="btn-group btn-group-sm">
        <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="{{$title}}" class="btn btn-sm btn-info tip {{$disabledEdit}}">
            <i class="fa fa-edit"></i>
        </a>
    </div>
@endif

@if (!in_array($section_name, ['content', 'cart_products', 'order_products']) && !isset($order_dashboard))
    <span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'class' => 'btn btn-sm btn-danger deleteRecord',
            'data-id' => $id,
            'type' => 'button',
            'data-url' => url('admin/'.$section_name.'/'.$id),
            'data-section' => $section_name.'_table'
        ]) !!}
    </span>
@endif

@if ($section_name === 'orders')
    <div class="btn-group btn-group-sm">
        <a href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" class="btn btn-sm btn-warning tip  order-info" data-url="{{ route('orders.show', ['order' => $id]) }}">
            <i class="fa fa-eye"></i>
        </a>
    </div>
@elseif (!in_array($section_name, ['cart_products', 'order_products']))
    <div class="btn-group btn-group-sm">
        <a href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" class="btn btn-sm btn-warning tip  view-info" data-url="{{ route($section_name.'.show', [$section_name != 'contactus' ? strtolower(str_replace(' ', '_', $section_title)) : 'contactu' => $id]) }}">
            <i class="fa fa-eye"></i>
        </a>
    </div>
@endif

@if (in_array($section_name, ['cart_products', 'order_products']))
    <span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
        {!! Form::button('<i class="fa fa-trash"></i>', [
            'class' => 'btn btn-sm btn-danger deleteCartRecord',
            'data-id' => $id,
            'type' => 'button',
        ]) !!}
    </span>
@endif

<!-- @if ($section_name === 'products')
    <div class="btn-group btn-group-sm">
        <a href="{{ route('product.reviews.list', ['id' => $id]) }}" title="{{$section_title}} Reviews" class="btn btn-sm btn-secondary tip">
            <i class="fa fa-star"></i>
        </a>
    </div>
@endif -->
