class RegisterController < ApplicationController

	skip_before_action :check_logined

	# 本登録 入力アクション
	def index

		# Initialize
		data = ''
		user_data = ''
		@email = ''

		if !params.blank? && !params["session"].blank?

	 		data = PreRegist.find_by(t_session: params['session'])
 
 	 		if !data.blank? && !data.t_email.blank?
 	 			@email = data.t_email
 	 			user_data = User.find_by(u_email: data.t_email)
  			end
		end

		# 仮登録データが取得できなかったらエラー遷移
		if @email.blank? || !user_data.blank?
			redirect_to controller: :error, action: :no_session
		else
			render "register/index"
		end
	end

	# 本登録 確認アクション
	def confirm

		# Initialize
		data = nil
		session_flag = false
		@message = []
		@email = ''
		@yourname = ''
		@furigana = ''
		@telnumber = ''
		@birthyear = ''
		@birthmonth = ''
		@birthday = ''
		@companyname = ''
		@password = ''
		
		if !params['user'].blank? && !params['user']['email'].blank?

 			data = PreRegist.find_by(t_email: params['user']['email'])

 			if !data.blank? && !data.id.blank?
 				session_flag = true
 			end
		end

		# セッションデータが無ければエラーへ遷移
		if session_flag === false
			redirect_to controller: :error, action: :no_session
			return
		end

		# 入力値の確認		
		@message = checkRegistData(params)

		if @message.size === 0
			render "register/confirm"
		else
			render "register/index"
		end
	end


	# 本登録 完了アクション
	def complete

		# Initialize
		@message = []
		@email = ''
		@yourname = ''
		@furigana = ''
		@telnumber = ''
		@birthyear = ''
		@birthmonth = ''
		@birthday = ''
		@companyname = ''
		@password = ''
		data = nil
		user_id = nil
		birthday = ''
		passcode = ''
		tool = Tool.new
		now_time = Time.now
		session_flag = false

		if !params['user'].blank? && !params['user']['email'].blank?

			data = PreRegist.find_by(t_email: params['user']['email'])

			if !data.blank? && !data.id.blank?
				session_flag = true
			end
		end

		# セッションデータが無ければエラーへ遷移
		if session_flag === false
			redirect_to controller: :error, action: :no_session
			return
		end

		
		# 入力値の確認		
		@message = checkRegistData(params)
		
		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			render "register/index"
			return
		end


		if @message.size === 0

			# 誕生日の登録データ生成
			birthday = Time.mktime( @birthyear, @birthmonth, @birthday).strftime("%Y-%m-%d")

			# パスワードのハッシュ生成
			passcode = tool.makePasscode(params['user']['password'])


			# ユーザー登録の実行
			User.transaction do

		  		u_create = User.new({
			  		u_email: params["user"]["email"],
			  		u_passcode: passcode,
		  			u_name: params["user"]["yourname"],
		  			u_furigana: params["user"]["furigana"],
		  			u_tel: params["user"]["telnumber"],
		  			u_birthday: birthday,
		  			u_business_name: params["user"]["companyname"],
		  			u_status: 1,
		  			u_error_count: 0,
					created_at: now_time.strftime("%Y-%m-%d %H:%M:%S"),
					updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
	  			})

	  			if u_create.save

		  			user_id = u_create.id

		  			# メール送信
		  			RegistMailer.regist(u_create).deliver
		  			
		  			render "register/complete"
		  		else
		  			@message.push("アカウント登録時に失敗しました")
		  			render "register/index"
		  			return
		  		end

		  		# 仮登録データの削除
		  		PreRegist.transaction do

			  		pre_data = PreRegist.find_by(t_email: params["user"]["email"])

					if !pre_data.blank?
				  		PreRegist.delete(pre_data["id"])
				  	end
		  		end

		  		# 仕訳項目の初期設定
		  		Item.transaction do

		  			# 設定ファイルから初期仕訳項目を読み込む
					items = YAML.load_file("#{Rails.root}/config/config.yml")
					@default_items = items["COMMON"]["default-items"]

					# BULK INSERT
					i_create = []
					@default_items.each do |item_data|

						i_create << Item.new(
							i_user_id: user_id,
							i_category: item_data[1],
							i_label: item_data[0],
							i_edit_flag: item_data[2],
							i_memo: item_data[3],
							created_at: Time.now.strftime("%Y-%m-%d %H:%M:%S"),
							updated_at: Time.now.strftime("%Y-%m-%d %H:%M:%S")
						)
					end
					Item.import i_create
				end

	  		end

		else
			render "register/index"
		end
		

	end


	private
	
	# 入力値を確認する
	def checkRegistData(data)

		res = []
		tool = Tool.new
		now_time = Time.now

		# メールアドレス
		if !data['user']['email'].blank?

			user_data = User.find_by(u_email: data['user']['email'])

			if !user_data.blank?
				res.push("既に使用されているメールアドレスです。お手数をお掛けし恐れ入りますが、別のメールアドレスから再度アカウント登録をお願いいたします。")
			end

			@email = data['user']['email']

		else
			res.push("セッションエラーです")
		end

		# 氏名
		if !data['user']['yourname'].blank?
			@yourname = data['user']['yourname']
		else
			res.push("「氏名」は必ず入力してください")
		end

		# フリガナ
		if !data['user']['furigana'].blank?
			data['user']['furigana'] = tool.convertKatakana(data['user']['furigana'])
			@furigana = data['user']['furigana']
		else
			res.push("「フリガナ」は必ず入力してください")
		end

		# 電話番号
		if !data['user']['telnumber'].blank?

			# 全角を半角へ変換
			data['user']['telnumber'] = tool.convertHankaku(data['user']['telnumber'])

			# ハイフンを除去
			data['user']['telnumber'] = data['user']['telnumber'].gsub( /[-ー]/, '')

			@telnumber = data['user']['telnumber']

			if !tool.checkTelFormat( data['user']['telnumber'])
				res.push("「電話番号」の形式が正しくありません")
			end

		else
			res.push("「電話番号」は必ず入力してください")
		end

		# 誕生日
		if !data['user']['birthyear'].blank?
			@birthyear = data['user']['birthyear']
		else
			res.push("生年月日の「年」は必ず選択してください")
		end

		if !data['user']['birthmonth'].blank?
			@birthmonth = data['user']['birthmonth']
		else
			res.push("生年月日の「月」は必ず選択してください")
		end

		if !data['user']['birthday'].blank?
			@birthday = data['user']['birthday']
		else
			res.push("生年月日の「日」は必ず選択してください")
		end
		
		if !@birthyear.blank? && !@birthmonth.blank? && !@birthday.blank?
			
			if !tool.checkBirthFormat( @birthyear, @birthmonth, @birthday)
				res.push("生年月日の形式が正しくありません")
			end
		end
		
		# 屋号
		if !data['user']['companyname'].blank?
			@companyname = data['user']['companyname']
		end

		# パスワード
		if !data['user']['password'].blank?

			if tool.checkPasscodeFormat(data['user']['password'])
				@password = data['user']['password']
			else
				res.push("「パスワード」は半角英数で8文字以上、20文字以下で入力してください")
			end
		else
			res.push("「パスワード」は必ず入力してください")
		end
		
		return res
	end

end
