<?php

use JetBrains\PhpStorm\NoReturn;

Class Product_Element_Ajax {

    #[NoReturn]
    static function saveGeneral(SkillDo\Http\Request $request, $model): void
    {
        if($request->isMethod('post')) {

            $module = trim($request->input('module'));

            if($module == 'general') {

                $config = Product_Element::config();

                $module_active = $request->input('module_active');

                $config['module_active'] = (!empty($module_active)) ? $module_active : [];

                if(in_array('viewscart', $config['module_active']) === true) {

                    if(in_array('views', $config['module_active']) === true || in_array('buttoncart', $config['module_active']) === true) {

                        response()->error('Không thể bật đồng thời Views & Cart cùng với các element cùng loại');
                    }
                }

                Option::update('product_element_config', $config);

                response()->success(trans('ajax.save.success'));
            }
            else {

                $module = Product_Element::module($module);

                if(have_posts($module) && method_exists($module['class'], 'saveConfig')) {

                    $module['class']::saveConfig($request, $model);
                }
            }
        }

        response()->error(trans('ajax.save.error'));
    }
}

Ajax::admin('Product_Element_Ajax::saveGeneral');