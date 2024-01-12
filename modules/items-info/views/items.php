<div class="product-detail-items-info" style="--prd-item-info-per-row: <?php echo $itemInfo['number'];?>;  --prd-item-info-heading: <?php echo $itemInfo['headingColor'];?>;  --prd-item-info-desc: <?php echo $itemInfo['descColor'];?>;">
    <div class="item-info-wrapper">
    <?php foreach ($itemInfo['items'] as $key => $item) { $item['description'] = str_replace('{contact_phone}', Option::get('contact_phone'), $item['description'])?>
        <div class="item-info item<?php echo $key;?>" data-aos-delay="<?php echo $number++*100;?>" data-aos="fade-up" data-aos-duration="500">
            <div class="item-img"><?php Template::img($item['image'], $item['title']);?></div>
            <div class="item-title">
                <?php if(!empty($item['title'])) {?><p class="item-heading"><?php echo $item['title'];?></p><?php } ?>
                <?php if(!empty($item['description'])) {?><p class="item-description"><?php echo $item['description'];?></p><?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>
</div>