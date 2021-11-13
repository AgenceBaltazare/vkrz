<?php
/*
    Template Name: Tirage
*/
?>
<?php get_header(); ?>
<div class="app-content content ">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="blog-detail-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body apropos">
                                <h1 class="text-center">
                                    Tirage au sort des gagnants🍀
                                </h1>
                                
                                <div class="card-text mb-2 mt-2">
                                    <div class="big">
                                    
                                        <?php echo rand(1, 26); ?>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>