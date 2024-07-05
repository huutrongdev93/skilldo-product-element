<div class="pre-form-contact">
    <p class="pre-form-contact__title">{!! $config['title'] !!}</p>
    <div class="pre-form-contact__box">
        <form method="post" class="form email-register-form">
            <div class="form-group">
                <div class="input">
                    <input name="phone" type="text" class="form-control input-lg" required placeholder="{!! $config['placeholder'] !!}">
                    <input name="form_key" type="hidden" value="product_form_contact">
                    <input name="url" type="hidden" value="{!! Url::current() !!}">
                </div>
                <button type="submit" class="btn">{!! html_entity_decode($config['button_icon']) !!}</button>
            </div>
        </form>
    </div>
</div>
<style>
    :root {
        --pre-form-contact-padding           : {!! $config['padding'] !!};
        --pre-form-contact-bg_box            : {!! (!empty($config['bg_box'])) ? $config['bg_box'] : 'var(--theme-color)' !!};
        --pre-form-contact-bg_input          : {!! $config['bg_input'] !!};
        --pre-form-contact-bg_button         : {!! $config['bg_button'] !!};
        --pre-form-contact-bg_button_hover   : {!! $config['bg_button_hover'] !!};
        --pre-form-contact-color_button      : {!! $config['color_button'] !!};
        --pre-form-contact-color_button_hover: {!! $config['color_button_hover'] !!};
    }
</style>