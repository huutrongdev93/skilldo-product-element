<div class="box">
    <div class="header"><h3>TEXT</h3></div>
    <div class="box-content row m-1">
        <?php
        $Form = new FormBuilder();
        $Form->add('buttoncart[position]', 'number', ['label' => 'Thứ tự gắn vào hook "product_object_info"'], Product_Element_Button_Cart::config('position'));
        $Form->add('buttoncart[button_icon]', 'text', ['label' => 'Button send icon'], Product_Element_Button_Cart::config('button_icon'));
        $Form->html(false);
        ?>
    </div>
</div>

<div class="box">
    <div class="header"><h3>STYLE</h3></div>
    <div class="box-content row m-1">
        <?php
        $Form->add('buttoncart[location]', 'select', ['label' => 'Vị trí', 'options' => ['center' => 'Center', 'left' => 'Left', 'right' => 'Right']], Product_Element_Button_Cart::config('location'));
        $Form->add('buttoncart[padding]', 'text', ['label' => 'Padding khung', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Button_Cart::config('padding'));
        $Form->add('buttoncart[margin]', 'text', ['label' => 'Margin khung', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Button_Cart::config('margin'));
        $Form->add('buttoncart[bg_button]', 'color', ['label' => 'Màu nền button', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Button_Cart::config('bg_button'));
        $Form->add('buttoncart[bg_button_hover]', 'color', ['label' => 'Màu nền button hover', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Button_Cart::config('bg_button_hover'));
        $Form->add('buttoncart[color_button]', 'color', ['label' => 'Màu text button', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Button_Cart::config('color_button'));
        $Form->add('buttoncart[color_button_hover]', 'color', ['label' => 'Màu text button hover', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Button_Cart::config('color_button_hover'));
        $Form->html(false);
        ?>
    </div>
</div>

<style>
    .select-img .checkbox img { width:50px; border:1px solid #ccc; }
    .select-img .checkbox input:checked + label img {
        border:1px solid #000;
    }
    .select-img .checkbox label span { display: none;}
</style>
