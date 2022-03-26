<?php wp_head();?>

<header class="header">
  <div class="header__container">
    <a href="<?php echo get_home_url();?>" class="header__logo">
      <img src="<?php echo get_stylesheet_directory_uri();?>/lib/images/logo.png" alt="movify">
    </a>

    <nav class="header__nav">
      <?php wp_nav_menu(array(
        'theme_location' => 'main-menu',
        'container' => 'ul',
        'menu_class' => 'header__nav-list'
      ));?>
    </nav>


    <a href="" class="header__search">
      <img src="" alt="">
    </a>

    <a href="#" class="header__login"><i class="icon-user"></i> Login</a>

  </div>
</header>