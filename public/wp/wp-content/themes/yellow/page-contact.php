<?php

define( 'EMAIL', 'koheiishido@gmail.com');
define( 'TO_MAIL', 'noreply@gray-code.com');
define( 'ADMIN_SENDER', 'GRAYCODE');

// Initialize
$page_type = 0;
$clean = array();
$error = array();

// Sanitize
foreach( $_POST as $key => $value ) {
	$clean[$key] = htmlspecialchars( $value, ENT_QUOTES);
}

if( isset($_POST['btn_confirm']) && $_POST['btn_confirm'] !== null ) {

	if( empty($clean['contact_type']) || ($clean['contact_type'] != "1" && $clean['contact_type'] != "2" && $clean['contact_type'] != "3" && $clean['contact_type'] != "4" && $clean['contact_type'] != "5") ) {
		
		$error['contact_type'] = true;
	}

	if( empty($clean['your_name']) ) {
		$error['your_name'] = true;
	}

	if( empty($clean['your_email']) ) {
		$error['your_email'] = true;
	}

	if( empty($clean['your_message']) ) {
		$error['your_message'] = true;
	}

	if( count($error) === 0 ) {
		$page_type = 1;
	}

} else if( isset($_POST['btn_submit']) && $_POST['btn_submit'] !== null ) {

	$to = null;
	$header = null;
	$subject = null;
	$text = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$parameter = null;
	date_default_timezone_set('Asia/Tokyo');
	
	// setting the "From"
	add_filter( 'wp_mail_from', 'set_mail_from' );
	add_filter( 'wp_mail_from_name', 'set_mail_from_name' );

	if( !empty($clean['your_company']) ) {
		$auto_reply_text = $clean['your_company'] . ' ';
	}
	$auto_reply_text .= $clean['your_name'] . "様\n\n";
	$auto_reply_text .= "この度は、お問い合わせ頂き誠にありがとうございます。
下記の内容でお問い合わせを受け付けました。\n\n";

	switch( $clean['contact_type'] ) {

		default:
		case '5':
			$auto_reply_subject = '【GRAYCODE】お問い合わせを受け付けました';
			$subject = '【GRAYCODE】お問い合わせ';
			$text = "下記の内容でお問い合わせがありました。\n\n";
			break;

		case '1':
			$auto_reply_subject = '【GRAYCODE】お問い合わせを受け付けました';
			$subject = '【GRAYCODE】サイトコンテンツについてお問い合わせ';
			$text = "下記の内容で、コンテンツについてのお問い合わせがありました。\n\n";
			break;

		case '2':
			$auto_reply_subject = '【GRAYCODE】お仕事についてのお問い合わせを受け付けました';
			$subject = '【GRAYCODE】お仕事についてのお問い合わせ';
			$text = "下記の内容で、お仕事へのお問い合わせがありました。\n\n";
			break;

		case '3':
			$auto_reply_subject = '【GRAYCODE】求人についてのお問い合わせを受け付けました';
			$subject = '【GRAYCODE】求人についてのお問い合わせ';
			$text = "下記の内容で、求人についてのお問い合わせがありました。\n\n";
			break;

		case '4':
			$auto_reply_subject = '【GRAYCODE】広告掲載についてのお問い合わせを受け付けました';
			$subject = '【GRAYCODE】広告掲載についてのお問い合わせ';
			$text = "下記の内容で、広告掲載についてのお問い合わせがありました。\n\n";
			break;
	}

	$auto_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$auto_reply_text .= "氏名：" . $clean['your_name'] . "\n";
	if( !empty($clean['your_company']) ) {
		$auto_reply_text .= "貴社名：" . $clean['your_company'] . "\n";
	}
	$auto_reply_text .= "メールアドレス：" . $clean['your_email'] . "\n";
	if( !empty($clean['your_tel']) ) {
		$auto_reply_text .= "電話番号：" . $clean['your_tel'] . "\n";
	}
	$auto_reply_text .= "お問い合わせ内容：" . $clean['your_message'] . "\n";

	$text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$text .= "氏名：" . $clean['your_name'] . "\n";
	if( !empty($clean['your_company']) ) {
		$text .= "貴社名：" . $clean['your_company'] . "\n";
	}
	$text .= "メールアドレス：" . $clean['your_email'] . "\n";
	if( !empty($clean['your_tel']) ) {
		$text .= "電話番号：" . $clean['your_tel'] . "\n";
	}
	$text .= "お問い合わせ内容：" . $clean['your_message'] . "\n";

	// 自動返信メール送信
	wp_mail( $clean['your_email'], $auto_reply_subject, $auto_reply_text);
	
	// 管理者へメール送信
	wp_mail( EMAIL, $subject, $text);
	
	$page_type = 2;
}

function set_mail_from( $email ) {
    return TO_MAIL;
}

function set_mail_from_name( $email_from ) {
    return ADMIN_SENDER;
}

get_header();
?>

<div class="wrapper">
	<div class="main_content">
		<div class="main_content_wrap">
			<article>
				<?php if( $page_type === 1 ): ?>
					<header>
						<h2>お問い合わせ</h2>
						<p>入力内容をご確認のうえ、「送信」ボタンを押してください。</p>
					</header>
					<form method="post">
						<dl>
							<dt>お問い合わせの種類 <span>*</span></dt>
							<dd><?php if( isset($clean['contact_type']) && $clean['contact_type'] == "1" ) { echo 'サイト上のコンテンツについて'; } else if( isset($clean['contact_type']) && $clean['contact_type'] == "2" ) { echo 'お仕事について'; } else if( isset($clean['contact_type']) && $clean['contact_type'] == "3" ) { echo '求人について'; } else if( isset($clean['contact_type']) && $clean['contact_type'] == "4" ) { echo '広告掲載について'; } else if( isset($clean['contact_type']) && $clean['contact_type'] == "5" ) { echo 'その他'; } ?></dd>
							<dt>氏名 <span>*</span></dt>
							<dd><?php if( isset($clean['your_name']) && $clean['your_name'] !== "" ) { echo $clean['your_name']; } ?></dd>
							<?php if( isset($clean['your_company']) && $clean['your_company'] !== "" ): ?>
								<dt>貴社名 (任意)</dt>
								<dd><?php echo $clean['your_company']; ?></dd>
							<?php endif; ?>
							<dt>メールアドレス <span>*</span></dt>
							<dd><?php if( isset($clean['your_email']) && $clean['your_email'] !== "" ) { echo $clean['your_email']; } ?></dd>
							<?php if( isset($clean['your_tel']) && $clean['your_tel'] !== "" ): ?>
								<dt>電話番号</dt>
								<dd><?php echo $clean['your_tel']; ?></dd>
							<?php endif; ?>
							<dt>お問い合わせ内容 <span>*</span></dt>
							<dd><?php if( isset($clean['your_message']) && $clean['your_message'] !== "" ) { echo nl2br($clean['your_message']); } ?></dd>
						</dl>
						<div class="btn_area">
							<p class="btn_back"><input type="submit" name="btn_back" value="戻る"></p><p class="btn_submit"><input type="submit" name="btn_submit" value="送信"></p>
						</div>
						<input type="hidden" name="contact_type" value="<?php echo $clean['contact_type']; ?>">
						<input type="hidden" name="your_name" value="<?php echo $clean['your_name']; ?>">
						<?php if( !empty($clean['your_company']) ): ?>
							<input type="hidden" name="your_company" value="<?php echo $clean['your_company']; ?>">
						<?php endif; ?>
						<input type="hidden" name="your_email" value="<?php echo $clean['your_email']; ?>">
						<?php if( !empty($clean['your_tel']) ): ?>
							<input type="hidden" name="your_tel" value="<?php echo $clean['your_tel']; ?>">
						<?php endif; ?>
						<input type="hidden" name="your_message" value="<?php echo $clean['your_message']; ?>">
					</form>
				<?php elseif( $page_type === 2 ): ?>
					<header>
						<h2>お問い合わせ</h2>
						<p>お問い合わせいただき、誠にありがとうございます。<br>3営業日以内に返信を差し上げますので、今しばらくお待ちください。</p>
					</header>
					<p class="link_top"><a href="/">トップページへ戻る</a></p>
				<?php else: ?>
					<header>
						<h2>お問い合わせ</h2>
						<p>サイト上のコンテンツについての気になる点やご質問、お仕事についてのお問い合わせは、こちらのフォームよりご連絡いただきますようお願いいたします。</p>
						<?php if( 0 < count($error) ): ?>
						<ul class="error_list">
							<?php if( !empty($error['contact_type']) ) : ?>
							<li>・「お問い合わせの種類」を選択してください</li>
							<?php endif; ?>
							<?php if( !empty($error['your_name']) ) : ?>
							<li>・「氏名」は必ず入力してください</li>
							<?php endif; ?>
							<?php if( !empty($error['your_email']) ) : ?>
							<li>・「メールアドレス」は必ず入力してください</li>
							<?php endif; ?>
							<?php if( !empty($error['your_message']) ) : ?>
							<li>・「お問い合わせ内容」は必ず入力してください</li>
							<?php endif; ?>
						</ul>
						<?php endif; ?>
					</header>
					<form method="post">
						<dl>
							<dt>お問い合わせの種類 <span>*</span></dt>
							<dd>
								<select name="contact_type">
									<option value="0">選択してください</option>
									<option value="1" <?php if( isset($clean['contact_type']) && $clean['contact_type'] == "1" ) { echo 'selected="selected"'; } ?>>サイト上のコンテンツについて</option>
									<option value="2" <?php if( isset($clean['contact_type']) && $clean['contact_type'] == "2" ) { echo 'selected="selected"'; } ?>>お仕事について</option>
									<option value="3" <?php if( isset($clean['contact_type']) && $clean['contact_type'] == "3" ) { echo 'selected="selected"'; } ?>>求人について</option>
									<option value="4" <?php if( isset($clean['contact_type']) && $clean['contact_type'] == "4" ) { echo 'selected="selected"'; } ?>>広告掲載について</option>
									<option value="5" <?php if( isset($clean['contact_type']) && $clean['contact_type'] == "5" ) { echo 'selected="selected"'; } ?>>その他</option>
								</select>
							</dd>
							<dt>氏名 <span>*</span></dt>
							<dd><input type="text" name="your_name" value="<?php if( isset($clean['your_name']) ) { echo $clean['your_name']; } ?>"></dd>
							<dt>貴社名</dt>
							<dd><input type="text" name="your_company" value="<?php if( isset($clean['your_company']) ) { echo $clean['your_company']; } ?>"></dd>
							<dt>メールアドレス <span>*</span></dt>
							<dd><input class="input_long" type="text" name="your_email" value="<?php if( isset($clean['your_email']) ) { echo $clean['your_email']; } ?>"></dd>
							<dt>電話番号</dt>
							<dd><input type="text" name="your_tel" value="<?php if( isset($clean['your_tel']) ) { echo $clean['your_tel']; } ?>"></dd>
							<dt>お問い合わせ内容 <span>*</span></dt>
							<dd><textarea name="your_message"><?php if( isset($clean['your_message']) ) { echo $clean['your_message']; } ?></textarea></dd>
						</dl>
						<div class="btn_area">
							<p class="btn"><input type="submit" name="btn_confirm" value="入力内容の確認へ"></p>
						</div>
					</form>
				<?php endif; ?>
			</article>
		</div>
	</div>

	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>