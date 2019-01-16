<?php
// Initialize
global $all_cats;
global $main_src;
$meta = null;
$all_cats = array();

$meta = getPageMeta();

session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scale=0;">
	<meta name="author" content="Kohei Ishido">
	<?php if( !empty($meta['desc']) ): ?>
		<meta name="description" content="<?php echo $meta['desc']; ?>">
	<?php endif; ?>
	<?php if( !empty($meta['keywords']) ): ?>
		<meta name="keywords" content="<?php echo $meta['keywords']; ?>">
	<?php else: ?>
		<meta name="keywords" content="フリーランス,個人事業主,経理,仕訳帳,YELLOW">
	<?php endif; ?>
	<?php if( is_search() ): ?>
		<meta name="robots" content="noindex,nofollow">
	<?php endif; ?>
	<?php if( is_single() || is_post_type_archive('html_css') || is_post_type_archive('php') ): ?>
		<meta name="og:title" content="<?php echo $meta['title']; ?>">
		<meta name="og:type" content="article">
		<meta name="og:description" content="<?php echo $meta['desc']; ?>">
		<meta name="og:url" content="<?php the_permalink(); ?>">
		<meta name="og:site_name" content="<?php bloginfo('site_name'); ?>">
		<meta name="og:locale" content="ja_JP">
		<meta name="fb:app_id" content="679987048779161">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@koheiishido">
		<meta name="twitter:title" content="<?php echo $meta['title']; ?>">
		<meta name="twitter:description" content="<?php echo $meta['desc']; ?>">
		<?php if( isset($main_src[0]) && $main_src[0] !== null ): ?>
			<meta name="og:image" content="<?php echo $main_src[0]; ?>">
		<?php elseif( is_singular('php') || is_post_type_archive('php') ): ?>
			<meta name="og:image" content="<?php echo get_template_directory_uri(); ?>/img/php_share_image.jpg">
		<?php elseif( is_singular('html_css') || is_post_type_archive('html_css') ): ?>
			<meta name="og:image" content="<?php echo get_template_directory_uri(); ?>/img/html_share_image.jpg">
		<?php else: ?>
			<meta name="og:image" content="<?php echo get_template_directory_uri(); ?>/img/noimage_thumbnail.png">
		<?php endif; ?>

		<?php if( is_singular('php') || is_post_type_archive('php') ): ?>
			<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/img/php_thumb.jpg">
		<?php elseif( is_singular('html_css') || is_post_type_archive('html_css') ): ?>
			<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/img/html_thumb.jpg">
		<?php else: ?>
			<?php if( has_post_thumbnail() ): ?>
				<?php
				$image_id = get_post_thumbnail_id();
				$image_src = wp_get_attachment_image_src( $image_id, true);
				?>
				<meta name="twitter:image" content="<?php echo $image_src[0]; ?>" alt="<?php echo $meta['title']; ?>">
			<?php else: ?>
				<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/img/noimage_thumbnail.png">
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
	<title><?php echo $meta['title']; ?></title>
	<?php if( isset($meta['prev']) && $meta['prev'] !== null ) { echo $meta['prev']; } ?>
	<?php if( isset($meta['next']) && $meta['next'] !== null ) { echo $meta['next']; } ?>
	<?php if( !empty($meta['canonical']) ) { echo $meta['canonical']; } ?>
	<link rel="author" href="https://plus.google.com/u/0/108062516886641967141">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
	<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugin.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/functions.js"></script>
	<?php if( !preg_match( '/localhost/', $_SERVER['HTTP_HOST']) ): ?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-97232215-1', 'auto');
	  ga('send', 'pageview');
	</script>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body>
<?php if( is_single() || is_post_type_archive('html_css') || is_post_type_archive('php') ): ?>
<!-- Facebook SDK -->
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '601059013400412',
      xfbml      : true,
      version    : 'v2.7'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- //Facebook SDK -->
<?php endif; ?>

<header id="header">
	<div class="header-wrap">
		<figure id="logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Yellow"></a></figure>
		<nav id="global-navigation">
			<ul>
				<li><a href="/document/">アプリの使い方</a></li>
<!--
				<li><a href="/business-owner/">個人事業主の経理</a></li>
				<li><a href="/tax-return/">確定申告について</a></li>
-->
			</ul>
		</nav>
		<div class="button-area">
			<a class="btn" href="/pre-register">アカウント作成</a><a class="btn" href="/login">ログイン</a>
		</div>
		<div id="btn-menu"><a href="#"><span></span></a></div>
	</div>
	<div id="sp-navigation">
		<form method="get" id="sp-searchform" action="<?php echo home_url( '/' ); ?>">
			<input type="text" value="<?php if( $search_word !== null ){ echo $search_word; } ?>" name="s" id="s" placeholder="検索"><input type="image" id="searchsubmit" src="<?php echo get_template_directory_uri(); ?>/img/icon_search.png" alt="検索">
		</form>
		<nav>
			<ul class="sp-menu">
				<li><a href="/document/">アプリの使い方</a></li>
<!--
				<li><a href="/business-owner/">個人事業主の経理</a></li>
				<li><a href="/tax-return/">確定申告について</a></li>
-->
			</ul>
			<ul>
				<li><a class="btn" href="/pre-register">アカウント作成</a></li>
				<li><a class="btn" href="/logout">ログイン</a></li>
			</ul>
		</nav>
	</div>
</header>
<div id="sp-back-sheet"></div>

<?php if( !is_home() ): ?>
<section class="breadcrumb-area-wrap">
	<div>
		<?php if( !empty($meta['breadcrumb_html']) ): ?>
		<ol class="breadcrumb-list" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<?php echo $meta['breadcrumb_html']; ?>
		</ol>
		<?php endif; ?>
		<form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
			<input type="text" value="<?php if( $search_word !== null ){ echo $search_word; } ?>" name="s" id="s" placeholder="検索"><input type="image" id="searchsubmit" src="<?php echo get_template_directory_uri(); ?>/img/icon_search.png" alt="検索">
		</form>
	</div>
</section>
<?php endif; ?>