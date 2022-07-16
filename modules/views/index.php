<?php
Class Product_Element_Views {

    const KEY = 'views';

    public function __construct() {
        add_filter('product_element_module', [$this, 'register'], 10);
        add_filter('product_object_info', [$this, 'render'], self::config('position'));
        if(Admin::is()) {
            Metabox::add('admin_product_element_views', 'Lượt xem tùy chỉnh', 'admin_product_element_views', ['module' => 'products']);
            function admin_product_element_views($object) { Product_Element_Views::metaboxViews($object);}
            add_action('save_object', [$this, 'saveViews'], 10, 2);
        }
        else {
            add_shortcode( 'product_view', [$this, 'getViews']);
            add_action('cle_footer', [$this, 'autoPlusView'], 10);
        }
    }

    public function register($module) {
        $module[Product_Element_Views::KEY] = [
            'label' => 'Lượt xem',
            'class' => 'Product_Element_Views'
        ];
        return $module;
    }

    public static function config($key = '') {

        $option = [
            'position'          => 50,
            'button_icon'       => html_escape('<i class="fal fa-eye"></i>'),
        ];

        $option_save = Option::get('product_element_views', []);

        foreach ($option as $key_default => $item) {
            if(!isset($option_save[$key_default])) $option_save[$key_default] = $item;
        }

        if(!empty($key)) return Arr::get($option_save , $key);

        return $option_save;
    }

    public static function pageConfig() {
        include PR_EL_PATH.'/modules/'.Product_Element_Views::KEY.'/views/page-config.php';
    }

    public static function saveConfig($ci, $model) {

        $config = Product_Element_Views::config();

        $form_contact = Request::Post('views');

        foreach ($config as $key => $item) {
            if(isset($form_contact[$key]))
                $config[$key] = Str::clear($form_contact[$key]);
        }

        Option::update('product_element_views', $config);

        $result['status']  = 'success';

        $result['message'] = __('Lưu dữ liệu thành công');

        return $result;

    }

    /****===================================
     * Xử lý metabox
    ===================================*/
    public static function metaboxViews($object) {
        $view = (have_posts($object)) ? (int)Product::getMeta($object->id, 'views', true) : 0;
        $Form = new FormBuilder();
        $Form->add('views', 'number', ['label' => 'Lượt xem sản phẩm', 'value' => 0], $view)->html(false);
    }

    public static function saveViews($product_id, $module) {
        if($module == 'products') {
            $product_views = (int)Request::Post('views');
            Product::updateMeta($product_id, 'views', $product_views);
        }
    }

    /****===================================
     * Render frontend
    ===================================*/
    public function render($object) {
        $config = Product_Element_Views::config();
        $view = (int)Product::getMeta($object->id, 'views', true);
        include PR_EL_PATH.'/modules/'.Product_Element_Views::KEY.'/views/element.php';
    }

    public function autoPlusView() {
        if(Template::isPage('products_detail')) {
            $object = get_object_current('object');
            $views = (int)Product::getMeta($object->id, 'views', true);
            Product::updateMeta($object->id, 'views', $views+1);
        }
    }

    public function getViews($args, $content) {
        $productID = (!empty($args['id'])) ? (int)$args['id'] : 0;
        ob_start();
        echo (int)Product::getMeta($productID, 'views', true);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}

new Product_Element_Views();