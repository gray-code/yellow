class AccountController < ApplicationController


	#------------------------------------------------------------
	# アカウント設定トップ
	#------------------------------------------------------------
	def index

		@asset = ''
		@debt = ''
		@net_asset = ''
		@income = ''
		@cost = ''
		@message = ''
		
		unless flash[:message].blank?
			@message = flash[:message]
		end

		# 各カテゴリーの項目を取得
		@asset = Item.where(i_user_id: session['user']['id']).where(i_category: 1)
		@debt = Item.where(i_user_id: session['user']['id']).where(i_category: 2)
		@net_asset = Item.where(i_user_id: session['user']['id']).where(i_category: 3)
		@income = Item.where(i_user_id: session['user']['id']).where(i_category: 4)
		@cost = Item.where(i_user_id: session['user']['id']).where(i_category: 5)

	end


	#------------------------------------------------------------
	# アカウント編集
	#------------------------------------------------------------
	def edit
		
		@yourname = ''
		@furigana = ''
		@telnumber = ''
		@birthyear = ''
		@birthmonth = ''
		@birthday = ''
		@companyname = ''
		@s_message = ''
		@message = []
		user_data = ''
		birth_data = ''
		birthday = ''
		tool = Tool.new
		now_time = Time.now

		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			redirect_to action: :index
			return
		end

		# ユーザーデータを取得
		user_data = User.find(session['user']['id'])

		# 誕生日でDateオブジェクトを生成
		birth_data = Date.parse(user_data['u_birthday'].to_s)

		# パラメータ確認
		unless params['user'].blank?
			

			# 氏名
			unless params['user']['yourname'].blank?
				@yourname = params['user']['yourname']
			else
				@message.push('「氏名」は必ず入力してください')
			end

			# フリガナ
			unless params['user']['furigana'].blank?
				@furigana = tool.convertKatakana(params['user']['furigana'])
			else
				@message.push('「フリガナ」は必ず入力してください')
			end

			# 電話番号
			unless params['user']['telnumber'].blank?

				# 全角を半角へ変換
				@telnumber = tool.convertHankaku(params['user']['telnumber'])
				
				# ハイフンを除去
				@telnumber = @telnumber.gsub( /[-ー]/, '')

				if !tool.checkTelFormat(@telnumber)
					@message.push("「電話番号」の形式が正しくありません")
				end

			else
				@message.push('「電話番号」は必ず入力してください')
			end

			# 誕生日
			unless params['user']['birthyear'].blank?
				@birthyear = params['user']['birthyear']
			else
				@message.push("生年月日の「年」を選択してください")
			end
			
			unless params['user']['birthmonth'].blank?
				@birthmonth = params['user']['birthmonth']
			else
				@message.push("生年月日の「月」を選択してください")
			end
			
			unless params['user']['birthday'].blank?
				@birthday = params['user']['birthday']
			else
				@message.push("生年月日の「日」を選択してください")
			end

			# 屋号
			unless params['user']['companyname'].blank?
				@companyname = params['user']['companyname']
			end

			# エラーがなければ更新
			if @message.blank?
				
				# 誕生日の登録データ生成
				birthday = Time.mktime( @birthyear, @birthmonth, @birthday).strftime("%Y-%m-%d")

				# 更新
				User.transaction do
					u_data = user_data.update(
						u_name: @yourname,
						u_furigana: @furigana,
						u_tel: @telnumber,
						u_birthday: birthday,
						u_business_name: @companyname,
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					)

					if u_data

						flash[:message] = '登録情報を更新しました'

						# セッションのデータを更新
						session[:user] = user_data
						session[:user][:u_passcode] = nil
						
						redirect_to action: :index
						return

					else
						@message.push("更新できませんでした")
					end
				end
			end

		else

			unless user_data.blank?
				
				@yourname = user_data['u_name']
				@furigana = user_data['u_furigana']
				@telnumber = user_data['u_tel']
				@birthyear = birth_data.year
				@birthmonth = birth_data.month
				@birthday = birth_data.day
				@companyname = user_data['u_business_name']
			end
		end

		render "account/edit"
	end


	#------------------------------------------------------------
	# メールアドレス編集
	#------------------------------------------------------------
	def emailedit

		@now_email = session['user']['u_email']
		@email = ''
		@emailconf = ''
		@s_message = ''
		@message = []
		user_data = ''
		already_used_count = 0
		tool = Tool.new
		now_time = Time.now
		regexp = /\A[a-zA-Z0-9_\#!$%&`'*+\-{|}~^\/=?\.]+@[a-zA-Z0-9][a-zA-Z0-9\.-]+\z/

		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			redirect_to action: :index
			return
		end

		# ユーザーデータを取得
		user_data = User.find(session['user']['id'])

		# パラメータ確認
		unless params['user'].blank?

			unless params["user"]["email"].blank?
				@email = params["user"]["email"]
				
				already_used_count = User.where(u_email: @email, u_status: 1).where.not(id: session['user']['id']).count
			end
			
			unless params["user"]["conf-email"].blank?
				@emailconf = params["user"]["conf-email"]
			end

			if @email.blank? || @emailconf.blank?

				@message = '新しく設定したいメールアドレスを入力してください'

			elsif !regexp =~ @email
	
				@message = '無効なメールアドレスです。'
			
			elsif @email != @emailconf
	
				@message = "2つのメールアドレスが一致しません。"
			
			elsif user_data["u_email"] === @email
				@message = "現在設定しているものとは異なるメールアドレスを入力してください"
			
			elsif 0 < already_used_count
			
				@message = "既に登録されているメールアドレスです"
			end

			# エラーがなければ更新
			if @message.blank?

				# 更新
				User.transaction do
					u_data = user_data.update(
						u_email: @email,
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					)

					if u_data

						flash[:message] = 'メールアドレスを更新しました'

						# メール送信
						RegistMailer.emailedit( user_data, @now_email).deliver

						# セッションのデータを更新
						session[:user] = user_data
						session[:user][:u_passcode] = nil

						@now_email = @email
						@email = ''
						@emailconf = ''

						redirect_to action: :index
						return

					else
						@message = "更新できませんでした"
					end
				end
			end
		end

		render "account/emailedit"
	end


	#------------------------------------------------------------
	# パスワード編集
	#------------------------------------------------------------
	def passedit

		@old = ''
		@new = ''
		@conf = ''
		@s_message = ''
		@message = []
		user_data = ''
		passcode = ''
		tool = Tool.new
		now_time = Time.now

		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			redirect_to action: :index
			return
		end

		# ユーザーデータを取得
		user_data = User.find(session['user']['id'])

		# パラメータ確認
 		unless params['user'].blank?

			unless params["user"]["nowpassword"].blank?
				@old = params["user"]["nowpassword"]
			end
			
			unless params["user"]["newpassword"].blank?
				@new = params["user"]["newpassword"]
			end

			unless params["user"]["confpassword"].blank?
				@conf = params["user"]["confpassword"]
			end


			if @old.blank? || @new.blank? || @conf.blank?

				@message = "パスワードを入力してください"

			elsif !tool.checkPasscode( user_data["u_passcode"], @old)

				@message = "現在お使いのパスワードが正しくありません"

			elsif !tool.checkPasscodeFormat(@new)

				@message = "パスワードは半角英数で8文字以上、20文字以下で入力してください"

			elsif @new != @conf
			
				@message = "新しいパスワードと確認用パスワードが一致しません"
			end


			# エラーがなければ更新
 			if @message.blank?

				# パスワードのハッシュ生成
				passcode = tool.makePasscode(@new)

				# 更新
				User.transaction do
					u_data = user_data.update(
						u_passcode: passcode,
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					)

					if u_data

						flash[:message] = 'パスワードを更新しました'

						# メール送信
						RegistMailer.passedit( user_data).deliver

						redirect_to action: :index
						return

					else
						@message = "更新できませんでした"
					end
				end
 			end
 		end

		render "account/passedit"
	end


	#------------------------------------------------------------
	# 仕訳項目編集トップ
	#------------------------------------------------------------
	def itemedit
		
		@asset = ''
		@debt = ''
		@net_asset = ''
		@income = ''
		@cost = ''

		# 各カテゴリーの項目を取得
		@asset = Item.where(i_user_id: session['user']['id']).where(i_category: 1)
		@debt = Item.where(i_user_id: session['user']['id']).where(i_category: 2)
		@net_asset = Item.where(i_user_id: session['user']['id']).where(i_category: 3)
		@income = Item.where(i_user_id: session['user']['id']).where(i_category: 4)
		@cost = Item.where(i_user_id: session['user']['id']).where(i_category: 5)

		render "account/itemedit"
	end


	#------------------------------------------------------------
	# 項目の新規登録
	#------------------------------------------------------------
	def itemcreate

		# Initialize
		message = ''
		item_category = ''
		item_label = ''
		item_memo = ''
		now_time = Time.now

		# カテゴリー
		unless params["item_category"].blank?

			case params["item_category"].to_i
			when 1
				item_category = 1
			when 2
				item_category = 2
			when 3
				item_category = 3
			when 4
				item_category = 4
			when 5
				item_category = 5
			else
				message = 'カテゴリーを選択してください'
			end
		else
			message = 'カテゴリーを選択してください'
		end

		# カテゴリーエラーの場合は終了
		unless message.blank?

			render text: message, status: 422
			return
		end

		# ラベル
		unless params["item_label"].blank?
			item_label = params["item_label"]
		else
			message = 'ラベルは必ず入力してください'
		end
		
		# ラベルエラーの場合は終了
		unless message.blank?

			render text: message, status: 422
			return
		end

		# メモ
		unless params["item_memo"].blank?
			item_memo = params["item_memo"]
		end

		if message.blank?

			# 項目を登録
			Item.transaction do
				
				i_create = Item.create(
					i_category: item_category,
					i_label: item_label,
					i_memo: item_memo,
					i_user_id: session["user"]["id"],
					i_edit_flag: 1,
					created_at: now_time.strftime("%Y-%m-%d %H:%M:%S"),
					updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
				);
				
				if i_create.save
		  			render text: i_create.id
		  		else
		  			render text: '項目の追加に失敗しました', status: 422
		  		end
			end

		else
			render text: message, status: 422	
		end

	end


	#------------------------------------------------------------
	# 仕訳項目を編集可能か確認
	#------------------------------------------------------------
	def checkedit

		# Initialize
		edit_flag = true
		item_id = ''
		item_data = ''
		
		# ID
		unless params["item_id"].blank?
			item_id = params["item_id"]
			
			unless item_id.blank? && session['user']['id'].blank?
				item_data = Item.where(id: item_id).where(i_user_id: session['user']['id'])
				
				unless item_data[0].blank?

					if item_data[0]['i_edit_flag'] === false
						edit_flag = false
					end
				end
			end
		end

		if edit_flag
			render text: true
		else
			render text: false
		end
	end


	#------------------------------------------------------------
	# 仕訳項目を削除可能か確認
	#------------------------------------------------------------
	def checkdelete

		# Initialize
		delete_flag = true
		item_id = ''
		item_data = ''
		entry_data = ''

		# ID
		unless params["item_id"].blank?
			item_id = params["item_id"]

			unless item_id.blank? && session['user']['id'].blank?

				item_data = Item.where(id: item_id).where(i_user_id: session['user']['id'])

				unless item_data[0].blank?

					if item_data[0]['i_edit_flag'] === false
						delete_flag = false
						message = "こちらの仕訳項目は削除できません"
					end

					# 仕訳で使っていないか確認
					# 仕訳データを登録後に実装する
					#item_data = Entry.where(id: item_id).where(i_user_id: session['user']['id'])
					#message = "仕訳で使われている項目は削除できません"

				end
			end
		end

		if delete_flag
			render text: delete_flag
		else
			render text: message, status: 422
		end
	end


	#------------------------------------------------------------
	# 項目の編集
	#------------------------------------------------------------
	def itemmodify

		# Initialize
		message = ''
		i_edit = ''
		item_id = ''
		item_data = ''
		item_category = ''
		item_label = ''
		item_memo = ''
		now_time = Time.now

		# ID
		unless params["item_id"].blank?
			item_id = params["item_id"]
			
			unless item_id.blank? && session['user']['id'].blank?
				item_data = Item.where(id: item_id).where(i_user_id: session['user']['id'])
				
				if item_data[0].blank?
					message = '項目の更新に失敗しました'
				end
			end
			
		else
			message = '項目の更新に失敗しました'
		end
		
		# IDエラーの場合は終了
		unless message.blank?

			render text: message, status: 422
			return
		end


		# カテゴリー
		unless params["item_category"].blank?

			case params["item_category"].to_i
			when 1
				item_category = 1
			when 2
				item_category = 2
			when 3
				item_category = 3
			when 4
				item_category = 4
			when 5
				item_category = 5
			else
				message = 'カテゴリーを選択してください'
			end
		else
			message = 'カテゴリーを選択してください'
		end

		# カテゴリーエラーの場合は終了
		unless message.blank?

			render text: message, status: 422
			return
		end

		# ラベル
		unless params["item_label"].blank?
			item_label = params["item_label"]
		else
			message = 'ラベルは必ず入力してください'
		end
		
		# ラベルエラーの場合は終了
		unless message.blank?

			render text: message, status: 422
			return
		end

		# メモ
		unless params["item_memo"].blank?
			item_memo = params["item_memo"]
		end

		# データを更新
		Item.transaction do

			if item_data[0]['i_edit_flag'] === false

				i_edit = item_data.update(
					i_memo: item_memo,
					updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
				)

			else
				i_edit = item_data.update(
					i_category: item_category,
					i_label: item_label,
					i_memo: item_memo,
					updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
				)
			end
		end

		unless i_edit.blank?
			render text: '項目を更新しました'
		else
			render text: message, status: 422
		end
	end


	#------------------------------------------------------------
	# 項目の削除
	#------------------------------------------------------------
	def itemdelete

		# Initialize
		message = ''
		item_id = ''
		item_data = ''
		i_delete = ''

		# ID
		unless params["item_id"].blank?
			item_id = params["item_id"]
			
			unless item_id.blank? && session['user']['id'].blank?
				item_data = Item.where(id: item_id).where(i_user_id: session['user']['id'])

				if item_data[0].blank?
					message = '仕訳項目の削除に失敗しました'
				else

					if item_data[0]['i_edit_flag'] === false
						message = 'こちらの仕訳項目は削除できません'
					end
				end
			end
			
		else
			message = '仕訳項目の削除に失敗しました'
		end

		# IDエラーの場合は終了
		unless message.blank?
			render text: message, status: 422
			return
		end

		Item.transaction do
			
			i_delete = Item.delete(item_data[0]['id'])
		end

		if i_delete === 1
			render text: '仕訳項目を削除しました'
		else
			render text: '仕訳項目の削除に失敗しました', status: 422
		end
	end

end
