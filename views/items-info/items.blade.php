<div class="product-detail-items-info" style="--prd-item-info-per-row: {!! $itemInfo['number'] !!};  --prd-item-info-heading: {!! $itemInfo['headingColor'] !!};  --prd-item-info-desc: {!! $itemInfo['descColor'] !!};">
    <div class="item-info-wrapper">
    @foreach ($itemInfo['items'] as $key => $item)
        <div class="item-info item{{ $key }}" data-aos-delay="{{ $number++*100 }}" data-aos="fade-up" data-aos-duration="500">
            <div class="item-img">{!! Template::img($item['image'], $item['title']) !!}</div>
            <div class="item-title">
                @if(!empty($item['title']))
                    <p class="item-heading">{!! $item['title'] !!}</p>
                @endif
                @if(!empty($item['description']))
                    <p class="item-description">{!! $item['description'] !!}</p>
                @endif
            </div>
        </div>
    @endforeach
    </div>
</div>