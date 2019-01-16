class PrePasswordResetController < ApplicationController

	skip_before_action :check_logined

	def index

	end


	def complete

		# Initialize
		@message = ''
		@email = ''
		@user_data = ''
		tool = Tool.new
		user_data = ''
		pre_data = ''
		p_session = ''
		regexp = /\A[a-zA-Z0-9_\#!$%&`'*+\-{|}~^\/=?\.]+@[a-zA-Z0-9][a-zA-Z0-9\.-]+\z/

		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			redirect_to controller: :login, action: :index
			return
		end


		if params["user"].blank? || params["user"]["email"].blank?

			@message = 'メールアドレスを入力してください。'

		elsif !regexp =~ params["user"]["email"]

			@message = 'メールアドレスを正しい形式で入力してください。'
			@email = params["user"]["email"]

		end

		user_data = User.where(u_email: params["user"]["email"]).where(u_status: 1).first

		unless user_data.blank?
			
			unless user_data.id.blank?
			
				PReset.transaction do
	
					PReset.destroy_all([ 'p_user_id = ?', user_data.id])
	
					p_session = tool.randomstring(128)

					p_create = PReset.create({
						p_user_id: user_data.id,
						p_session: p_session,
						created_at: Time.now.strftime("%Y-%m-%d %H:%M:%S"),
						updated_at: Time.now.strftime("%Y-%m-%d %H:%M:%S")
					})
				end

				# メール送信
				RegistMailer.prepassreset( user_data.u_email, p_session).deliver

			end
		end

		if @message.blank?
			render "pre_password_reset/complete"
		else
			render "pre_password_reset/index"
		end

	end
end
