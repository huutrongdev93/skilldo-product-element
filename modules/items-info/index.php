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
        Plugin::partial(PR_EL_NAME, 'modules/items-info/views/admin/config', ['itemInfo' => $itemInfo]);
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
            Plugin::partial(PR_EL_NAME, 'modules/items-info/views/items', ['itemInfo' => $itemInfo, 'number' => $number]);
        }
    }

    static function less(): void {
        include PR_EL_PATH.'/modules/items-info/views/style-element.less';
    }
}

new ProductElementItems();