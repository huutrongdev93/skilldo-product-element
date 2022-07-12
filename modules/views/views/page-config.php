<div class="box">
    <div class="header"><h3>TEXT</h3></div>
    <div class="box-content row m-1">
        <?php
        $Form = new FormBuilder();
        $Form->add('views[position]', 'number', ['label' => 'Thứ tự gắn vào hook "product_object_info"'], Product_Element_Views::config('position'));
        $Form->add('views[button_icon]', 'text', ['label' => 'Button send icon'], Product_Element_Views::config('button_icon'));
        $Form->html(false);
        ?>
    </div>
</div>
<div class="box">
    <div class="header"><h3>SHORTCODE</h3></div>
    <div class="box-content row m-1">
        <div class="col-md-12">
            <p>Lấy lượt xem sản phẩm:</p>
            <p><textarea class="form-control code-javascript">do_shortcode('[product_view id={{ID}}][/product_view]');</textarea></p>
            <p>Với "{{ID}}" là Id sản phẩm cần lấy</p>
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
