<div class="pre-button-cart-box text-<?php echo $config['location'];?>">
    <?php if($count == 0) {?>
    <button class="btn btn-effect-default wcmc_add_to_cart_now" data-id="<?php echo $object->id;?>">
        <span><?php echo html_entity_decode($config['button_icon']);?> <?php echo __('Mua Ngay');?></span>
    </button>
    <?php } else { ?>
    <a class="btn btn-effect-default" href="<?php echo Url::permalink($object->slug);?>">
        <span><?php echo html_entity_decode($config['button_icon']);?> <?php echo __('Xem Ngay');?></span>
    </a>
    <?php } ?>
</div>
<style>
    :root {
        --pre-button-cart-padding           : <?php echo $config['padding'];?>;
        --pre-button-cart-margin           : <?php echo $config['margin'];?>;
        --pre-button-cart-bg_button         : <?php echo (!empty($config['bg_button'])) ? $config['bg_button'] : 'var(--theme-color)';?>;
        --pre-button-cart-bg_button_hover   : <?php echo (!empty($config['bg_button_hover'])) ? $config['bg_button_hover'] : 'var(--theme-color)';?>;
        --pre-button-cart-color_button      : <?php echo $config['color_button'];?>;
        --pre-button-cart-color_button_hover: <?php echo (!empty($config['color_button_hover'])) ? $config['color_button_hover'] : 'var(--theme-color)';?>;
    }
</style>
<style>
    .pre-button-cart-box .btn {
        padding:var(--pre-button-cart-padding);
        margin:var(--pre-button-cart-margin);
        border-color: var(--pre-button-cart-bg_button);
        display: inline-block;
        color: var(--pre-button-cart-color_button);
        width: auto; height: auto; line-height: 25px;
    }
    .pre-button-cart-box .btn.btn-effect-default:before {
        background-color: var(--pre-button-cart-bg_button);
    }
    .pre-button-cart-box .btn.btn-effect-default:hover {
        color: var(--pre-button-cart-color_button_hover);
    }
</style>