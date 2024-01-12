<div class="box">
    <div class="header"> <h2>ITEM Ở INFO SẢN PHẨM</h2> </div>
    <div class="box-content">
        <div class="row m-1">
            <?php
            $form = new FormBuilder();
            $form
                ->add('product_item_info[enable]', 'switch', ['label' => 'Bật tắt item', 'start' => 2], (isset($itemInfo['enable'])) ? $itemInfo['enable'] : '0')
                ->add('product_item_info[headingColor]', 'color', ['label' => 'Màu tiêu đề', 'start' => 2], (isset($itemInfo['headingColor'])) ? $itemInfo['headingColor'] : '#000')
                ->add('product_item_info[descColor]', 'color', ['label' => 'Màu mô tả', 'start' => 2], (isset($itemInfo['descColor'])) ? $itemInfo['descColor'] : '#000')
                ->add('product_item_info[number]', 'number', ['label' => 'Số item / hàng', 'start' => 2], (isset($itemInfo['number'])) ? $itemInfo['number'] : 3)
                ->add('product_item_info[items]', 'repeater', ['label' => 'Danh sách item', 'fields' => [
                    ['name' => 'image', 'type' => 'image', 'label' => __('Icon'), 'col' => 3],
                    ['name' => 'title', 'type' => 'text',  'label' => __('Tiêu đề'), 'col' => 4, 'language' => true],
                    ['name' => 'description', 'type' => 'textarea', 'label' => __('Mô tả'), 'col' => 5, 'language' => true],
                ]], (isset($itemInfo['items'])) ? $itemInfo['items'] : [])
                ->html(false);
            ?>
        </div>
    </div>
</div>