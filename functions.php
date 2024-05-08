<?php

function my_child_theme_setup()
{

    // $args = array(
    //     'width'         => 1200, // Imposta la larghezza dell'immagine dell'intestazione.
    //     'height'        => 600,  // Imposta l'altezza dell'immagine dell'intestazione.
    //     'flex-width'    => true, // Permette larghezza flessibile.
    //     'flex-height'   => true, // Permette altezza flessibile.
    //     'header-text'   => false, // Nasconde il testo dell'intestazione se desiderato.
    //     'uploads'       => true, // Permette l'upload di un'immagine personalizzata.
    // );

    // add_theme_support( 'custom-header', $args );

    // Rimuovi gli stili CSS del customizer definiti nel tema padre
    remove_action('wp_head', 'nextawards_customize_css');
}
add_action('after_setup_theme', 'my_child_theme_setup');

/* Customizer CSS Front-end */
/* ------------------------------------ */
function nextawards_customize_css_plus()
{

    $nextawards_bg_color = get_background_color();
    echo '<style type="text/css">';
    echo ':root { --site-bg: #' . $nextawards_bg_color . '; --link-color: ' . esc_attr(get_theme_mod('nextawards_link_color', '#048ea0')) . '; --link-color-hover: ' . esc_attr(get_theme_mod('nextawards_link_color_hover', '#105862')) . '; }';
    echo 'body{font-family: ' . esc_attr(get_theme_mod('nextawards_google_font_body', 'Barlow')) . '}';
    echo 'h1,h2,h3,h4,h5,h6{font-family: ' . esc_attr(get_theme_mod('nextawards_google_font', 'Barlow')) . '}';
    echo '.wp-block-button__link{background-color: ' . esc_attr(get_theme_mod('nextawards_link_color', '#048ea0')) . '}';
    echo '.wp-block-button__link:hover{background-color: ' . esc_attr(get_theme_mod('nextawards_link_color_hover', '#105862')) . '}';
    // Verifica se l'opzione di sfondo trasparente non è attiva
    if (get_theme_mod('nextawards_header_transparent') !== true) {
        echo '.header {background-color: ' . esc_attr(get_theme_mod('nextawards_header_color', '#E4E4E4')) . '}';
    }
    echo '.header__content, .header__menu li {border-color: ' . esc_attr(get_theme_mod('nextawards_border_color', '#222222')) . '}';
    if (esc_attr(get_theme_mod('nextawards_center_logo', 'no')) == "Yes") {
        echo '@media (min-width: 768px) {.header__logo{position: absolute; left: 50%; transform: translate(-50%,50%);}.header__logo img{margin-top:-10px}}';
    }
    if (esc_attr(get_theme_mod('nextawards_menu_left', 'no')) == "Yes") {
        echo '@media (min-width: 998px) { .header__content{position: relative; justify-content: flex-start;} .header__quick{position: absolute; right:70px;top: 27px}}';
    }
    if (class_exists('WooCommerce')) {
        echo '.woocommerce .button{background-color: ' . esc_attr(get_theme_mod('nextawards_link_color', '#048ea0')) . '!important}';
        echo '.woocommerce .button:hover{background-color: ' . esc_attr(get_theme_mod('nextawards_link_color_hover', '#105862')) . '!important}';
    }

    echo '.has-light-gray-background-color {background-color: #f5f5f5 }';
    echo '.has-light-gray-color  {color: #f5f5f5 }';

    echo '.has-medium-gray-background-color {background-color: #999 }';
    echo '.has-medium-gray-color  {color: #999 }';

    echo '.has-dark-gray-background-color {background-color: #333 }';
    echo '.has-dark-gray-color {color: #333 }';

    echo '.has-link-color-background-color {background-color: ' . esc_attr(get_theme_mod('nextawards_link_color', '#048ea0')) . ';}';
    echo '.has-link-color-color {color: ' . esc_attr(get_theme_mod('nextawards_link_color', '#048ea0')) . ';}';

    echo '.has-link-color-hover-background-color {background-color: ' . esc_attr(get_theme_mod('nextawards_link_color_hover', '#048ea0')) . ';}';
    echo '.has-link-color-hover-color {color: ' . esc_attr(get_theme_mod('nextawards_link_color_hover', '#048ea0')) . ';}';

    echo '</style>';
}
add_action('wp_head', 'nextawards_customize_css_plus');

/******************************************
 * Customizer
 *******************************************/
function nextawards_customize_register_plus($wp_customize)
{
    // Aggiungi una sezione se non esiste già
    $wp_customize->add_section('nextawards_header_options', array(
        'title'    => __('Header Options', 'nextawards'),
        'priority' => 30,
    ));

    // Aggiungi nel DB l'impostazione per il background trasparente
    $wp_customize->add_setting('nextawards_header_transparent', array(
        'default'   => false, // Imposta il valore di default su non trasparente
        'transport' => 'refresh', // Aggiorna la pagina dopo il salvataggio delle impostazioni
        'sanitize_callback' => 'nextawards_sanitize_checkbox', // Funzione di sanitizzazione
    ));

    // Aggiungi il controllo della checkbox
    $wp_customize->add_control('nextawards_header_transparent_control', array(
        'label'    => __('Make header background transparent', 'nextawards'),
        'section'  => 'nextawards_header_options',
        'settings' => 'nextawards_header_transparent',
        'type'     => 'checkbox',
    ));
}
add_action('customize_register', 'nextawards_customize_register_plus');

// Funzione di sanitizzazione per la checkbox
function nextawards_sanitize_checkbox($checked)
{
    // restituisce true se checkbox è selezionata
    return ((isset($checked) && true == $checked) ? true : false);
}

function nextawards_customize_unregister($wp_customize)
{

    // Verifica se l'opzione di sfondo trasparente non è attiva
    if (get_theme_mod('nextawards_header_transparent') === true) {
        // Rimuovi il controllo del colore dell'intestazione
        $wp_customize->remove_control('nextawards_header_color_control');

        // Rimuovi l'impostazione del colore dell'intestazione
        $wp_customize->remove_setting('nextawards_header_color');
    }
}
add_action('customize_register', 'nextawards_customize_unregister', 20);

/******************************************
 * Styles & Scripts
 *******************************************/

function nextawards_parent_enqueue_styles()
{
    // load only the parent theme's stylesheet
    // wp_enqueue_style( 'nextawards-parent-style', get_parent_theme_file_uri('style.css') );

    //  load the active theme’s stylesheet after parent theme's stylesheet
    wp_enqueue_style('nextawards-child', get_stylesheet_uri(), array('nextawards'));

    // load js
    wp_enqueue_script('my-custom-script', get_stylesheet_directory_uri() . '/my-custom-script.js', array(), false, true);
    wp_enqueue_script('boxicons', 'https://unpkg.com/boxicons@2.1.4/dist/boxicons.js', array(), null, false);
}
add_action('wp_enqueue_scripts', 'nextawards_parent_enqueue_styles');

/******************************************
 * Download
 *******************************************/

function nextawards_parent_enqueue_scripts()
{
    wp_enqueue_script('my-custom-script', get_stylesheet_directory_uri() . '/my-custom-script.js', array(), false, true);

    wp_localize_script('my-custom-script', 'siteData', array(
        'pdfUrl' => home_url('wp-content/uploads/2024/04/programma.pdf')
    ));
}
add_action('wp_enqueue_scripts', 'nextawards_parent_enqueue_scripts');

/******************************************
 * Editor Layout
 *******************************************/

function gb_gutenberg_admin_styles()
{
    echo '
        <style>
            /* Main column width */
            .wp-block {
                max-width: 720px;
            }
 
            /* Width of "wide" blocks */
            .wp-block[data-align="wide"] {
                max-width: 1080px;
            }
 
            /* Width of "full-wide" blocks */
            .wp-block[data-align="full"] {
                max-width: none;
            }	
        </style>
    ';
}
add_action('admin_head', 'gb_gutenberg_admin_styles');

/******************************************
 * EMAIL SETTINGS
 *******************************************/

 if (strpos(get_site_url(), 'local') !== false) {
    function mailtrap($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '7e6787bcb10937';
        $phpmailer->Password = '07e3b9a8d5037e';
    }

    add_action('phpmailer_init', 'mailtrap');
}


