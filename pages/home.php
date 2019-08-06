<?php

/*
Template Name: Home
*/

get_header();
?>

<section class="fdb-block py-5 main-fold">
    <div class="container">
        <div class="row text-right align-items-center">
            <div class="col-12 col-lg-6 col-xl-5 pt-4 pt-md-0 m-lg-auto text-left">
                <h1 class="wow fadeInLeft"><?php _e('Share more on your social bio links.','growlink');?></h1>
                <p class="lead wow fadeIn" data-wow-delay="0.3s"><?php _e('Turn a single link into a unlimited, <i>100% free</i>','growlink');?></p>
                <p><a class="btn btn-lg btn-primary mt-4 mb-5 mb-md-0 wow fadeIn d-none d-md-inline-block" data-wow-delay="0.6s" href="<?php bloginfo('url');?>/signup/"><?php _e('Get Started','growlink');?></a></p>
            </div>
            <div class="col-12 col-md-5 m-auto p-0">
                <div id="slidephones" data-slick='{"slidesToShow": 1, "slidesToScroll": 1,"fade": true,"infinite": true,"arrows" : false,"autoplay":true}'>
                  <div><img alt="image" class="img-fluid" src="<?php bloginfo('template_url');?>/src/images/slide-1.png"></div>
                  <div><img alt="image" class="img-fluid" src="<?php bloginfo('template_url');?>/src/images/slide-2.png"></div>
                  <div><img alt="image" class="img-fluid" src="<?php bloginfo('template_url');?>/src/images/slide-3.png"></div>
                </div>
                <p class="px-4"><a class="btn btn-lg btn-primary mt-0 d-block d-md-none" data-wow-delay="0.6s" href="<?php bloginfo('url');?>/signup/"><?php _e('Get Started','growlink');?></a></p>

            </div>
        </div>
    </div>
</section>

<section class="fdb-block bg-gray">
    <div class="container">
        <div class="row text-center pb-0 pb-lg-4">
            <div class="col-12">
                <h1 class="wow fadeIn"><?php _e('Never Change your bio again','growlink');?></h1>
            </div>
        </div>
        <div class="row text-right align-items-center">
            <div class="col-md-6 m-auto pt-5 pt-md-0">
                <img alt="image" class="img-fluid wow fadeInLeft" src="<?php bloginfo('template_url');?>/src/images/slide-2.png">
            </div>
            <div class="col-12 col-lg-6 col-xl-5 m-lg-auto text-left">
                <h3 class="lead mb-5 wow fadeIn" data-wow-delay="0.15s"><?php _e('Socialink is a beautiful way to share your other social networks and recommend products, events, courses, and any other content with just one bio link.','growlink');?></h3>
                <p class="wow fadeIn" data-wow-delay="0.3s"><?php _e('Your landing page is a collection of links with images, which gets your followers to where you want them, fast.','growlink');?></p>
                <p><a class="btn btn-primary btn-lg mt-4 mb-5 mb-md-0 wow fadeIn d-block d-md-inline-block" data-wow-delay="0.6s" href="<?php bloginfo('url');?>/signup/"><?php _e('Sign Up for free!','growlink');?></a></p>
            </div>

        </div>
    </div>
</section>
<section class="fdb-block">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1><?php _e('How it works','growlink');?></h1>
            </div>
        </div>
        <div class="row text-center justify-content-center mt-5">
            <div class="col-12 col-sm-4 col-xl-3 m-md-auto">
                <img alt="image" class="fdb-icon" src="<?php bloginfo('template_url');?>/src/images/link.svg">
                <h3><strong><?php _e('Your unique link','growlink');?></strong></h3>
                <p><?php _e('You\'ll get one bio link to house all the content you\'re driving followers to.','growlink');?></p>
            </div>

            <div class="col-12 col-sm-4 col-xl-3 m-auto pt-4 pt-sm-0">
                <img alt="image" class="fdb-icon" src="<?php bloginfo('template_url');?>/src/images/share.svg">
                <h3><strong><?php _e('Add multiple destinations','growlink');?></strong></h3>
                <p><?php _e('Add other social networks, recommend products, causes you care about, etc.','growlink');?></p>
            </div>
            <div class="col-12 col-sm-4 col-xl-3 m-auto pt-4 pt-sm-0">
                <img alt="image" class="fdb-icon" src="<?php bloginfo('template_url');?>/src/images/pay-per-click.svg">
                <h3><strong><?php _e('Easily managed','growlink');?></strong></h3>
                <p><?php _e('It works in all the places you need to share important links with your followers.','growlink');?></p>
            </div>
        </div>
        <div class="text-center  mt-5">
            <a href="<?php bloginfo('url');?>/signup/" class="btn btn-primary btn-lg mx-md-4 mb-4"><?php _e('Join Now for free','growlink');?></a>
            <a href="<?php bloginfo('url');?>/features/" class="btn btn-secondary btn-lg mx-md-4 mb-4"><?php _e('All features','growlink');?></a>
        </div>
    </div>
</section>
<section class="fdb-block pt-5 bg-gray">
    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="col-8">
                <h1><?php _e('Some examples','growlink');?></h1>
            </div>
        </div>
        <div class="row-50"></div>
        <div class="row">
            <div class="col-sm-3 text-left">
                <div class="fdb-box person-card clickdiv mb-4 p-0">
                    <img alt="image" class="img-fluid rounded-0" src="<?php bloginfo('template_url');?>/src/images/people-1.png">
                    <div class="content p-3">
                        <h3><strong><a href="">@mikeleague</a></strong></h3>
                        <span class="muted">Musician</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-left">
                <div class="fdb-box person-card clickdiv mb-4 p-0">
                    <img alt="image" class="img-fluid rounded-0" src="<?php bloginfo('template_url');?>/src/images/people-2.png">
                    <div class="content p-3">
                        <h3><strong><a href="">@stevendorzlky</a></strong></h3>
                        <span class="muted">Marketing</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-left">
                <div class="fdb-box person-card clickdiv mb-4 p-0">
                    <img alt="image" class="img-fluid rounded-0" src="<?php bloginfo('template_url');?>/src/images/people-3.png">
                    <div class="content p-3">
                        <h3><strong><a href="">@laudomink</a></strong></h3>
                        <span class="muted">Normal Person</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-left">
                <div class="fdb-box person-card clickdiv mb-4 p-0">
                    <img alt="image" class="img-fluid rounded-0" src="<?php bloginfo('template_url');?>/src/images/people-4.jpg">
                    <div class="content p-3">
                        <h3><strong><a href="">@kaelymuik</a></strong></h3>
                        <span class="muted">Fashion influencer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer();?>