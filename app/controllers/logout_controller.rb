class LogoutController < ApplicationController

	# ログアウト
	def index

		@login_status = false
		@success_message = true		
		reset_session

		render "login/index"
	end
end
