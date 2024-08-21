<?php
Class ProductElementItems {
    public function __construct() {
        if(Admin::is()) {
            add_action('admin_product_setting_detail', 'ProductElementItems::adminConfigHtml', 60);
            add_filter('admin_product_save_setting_before', 'ProductElementItems::adminProcess');
        }
        else {
            add_action('theme_custom_less', 'ProductElementItems::less');
        }
        add_action('product_detail_info', 'ProductElementItems::render', 60);
    }

    static function adminConfigHtml(): void {

        $itemInfo = Option::get('product_item_info', ['enable' => 0, 'number' => 3, 'item' => []]);

        $form = form();
        $form->switch('product_item_info[enable]', ['label' => 'Bật tắt item', 'start' => 2], $itemInfo['enable'] ?? 0);
        $form->color('product_item_info[headingColor]', ['label' => 'Màu tiêu đề', 'start' => 2], $itemInfo['headingColor'] ?? '#000');
        $form->color('product_item_info[descColor]', ['label' => 'Màu mô tả', 'start' => 2], $itemInfo['descColor'] ?? '#000');
        $form->number('product_item_info[number]', ['label' => 'Số item / hàng', 'start' => 2], $itemInfo['number'] ?? 3);
        $form->repeater('product_item_info[items]', ['label' => 'Danh sách item', 'fields' => [
            ['name' => 'image', 'type' => 'image', 'label' => __('Icon'), 'col' => 3],
            ['name' => 'title', 'type' => 'text',  'label' => __('Tiêu đề'), 'col' => 4, 'language' => true],
            ['name' => 'description', 'type' => 'textarea', 'label' => __('Mô tả'), 'col' => 5, 'language' => true],
        ]], $itemInfo['items'] ?? []);

        Admin::view('components/system-default', [
            'title'       => 'Item ở thông tin sản phẩm',
            'description' => trans('Thồng thường nằm dưới button mua hàng'),
            'form'        => $form
        ]);
    }

    static function adminProcess($productOptions): array {
        if(isset($productOptions['product_item_info']['items']) && have_posts($productOptions['product_item_info']['items'])) {
            foreach ($productOptions['product_item_info']['items'] as $key => $item) {
                $item['image'] = FileHandler::handlingUrl($item['image']);
                $productOptions['product_item_info']['items'][$key] = $item;
            }
        }
        return $productOptions;
    }

    static function render($object): void {

        $itemInfo = Option::get('product_item_info', ['enable' => 0, 'number' => 3, 'item' => []]);

        if($itemInfo['enable'] == 1) {

            $number = 0;

            $phone = Option::get('contact_phone');

            foreach ($itemInfo['items'] as $key => $item) {

                if(!empty($phone)) {
                    $item['description'] = str_replace('{contact_phone}', $phone, $item['description']);
                }

                $itemInfo['items'][$key] = $item;
            }

            Plugin::view(PR_EL_NAME, 'items-info/items', ['itemInfo' => $itemInfo, 'number' => $number]);
        }
    }

    static function less(): void {
        include PR_EL_PATH.'/assets/css/items-info.less';
    }
}

new ProductElementItems();