<div class="pre-button-cart-box text-<?php echo $config['location'];?>">
    <?php if($count == 0) {?>
    <button class="btn btn-effect-default product_add_to_cart_now" data-id="<?php echo $object->id;?>">
        <span><?php echo html_entity_decode($config['button_icon']);?> <?php echo __('Mua Ngay');?></span>
    </button>
    <?php } else { ?>
    <a class="btn btn-effect-default" href="<?php echo Url::permalink($object->slug);?>">
        <span><?php echo html_entity_decode($config['button_icon']);?> <?php echo __('Xem Ngay');?></span>
    </a>
    <?php } ?>
</div>