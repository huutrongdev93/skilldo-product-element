<div class="pre-cart-box">
    @if($count == 0)
        <button class="btn product_add_to_cart_now" data-id="{{ $object->id }}">
            <span><i class="fa-thin fa-basket-shopping-simple"></i> {!! trans('element.cart.buy') !!}</span>
        </button>
    @else
        <a class="btn" href="{!! Url::permalink($object->slug) !!}">
            <span><i class="fa-thin fa-basket-shopping-simple"></i> {{ trans('element.cart.view') }}</span>
        </a>
    @endif
</div>