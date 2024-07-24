<?php
const PR_EL_NAME = 'product-element';

define('PR_EL_PATH', Path::plugin(PR_EL_NAME) );

class Product_Element {

    private string $name = 'Product_Element';

    function __construct() {
        $this->loadDependencies();
        $this->loadModules();
        if(Admin::is()) new Product_Element_Admin();
    }

    public function active() {}

    public function uninstall() {}

    private function loadDependencies(): void
    {
        require_once PR_EL_PATH.'/admin/admin.php';
    }

    private function loadModules(): void
    {
        $module = static::config('module_active');

        if(have_posts($module)) {
            foreach ($module as $itemKey => $itemName) {
                $path = PR_EL_PATH.'/modules/'.$itemName.'/index.php';
                if(file_exists($path)) require_once $path;
            }
        }

        include_once PR_EL_PATH.'/modules/views_cart/index.php';
        include_once PR_EL_PATH.'/modules/items-info/index.php';
    }

    public static function config($key = '') {

        $option = [
            'module'           => [],
            'module_active'    => [],
        ];

        $option_save = Option::get('product_element_config', []);

        if(!isset($option_save['module'])) $option_save['module'] = $option['module'];

        if(!isset($option_save['module_active'])) $option_save['module_active'] = $option['module_active'];

        if(!empty($key)) return Arr::get($option_save , $key);

        return $option_save;
    }

    public static function module($module = '') {

        $modules = apply_filters('product_element_module', [
            'general' => [
                'label' => 'Cấu hình',
                'callback' => 'Product_Element_Admin::pageGeneral'
            ],
        ]);

        if(!empty($module)) return Arr::get($modules , $module);

        return $modules;
    }
}

new Product_Element();