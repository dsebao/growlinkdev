<footer class="fdb-block footer-small">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-md-10">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php bloginfo('url');?>/contact/"><?php _e('Contact','growlink');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php bloginfo('url');?>/privacy/"><?php _e('Privacy','growlink');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php bloginfo('url');?>/terms/"><?php _e('Terms','growlink');?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php bloginfo('url');?>/report/"><?php _e('Report Violation','growlink');?></a>
                    </li>
                    <li class="nav-item drowdown">
                        <a class="nav-link dropdown-toggle" href="" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php _e('Language','growlink');?></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownLanguage">
                            <a class="dropdown-item" href="<?php echo network_home_url('');?>es"><?php _e('Spanish','growlink');?></a>
                            <a class="dropdown-item" href="<?php echo network_home_url('');?>"><?php _e('English','growlink');?></a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer();?>
<?php echo growlink_getoption('footer_scripts');?>
</body>
</html>