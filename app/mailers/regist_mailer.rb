class RegistMailer < ApplicationMailer

	# Default header
	default from: "noreply@gray-code.com",
		parts_order: "text/plain",
		content_type: "text/plain"


	#---------------------------------------------
	# 仮登録完了
	#---------------------------------------------
	def preregist( email, session)

		# 設定ファイルから初期仕訳項目を読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		# 本登録URLの生成
		@url = config["COMMON"]["url"] + '/register/?session=' + session

		mail(
			to: email,
			subject: "Yellow 仮登録を受け付けました"
		)

		render "regist_mailer/preregist"
	end


	#---------------------------------------------
	# 本登録完了
	#---------------------------------------------
	def regist( user_data)

		# 設定ファイル読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		@user_data = user_data

		# ログインURLの生成
		@url = config["COMMON"]["url"] + '/login/'

		mail(
			to: user_data.u_email,
			subject: "Yellow 本登録が完了しました"
		)

		render "regist_mailer/regist"
	end


	#---------------------------------------------
	# メールアドレス編集完了(旧メールアドレス宛)
	#---------------------------------------------
	def emailedit( user_data, old_email)

		# 設定ファイル読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		@user_data = user_data
		@old_email = old_email
		
		# URLの生成
		@url = config["COMMON"]["url"] + '/login/'
		@contact_url = config["COMMON"]["url"] + '/contact/'

		mail(
			to: [ @old_email, user_data.u_email],
			subject: "Yellow メールアドレスを変更しました"
		)

		render "regist_mailer/emailedit"
	end


	#---------------------------------------------
	# 仮パスワードリセット申請
	#---------------------------------------------
	def prepassreset( email, session)

		# 設定ファイルから初期仕訳項目を読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		# URLの生成
		@url = config["COMMON"]["url"] + '/password-reset/?session=' + session
		@contact_url = config["COMMON"]["url"] + '/contact/'

		mail(
			to: email,
			subject: "Yellow パスワードリセットの申請を受け付けました"
		)

		render "regist_mailer/prepassreset"
	end


	#---------------------------------------------
	# パスワードリセット完了
	#---------------------------------------------
	def passreset( user_data)

		# 設定ファイルから初期仕訳項目を読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		@user_data = user_data

		# URLの生成
		@url = config["COMMON"]["url"] + '/login/'
		@contact_url = config["COMMON"]["url"] + '/contact/'

		mail(
			to: user_data.u_email,
			subject: "Yellow パスワードをリセットしました"
		)

		render "regist_mailer/passreset"
	end


	#---------------------------------------------
	# パスワード変更完了 (アカウント設定)
	#---------------------------------------------
	def passedit( user_data)

		# 設定ファイルから初期仕訳項目を読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		@user_data = user_data

		# URLの生成
		@url = config["COMMON"]["url"] + '/login/'
		@contact_url = config["COMMON"]["url"] + '/contact/'

		mail(
			to: user_data.u_email,
			subject: "Yellow パスワードを変更しました"
		)

		render "regist_mailer/passedit"
	end


	#---------------------------------------------
	# 退会完了
	#---------------------------------------------
	def unsubscription( user_data)

		# 設定ファイルから初期仕訳項目を読み込む
		config = YAML.load_file("#{Rails.root}/config/config.yml")

		@user_data = user_data

		# URLの生成
		@url = config["COMMON"]["url"]

		mail(
			to: user_data.u_email,
			subject: "Yellow 退会申請を承りました"
		)

		render "regist_mailer/unsubscription"
	end

end
