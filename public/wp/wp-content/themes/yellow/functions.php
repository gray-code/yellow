<?php add_theme_support('post-thumbnails'); ?>
<?php

define( 'SITE_NAME', get_bloginfo('site_name'));
define( 'OTHER_LOGIN', 'y120gate.php' );

function getPageMeta() {

	// Initialize
	global $paged;
	global $wp_query;
	$max_page = (int)$wp_query->max_num_pages;
	$base_url = get_bloginfo('url');
	$res = array(
		'base_url' => null,
		'title' => null,
		'h1' => null,
		'desc' => null,
		'keywords' => null,
		'next' => null,
		'prev' => null,
		'type' => null,
		'canonical' => null,
		'breadcrumb_html' => '<li><a href="' . $base_url . '" itemprop="url"><span itemprop="title">ホーム</span></a></li>',
	);

	if( is_category() ) {

		$cat = single_cat_title( '', false);

		if( is_category('document') ) {

			$res['title'] = $cat . ' | ' . SITE_NAME;
			$res['type'] = 'document';
			$res['desc'] = '仕訳帳アプリ「Yellow」の使い方について解説します。ご覧になりたい項目を選択してください。';
			$res['base_url'] = '/document/';
			$res['breadcrumb_html'] .= '<li><a href="'. $base_url . '/document/" itemprop="url"><span itemprop="title">' . $cat . '</span></a></li>';
		}

	} elseif( is_home() ) {

		$res['title'] = SITE_NAME;
		$res['h1'] = '埼玉・東京で活動するフリーランスWebクリエーターのブログ';
		$res['desc'] = '埼玉県東松山市を拠点に活動するWebクリエーターのブログです。WEB制作、個人事業主の活動に関するノウハウを公開。お勧めしたい本や体験談なども発信していきます。';
		$res['base_url'] = '/';
		$res['breadcrumb_html'] = null;
		$res['canonical'] = '<link rel="canonical" href="' . get_bloginfo('url') . '">';

	} elseif( is_search() ) {

		$serach_word = get_search_query();

		$res['title'] = $serach_word . ' | ' . SITE_NAME;
		$res['h1'] = '「' . $serach_word . '」の検索結果は' . $wp_query->found_posts . '件です。';
		$res['desc'] = '「' . $serach_word . '」の検索結果は' . $wp_query->found_posts . '件です。';
		$res['breadcrumb_html'] .= '<li><span itemprop="title">「' . $serach_word . '」の検索結果</span></li>';

	} elseif( is_post_type_archive('html_css') ) {

		$res['title'] = SITE_NAME . ' HTML5&CSS3';
		$res['type'] = 'html';
		$res['desc'] = 'HTML5やCSS3のオンライン辞典です。HTMLの要素(タグ)の意味、CSSプロパティの指定方法、使い方を解説。';
		$res['keywords'] = 'HTML,HTML5,CSS,CSS3,CSS2.1,GRAYCODE';
		$res['base_url'] = '/html_css/';
		$res['breadcrumb_html'] .= '<li><a href="/html_css/" itemprop="url"><span itemprop="title">HTML5&nbsp;&amp;&nbsp;CSS3</span></a></li>';

	} elseif( is_post_type_archive('php') ) {

		$res['title'] = SITE_NAME . ' PHPプログラミング';
		$res['type'] = 'php';
		$res['desc'] = '多くのWebアプリケーション開発で使われているPHPプログラミングについて、入門向けから実践に役立つ情報まで幅広く解説。';
		$res['keywords'] = 'PHP,プログラミング,システム開発,GRAYCODE';
		$res['base_url'] = '/php/';
		$res['breadcrumb_html'] .= '<li><a href="/php/" itemprop="url"><span itemprop="title">PHPプログラミング</span></a></li>';

	} elseif( is_single() ) {

		$cf = null;
		$cat = null;
		$categories = array();
		$child_cat = null;
		$excerpt = null;
		$html_css_terms = array();
		$php_css_terms = array();

		$res['title'] = get_the_title() . ' | ' . SITE_NAME;

		// Get the category
		$current_cat = get_the_category();
		$cat = $current_cat[0];

		// Get the custom field
		$cf = get_post_custom();
		$cf['tag_excerpt'][0] = strip_tags($cf['tag_excerpt'][0]);

		if( !empty($cf['keywords'][0]) ) {
			$res['keywords'] = $cf['keywords'][0];
		}

		// Get the terms of 'PHP'
		$php_terms = get_the_terms( get_the_ID(), 'php_post_cat');

		while ( isset($cat->name) ) {
			array_unshift( $categories, $cat);
			$cat = get_category($cat->parent);
		}

		if( is_singular('php') ) {

			$res['title'] .= ' PHPプログラミング';
			$res['type'] = 'php';
			$res['keywords'] .= 'PHP,プログラミング,システム開発,GRAYCODE';
			$res['breadcrumb_html'] .= '<li><a href="/php/" itemprop="url"><span itemprop="title">PHPプログラミング</span></a></li>';

		} elseif( is_singular('html_css') ) {

			$res['title'] .= ' HTML5&CSS3';
			$res['type'] = 'html';
			$res['keywords'] .= preg_replace( '/ /', '', get_the_title()) . ',HTML,HTML5,CSS,CSS3,CSS2.1,GRAYCODE';
			$res['breadcrumb_html'] .= '<li><a href="/html_css/" itemprop="url"><span itemprop="title">HTML5&nbsp;&amp;&nbsp;CSS3</span></a></li>';

		} else {
			$res['type'] = 'post';
			$res['keywords'] .= 'フリーランス,個人事業主,Yellow,GRAYCODE';
		}

		$excerpt = strip_tags(get_the_excerpt());
		if( !empty($excerpt) ) {
			$res['desc'] = $excerpt;
		} elseif( !empty($cf['tag_excerpt'][0]) ) {
			$res['desc'] = $cf['tag_excerpt'][0];
		}

		foreach( $categories as $value ) {
			if( $categories[0]->slug !== 'php' ) {
				$res['breadcrumb_html'] .= '<li><a href="' . $base_url . '/' . $value->slug . '/" itemprop="url"><span itemprop="title">' . $value->name . '</span></a></li>';
			}
		}

		$res['breadcrumb_html'] .= '<li><a href="' . get_the_permalink() . '" itemprop="url"><span itemprop="title">' . get_the_title() . '</span></a></li>';

	} elseif( is_404() ) {

		$res['title'] = '404 Error | ' . SITE_NAME;
		$res['desc'] = '404 Error。お探しのページは存在しないか、URLが変更となったためページが見つかりません。';
		$res['breadcrumb_html'] .= '<li><span itemprop="title">404 Error</span></li>';

	} elseif( is_page() ) {

		if( preg_match( '/privacy\-policy\//', $_SERVER['REQUEST_URI']) ) {

			$res['title'] = 'プライバシーポリシー | ' . SITE_NAME;
			$res['desc'] = 'Yellowの個人情報保護に関する考え方とご利用者様にご留意いただきたい点につきましては、こちらのプライバシーポリシーに記載しております。';
			$res['breadcrumb_html'] .= '<li><a href="' . $base_url . '/privacy-policy/" itemprop="url"><span itemprop="title">プライバシーポリシー</span></a></li>';

		} elseif( preg_match( '/terms\//', $_SERVER['REQUEST_URI']) ) {

			$res['title'] = '利用規約 | ' . SITE_NAME;
			$res['desc'] = 'Yellowの利用規約です。ユーザーは本サービスを利用することによって本規約に同意することになため、こちらの利用規約を必ずお読みください。';
			$res['breadcrumb_html'] .= '<li><a href="' . $base_url . '/terms/" itemprop="url"><span itemprop="title">ABOUT</span></a></li>';

		} elseif( preg_match( '/contact\//', $_SERVER['REQUEST_URI']) ) {

			$res['title'] = 'CONTACT | ' . SITE_NAME;
			$res['h1'] = '各種お問い合わせはこちらのページよりお願いいたします';
			$res['desc'] = 'サイト上のコンテンツについての気になる点やご質問、お仕事についてのお問い合わせは、こちらのフォームよりご連絡いただきますようお願いいたします。';
			$res['breadcrumb_html'] .= '<li><a href="' . $base_url . '/contact/" itemprop="url"><span itemprop="title">CONTACT</span></a></li>';

		}
	}

/*
	if( $paged < $max_page && ($paged === 0 || $paged === 1) ) {

		$res['next'] = '<link rel="next" href="' . $base_url . $res['base_url'] . 'page/2/">';

	} elseif( $paged < $max_page && 1 < $paged ) {

		if( 1 < $paged-1 ) {
			$res['prev'] = '<link rel="prev" href="' . $base_url . $res['base_url'] . 'page/' . ($paged-1) . '/">';
		} else {
			$res['prev'] = '<link rel="prev" href="' . $base_url . $res['base_url'] . '">';
		}
		$res['next'] = '<link rel="next" href="' . $base_url . $res['base_url'] . 'page/' . ($paged+1) . '/">';

	} elseif ( 1 < $paged && $max_page <= $paged ) {

		$res['prev'] = '<link rel="prev" href="' . $base_url . $res['base_url'] . 'page/' . ($paged-1) . '/">';
	}
*/

	return $res;
}


function getBlogCategory($cat_array=null)
{
	// Initialize
	$res = null;
	
	if( $cat_array !== null ) {

		foreach( $cat_array as $value ) {

			if( $value->slug !== 'blog' ) {
				$res = $value->name;
			}
		}
	}

	if( $res === null ) {
		$res = 'BLOG';
	}

	return $res;
}


function getArticleType($category=null)
{
	// Initialize
	$res = null;

	while( is_object($category) && $category->parent !== 0 ) {
		
		$category = get_category( $category->parent );

		if( !is_object($category) && isset($category[0]) ) {
			$category = $category[0];
		}
	}

	if( $category->slug === 'php' ) {
		$res = 'php';
	} else {
		$res = 'blog';
	}

	return $res;
}

/*
add_action( 'login_init', 'admin_login_init');
function admin_login_init()
{
	if( !defined('CHECK_KEY') || password_verify( 'ko-heI4GPress89', CHECK_KEY) === false ) {
		status_header(404);
		header('Location:' . site_url() . '/404.php');
		exit;
	}
}

add_filter( 'site_url', 'admin_login_site_url', 10, 4);
function admin_login_site_url( $url, $path, $orig_scheme, $blog_id)
{
	if( ($path == 'wp-login.php' || preg_match( '/wp-login\.php\?action=\w+/', $path) ) &&
		(is_user_logged_in() || strpos( $_SERVER['REQUEST_URI'], OTHER_LOGIN) !== false) ) {
		$url = str_replace( 'wp-login.php', OTHER_LOGIN, $url);
	}
	return $url;
}

add_filter( 'wp_redirect', 'admin_login_wp_redirect', 10, 2);
function admin_login_wp_redirect( $location, $status) {
	if( is_user_logged_in() && strpos( $_SERVER['REQUEST_URI'], OTHER_LOGIN) !== falsee ) {
		$location = str_replace( 'wp-login.php', OTHER_LOGIN, $location);
	}
	return $location;
}
*/


//----------------------------------------
// Custom Post
//----------------------------------------
function new_post_type() {

	register_post_type(
		'business-owner',
		array(
			'labels' => array(
				'name' => '個人事業主の経理',
				'singular_name' => '個人事業主の経理',
				'add_new' => '新規追加',
				'add_new_item' => '新規追加',
				'edit_item' => '投稿を編集',
				'new_item' => '新着情報',
				'all_items' => '投稿一覧',
				'view_item' => '投稿を見る',
				'search_items' => '検索する',
				'not_found' => '投稿が見つかりませんでした。',
				'not_found_in_trash' => 'ゴミ箱内に投稿が見つかりませんでした。'
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			'supports' => array(
				'title',
				'editor',
				'thumbnail'
			),
			'taxonomies' => array('bo_post_cat')
		)
	);

	register_post_type(
		'tax-return',
		array(
			'labels' => array(
				'name' => '確定申告について',
				'singular_name' => '確定申告について',
				'add_new' => '新規追加',
				'add_new_item' => '新規追加',
				'edit_item' => '投稿を編集',
				'new_item' => '新着情報',
				'all_items' => '投稿一覧',
				'view_item' => '投稿を見る',
				'search_items' => '検索する',
				'not_found' => '投稿が見つかりませんでした。',
				'not_found_in_trash' => 'ゴミ箱内に投稿が見つかりませんでした。'
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt',
			),
			'taxonomies' => array('tax_post_cat')
		)
	);

	$labels = array(
		'name'                => 'カテゴリー',
		'singular_name'       => 'カテゴリー',
		'search_items'        => 'カテゴリー検索',
		'all_items'           => '全てのカテゴリー',
		'parent_item'         => '親カテゴリー',
		'parent_item_colon'   => '親カテゴリー:',
		'edit_item'           => 'カテゴリーを編集',
		'update_item'         => 'カテゴリーを更新',
		'add_new_item'        => 'カテゴリーを追加',
		'new_item_name'       => '新規カテゴリー',
		'menu_name'           => 'カテゴリー'
	);
	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
	);
	register_taxonomy( 'bo_post_cat', 'business-owner', $args );
	register_taxonomy( 'tax_post_cat', 'tax-return', $args );
}
add_action( 'init', 'new_post_type');


// カスタム投稿の投稿一覧にカテゴリー絞り込みの追加
add_action( 'restrict_manage_posts', 'add_post_taxonomy_restrict_filter' );
function add_post_taxonomy_restrict_filter() {
    global $post_type;
    if ( 'html_css' == $post_type ) {
        ?>
        <select name="html_post_cat">
            <option value="">カテゴリー指定なし</option>
            <?php
            $terms = get_terms('html_post_cat');
            foreach ($terms as $term) { ?>
                <option value="<?php echo $term->slug; ?>"><?php echo $term->name; ?></option>
            <?php } ?>
        </select>
        <?php
    }
}


//--------------------------------------------------
// リダイレクトリフレッシュ
//--------------------------------------------------
global $wp_rewrite;
$wp_rewrite->flush_rules();



function custom_popular_post( $content, $p, $instance)
{
	// Initialize
	$output = null;
	$thumb_id = null;
	$permalink = null;

	// データ取得
	$thumb_id = get_post_thumbnail_id( $p->id);
	$permalink = get_the_permalink($p->id);

	if( $instance['thumbnail']['width'] === "50" ) {

		$output = '<li><p class="pic_content">';
		$output .= '<a href="' . $permalink . '">';

		if( has_post_thumbnail($p->id) ) {
			$output .= get_the_post_thumbnail( $p->id, array( 50, 50));
		}

		$output .= '</a></p>';
		$output .= '<h3><a href="' . $permalink . '">' . get_the_title($p->id) . '</a></h3>';
		$output .= '</li>';

	} else {

		$output = '<li><p class="pic_content">';
		$output .= '<a href="' . $permalink . '">';

		if( has_post_thumbnail($p->id) ) {
			$output .= get_the_post_thumbnail( $p->id, array( 100, 100));
		}

		$output .= '</a></p>';
		$output .= '<div class="text_content">';
		$output .= '<h3><a href="' . $permalink . '">' . get_the_title($p->id) . '</a></h3>';
		$output .= '<p class="text_excerpt">' . get_the_excerpt($p->id) . '  <a href="' . $permalink . '">記事を読む +</a></p>';
		$output .= '</div>';
		$output .= '</li>';
	}

	return $output;
}
add_filter( 'wpp_post', 'custom_popular_post', 10, 3);
