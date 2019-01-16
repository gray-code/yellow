class PasswordResetController < ApplicationController

	skip_before_action :check_logined

	def index
		
		# Initialize
		data = ''
		user_data = ''
		@user_id = ''

		if !params['session'].blank?

			data = PReset.find_by(p_session: params['session'])

			if !data.blank? && !data.p_user_id.blank?
				@user_id = data.p_user_id

				user_data = User.find(@user_id)
			end

		end

		# 仮登録データが取得できなかったらエラー遷移
		if @user_id.blank? || user_data.blank?
			redirect_to controller: :error, action: :password_reset
		else
			render "password_reset/index"
		end

	end
	
	def complete

		# Initialize
		@user_id = ''
		@new = ''
		@conf = ''
		@message = []
		user_data = ''
		passcode = ''
		tool = Tool.new

		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			redirect_to controller: :login, action: :index
			return
		end

		unless params["user"]["id"].blank?
			@user_id = params["user"]["id"]
		end

		unless params["user"]["newpassword"].blank?
			@new = params["user"]["newpassword"]
		end

		unless params["user"]["confpassword"].blank?
			@conf = params["user"]["confpassword"]
		end

		# ユーザーIDがない場合はエラーページへリダイレクト
		if @user_id.blank?
			redirect_to controller: :error, action: :password_reset
			return
		
		else
			
			user_data = User.find(@user_id)
		end		

		if @new.blank? || @conf.blank?

			@message = "新しいパスワードを入力してください"

		elsif !tool.checkPasscodeFormat(@new)

			@message = "パスワードは半角英数で8文字以上、20文字以下で入力してください"

		elsif @new != @conf
		
			@message = "新しいパスワードと確認用パスワードが一致しません"
		end

		if @message.blank?
			
			# パスワードのハッシュ生成
			passcode = tool.makePasscode(@new)

			# 更新
			User.transaction do

				u_data = user_data.update(
					u_passcode: passcode,
					updated_at: Time.now.strftime("%Y-%m-%d %H:%M:%S")
				)

				if u_data
					
					# パスワードリセットのセッション削除
					PReset.destroy_all([ 'p_user_id = ?', @user_id])

					# パスワードリセットの完了メール
					RegistMailer.passreset( user_data).deliver

					@message = nil
				else
					@message = "パスワードの更新に失敗しました"
				end
			end
		end
		
		if @message.blank?
			render "password_reset/complete"
		else
			render "password_reset/index"
		end

	end

end
