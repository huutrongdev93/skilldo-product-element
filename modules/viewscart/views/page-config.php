<div class="box">
    <div class="header"><h3>TEXT</h3></div>
    <div class="box-content">
        <?php
        $Form = new FormBuilder();
        $Form->add('viewscart[position]', 'number', ['label' => 'Thứ tự gắn vào hook "product_object_info"'], Product_Element_Views_Cart::config('position'));
        $Form->add('viewscart[location]', 'select', ['label' => 'Vị trí', 'options' => ['center' => 'Center', 'left' => 'Left', 'right' => 'Right']], Product_Element_Views_Cart::config('location'));
        $Form->html(false);
        ?>
    </div>
</div>

<div class="box">
    <div class="header"><h3>LƯỢT XEM</h3></div>
    <div class="box-content">
        <?php
        $Form->add('viewscart[views_icon]', 'text', ['label' => 'Icon'], Product_Element_Views_Cart::config('views_icon'));
        $Form->add('viewscart[views_bg]', 'color', ['label' => 'Màu nền button', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('views_bg'));
        $Form->add('viewscart[views_bg_hover]', 'color', ['label' => 'Màu nền button hover', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('views_bg_hover'));
        $Form->add('viewscart[views_color]', 'color', ['label' => 'Màu text button', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('views_color'));
        $Form->add('viewscart[views_color_hover]', 'color', ['label' => 'Màu text button hover', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('views_color_hover'));
        $Form->html(false);
        ?>
    </div>
</div>

<div class="box">
    <div class="header"><h3>CART</h3></div>
    <div class="box-content">
        <?php
        $Form->add('viewscart[cart_icon]', 'text', ['label' => 'Icon'], Product_Element_Views_Cart::config('cart_icon'));
        $Form->add('viewscart[cart_bg]', 'color', ['label' => 'Màu nền button', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('cart_bg'));
        $Form->add('viewscart[cart_bg_hover]', 'color', ['label' => 'Màu nền button hover', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('cart_bg_hover'));
        $Form->add('viewscart[cart_color]', 'color', ['label' => 'Màu text button', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('cart_color'));
        $Form->add('viewscart[cart_color_hover]', 'color', ['label' => 'Màu text button hover', 'after' => '<div class="col-md-6"><div class="form-group group">', 'before'=> '</div></div>'], Product_Element_Views_Cart::config('cart_color_hover'));
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
