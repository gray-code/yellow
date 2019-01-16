class ApplicationController < ActionController::Base
	protect_from_forgery with: :exception

	before_action :start_logger, :check_logined
	after_action :end_logger

	private
	
	def start_logger
		logger.debug('[START] ' + Time.now.to_s)
	end

	def end_logger
		logger.debug('[END] ' + Time.now.to_s)
	end

	# ログインを確認
	def check_logined

		# initialize
		user_data = ''
		@login_status = false

 		if !session[:user].blank?

	 		begin
		 		user_data = User.find(session["user"]["id"])

		 	rescue ActiveRecord::RecordNotFound

		 		# データが取得できない場合、不正なログインなのでセッション破棄
		 		reset_session
		 	end
		 	
		 	if !user_data.blank? && !user_data["id"].blank?
		 	 	@login_status = true
		 	end
		end

		# 正常にログインしていない場合はログインページへリダイレクト
		unless @login_status
			reset_session
			redirect_to controller: :login, action: :index
		end

	end
end
