<?php
Class Product_Element_Button_Cart {

    const KEY = 'buttoncart';

    public function __construct() {
        add_filter('product_element_module', [$this, 'register'], 10);
        add_filter('product_object_info', [$this, 'render'], self::config('position'));
        //add_action('theme_custom_css', [$this, 'css'], 10);
    }

    public function register($module) {
        $module[Product_Element_Button_Cart::KEY] = [
            'label' => 'Button mua hàng',
            'class' => 'Product_Element_Button_Cart'
        ];
        return $module;
    }

    public static function config($key = '') {

        $option = [
            'position'          => 50,
            'button_icon'       => html_escape('<i class="fal fa-shopping-cart"></i>'),
            'location'          => 'center',
            'padding'           => '5px 30px',
            'margin'            => '10px',
            'bg_button'         => '',
            'bg_button_hover'   => '',
            'color_button'      => '#fff',
            'color_button_hover'=> '',
        ];

        $option_save = Option::get('product_element_button_cart', []);

        foreach ($option as $key_default => $item) {
            if(!isset($option_save[$key_default])) $option_save[$key_default] = $item;
        }

        if(!empty($key)) return Arr::get($option_save , $key);

        return $option_save;
    }

    public static function pageConfig() {
        include PR_EL_PATH.'/modules/'.Product_Element_Button_Cart::KEY.'/views/page-config.php';
    }

    public static function saveConfig($ci, $model) {

        $config = Product_Element_Button_Cart::config();

        $form_contact = Request::Post('buttoncart');

        foreach ($config as $key => $item) {
            if(isset($form_contact[$key]))
                $config[$key] = Str::clear($form_contact[$key]);
        }

        Option::update('product_element_button_cart', $config);

        $result['status']  = 'success';

        $result['message'] = __('Lưu dữ liệu thành công');

        return $result;

    }

    public function render($object) {
        $config = Product_Element_Button_Cart::config();
        $count = Product::count(Qr::set('parent_id', $object->id)->where('type', 'variations'));
        include PR_EL_PATH.'/modules/'.Product_Element_Button_Cart::KEY.'/views/element.php';
    }

    public function css() {
        $config = Product_Element_Button_Cart::config();
        ?>
        <style>
            :root {
                --pre-button-cart-padding           : <?php echo $config['padding'];?>;
                --pre-button-cart-margin           : <?php echo $config['margin'];?>;
                --pre-button-cart-bg_button         : <?php echo (!empty($config['bg_button'])) ? $config['bg_button'] : 'var(--theme-color)';?>;
                --pre-button-cart-bg_button_hover   : <?php echo (!empty($config['bg_button_hover'])) ? $config['bg_button_hover'] : 'var(--theme-color)';?>;
                --pre-button-cart-color_button      : <?php echo $config['color_button'];?>;
                --pre-button-cart-color_button_hover: <?php echo (!empty($config['color_button_hover'])) ? $config['color_button_hover'] : 'var(--theme-color)';?>;
            }
        </style>

        <?php
        include PR_EL_PATH.'/modules/'.Product_Element_Button_Cart::KEY.'/views/style-element.css';
    }
}

new Product_Element_Button_Cart();