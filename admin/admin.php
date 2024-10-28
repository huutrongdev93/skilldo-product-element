<?php
include_once 'ajax.php';

Class Product_Element_Admin {

    public function __construct() {
        if(Admin::isRoot()) {
            AdminMenu::addSub('products', PR_EL_NAME, 'Element', 'plugins/' . PR_EL_NAME, [
                'callback' => 'Product_Element_Admin::pageConfig'
            ]);
        }
    }

    static function pageConfig(\SkillDo\Http\Request $request): void
    {
        $tabsData = Product_Element::module();

        if(have_posts($tabsData)) {

            reset($tabsData);

            $section = ($request->input('section')) ? $request->input('section') : key($tabsData);

            $tabs = [];

            foreach ($tabsData as $key => $tab) {
                $tabs[$key] = [
                    'label'=> ((isset($tab['icon'])) ? $tab['icon'].' ' : '<i class="fal fa-layer-plus"></i> ').$tab['label'],
                    'href' => Url::admin('plugins/'.PR_EL_NAME.'?section='.$key),
                ];
            }

            Plugin::view(PR_EL_NAME, 'views/admin/page-config', [
                'tabsData' => $tabsData,
                'tabs' => Admin::tabs($tabs, $section),
                'section' => $section,
            ]);
        }
    }

    static function pageGeneral($tab, $key): void
    {
        $form = form();

        $form->checkbox('module_active',
            [
                'form_contact' => 'Form contact',
                'box_sale'     => 'Khung khuyến mãi',
                'button_contact' => 'Button liên hệ',
            ],
            [
                'label' => 'Hiển thị',
                'start' => 6,
            ], Product_Element::config('module_active'));

        Plugin::view(PR_EL_NAME, 'views/admin/page-general', ['form' => $form]);
    }
}