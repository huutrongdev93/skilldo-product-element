<?php
Class Product_Element_Views_Cart {

    const KEY = 'viewscart';

    public function __construct() {
        add_filter('product_element_module', [$this, 'register'], 10);
        add_filter('product_object_info', [$this, 'render'], self::config('position'));
        if(Admin::is()) {
            Metabox::add('admin_product_element_views', 'Lượt xem tùy chỉnh', 'admin_product_element_views', ['module' => 'products']);
            function admin_product_element_views($object) { Product_Element_Views_Cart::metaboxViews($object);}
            add_action('save_object', [$this, 'saveViews'], 10, 2);
        }
        else {
            add_action('cle_header', [$this, 'cssVariables'], 10);
            add_action('theme_custom_css', [$this, 'css'], 10);
            add_shortcode( 'product_view', [$this, 'getViews']);
            add_action('cle_footer', [$this, 'autoPlusView'], 10);
        }
    }

    public function register($module) {
        $module[Product_Element_Views_Cart::KEY] = [
            'label' => 'Lượt xem & mua hàng',
            'class' => 'Product_Element_Views_Cart'
        ];
        return $module;
    }

    public static function config($key = '') {

        $option = [
            'position'          => 50,
            'views_icon'        => html_escape('<i class="fal fa-eye"></i>'),
            'cart_icon'         => html_escape('<i class="fal fa-shopping-cart"></i>'),
            'location'          => 'center',
            'views_bg'          => '#fff',
            'views_bg_hover'    => '#fff',
            'views_color'       => '#000',
            'views_color_hover' => '',
            'views_border_hover'=> '',
            'cart_bg'           => '#fff',
            'cart_bg_hover'     => '',
            'cart_color'        => '#000',
            'cart_color_hover'  => '#fff',
            'cart_border_hover' => '',
        ];

        $option_save = Option::get('product_element_views_cart', []);

        foreach ($option as $key_default => $item) {
            if(!isset($option_save[$key_default])) $option_save[$key_default] = $item;
        }

        if(!empty($key)) return Arr::get($option_save , $key);

        return $option_save;
    }

    public static function pageConfig() {
        include PR_EL_PATH.'/modules/'.Product_Element_Views_Cart::KEY.'/views/page-config.php';
    }

    public static function saveConfig($ci, $model) {

        $config = Product_Element_Views_Cart::config();

        $form_contact = InputBuilder::Post('viewscart');

        foreach ($config as $key => $item) {
            if(isset($form_contact[$key]))
                $config[$key] = Str::clear($form_contact[$key]);
        }

        Option::update('product_element_views_cart', $config);

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
            $product_views = (int)InputBuilder::Post('views');
            Product::updateMeta($product_id, 'views', $product_views);
        }
    }

    /****===================================
     * Render frontend
    ===================================*/
    public function render($object) {
        $config = Product_Element_Views_Cart::config();
        $view = (int)Product::getMeta($object->id, 'views', true);
        $count = Product::count(['where' => ['parent_id' => $object->id, 'type' => 'variations']]);
        include PR_EL_PATH.'/modules/'.Product_Element_Views_Cart::KEY.'/views/element.php';
    }

    public function cssVariables() {
        $config = Product_Element_Views_Cart::config();
        ?>
        <style>
            :root {
                --pre-views_bg         : <?php echo (!empty($config['views_bg'])) ? $config['views_bg'] : 'var(--theme-color)';?>;
                --pre-views_bg_hover   : <?php echo (!empty($config['views_bg_hover'])) ? $config['views_bg_hover'] : 'var(--theme-color)';?>;
                --pre-views_color      : <?php echo $config['views_color'];?>;
                --pre-views_color_hover: <?php echo (!empty($config['views_color_hover'])) ? $config['views_color_hover'] : 'var(--theme-color)';?>;
                --pre-views_border_hover: <?php echo (!empty($config['views_border_hover'])) ? $config['views_border_hover'] : 'var(--theme-color)';?>;

                --pre-cart_bg         : <?php echo (!empty($config['cart_bg'])) ? $config['cart_bg'] : 'var(--theme-color)';?>;
                --pre-cart_bg_hover   : <?php echo (!empty($config['cart_bg_hover'])) ? $config['cart_bg_hover'] : 'var(--theme-color)';?>;
                --pre-cart_color      : <?php echo $config['cart_color'];?>;
                --pre-cart_color_hover: <?php echo (!empty($config['cart_color_hover'])) ? $config['cart_color_hover'] : 'var(--theme-color)';?>;
                --pre-cart_border_hover: <?php echo (!empty($config['cart_border_hover'])) ? $config['cart_border_hover'] : 'var(--theme-color)';?>;
            }
        </style>
        <?php
    }

    public function css() {
        include PR_EL_PATH.'/modules/'.Product_Element_Views_Cart::KEY.'/views/style-element.css';
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

new Product_Element_Views_Cart();