<?php

get_header();
if (have_posts()) : while (have_posts()) : the_post();?>

<section class="fdb-block py-5 bg-white main-fold">
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
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-body p-md-5">
                        <?php the_content();?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php endwhile; endif;?>

<?php get_footer();?>