<?php

get_header();
if (have_posts()) : while (have_posts()) : the_post();?>

<section class="fdb-block py-5 bg-white">
    <div class="container">
        <div class="row text-center pb-0 pb-lg-4">
            <div class="col-12">
                <h1 class="wow fadeIn"><?php the_title();?></h1>
            </div>
        </div>
    </div>
</section>

<section class="fdb-block bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php the_content();?>
            </div>
        </div>
    </div>
</section>

<?php endwhile; endif;?>

<?php get_footer();?>