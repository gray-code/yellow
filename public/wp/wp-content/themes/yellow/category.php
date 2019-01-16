<?php
// File Name:		category.php
// Template Name:	Category(Document) Template
?>
<?php get_header(); ?>

<div class="wrapper">
	<main class="main-content">
		<h1 class="ttl_category"><?php echo single_cat_title( '', false ); ?></h1>
		<section class="toc-section toc-first-section">
			<nav>
				<ul>
					<li>
						<h2><a href="/document/basic-usage/">基本的な活用方法</a></h2>
						<p>個人事業主の日々の経理の流れと、Yellowの活用方法を解説します。</p>
					</li>
				</ul>
			</nav>
		</section>
		<section class="toc-section">
			<nav>
				<ul>
					<li>
						<h2><a href="/document/register-account/">アカウント登録</a></h2>
						<p>アカウント作成の全体的な流れを解説します。</p>
					</li>
					<li>
						<h2><a href="/document/edit-account/">登録した情報を変更する</a></h2>
						<p>登録した情報はいつでも変更することが可能です。</p>
					</li>
					<li>
						<h2><a href="/document/edit-information/">一般情報を変更する</a></h2>
						<p>氏名、電話番号、生年月日、屋号を編集する方法を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/edit-email/">メールアドレスを変更する</a></h2>
						<p>使用しているメールアドレスの変更方法を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/edit-password/">ログインパスワードを変更する</a></h2>
						<p>ログイン時に使用しているパスワードを変更する方法を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/exit/">退会する</a></h2>
						<p>ご利用を停止したい場合の退会手順を解説します。</p>
					</li>
				</ul>
			</nav>
		</section>
		<section class="toc-section">
			<nav>
				<ul>
					<li>
						<h2><a href="/document/edit-item/">仕訳項目の編集</a></h2>
						<p>仕訳で使う項目は必要に応じてカスタマイズすることができます。ここではその方法を解説します。</p>
					</li>
				</ul>
			</nav>
		</section>
		<section class="toc-section">
			<nav>
				<ul>
					<li>
						<h2><a href="/document/book/">仕訳帳について</a></h2>
						<p>仕訳帳の使い方を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/book-list/">仕訳帳の見方</a></h2>
						<p>仕訳帳ページの見方を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/book-entry/">新しく仕訳を登録する</a></h2>
						<p>仕訳を入力する方法を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/book-edit/">仕訳を編集する</a></h2>
						<p>一度登録した仕訳を編集する方法を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/book-clone/">仕訳を複製して登録する</a></h2>
						<p>以前登録した仕訳を複製し、新しい仕訳を登録する方法を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/book-delete/">仕訳を削除する</a></h2>
						<p>登録した仕訳を削除する方法を解説します。</p>
					</li>
				</ul>
			</nav>
		</section>
		<section class="toc-section">
			<nav>
				<ul>
					<li>
						<h2><a href="/document/ledger/">総勘定元帳 (元帳)について</a></h2>
						<p>総勘定元帳の見方を解説します。</p>
					</li>
					<li>
						<h2><a href="/document/bs/">残高試算表 (試算表)について</a></h2>
						<p>残高試算表の見方を解説します。</p>
					</li>
				</ul>
			</nav>
		</section>
		<section class="register-area">
			<p>無料で、登録後すぐにご利用いただけます。</p>
			<div class="btn-area"><a class="btn-register" href="/pre-register">アカウントを作成</a></div>
		</section>
		<div class="ad-type02">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- G-3 -->
			<ins class="adsbygoogle"
			     style="display:block"
			     data-ad-client="ca-pub-6292870682629488"
			     data-ad-slot="5504879258"
			     data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	</main>
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>