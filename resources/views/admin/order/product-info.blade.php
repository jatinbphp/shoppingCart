<div class="main-div d-flex">
    <div class="image-div"> 
        @if(!empty($product['product_image']['image']) && file_exists($product['product_image']['image']))
            <img src="{{url($product['product_image']['image'])}}" alt="..." width="50px">
        @else 
            <img src="{{url('assets/website/images/default-image.png')}}" alt="..." width="50px">
        @endif
    </div>

    <div class="info-div pl-3">
        {{$product['product_name']}}

        @if(!empty(json_decode($options)))
            @foreach (json_decode($options) as $keyO => $valueO)
                @php
                    $product_option = App\Models\ProductsOptions::where('id', $keyO)->first();
                    $product_option_value = App\Models\ProductsOptionsValues::where('id', $valueO)->first();
                @endphp
                        
                <p class="mb-0">
                    <small>
                        <b>{{ $product_option->option_name }} :</b> 
                        @if($product_option->option_name == 'COLOR')
                            <i class="fas fa-square" style="color: {{ $product_option_value->option_value }}"></i>
                        @else
                            {{ $product_option_value->option_value }}
                        @endif
                        <a class="editOption" href="javascript:void(0)" data-option_id="{{ $keyO }}" data-option_value_id="{{ $valueO }}" data-product_id="{{ $product['id'] }}" data-id="{{ $id }}">Edit</a>
                    </small>
                </p>
            @endforeach
        @endif

    </div>
</div>
