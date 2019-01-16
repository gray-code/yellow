<?php
// File Name:		index.php
// Template Name:	Main Template
?>
<?php
// Initialize
$post_i = 0;
?>
<?php get_header(); ?>

<main>
	<section class="main-visual-wrap">
		<div class="main-visual">
			<div class="text-content">
				<h1>個人事業主の経理を楽チンにする仕訳帳アプリ<br><img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Yellow"></h1>
				<p class="text-free">無料</p>
				<p class="text-blue-tax">青色申告<br>対応</p>
			</div>
			<figure><img src="<?php echo get_template_directory_uri(); ?>/img/main_device.png"></figure>
		</div>
	</section>
	<section class="section-wrap">
		<div>
			<h2>ただの仕訳帳。<br>機能を絞っているからこそ、シンプルで使いやすい。</h2>
			<p>仕訳帳アプリ「Yellow」は、個人事業主として活躍する両親・友人にとって<br>ストレスになっている日々の経理の手間を減らし、<br>さらに青色申告へも気軽にチャレンジできるようにという想いから作成しました。</p>
			<p>加えて、Webサービスへの信頼性や月額利用料を支払うことに抵抗を持っていたため、<br>無料で使えるようにしながらも、セキュリティへの配慮も万全を期しています。</p>
			<p>他の経理アプリのように、何から何まで自動化してくれるほど高機能ではありません。<br>あくまで、日々のお金の支出を記帳する仕訳帳です。<br>目的を絞っているからこそ、操作も簡単で使いやすくなります。</p>
			<p>総勘定元帳、残高試算表は自動生成されますので、確定申告もスムーズに進めることができます。</p>
			<ul class="lead-content">
				<li class="book">
					<hr>
					<h3>仕訳帳 <span class="text-doit">入力する帳簿はこれだけ</span></h3>
					<p>日々の事業における収支を記録する帳簿。<br>全ての帳簿のベースになります。</p>
				</li>
				<li class="ledger">
					<hr>
					<h3>総勘定元帳<span class="text-automake">自動生成</span></h3>
					<p>仕訳帳を勘定科目ごとに集計した帳簿。<br>勘定科目ごとにどれだけの収支があるかを把握することができる帳簿。</p>
				</li>
				<li class="bs">
					<hr>
					<h3>残高試算表<span class="text-automake">自動生成</span></h3>
					<p>各勘定科目の合計金額を集計した帳簿。<br>全ての科目を一覧で見れるので便利。</p>
				</li>
			</ul>
			<div class="register-area lead-register-area">
				<p>無料で、登録後すぐにご利用いただけます。</p>
				<div class="btn-area"><a class="btn-document" href="/document/basic-usage/">基本的な使い方を見る</a><a class="btn-register" href="/pre-register/">アカウントを作成</a></div>
			</div>
		</div>
	</section>
	<section class="section-wrap section-white">
		<div class="sample-wrap">
			<h2 class="title-sample">仕訳帳</h2>
			<div class="right-text-content">
				<p>日々の収支を入力する帳簿です。<br>複式簿記に必要不可欠な帳簿で、「借方」と「貸方」で左右2つに分かれていることが特徴。</p>
				<p>この帳簿を見れば「xx月xx日にお金を何に使ったか」「どこからお金が入ってきたか」がすぐに分かります。</p>
				<div class="btn-area"><a class="btn-document" href="/document/book/">より詳しくはこちら</a></div>
			</div>
			<figure class="left-picture"><img src="<?php echo get_template_directory_uri(); ?>/img/pic_sample-book.png" alt="仕訳帳ページのサンプル"></figure>
		</div>
	</section>
	<section class="section-wrap">
		<div class="sample-wrap">
			<h2 class="title-sample">総勘定元帳</h2>
			<div class="left-text-content">
				<p>仕訳帳を基にして作成される、「元帳」とも呼ばれる帳簿。<br>項目ごとに、年間でいくらぐらいの収支があったかが分かります。</p>
				<p>この帳簿があると、確定申告で必要な貸借対照表と損益計算書を簡単に作成することができます。</p>
				<div class="btn-area"><a class="btn-document" href="/document/ledger/">より詳しくはこちら</a></div>
			</div>
			<figure class="right-picture"><img src="<?php echo get_template_directory_uri(); ?>/img/pic_sample-ledger.png" alt="総勘定元帳ページのサンプル"></figure>
		</div>
	</section>
	<section class="section-wrap section-white">
		<div class="sample-wrap">
			<h2 class="title-sample">残高試算表</h2>
			<div class="right-text-content">
				<p>「試算表」とも呼ばれる帳簿。</p>
				<p>総勘定元帳は項目ごとに分かれていますが、残高試算表は全体を俯瞰することができます。<br>総勘定元帳と共に、確定申告の時に便利な帳簿です。</p>
				<div class="btn-area"><a class="btn-document" href="/document/bs/">より詳しくはこちら</a></div>
			</div>
			<figure class="left-picture"><img src="<?php echo get_template_directory_uri(); ?>/img/pic_sample_bs.png" alt="残高試算表ページのサンプル"></figure>
		</div>
	</section>
	<section class="section-wrap">
		<div class="register-area">
			<p>無料で、登録後すぐにご利用いただけます。</p>
			<div class="btn-area"><a class="btn-register" href="/pre-register/">アカウントを作成</a></div>
		</div>
	</section>
	<section class="section-wrap section-pr">
		<div class="pr-area">
			<h2>入力の自動化など、もっと高機能な経理アプリをお探しの方へ</h2>
			<div class="pr-content">
				<div class="pr-ad">
					<p>freeeはこちら</p>
					<figure><a href="https://px.a8.net/svt/ejp?a8mat=2NKBRX+1YULRM+2XTQ+66OZ5" target="_blank" rel="nofollow">
<img border="0" width="250" height="250" alt="" src="https://www22.a8.net/svt/bgt?aid=160511901119&wid=001&eno=01&mid=s00000013715001039000&mc=1"></a>
<img border="0" width="1" height="1" src="https://www14.a8.net/0.gif?a8mat=2NKBRX+1YULRM+2XTQ+66OZ5" alt=""></figure>
				</div>
				<p>「Yellow」は無料でご利用いただけますが、機能はシンプルで日々の仕訳は手入力です。<br>前提として、基本的な仕訳方法は身に付けなければなりません。</p>
				<p>一方、経理アプリ「freee」は有料ではありますが、<br>入力の自動化、確定申告サポート機能など経理の手間を省く機能が充実しています。</p>
				<p>この2つのアプリには、自動車で言うところのマニュアル車とオートマ車ぐらいの違いがあります。</p>
				<p>「Yellow」は自身で日々の仕訳をすることで、事業のお金の出入りを把握し、<br>お金の使い方をしっかり考えたい方に向けて作っています。<br>もしくは、多少の手間が掛かっても、経理アプリを無料でご利用したい方に向いています。</p>
				<p>経理にかかる手間を最大限省きたい方、仕訳が面倒と感じる方は、<br>「freee」のご利用をご検討ください。</p>
			</div>
			<div class="ad_type02">
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
		</div>
	</section>
</main>

<?php get_footer(); ?>