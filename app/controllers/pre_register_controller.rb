# coding: utf-8

class PreRegisterController < ApplicationController

	skip_before_action :check_logined

	# 仮登録 入力アクション
	def index
		render "pre_register/index"
	end


	# 仮登録 完了アクション
	def complete

		# Initialize
		@message = ''
		@email = ''
		@conf = ''
		@mailres = ''
		page_flag = 0
		now_time = Time.now
		tool = Tool.new
		user_data = ''
		pre_data = ''
		t_session = ''
		regexp = /\A[a-zA-Z0-9_\#!$%&`'*+\-{|}~^\/=?\.]+@[a-zA-Z0-9][a-zA-Z0-9\.-]+\z/

		if params["user"].blank? || params["user"]["email"].blank? || params["user"]["conf-email"].blank?

			@message = '無効なメールアドレスです。'
		
		elsif !regexp =~ params["user"]["email"]

			@message = '無効なメールアドレスです。'
		
		elsif params["user"]["email"] != params["user"]["conf-email"]

			@message = "2つのメールアドレスが一致しません。"
		end

		# エラーの有無を確認
		if @message.blank?

			user_data = User.find_by(u_email: params["user"]["email"], u_status: 1)
			PreRegist.destroy_all([ 't_email = ?', params["user"]["email"]])

			if user_data.blank?

				PreRegist.transaction do

					t_session = tool.randomstring(128)

					p_create = PreRegist.new({
						t_email: params["user"]["email"],
						t_session: t_session,
						created_at: now_time.strftime("%Y-%m-%d %H:%M:%S"),
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					})

					if p_create.save
						page_flag = 1
					else
						@message = "無効なメールアドレスです。"
						page_flag = 0
					end
				end

			else
				@message = "既に使用されているメールアドレスです。"
				page_flag = 0
			end

		else
			unless params["user"].blank?
				unless params["user"]["email"].blank?
					@email = params["user"]["email"]
				end
				
				unless params["user"]["conf-email"].blank?
					@conf = params["user"]["conf-email"]
				end
			end

			page_flag = 0
		end

		if page_flag === 1

			# メール送信
			RegistMailer.preregist( params["user"]["email"], t_session).deliver

			render "pre_register/complete"
		else
			render "pre_register/index"
		end

		return

	end
end
