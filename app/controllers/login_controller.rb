class LoginController < ApplicationController

	skip_before_action :check_logined 

	def index

		# initialize
		@email = ''
		@password = ''
		@error_message = ''
		@success_message = ''
		@tes = ''
		user_data = ''
		session_user_data = ''
		tool = Tool.new
		now_time = Time.now
		
		# セッションの確認
		unless session[:user].blank?
			
			begin
		 		session_user_data = User.find(session["user"]["id"])

		 	rescue ActiveRecord::RecordNotFound

		 		reset_session
		 	end

			if !session_user_data.blank? && !session_user_data["id"].blank?
		 	 	redirect_to controller: :book, action: :index
		 	 	return
		 	end
		end
		

		# メールアドレスを取得
		if !params['user'].blank?
			
			if !params['user']['email'].blank?
				@email = params['user']['email']
			else
				@error_message = "ログインに失敗しました。"
			end
			
			# パスワードを取得
			if !params['user']['password'].blank?
				@password = params['user']['password']
			else
				@error_message = "ログインに失敗しました。"
			end

		end

		if !@email.blank? && !@password.blank?

			user_data = User.where(u_email: params['user']['email']).where(u_status: 1).first

			if !user_data.blank? && !user_data["u_passcode"].blank? && tool.checkPasscode( user_data["u_passcode"], params['user']['password'])

				User.transaction do
					user_data.update({
						u_last_login_date: now_time.strftime("%Y-%m-%d %H:%M:%S"),
					})
				end

				# セッションにユーザーデータを保存
				session[:user] = user_data
				session[:user][:u_passcode] = nil

			else
				@error_message = "ログインに失敗しました。"
			end
		end

		if @error_message.blank? && !session[:user].blank? && !session[:user][:id].blank?
			redirect_to controller: :book, action: :index
		else
			render "login/index"
		end
	end

end
