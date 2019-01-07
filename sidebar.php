<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 */
?>


<?php
// ウィジェットの取得&関数呼び出し
// function.php で設定したウィジェットID
if ( is_active_sidebar( 'pickup_posts' ) && function_exists('showNavPosts') ) :
?>

<div class="widget-area" role="complementary">
<?php showNavPosts('pickup'); ?>
</div><!-- .widget-area -->

<?php
// ここまで / ウィジェットの取得&関数呼び出し
endif;
?>