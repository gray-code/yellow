class UnsubscriptionController < ApplicationController

	#------------------------------------------------------------
	# 退会トップ
	#------------------------------------------------------------
	def index

		render "unsubscription/index"
	end


	#------------------------------------------------------------
	# 退会完了
	#------------------------------------------------------------
	def complete

		# Initialize
		@pass = ''
		@reason = ''
		@comment = ''
		@message = ''
		user_data = ''
		u_edit = ''
		u_create = ''
		tool = Tool.new
		now_time = Time.now

		# キャンセルの場合は前ページへ戻る
		unless params['btn-back'].blank?
			redirect_to controller: :account, action: :index
			return
		end

		# ユーザーデータを取得
		user_data = User.find(session['user']['id'])

		# パラメータ確認
 		unless params['user'].blank?

			unless params["user"]["password"].blank?
				@pass = params["user"]["password"]
			end
			
			unless params["user"]["reason"].blank?
				@reason = params["user"]["reason"]
			end

			unless params["user"]["comment"].blank?
				@comment = params["user"]["comment"]
			end

			if @pass.blank? || @reason.blank?

				@message = "パスワード、退会理由を入力してください"

			elsif !tool.checkPasscode( user_data["u_passcode"], @pass)

				@message = "パスワードが正しくありません"
			end

			if @message.blank?
				
				User.transaction do
					u_edit = user_data.update(
						u_status: 5,
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					)
					
					if u_edit != true
						@message = "退会処理が完了できませんでした"
					end
				end

				Unsubscription.transaction do

					u_create = Unsubscription.create(
						u_user_id: session['user']['id'],
						u_reason: @reason,
						u_comment: @comment,
						created_at: now_time.strftime("%Y-%m-%d %H:%M:%S"),
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					)

					if u_create["id"].blank?
						@message = "退会処理が完了できませんでした"
					end
				end
			end

		end

		if @message.blank?
			
			# メール送信
			RegistMailer.unsubscription( user_data).deliver
			
			render "unsubscription/complete"
		else
			render "unsubscription/index"
		end
	end

end
