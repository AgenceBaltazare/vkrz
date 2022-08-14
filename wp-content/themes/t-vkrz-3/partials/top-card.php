<?php
global $id_top;
$list_cat   = get_the_terms($id_top, 'categorie');
$cat_id     = false;
if($list_cat){
    foreach ($list_cat as $cat) {
        $cat_id     = $cat->term_id;
    }
}
if($cat_id){
    $icontop = get_field('icone_cat', 'term_' . $cat_id);
}
else{
    $icontop = "<span class='va va-crossed-swords va-lg'></span>";
}
?>
<a href="<?php the_permalink($id_top); ?>" class="top-card">
    <div class="d-flex align-items-center">
        <div class="avatar">
            <?php $minia = get_the_post_thumbnail_url($id_top, 'large') ?>
            <span class="avatar-picture avatar-top" style="background-image: url(<?php echo $minia; ?>);"></span>
        </div>
        <div class="font-weight-bold topnamebestof">
            <div class="media-body">
                <div class="media-heading">
                    <h6 class="cart-item-title mb-0">
                        Top <?php the_field('count_contenders_t', $id_top); ?> <?php echo $icontop; ?> <?php echo get_the_title($id_top); ?>
                    </h6>
                    <span class="cart-item-by legende">
                        <?php the_field('question_t', $id_top); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</a>