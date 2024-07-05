<?php
Class ProductElementViewsCart {
    public function __construct() {

        add_filter('productItemStyle', 'ProductElementViewsCart::customProductItemStyle');

        if(Admin::is()) {
            add_action('admin_product_setting_object', 'ProductElementViewsCart::adminConfigHtml', 60);
            Metabox::add('admin_product_element_views', 'Lượt xem tùy chỉnh', 'ProductElementViewsCart::viewsMetaBoxForm', ['module' => 'products']);
            add_action('save_object', 'ProductElementViewsCart::saveViews', 10, 2);
        }
        else {
            add_action('cle_header', 'ProductElementViewsCart::cssVariables');
            add_action('theme_custom_less', 'ProductElementViewsCart::less');
            add_action('cle_footer', 'ProductElementViewsCart::autoPlusView');
        }
        if(Prd::itemStyle('viewsCart.style') == 'inline') {
            add_action('product_object_info', 'ProductElementViewsCart::renderInlineBlock', 60);
        }
        else {
            add_action('product_object_info', 'ProductElementViewsCart::renderViews', Prd::itemStyle('viewsCart.views.position'));
            add_action('product_object_info', 'ProductElementViewsCart::renderCart', Prd::itemStyle('viewsCart.cart.position'));
        }
    }
    public static function adminConfigHtml(): void {

        $viewCart = Prd::itemStyle('viewsCart');

        $fonts 	= ['Font mặc định'];

        $fonts 	= array_merge($fonts, gets_theme_font());

		$formViews = form();

        $formViews->addGroup(function(\SkillDo\Form\Form $form) use ($viewCart) {
            $form->switch('productViewsCart[views][show]', ['label' => 'Ẩn / Hiện'], $viewCart['views']['show']);
            $form->number('productViewsCart[views][position]', ['label' => 'Thứ tự'], $viewCart['views']['position']);
        }, ['start' => 2]);

        $formViews->addGroup(function(\SkillDo\Form\Form $form) use ($viewCart, $fonts) {
            $positionOptions = ['left' => 'Trái', 'center' => 'Giữa', 'right' => 'Phải'];
			$fontWeightOptions = ['300' => '300', '400' => '400', '500' => '500', '700' => '700', 'bold' => 'Bold'];
            $form->color('productViewsCart[views][bg]', ['label' => 'Màu nền', 'start' => 3], $viewCart['views']['bg']);
            $form->color('productViewsCart[views][color]', ['label' => 'Màu chữ', 'start' => 3], $viewCart['views']['color']);
            $form->color('productViewsCart[views][borderColor]', ['label' => 'Màu viền', 'start' => 3], $viewCart['views']['borderColor']);
            $form->number('productViewsCart[views][borderWidth]', ['label' => 'Độ dầy viền', 'start' => 3], $viewCart['views']['borderWidth']);
            $form->color('productViewsCart[views][bgHover]', ['label' => 'Màu nền (hover)', 'start' => 3], $viewCart['views']['bgHover']);
            $form->color('productViewsCart[views][colorHover]', ['label' => 'Màu chữ (hover)', 'start' => 3], $viewCart['views']['colorHover']);
            $form->color('productViewsCart[views][borderColorHover]', ['label' => 'Màu viền (hover)', 'start' => 6], $viewCart['views']['borderColorHover']);
            $form->tab('productViewsCart[views][align]', $positionOptions, ['label' => 'Vị trí', 'start' => 3], $viewCart['views']['align']);
            $form->select('productViewsCart[views][font]', $fonts, ['label' => 'Font chữ', 'start' => 3], $viewCart['views']['font']);
            $form->tab('productViewsCart[views][weight]', $fontWeightOptions, ['label' => 'In đậm chữ', 'start' => 3], $viewCart['views']['weight']);
            $form->number('productViewsCart[views][size]', ['label' => 'Font size', 'value' => 16, 'start' => 3], $viewCart['views']['size']);
        }, ['start' => 10]);

        $formCart = form();

        $formCart->addGroup(function(\SkillDo\Form\Form $form) use ($viewCart) {
            $form->switch('productViewsCart[cart][show]', ['label' => 'Ẩn / Hiện'], $viewCart['cart']['show']);
            $form->number('productViewsCart[cart][position]', ['label' => 'Thứ tự'], $viewCart['cart']['position']);
        }, ['start' => 2]);

        $formCart->addGroup(function(\SkillDo\Form\Form $form) use ($viewCart, $fonts) {
            $positionOptions = ['left' => 'Trái', 'center' => 'Giữa', 'right' => 'Phải'];
            $fontWeightOptions = ['300' => '300', '400' => '400', '500' => '500', '700' => '700', 'bold' => 'Bold'];
            $form->color('productViewsCart[cart][bg]', ['label' => 'Màu nền', 'start' => 3], $viewCart['cart']['bg']);
            $form->color('productViewsCart[cart][color]', ['label' => 'Màu chữ', 'start' => 3], $viewCart['cart']['color']);
            $form->color('productViewsCart[cart][borderColor]', ['label' => 'Màu viền', 'start' => 3], $viewCart['cart']['borderColor']);
            $form->number('productViewsCart[cart][borderWidth]', ['label' => 'Độ dầy viền', 'start' => 3], $viewCart['cart']['borderWidth']);
            $form->color('productViewsCart[cart][bgHover]', ['label' => 'Màu nền (hover)', 'start' => 3], $viewCart['cart']['bgHover']);
            $form->color('productViewsCart[cart][colorHover]', ['label' => 'Màu chữ (hover)', 'start' => 3], $viewCart['cart']['colorHover']);
            $form->color('productViewsCart[cart][borderColorHover]', ['label' => 'Màu viền (hover)', 'start' => 6], $viewCart['cart']['borderColorHover']);
            $form->tab('productViewsCart[cart][align]', $positionOptions, ['label' => 'Vị trí', 'start' => 3], $viewCart['cart']['align']);
            $form->select('productViewsCart[cart][font]', $fonts, ['label' => 'Font chữ', 'start' => 3], $viewCart['cart']['font']);
            $form->tab('productViewsCart[cart][weight]', $fontWeightOptions, ['label' => 'In đậm chữ', 'start' => 3], $viewCart['cart']['weight']);
            $form->number('productViewsCart[cart][size]', ['label' => 'Font size', 'value' => 16, 'start' => 3], $viewCart['cart']['size']);
        }, ['start' => 10]);


        Plugin::view(PR_EL_NAME, 'views_cart/admin/config', [
			'formViews' => $formViews,
	        'formCart' => $formCart,
	        'style' => $viewCart['style']
        ]);
    }
    public static function customProductItemStyle($style) {
        $style['viewsCart'] = [
            'style' => 'block',
            'views' => [
                'show' => false, 'position' => 40,
                'color' => '#000',
                'borderColor' => '#000',
                'borderWidth' => '1',
                'bg' => '#fff',
                'colorHover' => '#fff',
                'borderColorHover' => Option::get('theme_color'),
                'bgHover' => Option::get('theme_color'),
                'align' => 'center', 'font' => '','weight' => 'bold', 'size' => '12'
            ],
            'cart' => [
                'show' => false, 'position' => 40,
                'color' => '#000',
                'borderColor' => '#000',
                'borderWidth' => '1',
                'bg' => '#fff',
                'colorHover' => '#fff',
                'borderColorHover' => Option::get('theme_color'),
                'bgHover' => Option::get('theme_color'),
                'align' => 'center', 'font' => '','weight' => 'bold', 'size' => '12'
            ]
        ];

        $viewsCart = Option::get('productViewsCart');

        if(isset($viewsCart['style'])) $style['viewsCart']['style']  = $viewsCart['style'];

        if(isset($viewsCart['views']['position']))       $style['viewsCart']['views']['position']  = $viewsCart['views']['position'];
        if(isset($viewsCart['views']['show']))           $style['viewsCart']['views']['show']      = $viewsCart['views']['show'];
        if(isset($viewsCart['views']['color']))          $style['viewsCart']['views']['color']     = $viewsCart['views']['color'];
        if(isset($viewsCart['views']['borderColor']))    $style['viewsCart']['views']['borderColor']     = $viewsCart['views']['borderColor'];
        if(isset($viewsCart['views']['borderWidth']))    $style['viewsCart']['views']['borderWidth']     = $viewsCart['views']['borderWidth'];
        if(isset($viewsCart['views']['bg']))             $style['viewsCart']['views']['bg']     = $viewsCart['views']['bg'];
        if(isset($viewsCart['views']['colorHover']))          $style['viewsCart']['views']['colorHover']     = $viewsCart['views']['colorHover'];
        if(isset($viewsCart['views']['borderColorHover']))    $style['viewsCart']['views']['borderColorHover']     = $viewsCart['views']['borderColorHover'];
        if(isset($viewsCart['views']['bgHover']))             $style['viewsCart']['views']['bgHover']     = $viewsCart['views']['bgHover'];
        if(isset($viewsCart['views']['align']))    $style['viewsCart']['views']['align']     = $viewsCart['views']['align'];
        if(isset($viewsCart['views']['font']))     $style['viewsCart']['views']['font']      = $viewsCart['views']['font'];
        if(isset($viewsCart['views']['weight']))   $style['viewsCart']['views']['weight']    = $viewsCart['views']['weight'];
        if(isset($viewsCart['views']['size']))     $style['viewsCart']['views']['size']      = $viewsCart['views']['size'];

        if(isset($viewsCart['cart']['position'])) $style['viewsCart']['cart']['position']  = $viewsCart['cart']['position'];
        if(isset($viewsCart['cart']['show']))     $style['viewsCart']['cart']['show']      = $viewsCart['cart']['show'];
        if(isset($viewsCart['cart']['color']))    $style['viewsCart']['cart']['color']     = $viewsCart['cart']['color'];
        if(isset($viewsCart['cart']['borderColor']))    $style['viewsCart']['cart']['borderColor']     = $viewsCart['cart']['borderColor'];
        if(isset($viewsCart['cart']['borderWidth']))    $style['viewsCart']['cart']['borderWidth']     = $viewsCart['cart']['borderWidth'];
        if(isset($viewsCart['cart']['bg']))             $style['viewsCart']['cart']['bg']     = $viewsCart['cart']['bg'];
        if(isset($viewsCart['cart']['colorHover']))          $style['viewsCart']['cart']['colorHover']     = $viewsCart['cart']['colorHover'];
        if(isset($viewsCart['cart']['borderColorHover']))    $style['viewsCart']['cart']['borderColorHover'] = $viewsCart['cart']['borderColorHover'];
        if(isset($viewsCart['cart']['bgHover']))             $style['viewsCart']['cart']['bgHover']     = $viewsCart['cart']['bgHover'];
        if(isset($viewsCart['cart']['align']))    $style['viewsCart']['cart']['align']     = $viewsCart['cart']['align'];
        if(isset($viewsCart['cart']['font']))     $style['viewsCart']['cart']['font']      = $viewsCart['cart']['font'];
        if(isset($viewsCart['cart']['weight']))   $style['viewsCart']['cart']['weight']    = $viewsCart['cart']['weight'];
        if(isset($viewsCart['cart']['size']))     $style['viewsCart']['cart']['size']      = $viewsCart['cart']['size'];

        return $style;
    }
    /*===================================
     * Xử lý metabox
    ===================================*/
    public static function viewsMetaBoxForm($object): void {
        $view = (have_posts($object)) ? (int)Product::getMeta($object->id, 'views', true) : 0;
        $Form = form();
        $Form->number('views', ['label' => 'Lượt xem sản phẩm', 'value' => 0], $view)->html(false);
    }
    public static function saveViews($product_id, $module): void {
        if($module == 'products') {
            $product_views = (int)Request::Post('views');
            Product::updateMeta($product_id, 'views', $product_views);
        }
    }
    /****===================================
     * Render frontend
    ===================================*/
    static function renderInlineBlock($object): void {
        echo '<div class="pre-box-views-cart">';
        ProductElementViewsCart::renderViews($object);
        ProductElementViewsCart::renderCart($object);
        echo '</div>';
    }
    static function renderViews($object): void {
        if(Prd::itemStyle('viewsCart.views.show') == 1) {
            $view = (int)Product::getMeta($object->id, 'views', true);
            Plugin::view(PR_EL_NAME, 'views_cart/views', ['view' => $view]);
        }
    }
    static function renderCart($object): void {
        if(Prd::itemStyle('viewsCart.cart.show') == 1) {
            $count = Product::count(Qr::set('parent_id', $object->id)->where('type', 'variations'));
            Plugin::view(PR_EL_NAME, 'views_cart/cart', ['count' => $count, 'object' => $object]);
        }
    }
    static function cssVariables(): void {
        $configViews = Prd::itemStyle('viewsCart.views');
        $cssBuild = new ThemeCssBuild();
        if($configViews['show'] == 1) {
            $cssBuild->cssVariables('--pre-views-bg', (!empty($configViews['bg'])) ? $configViews['bg'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-views-color', $configViews['color']);
            $cssBuild->cssVariables('--pre-views-border', (!empty($configViews['borderColor'])) ? $configViews['borderColor'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-views-border-width', ((!empty($configViews['borderWidth'])) ? $configViews['borderWidth'] : '0').'px');
            $cssBuild->cssVariables('--pre-views-bg-hover', (!empty($configViews['bgHover'])) ? $configViews['bgHover'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-views-color-hover', $configViews['colorHover']);
            $cssBuild->cssVariables('--pre-views-border-hover', (!empty($configViews['borderColorHover'])) ? $configViews['borderColorHover'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-views-font', (!empty($configViews['font'])) ? $configViews['font'] : 'var(--font-family)');
            $cssBuild->cssVariables('--pre-views-size', $configViews['size'].'px');
            $cssBuild->cssVariables('--pre-views-weight', $configViews['weight'].((is_numeric($configViews['weight'])) ? 'px' : ''));
            $cssBuild->cssVariables('--pre-views-align', $configViews['align']);
        }

        $configCart = Prd::itemStyle('viewsCart.cart');

        if($configCart['show'] == 1) {
            $cssBuild->cssVariables('--pre-cart-bg', (!empty($configCart['bg'])) ? $configCart['bg'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-cart-color', $configCart['color']);
            $cssBuild->cssVariables('--pre-cart-border', (!empty($configCart['borderColor'])) ? $configCart['borderColor'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-cart-border-width', ((!empty($configCart['borderWidth'])) ? $configCart['borderWidth'] : '0').'px');
            $cssBuild->cssVariables('--pre-cart-bg-hover', (!empty($configCart['bgHover'])) ? $configCart['bgHover'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-cart-color-hover', $configCart['colorHover']);
            $cssBuild->cssVariables('--pre-cart-border-hover', (!empty($configCart['borderColorHover'])) ? $configCart['borderColorHover'] : 'var(--theme-color)');
            $cssBuild->cssVariables('--pre-cart-font', (!empty($configCart['font'])) ? $configCart['font'] : 'var(--font-family)');
            $cssBuild->cssVariables('--pre-cart-size', $configCart['size'].'px');
            $cssBuild->cssVariables('--pre-cart-weight', $configCart['weight'].'px');
            $cssBuild->cssVariables('--pre-cart-align', $configCart['align']);
        }
        echo '<style>';
        echo $cssBuild->build(':root');
        echo '</style>';
    }
    static function less(): void {
        include PR_EL_PATH.'/assets/css/views-cart.less';
    }

    static function autoPlusView(): void {
        if(Template::isPage('products_detail')) {
            $object = get_object_current('object');
            if(have_posts($object)) {
                $views = (int)Product::getMeta($object->id, 'views', true);
                Product::updateMeta($object->id, 'views', $views+1);
            }
        }
    }
}

new ProductElementViewsCart();