<?php
get_header();

var_dump("test");
?>
<header class="archive_header header_php">
	<h1><img src="<?php echo get_template_directory_uri(); ?>/img/title_php.png" srcset="<?php echo get_template_directory_uri(); ?>/img/title_phpx2.png 2x" alt="PHPプログラミング"></h1>
	<p>多くのWebアプリケーション開発で使われているPHPプログラミングについて、<br>入門向けから実践に役立つ情報まで幅広く解説</p>
</header>

<div class="wrapper">
	<main class="main_content">
		<div class="main_content_wrap">

			<ul class="sns_area">
				<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
			</ul>

			<article class="content_php">
				<section id="getting-started">
					<h2>PHP入門</h2>
					<ol>
<!-- 						<li><span>前準備 PHPの使用準備</span></li> -->
						<li><a href="/php/how-the-php-working/">第1章 PHPが動く仕組み</a></li>
						<li><a href="/php/variables-and-constants/">第2章 変数と定数</a></li>
						<li><a href="/php/array/">第3章 配列</a></li>
						<li><a href="/php/super-global/">第4章 スーパーグローバル</a></li>
						<li><a href="/php/cookie-and-session/">第5章 クッキーとセッション</a></li>
						<li><a href="/php/get-information-of-server/">第6章 サーバー情報の取得</a></li>
						<li><a href="/php/if-syntax/">第7章 if文</a></li>
						<li><a href="/php/switch-syntax/">第8章 switch文</a></li>
						<li><a href="/php/while-syntax/">第9章 while文</a></li>
						<li><a href="/php/for-syntax/">第10章 for文</a></li>
						<li><a href="/php/foreach-syntax/">第11章 foreach文</a></li>
						<li><a href="/php/original-function/">第12章 独自の関数</a></li>
						<li><a href="/php/oriented-object/">第13章 オブジェクト指向</a></li>
						<li><a href="/php/class/">第14章 クラス</a></li>
						<li><a href="/php/object/">第15章 オブジェクト</a></li>
						<li><a href="/php/introduce-book/">PHPの入門者向け参考書を紹介</a></li>
					</ol>
				</section>
				<section id="best-practice">
					<h2>PHPベストプラクティス</h2>
					<h3>スーパーグローバル変数</h3>
					<ul>
						<li><a href="/php/get_the_server_information/">PHP実行環境の情報を取得する：$_SERVER</a></li>
						<li><a href="/php/get-the-data-of-uploaded-file/">アップロードファイルの情報を取得する：$_FILES</a></li>
					</ul>
					<h3>文字列の扱い</h3>
					<ul>
						<li><a href="/php/make-the-random-strings/">ランダムな文字列を作成する</a></li>
						<li><a href="/php/search-of-strings/">文字列に特定の文字（単語）が含まれるか検索</a></li>
						<li><a href="/php/search-of-strings2/">文字列の検索から結果を取得</a></li>
						<li><a href="/php/replace-of-strings/">検索に一致した文字列を置換する</a></li>
						<li><a href="/php/split-of-strings/">特定の文字で文字列を分割する</a></li>
						<li><a href="/php/prevent-garbled-characters/">はしご高などの旧字体漢字の文字化けを防ぐ</a></li>
						<li><a href="/php/remove-space-of-strings/">文字列中の空白（スペース）を除去</a></li>
						<li><a href="/php/convert-string/">半角アルファベットの大文字、小文字表記を整える</a></li>
						<li><a href="/php/convert-string2/">半角、全角の表記を整える</a></li>
						<li><a href="/php/count-string-of-japanese/">日本語の文字数を数える</a></li>
						<li><a href="/php/remove-html-and-php/">文字列からHTMLタグやPHPを除去</a></li>
					</ul>
					<h3>配列</h3>
					<ul>
						<li><a href="/php/basic-sort-function/">基本的なソート関数で配列を並び替える</a></li>
						<li><a href="/php/split-array/">配列を変数へ分割</a></li>
						<li><a href="/php/combine-variable/">複数の変数を配列に統合</a></li>
						<li><a href="/php/combine-array/">複数の配列を1つに統合</a></li>
						<li><a href="/php/execute-function-for-all-element/">配列のすべての要素に対して同じ関数を実行する</a></li>
<!-- 						<li><a href="/php/sort-of-multi-array/">多次元配列のソート</a></li> -->
					</ul>
					<h3>フォームを作る</h3>
					<ul>
						<li><a href="/php/make-the-form-vol1/">フォームの基本構造を作成する</a></li>
						<li><a href="/php/make-the-form-vol2/">フォームの確認ページ&完了ページを作成</a></li>
						<li><a href="/php/make-the-form-vol3/">自動返信メールの実装</a></li>
						<li><a href="/php/make-the-form-vol4/">入力値の引き継ぎ</a></li>
						<li><a href="/php/make-the-form-vol5/">入力値のサニタイズ</a></li>
						<li><a href="/php/make-the-form-vol6/">入力値のバリデーション</a></li>
					</ul>
					<h3>出力</h3>
					<ul>
						<li><a href="/php/download-for-csv-file/">データをCSVファイルとしてダウンロードする</a></li>
						<!--<li><a href="/php/download-csv-file/">PDFファイルを出力・ダウンロードする</a></li>-->
					</ul>
					<h3>データベース MySQL</h3>
					<ul>
						<li><a href="/php/connection-db-by-using-mysqli/">mysqliを使ってデータベースへ接続</a></li>
						<li><a href="/php/create-table-by-using-mysqli/">mysqliでテーブルを作成（CREATE TABLE）</a></li>
						<li><a href="/php/getting-data-by-using-mysqli/">mysqliでデータを取得（SELECT）</a></li>
						<li><a href="/php/insert-data-by-using-mysqli/">mysqliでデータを新規登録（INSERT）</a></li>
						<li><a href="/php/update-data-by-using-mysqli/">mysqliでデータを更新（UPDATE）</a></li>
						<li><a href="/php/delete-data-by-using-mysqli/">mysqliでデータを削除（DELETE）</a></li>
						<li><a href="/php/how-to-get-variety-of-data/">様々なデータの取得方法</a></li>
						<li><a href="/php/transaction-by-using-mysqli/">mysqliのトランザクション</a></li>
						<li><a href="/php/prepared-statement-by-mysqli/">mysqliのプリペアドステートメント</a></li>
						<li><a href="/php/getting-id-of-last-inserted-data/">最後に登録したデータのIDを取得する</a></li>
						<li><a href="/php/escape-string-by-mysqli/">mysqliで文字列をエスケープする</a></li>
					</ul>
					<h3>データベース PostgreSQL</h3>
					<ul>
						<li><a href="/php/conectted-to-postgresql/">PostgreSQLデータベースへ接続</a></li>
						<li><a href="/php/create-table-to-postgresql/">PostgreSQLデータベースでテーブルを作成（CREATE TABLE）</a></li>
						<li><a href="/php/insert-data-to-postgresql/">PostgreSQLデータベースへデータを新規登録（INSERT）</a></li>
					</ul>
					<h3>セキュリティ</h3>
					<ul>
						<li><a href="/php/security-of-php/">PHPのセキュリティについて</a></li>
						<li><a href="/php/encryption-of-password/">パスワードの暗号化</a></li>
<!--
						<li><span>スクリプト埋め込み攻撃（Script Insertion）</span></li>
						<li><span>クロス・サイト・スクリプティング（Cross Site Scripting）</span></li>
						<li><span>クロス・サイト・リクエスト・フォージェリ（Cross Site Request Forgeries）</span></li>
						<li><span>SQLインジェクション（SQL Injection）</span></li>
						<li><span>セッションハイジャック</span></li>
						<li><span>変数汚染攻撃</span></li>
						<li><span>HTTPヘッダインジェクション</span></li>
						<li><span>スパムメール踏み台攻撃</span></li>
						<li><span>ファイルアップロード攻撃</span></li>
						<li><span>nullバイト攻撃</span></li>
						<li><span>ディレクトリ・トラバーサル（Directory Traversal）</span></li>
						<li><span>eval利用攻撃</span></li>
						<li><span>インクルード攻撃</span></li>
						<li><span>パス・ディスクロージャ</span></li>
						<li><span>コマンド実行攻撃（Command Injection）</span></li>
						<li><span>パスワードの暗号化</span></li>
-->
					</ul>
					<h3>Facebook PHP向けSDK</h3>
					<ul>
						<li><a href="/php/ready-for-use-of-sdk/">FacebookのPHP向けSDKで何ができるの？使用するための準備</a></li>
						<li><a href="/php/getting-started-of-sdk/">Facebookページの基本データを取得</a></li>
						<li><a href="/php/retrieve-data-of-facebookpage-using-graphapi/">GraphAPIを使ってFacebookページのデータを取得</a></li>
						<li><a href="/php/get-feed-of-facebookpage/">Facebookページのタイムライン（フィード）を取得</a></li>
						<li><a href="/php/imprementation-of-facebook-login/">Facebookログインの実装</a></li>
					</ul>
					<h3>フレームワーク</h3>
					<ul>
						<li><a href="/php/about-of-php-framework2016/">【2016年版】PHPのフレームワークについて</a></li>
					</ul>
				</section>
			</article>

			<ul class="sns_area">
				<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
			</ul>

			<div class="ad_type03">
				<div class="ad_left">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- GRAYCODE Type1 -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-6292870682629488"
					     data-ad-slot="2830614454"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
				<div class="ad_right">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- GRAYCODE Type1 -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-6292870682629488"
					     data-ad-slot="2830614454"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
			</div>

		</div>
	</main>

	<?php get_sidebar('php'); ?>
</div>

<?php get_footer(); ?>