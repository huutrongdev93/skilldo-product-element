<div class="box mt-3 mb-3">
    <div class="box-header"><h4 class="box-title">Lượt xem & Button mua hàng</h4></div>
    <div class="box-content" style="margin-top: 10px;">
        <div class="row m-1">
            <div class="col-md-3">
                <label for="">Lượt xem</label>
                <p style="color:#999;margin:5px 0 5px 0;">Cấu hình hiển thị lượt xem sản phẩm</p>
            </div>
            <div class="col-md-9">
                <div class="row">
                    {!! $formViews->html() !!}
                </div>
            </div>
        </div>
        <hr />
        <div class="row m-1">
            <div class="col-md-3">
                <label for="">Button mua hàng</label>
                <p style="color:#999;margin:5px 0 5px 0;">Cấu hình hiển thị button mua hàng sản phẩm</p>
            </div>
            <div class="col-md-9">
                <div class="row">
                    {!! $formCart->html() !!}
                </div>
            </div>
        </div>
        <hr />
        <div class="row m-1">
            <div class="col-md-3">
                <label for="">Kiểu hiển thị</label>
                <p style="color:#999;margin:5px 0 5px 0;">Cấu hình hiển thị button mua hàng sản phẩm</p>
            </div>
            <div class="col-md-9">
                <div class="row">
                    {!! \SkillDo\Form\Form::render(['name' => 'productViewsCart[style]', 'label' => 'Kiểu', 'type' => 'select',
                        'options' => [
                            'block'  => 'Lượt xem & button mua hàng nằm trên 2 hàng',
                            'inline' => 'Lượt xem & button mua hàng nằm trên 1 hàng',
                        ]
                    ], $style) !!}
                </div>
            </div>
        </div>
    </div>
</div>