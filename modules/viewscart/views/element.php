<div class="pre-views-car-box">
    <div class="pre-views-box text-left">
        <span class="btn btn-effect-default"><?php echo html_entity_decode($config['views_icon']);?> <?php echo $view;?> <?php echo __('Lượt xem');?></span>
    </div>
    <div class="pre-cart-box text-right">
        <?php if($count == 0) {?>
            <button class="btn btn-effect-default product_add_to_cart_now" data-id="<?php echo $object->id;?>">
                <span><?php echo html_entity_decode($config['cart_icon']);?> <?php echo __('Mua Ngay');?></span>
            </button>
        <?php } else { ?>
            <a class="btn btn-effect-default" href="<?php echo Url::permalink($object->slug);?>">
                <span><?php echo html_entity_decode($config['cart_icon']);?> <?php echo __('Xem Ngay');?></span>
            </a>
        <?php } ?>
    </div>
</div>