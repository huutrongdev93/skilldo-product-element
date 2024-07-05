<?php

use JetBrains\PhpStorm\NoReturn;

Class Product_Element_Form_Contact {

    const KEY = 'form_contact';

    public function __construct() {
        add_filter('product_element_module', [$this, 'register'], 10);
        add_filter('product_detail_info', [$this, 'render'], self::config('position'));
        add_action('theme_custom_css', array( $this, 'css'), 10);
    }

    public function register($module) {
        $module[Product_Element_Form_Contact::KEY] = [
            'label' => 'Form contact',
            'class' => 'Product_Element_Form_Contact'
        ];
        return $module;
    }

    static function config($key = '') {

        $option = [
            'position'          => 50,
            'title'             => 'NHẬP THÔNG TIN ĐỂ ĐƯỢC TƯ VẤN',
            'placeholder'       => 'Số điện thoại của bạn',
            'button_icon'       => html_escape('<i class="fal fa-paper-plane"></i>'),
            'padding'           => '10px',
            'bg_box'            => '',
            'bg_input'          => '#fff',
            'bg_button'         => '#fff',
            'bg_button_hover'   => '#fff',
            'color_button'      => '#000',
            'color_button_hover'=> '#000',
        ];

        $option_save = Option::get('product_element_form_contact', []);

        foreach ($option as $key_default => $item) {
            if(!isset($option_save[$key_default])) $option_save[$key_default] = $item;
        }

        if(!empty($key)) return Arr::get($option_save , $key);

        return $option_save;
    }

    static function pageConfig(): void
    {
        if(class_exists('generate_form_register')) {

            $form = Form_Register::where('key', 'product_form_contact')->first();

            if(!have_posts($form)) {

                $forms_default = [
                    'key'       => 'product_form_contact',
                    'name'      => 'Đăng ký liên hệ tư vấn',
                    'is_live'   => 1,
                    'send_email'=> 0,
                    'field'     => [
                        "default" => [
                            'name' => [
                                "use" => 0,
                                "field" => "name",
                                "label" => "",
                                "required" => 0,
                                "limit" => 0,
                            ],
                            'email' => [
                                "use" => 0,
                                "field" => "email",
                                "label" => "Email",
                                "required" => 0,
                                "isEmail" => 0,
                            ],
                            'phone' => [
                                "use"   => 1,
                                "field" => "phone",
                                "label" => "Số điện thoại",
                                "required" => 1,
                                "isPhone" => 1,
                            ],
                            'message' => [
                                "use"   => 0,
                                "field" => "note",
                                "label" => "Ghi chú",
                                "required" => 0,
                            ],
                        ],
                        'metadata'  => [
                            uniqid() => [
                                'name'  => 'url',
                                'field' => 'url',
                                'label' => 'Liên kết'
                            ]
                        ],
                    ],
                ];

                Form_Register::insert($forms_default);

                Form_Register_Helper::build();
            }


            $formText = form();
            $formText->number('form_contact[position]',['label' => 'Thứ tự gắn vào hook "product_detail_info"'], Product_Element_Form_Contact::config('position'));
            $formText->text('form_contact[title]', ['label' => 'Tiêu đề'], Product_Element_Form_Contact::config('title'));
            $formText->text('form_contact[placeholder]',[
                'label' => 'Placeholder input',
                'start' => 6
            ], Product_Element_Form_Contact::config('placeholder'));
            $formText->fontIcon('form_contact[button_icon]', [
                'label' => 'Button send icon',
                'start' => 6
            ], Product_Element_Form_Contact::config('button_icon'));

            $formStyle = form();
            $formStyle->text('form_contact[padding]', ['label' => 'Padding khung'], Product_Element_Form_Contact::config('padding'));
            $formStyle->color('form_contact[bg_box]', ['label' => 'Màu nền Box', 'start' => 3], Product_Element_Form_Contact::config('bg_box'));
            $formStyle->color('form_contact[bg_input]', ['label' => 'Màu nền input', 'start' => 3], Product_Element_Form_Contact::config('bg_input'));
            $formStyle->color('form_contact[bg_button]', ['label' => 'Màu nền button', 'start' => 3], Product_Element_Form_Contact::config('bg_button'));
            $formStyle->color('form_contact[bg_button_hover]', ['label' => 'Màu nền button hover', 'start' => 3], Product_Element_Form_Contact::config('bg_button_hover'));
            $formStyle->color('form_contact[color_button]', ['label' => 'Màu text button', 'start' => 3], Product_Element_Form_Contact::config('color_button'));
            $formStyle->color('form_contact[color_button_hover]', ['label' => 'Màu text button hover', 'start' => 3], Product_Element_Form_Contact::config('color_button_hover'));

            Plugin::view(PR_EL_NAME, Product_Element_Form_Contact::KEY.'/admin/config', [
                'formText' => $formText,
                'formStyle' => $formStyle,
            ]);
        }
        else {
            echo Admin::alert('error', 'Plugin <b>generate_form_register</b> chưa được cài đặt.');
        }
    }

    #[NoReturn]
    static function saveConfig(\SkillDo\Http\Request $request, $model): void
    {

        $config = Product_Element_Form_Contact::config();

        $form_contact = $request->input('form_contact');

        foreach ($config as $key => $item) {
            if(isset($form_contact[$key]))
            $config[$key] = Str::clear($form_contact[$key]);
        }

        Option::update('product_element_form_contact', $config);

        response()->success(trans('ajax.save.success'));
    }

    public function render($object): void
    {
        $config = Product_Element_Form_Contact::config();

        Plugin::view(PR_EL_NAME, Product_Element_Form_Contact::KEY.'/element', ['config' => $config]);
    }

    public function css(): void
    {
        include PR_EL_PATH.'/assets/css/form-contact.css';
    }
}

new Product_Element_Form_Contact();