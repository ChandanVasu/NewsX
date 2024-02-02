<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik:ital,wght@0,500;1,500&display=swap" rel="stylesheet">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
    <h1><?php bloginfo('name'); ?></h1>
    <nav id="primary-navigation">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary-menu',
            'menu_id'        => 'primary-menu-id',
            'container'      => 'nav',
            'container_class'=> 'primary-menu-container',
            'menu_class'     => 'primary-menu-class'
        ));
        ?>
    </nav>
</header>
