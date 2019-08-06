<nav id="dash-menu" class="navbar navbar-expand-sm navbar-light bg-white py-sm-0" data-page="<?php global $wp; echo home_url( add_query_arg( array(), $wp->request))?>">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dashmenu-elements" aria-controls="dashmenu-elements" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="dashmenu-elements">
            <?php wp_nav_menu(array('theme_location' => 'menu' , 'container' => false,  'menu_class' => 'navbar-nav mr-auto', 'sort_column' => 'menu_order','walker'=> new WP_Bootstrap_Navwalker()));?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown avatarlink">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar">
                            <img src="<?php echo get_avatarimg_url(get_avatar($theuser->ID));?>" width="40" height="40" class="rounded-circle" alt="<?php echo $theuser->display_name;?>">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown07">
                        <a class="dropdown-item" href="<?php echo wp_logout_url(home_url());?>"><?php _e('Logout','growlink');?></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="bg-white py-3 mb-3 mb-md-5">
    <div class="container">
    <form action="" id="form-link-copy" class="form">
        <div class="form-group" style="display:inline;">
            <div class="input-group">
            <input class="form-control" id="biourllinkdesktop" name="biourllinkdesktop" type="text" value="<?php echo getBio($theuser->ID,'guid');?>">
            <span class="input-group-btn">
                <button id="clipboard-action-tooltip" type="button" class="btncopy btn btn-secondary ml-2 text-white" data-clipboard-action="copy" data-clipboard-target="#biourllinkdesktop" data-toggle="tooltip" data-trigger="manual" data-placement="bottom" title="Copied!"><i class="far fa-fw fa-copy"></i> <?php _e('Copy','growlink');?></button>
                <button type="button" class="btn btn-info ml-2 text-white" onclick="window.open('<?php echo getBio($theuser->ID);?>')"><i class="fas fa-external-link-alt"></i> <?php _e('Open','growlink');?></button>
            </span>
          </div>
        </div>
    </form>
    </div>
</div>