<?php
class Product_Element_Button_Contact
{
    const KEY = 'button_contact';

    public function __construct() {
        add_filter('product_element_module', [$this, 'register'], 10);
        add_filter('product_detail_info', [$this, 'render'], self::config('position'));
        add_action('theme_custom_css', array( $this, 'css'), 10);
    }

    public function register($module) {
        $module[static::KEY] = [
            'label' => 'Button contact',
            'class' => static::class
        ];
        return $module;
    }

    static function config($key = '') {

        $option = [
            'position'          => 50,
            'title'             => 'Liên hệ đặt hàng nhanh chóng qua',
            'titleStyle'        => [],
            'zaloImg'           => '',
            'fbImg'             => '',
        ];

        if(Language::hasMulti()) {
            foreach (Language::list() as $key_lang => $item) {
                if($key_lang == Language::default()) continue;
                $option['title_'.$key_lang] = 'Liên hệ đặt hàng nhanh chóng qua';
            }
        }

        $optionSave = Option::get('product_element_button_contact', []);

        foreach ($option as $key_default => $item) {
            if(!isset($optionSave[$key_default])) $optionSave[$key_default] = $item;
        }

        if(!empty($key)) return Arr::get($optionSave , $key);

        return $optionSave;
    }

    static function pageConfig(): void
    {
        $form = form();
        $form->number('button_contact[position]',['label' => 'Thứ tự gắn vào hook "product_detail_info"', 'start' => 6], static::config('position'));
        $form->textBuilding('button_contact[titleStyle]',['label' => 'Kiểu tiêu để', 'start' => 6, 'txtInput' => false], static::config('titleStyle'));
        $form->text('button_contact[title]', ['label' => 'Tiêu đề', 'start' => 6], static::config('title'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key_lang => $item) {
                if($key_lang == Language::default()) continue;
                $form->text('button_contact[title_'.$key_lang.']', ['label' => 'Tiêu đề ('.$item['label'].')', 'start' => 6], static::config('title_'.$key_lang));
            }
        }
        $form->image('button_contact[zaloImg]', ['label' => 'Ảnh zalo', 'start' => 6], static::config('zaloImg'));
        $form->image('button_contact[fbImg]', ['label' => 'Ảnh messenger', 'start' => 6], static::config('fbImg'));

        $socials = get_theme_social();

        $isMessageId = false;

        foreach ($socials as $key => $social) {
            if($social['field'] == 'social_messenger_id') {
                $isMessageId = true;
                break;
            }
        }

        if(!$isMessageId) {
            $form->text('social_messenger_id', ['label' => 'ID Messenger', 'start' => 6], Option::get('social_messenger_id', ''));
        }

        Plugin::view(PR_EL_NAME, static::KEY.'/admin/config', [
            'form' => $form,
        ]);
    }

    static function saveConfig(\SkillDo\Http\Request $request): void
    {

        $config = static::config();

        $form_contact = $request->input('button_contact');

        foreach ($config as $key => $item) {
            if(isset($form_contact[$key])) {
                if($key == 'zaloImg' || $key == 'fbImg') {
                }
                $config[$key] = $form_contact[$key];
            }

        }

        Option::update('product_element_button_contact', $config);

        if($request->has('social_messenger_id'))
        {
            Option::update('social_messenger_id', $request->input('social_messenger_id'));
        }

        response()->success(trans('ajax.save.success'));
    }

    public function render($object): void
    {
        $config = static::config();

        if(Language::hasMulti() && Language::current() != Language::default()) {
            $langCurrent = Language::current();
            $config['title'] = static::config('title_'.$langCurrent);
        }

        if(empty($config['zaloImg']))
        {
            $config['zaloImg'] = Url::base().PR_EL_PATH.'/assets/images/contact/zalo.png';
        }

        if(empty($config['fbImg']))
        {
            $config['fbImg'] = Url::base().PR_EL_PATH.'/assets/images/contact/messenger.jpg';
        }

        $css = new ThemeCssBuild('.pr-element-button-contact');

        $css->cssStyle('.heading', [
            'data'  => $config['titleStyle'],
            'style' => 'cssText',
            'options' => [
                'desktop' => 'css',
                'tablet'  => 'cssTablet',
                'mobile'  => 'cssMobile',
            ]
        ]);

        Plugin::view(PR_EL_NAME, static::KEY.'/element', ['config' => $config, 'css' => $css]);
    }

    public function css(): void
    {
        include PR_EL_PATH.'/assets/css/button-contact.css';
    }
}

new Product_Element_Button_Contact();