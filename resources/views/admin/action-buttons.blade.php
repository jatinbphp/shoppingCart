@if($section_name!='contactus' && $section_name!='cart_products' && $section_name!='orders')
<div class="btn-group btn-group-sm">
    <a href="{{ url('admin/'.$section_name.'/'.$id.'/edit') }}" title="Edit {{$section_title}}" class="btn btn-sm btn-info tip mr-1">
        <i class="fa fa-edit"></i>
    </a>
</div>
@endif
@if($section_name!='content' && $section_name!='cart_products')
<span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
    <button class="btn btn-sm btn-danger deleteRecord" data-id="{{$id}}" type="button" data-url="{{ url('admin/'.$section_name.'/'.$id) }}" data-section="{{$section_name}}_table">
        <i class="fa fa-trash"></i>
    </button>
</span>
@endif
@if($section_name=='cart_products')
<span data-toggle="tooltip" title="Delete {{$section_title}}" data-trigger="hover">
    <button class="btn btn-sm btn-danger deleteCartRecord" data-id="{{$id}}" type="button">
        <i class="fa fa-trash"></i>
    </button>
</span>
@endif
@if($section_name=='orders')
<div class="btn-group btn-group-sm">
    <a href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" class="btn btn-sm btn-warning tip mr-1 order-info" data-url="{{ route('orders.show', ['order' => $id]) }}">
        <i class="fa fa-eye"></i>
    </a>
</div>
@else
<div class="btn-group btn-group-sm">
    <a href="javascript:void(0)" title="View {{$section_title}}" data-id="{{$id}}" class="btn btn-sm btn-warning tip mr-1 view-info" data-url="{{ route($section_name.'.show', [$section_name != 'contactus' ? strtolower(str_replace(' ', '_', $section_title)) : 'contactu' => $id]) }}">
        <i class="fa fa-eye"></i>
    </a>
</div>
@endif