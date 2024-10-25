<?php

use JetBrains\PhpStorm\NoReturn;

Class Product_Element_Box_Sale {

    const KEY = 'box_sale';

    public function __construct() {
        add_filter('product_element_module', [$this, 'register'], 10);
        add_filter('product_detail_info', [$this, 'render'], self::config('position'));
        add_action('theme_custom_css', [$this, 'css'], 10);
        if(Admin::is()) {
            Metabox::add('admin_product_element_box_sale', 'Khuyến mãi', 'Product_Element_Box_Sale::metaboxSale', ['module' => 'products']);
            add_action('save_object', [$this, 'saveSale'], 10, 2);
        }
    }

    public function register($module) {
        $module[Product_Element_Box_Sale::KEY] = [
            'label' => 'Khung khuyến mãi',
            'class' => 'Product_Element_Box_Sale'
        ];
        return $module;
    }

    static function config($key = '') {

        $option = [
            'position'          => 50,
            'style'             => 1,
            'title'             => 'QUÀ TẶNG & KHUYẾN MÃI',
            'padding'           => '20px',
            'margin'            => '50px 0 30px 0',
            'bg_box'            => '',
            'text_color'        => '#fff',
        ];

        if(Language::hasMulti()) {
            foreach (Language::list() as $key_lang => $item) {
                if($key_lang == Language::default()) continue;
                $option['title_'.$key_lang] = 'QUÀ TẶNG & KHUYẾN MÃI';
            }
        }

        $option_save = Option::get('product_element_box_sale', []);

        foreach ($option as $key_default => $item) {
            if(!isset($option_save[$key_default])) $option_save[$key_default] = $item;
        }

        if(!empty($key)) return Arr::get($option_save , $key);

        return $option_save;
    }

    static function pageConfig(): void
    {
        Plugin::view(PR_EL_NAME, Product_Element_Box_Sale::KEY.'/admin/config');
    }

    #[NoReturn]
    static function saveConfig(\SkillDo\Http\Request $request, $model): void
    {
        $config = Product_Element_Box_Sale::config();

        $form_contact = $request->input('box_sale');

        foreach ($config as $key => $item) {
            if(isset($form_contact[$key]))
                $config[$key] = Str::clear($form_contact[$key]);
        }

        Option::update('product_element_box_sale', $config);

        response()->success(trans('ajax.save.success'));
    }

    /****===================================
     * Xử lý metabox
    ===================================*/
    static function metaboxSale($object): void
    {
        $sale = (have_posts($object)) ? Product::getMeta($object->id, 'box_sale', true) : '';

        form()->wysiwyg('box_sale', ['label' => 'Khuyến mãi'], $sale)->html(false);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key_lang => $item) {
                if($key_lang == Language::default()) continue;
                form()->wysiwyg('box_sale_'.$key_lang, ['label' => 'Khuyến mãi ('.$item['label'].')'], $sale)->html(false);
            }
        }
    }

    static function saveSale($product_id, $module): void
    {
        if($module == 'products') {

            $sale = request()->input('box_sale');

            Product::updateMeta($product_id, 'box_sale', $sale);

            if(Language::hasMulti()) {
                foreach (Language::list() as $key_lang => $item) {
                    if($key_lang == Language::default()) continue;
                    $sale_lang = request()->input('box_sale_'.$key_lang);
                    Product::updateMeta($product_id, 'box_sale_'.$key_lang, $sale_lang);
                }
            }
        }
    }

    /****===================================
     * Render frontend
    ===================================*/
    public function render($object): void
    {
        $sale   = Product::getMeta($object->id, 'box_sale', true);

        if(Language::hasMulti() && Language::current() != Language::default()) {
            $langCurrent = Language::current();
            $sale = Product::getMeta($object->id, 'box_sale_'.$langCurrent, true);
        }

        if(!empty($sale) && $sale != '<p><br data-mce-bogus="1"></p>') {

            $config = Product_Element_Box_Sale::config();

            if(Language::hasMulti() && Language::current() != Language::default()) {
                $langCurrent = Language::current();
                $config['title'] = Product_Element_Box_Sale::config('title_'.$langCurrent);
            }

            if ($config['style'] == 1)
            {
                Plugin::view(PR_EL_NAME, Product_Element_Box_Sale::KEY.'/element', [
                    'config' => $config,
                    'sale' => $sale
                ]);
            }
            else
            {
                Plugin::view(PR_EL_NAME, Product_Element_Box_Sale::KEY.'/element-2', [
                    'config' => $config,
                    'sale' => $sale
                ]);
            }
        }
    }

    public function css(): void
    {
        include PR_EL_PATH.'/assets/css/box-sale.css';
    }
}

new Product_Element_Box_Sale();