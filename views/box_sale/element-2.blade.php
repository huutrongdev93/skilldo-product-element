<div class="pre-box-sale">
    <div class="box-promotion">
        <h4 class="header-promotion"><i class="fas fa-gift"></i> {!! $config['title'] !!}</h4>
        <div class="pre-box-sale__content">{!! $sale !!}</div>
    </div>
</div>
<style>
    :root {
        --pre-box-sale-padding      : {!! $config['padding'] !!};
        --pre-box-sale-margin       : {!! $config['margin'] !!};
        --pre-box-sale-bg_box       : {!! (!empty($config['bg_box'])) ? $config['bg_box'] : 'var(--theme-color)' !!};
        --pre-box-sale-text_color   : {!! (!empty($config['text_color'])) ? $config['text_color'] : 'var(--theme-color)' !!};
    }
</style>
<style>
    .box-promotion {
        margin: var(--pre-box-sale-margin);
        position: relative;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .box-promotion .header-promotion {
        position: absolute;
        display: inline-block;
        padding: 10px 20px;
        margin: 0;
        background-color: var(--pre-box-sale-bg_box);
        border-radius: 20px;
        color: var(--pre-box-sale-text_color);
        top: 0;
        left: 5%;
        transform: translate(-5%,-50%);
        font-size: 14px;
    }
    .pre-box-sale .pre-box-sale__content {
        background: none;
        border-top: none;
        -webkit-border-radius: 0 0 4px 4px;
        -moz-border-radius: 0 0 4px 4px;
        -ms-border-radius: 0 0 4px 4px;
        -o-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
        -moz-background-clip: padding;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        padding: var(--pre-box-sale-padding);
    }
</style>