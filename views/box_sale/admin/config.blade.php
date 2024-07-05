<div class="box mb-3">
    <div class="box-header"><h4 class="box-title">Loại</h4></div>
    <div class="box-content">
        <div class="row">
            <div class="col-md-6">
                <div class="radio">
                    <label class="text-center">
                        <img src="{!! PR_EL_PATH.'/assets/images/sale/style1.png' !!}" style="max-width: 100%;" alt="">
                        <input type="radio" name="box_sale[style]" value="1" {{ (Product_Element_Box_Sale::config('style') == 1) ? 'checked' : '' }}>
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="radio">
                    <label class="text-center">
                        <img src="{!! PR_EL_PATH.'/assets/images/sale/style2.png' !!}" style="max-width: 100%;" alt="">
                        <input type="radio" name="box_sale[style]" value="2" {{ (Product_Element_Box_Sale::config('style') == 2) ? 'checked' : '' }}>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box mb-3">
    <div class="box-header"><h4 class="box-title">TEXT</h4></div>
    <div class="box-content">
        <div class="row">
            @php
            $form = form();
            $form->number('box_sale[position]', ['label' => 'Thứ tự gắn vào hook "product_detail_info"'], Product_Element_Box_Sale::config('position'));
            $form->text('box_sale[title]', ['label' => 'Tiêu đề'], Product_Element_Box_Sale::config('title'));
            @endphp
            {!! $form->html(); !!}
        </div>
    </div>
</div>


<div class="box mb-3">
    <div class="box-header"><h4 class="box-title">Style</h4></div>
    <div class="box-content">
        <div class="row">
            @php
                $form = form();
                $form->text('box_sale[padding]',['label' => 'Padding', 'start' => 6], Product_Element_Box_Sale::config('padding'));
                $form->text('box_sale[margin]', ['label' => 'Margin', 'start' => 6], Product_Element_Box_Sale::config('margin'));
                $form->color('box_sale[bg_box]', ['label' => 'Màu Box', 'start' => 6], Product_Element_Box_Sale::config('bg_box'));
                $form->color('box_sale[text_color]', ['label' => 'Màu tiêu đề', 'start' => 6], Product_Element_Box_Sale::config('text_color'));
            @endphp
            {!! $form->html(); !!}
        </div>
    </div>
</div>

<div class="box">
    <div class="box-header"><h4 class="box-title">Gở bỏ tempalte</h4></div>
    <div class="box-content">
        <div class="row">
            <p>remove_action('product_detail_info', ['Product_Element_Box_Sale', 'render'], Product_Element_Box_Sale::config('position'));</p>
        </div>
    </div>
</div>

<style>
    .select-img .checkbox img { width:50px; border:1px solid #ccc; }
    .select-img .checkbox input:checked + label img {
        border:1px solid #000;
    }
    .select-img .checkbox label span { display: none;}
</style>
