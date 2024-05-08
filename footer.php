<?php
/**
 * Template for displaying the footer
 *
 * Contains the closing of the class=container div and all content
 * after.
 *
 * @package nextawards
 */
?>

<footer class="pt-3 pb-3">

    <div class="col-100">
        <hr class="mb-3">
    </div>

    <div class="grid">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer')) : ?>
        <?php endif; ?>
    </div>

    <div class="grid">
        <div class="col-50">
            <p class="sma-text-center">
                &copy; Copyright <?php echo date("o"); ?> 
                <?php bloginfo('name'); ?>
                <br>
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy">Privacy Policy</a> and
                <a href="https://policies.google.com/terms">Terms of Service</a> apply.
            </p>
        </div>
        <div class="col-50">
            <p class="alignright sma-text-center">
                <a href="#top"><i class="fa fa-angle-double-up"></i> <?php esc_html_e('Top', 'nextawards'); ?></a>
            </p>
        </div>
    </div>

</footer>

</div> <!-- Closing container div, ensure this is correct as per your theme structure -->

<?php if (esc_attr(get_theme_mod('nextawards_whatsapp', '')) != '') : ?>
    <a href="https://api.whatsapp.com/send?phone=<?php echo esc_attr(get_theme_mod('nextawards_whatsapp', '')); ?>" target="_blank" class="logo-whats-app">
        <div class="icon-wa"></div>
    </a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
