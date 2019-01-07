<?php


// ウィジェットを追加
register_sidebar();

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name'			=> 'ピックアップ記事',
		'id'			=> 'pickup_posts',
		'before_widget'	=> '<div>',
		'after_widget'	=> '</div>'
	));
}

// ナビゲーションメニュー名から記事を取得する関数
function showNavPosts($menu_name) {

	// ナビゲーションメニュー名を指定
	$menu = wp_get_nav_menu_object( $menu_name );

	// ウィジェット情報を取得
	$widget_nav_menus = get_option('widget_nav_menu');

	foreach ($widget_nav_menus as $key => $widget_data) {
		if(is_array($widget_data) && $widget_data['nav_menu']) {
			$widget_id = $widget_data['nav_menu'];

			/* ウィジェットに該当するナビゲーションメニューを設定しているかを確認し
			   設定があればナビゲーションメニューをリスト表示する
			*/
			if($widget_id == $menu->term_id) {
			?>
		<h4><?php
		// ウィジェットのタイトル
		echo $widget_data['title'];
		?></h4>
			<?php

				// ▼ここから ナビゲーションメニューの記事を取得・表示
				$menu_items	= wp_get_nav_menu_items($menu->term_id);

				foreach ( (array) $menu_items as $key => $menu_item ) {
					$post_id		= $menu_item->object_id;
					$content		= get_post($post_id);

					$post_title		= $menu_item->title;
					$post_url		= $menu_item->url;
					$categories		= $content->post_category;
					$post_content	= wp_html_excerpt($content->post_content);
					$post_thumbail	= get_the_post_thumbnail_url($post_id, 'thumbnail');
					?>
					<div class="media mt-3">
						<a href="<?php echo $post_url; ?>">
							<img class="d-flex mr-3" src="<?php echo $post_thumbail; ?>" alt="">
						</a>

						<div class="media-body">
							<h5 class="mt-0">
								<a href="<?php echo $post_url; ?>"><?php
							// 記事タイトルを表示
							echo $post_title;
							?></a>
							</h5>

							<?php
							// カテゴリーを表示
							if($categories) {

							echo '<p>';

								foreach ($categories as $category_id) {
									$category		= get_category($category_id);
									$category_name	= $category->cat_name;

									// カテゴリーの区切り
									if($category_id != reset($categories)) {
										echo ' / ';
									}

									echo $category_name;
								} // foreach

							echo '</p>';

							} // if
							// ここまで/カテゴリーを表示
							?>
							<p><?php
							// 本文
							echo wp_html_excerpt($post_content, 40, '…');
							?></p>
						</div>
					</div>
					<?php
				} // foreach $menu_items
				// ▲ここまで / ナビゲーションメニューの記事を取得・表示


			} // if
		} // if
	} // foreach
} // showNavPosts