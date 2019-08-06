<?php
/*
Template Name: Features
*/

get_header();
?>

<section class="fdb-block py-5 bg-white main-fold">
    <div class="container">
        <div class="row text-center pb-0 pb-lg-4">
            <div class="col-12">
                <h1 class="wow fadeIn"><?php _e('Growlink´s awesome features','growlink');?></h1>
                <p class="lead">
                    <?php _e('All the features listed below are available for all users, for free!','growlink');?>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="fdb-block bg-gray">
    <div class="container">
        <div class="row text-right align-items-center">
            <div class="col-12 col-md-5 m-auto pt-5 pt-md-0">
                <img alt="image" class="img-fluid wow fadeInLeft" src="<?php bloginfo('template_url');?>/src/images/slide-2.png">
            </div>
            <div class="col-12 col-lg-6 col-xl-5 m-lg-auto text-left">
                <h3 class="lead mb-5 wow fadeIn" data-wow-delay="0.15s"><?php _e('A beautiful and simple landing page where you can:','growlink');?></h3>
                <ul class="list">
                    <li><?php _e('Add unlimited links','growlink');?></li>
                    <li><?php _e('Add social media buttons','growlink');?></li>
                    <li><?php _e('Customize colors, buttons, fonts and images','growlink');?></li>
                    <li><?php _e('Add thumbnails to each link','growlink');?></li>
                    <li><?php _e('Highlight your most important links','growlink');?></li>
                    <li><?php _e('Choose your username and add a description','growlink');?></li>
                    <li><?php _e('Add a beautiful background image of GIF','growlink');?></li>
                </ul>
                <p><a class="btn btn-primary btn-lg mt-4 mb-5 mb-md-0 wow fadeIn d-block d-md-inline-block" data-wow-delay="0.6s" href=""><?php _e('Sign Up for free!','growlink');?></a></p>
            </div>

        </div>
    </div>
</section>

<section class="fdb-block bg-white">
    <div class="container">
        <div class="row text-right align-items-center">
            <div class="col-12 col-md-6 m-lg-auto text-left">
                <h3 class="lead mb-5 wow fadeIn" data-wow-delay="0.15s"><?php _e('A powerfull and intuitive dashboard where you can:','growlink');?></h3>
                <ul class="list">
                    <li><?php _e('See detailed statistics of your landing page','growlink');?></li>
                    <li><?php _e('See where your followers are based','growlink');?></li>
                    <li><?php _e('See how many times a link has been clicked','growlink');?></li>
                    <li><?php _e('Add custom UTM parameters to each link','growlink');?></li>
                    <li><?php _e('Schedule your links','growlink');?></li>
                    <li><?php _e('Grow your email list','growlink');?></li>
                    <li><?php _e('Add your facebook pixel re-targeting','growlink');?></li>
                </ul>
                <p><a class="btn btn-primary btn-lg mt-4 mb-5 mb-md-0 wow fadeIn d-block d-md-inline-block" data-wow-delay="0.6s" href=""><?php _e('Sign Up for free!','growlink');?></a></p>
            </div>
            <div class="col-12 col-md-5 m-auto pt-5 pt-md-0">
                <img alt="image" class="img-fluid wow fadeInLeft" src="<?php bloginfo('template_url');?>/src/images/slide-3.png">
            </div>
        </div>
    </div>
</section>
<section id="testimonials" class="fdb-block pt-0 pt-md-3" style="background-image: url(<?php bloginfo('template_url');?>/src/images/9.svg);">
    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7" style="z-index: 10000;"><h1><?php _e('Testimonials','growlink');?></h1></div>
        </div>
        <div class="row mt-5 align-items-center justify-content-center">
            <div class="col-md-8 col-lg-4" style="z-index: 10000;">
                <div class="fdb-box">
                    <div class="row no-gutters align-items-center">
                        <div class="col-3">
                            <img alt="image" class="img-fluid rounded" src="<?php bloginfo('template_url');?>/src/images/people-1.png">
                        </div>
                        <div class="col-8 ml-auto">
                            <p><strong>David Mateous</strong><br><em>Co-founder at Company</em></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <p class="lead">"I will refer everyone I know. Growlink is the real deal! I have gotten at least 500 more visits in my webiste. Not able to tell you how happy I am with Growlink."</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-4 mt-4 mt-lg-0" style="z-index: 10000;">
                <div class="fdb-box">
                    <div class="row no-gutters align-items-center">
                        <div class="col-3">
                            <img alt="image" class="img-fluid rounded" src="<?php bloginfo('template_url');?>/src/images/people-2.png">
                        </div>
                        <div class="col-8 ml-auto"><p><strong>Jenn Johnson</strong><br><em>Co-founder at Company</em></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <p class="lead">"Growlink did exactly what you said it does. This is simply unbelievable! I am completely blown away. I'm good to go."</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-4 mt-4 mt-lg-0" style="z-index: 10000;">
                <div class="fdb-box">
                    <div class="row no-gutters align-items-center">
                        <div class="col-3">
                            <img alt="image" class="img-fluid rounded" src="<?php bloginfo('template_url');?>/src/images/people-3.png">
                        </div>
                        <div class="col-8 ml-auto"><p><strong>Brian Baldwin</strong><br><em>Co-founder at Company</em></p></div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <p class="lead">"We have no regrets! I like Growlink more and more each day because it makes my life a lot easier. I would gladly pay what this guys will do in the future."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="fdb-block bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="mb-4"><?php _e('Frecuently asked questions','growlink');?></h1>
            </div>
        </div>
        <p>
        <div class="card faq mb-4">
            <div class="card-body" id="headingOne">
                <button class="btn px-0 px-sm-4 py-0 py-sm-1 btn-block text-left" type="button" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1">
                    <?php _e('What is Growl.ink?','growlink');?>
                </button>
                <div id="faq1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p>
                            <?php _e('Growl.ink allows you to create a personalised and easily customisable page, that houses all the important links you want to share with your followers on social platforms such as Instagram, Facebook, Youtube, Twitter, and more.','growlink');?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card faq mb-4">
            <div class="card-body" id="headingOne">
                <button class="btn px-0 px-sm-4 py-0 py-sm-1 btn-block text-left" type="button" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2">
                    <?php _e('Where can I share my Growl.ink?','growlink');?>
                </button>
                <div id="faq2" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p>
                            <?php _e('Once you\'ve setup your page and added all your links, you simply copy your unique URL and paste it into the \'Website\' field of your Instagram or Twitter bio or share it on facebook posts and Youtube Videos, or anywhere you want. Then, all you need to do is update your Growl.ink links - you never have to change the link in your bio again!','growlink');?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card faq mb-4">
            <div class="card-body" id="headingOne">
                <button class="btn px-0 px-sm-4 py-0 py-sm-1 btn-block text-left" type="button" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3">
                    <?php _e('How much does Growl.ink cost?','growlink');?>
                </button>
                <div id="faq3" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p><?php _e('Growl.ink is free to use. We have many cool features, but unlike other "link in bio" tools, there are no "pro" features -  everything is 100% free.','growlink');?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card faq mb-4">
            <div class="card-body" id="headingOne">
                <button class="btn px-0 px-sm-4 py-0 py-sm-1 btn-block text-left" type="button" data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4">
                    <?php _e('You have more questions?','growlink');?>
                </button>
                <div id="faq4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <p><?php _e('For any additional questions, please contact us at support@growl.ink.','growlink');?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer();?>