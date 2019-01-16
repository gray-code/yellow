class ErrorController < ApplicationController

	skip_before_action :check_logined

	# 仮登録のセッションエラー
	def no_session
		render "error/session"
	end

	# パスワードリセットのセッションエラー
	def password_reset
		render "error/passwordreset"
	end

end
