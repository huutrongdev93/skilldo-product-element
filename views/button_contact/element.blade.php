<div class="pr-element-button-contact">
    <p class="heading">{!! $config['title'] !!}</p>
    <div class="buttons-contact">
        <a href="https://zalo.me/{!! Option::get('social_zalo') !!}" target="_blank">
            {!! Template::img($config['zaloImg'], 'zalo contact') !!}
        </a>
        <a href="https://fb.com/msg/{!! Option::get('social_messenger_id', '') !!}" target="_blank">
            {!! Template::img($config['fbImg'], 'facebook contact') !!}
        </a>
    </div>
</div>
<style>
    {!! $css->build() !!}
</style>