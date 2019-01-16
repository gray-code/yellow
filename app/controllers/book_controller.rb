class BookController < ApplicationController


	#------------------------------------------------------------
	# 仕訳帳
	#------------------------------------------------------------
	def index

		# Initialize
		items = ''
		item = []
		entry_year = ''
		entry_month = ''
		entry_month_start = ''
		entry_month_end = ''
		before_end_year = ''
		after_end_year = ''
		before_category = ''
		@selected = ''
		m = 0
		@view_date = ''
		@entry_data = ''
		@select_date_list = []
		@debit_items = []
		@credit_items = []
		@debit_item1 = ''
		@debit_item2 = ''
		@debit_item3 = ''
		@debit_item4 = ''
		@debit_item5 = ''
		@debit_number1 = ''
		@debit_number2 = ''
		@debit_number3 = ''
		@debit_number4 = ''
		@debit_number5 = ''
		tool = Tool.new

		# 日付を取得する
		if params["t"].blank?
			entry_year = Time.now.year
			entry_month = Time.now.month
		else
			entry_year = DateTime.strptime( params["t"], "%Y%m").year
			entry_month = DateTime.strptime( params["t"], "%Y%m").month
		end

		# ページング用
		@view_month = Time.mktime( entry_year, entry_month, 1)
		@selected = @view_month.year.to_s + sprintf( "%02d", @view_month.month.to_s)

		@prev_month = @view_month.ago 1.month
		@next_month = @view_month.since 1.month

		# 年月選択用のSELECT生成
		@select_date_list = makeSelectDate(@view_month)

		# 仕訳データを取得するために、月初と月末の日付を取得
		entry_month_start = Date.new( entry_year, entry_month, 1)
		entry_month_end = Date.new( entry_year, entry_month, -1)

		# 仕訳データを取得
		@entry_data = Entry.where("a_user_id = '#{session["user"]["id"]}' AND '#{entry_month_start}' <= a_date AND a_date <= '#{entry_month_end}'").order(a_date: :asc)

		# 借方項目の取得
		items = Item.where(i_user_id: session['user']['id']).where('i_category = 1 OR i_category = 2 OR i_category = 3 OR i_category = 5').order(i_category: :asc).order(id: :asc)
		
		# 変数をリセット
		before_category = 0

		items.each do |value|

			# カテゴリーが切り替わるごとにカテゴリーラベルを追加
			if before_category != value.i_category

				before_category = value.i_category
				@debit_items.push([ '[ ' + tool.getCategoryName(before_category) + ' ]', ''])				
			end
			
			item = [ '　' + value.i_label, value.id]
			@debit_items.push(item)
		end

		# 貸方項目の取得
		items = Item.where(i_user_id: session['user']['id']).where('i_category = 1 OR i_category = 2 OR i_category = 3 OR i_category = 4').order(i_category: :asc).order(id: :asc)

		# 変数をリセット
		before_category = 0

		items.each do |value|

			# カテゴリーが切り替わるごとにカテゴリーラベルを追加
			if before_category != value.i_category

				before_category = value.i_category
				@credit_items.push([ '[ ' + tool.getCategoryName(before_category) + ' ]', ''])				
			end

			item = [ '　' + value.i_label, value.id]
			@credit_items.push(item)
		end

		render "book/index"
	end


	#------------------------------------------------------------
	# 仕訳 追加
	#------------------------------------------------------------
	def entry

		# Initialize
		entry_id = ''
		entry_data = ''
		entry_date = ''
		a_user_id = ''
		debit_entries = []
		credit_entries = []
		debit_item_data = nil
		credit_item_data = nil
		debit_total = 0
		credit_total = 0
		receipt1 = nil
		receipt2 = nil
		receipt3 = nil
		memo = nil
		res = []
		message = []
		entry_id = nil
		e_create = nil
		e_update = nil
		edit_flag = false
		view_date = nil

		res_entry_data = []
		get_onemonth_data = nil
		entry_year = nil
		entry_month = nil
		entry_month_start = nil
		entry_month_end = nil
		now_time = Time.now

		# IDを取得
		unless params["entry_id"].blank?
			entry_id = params["entry_id"].to_i
		end

		# 日付オブジェクトを取得
		unless params["entry_date"].blank?
			entry_date = Date.strptime( params["entry_date"], "%Y年%m月%d日")
		else
			message.push("日付は必ず選択してください")
		end
		
		# 表示する年月を取得
		unless params["view_date"].blank?
			view_date = Date.strptime( params["view_date"], "%Y%m")
		end

 		5.times do |i|

			index = i+1
			debit_item_data = nil
			credit_item_data = nil

			# 借方項目を取得
 			unless params["debit_item#{index}"].blank? && params["debit_number#{index}"].blank?
 
	 			# 項目データが存在するか確認
	 			debit_item_data = Item.where(id: params["debit_item#{index}"]).where(i_user_id: session["user"]["id"]).first
 
	 			unless debit_item_data.blank?
	 				debit_entries.push([
	 					params["debit_item#{index}"].to_i,
	 					params["debit_number#{index}"].to_i,
	 				])
	 			end
 
 				debit_total += params["debit_number#{index}"].to_i
 			end
 
 			# 貸方項目を取得
 			unless params["credit_item#{index}"].blank? && params["credit_number#{index}"].blank?
 
	 			# 項目データが存在するか確認
	 			credit_item_data = Item.where(id: params["credit_item#{index}"]).where(i_user_id: session["user"]["id"]).first
 
	 			unless credit_item_data.blank?
	 				credit_entries.push([
	 					params["credit_item#{index}"].to_i,
	 					params["credit_number#{index}"].to_i,
	 				])
	 			end
 				
 				credit_total += params["credit_number#{index}"].to_i
 			end
 		end
 		
 		if debit_total === 0 || credit_total === 0
	 		message.push('合計金額が0円の仕訳は登録できません')
	 	end

 		# 借方と貸方の金額が一致しているか確認
 		unless debit_total === credit_total
	 		message.push('借方と貸方は必ず一致する必要があります')
	 	end

	 	# 借方と貸方の項目を1つ以上あるか確認
	 	if debit_entries.size === 0 || credit_entries.size === 0
		 	message.push('1つ以上の項目を入力してください')
		end
		
		# 項目配列の長さを調整する
 		diff = 5 - debit_entries.size

 		if 0 < diff
	 		diff.times do |i|
		 		debit_entries.push([nil, nil])
		 	end
		end

 		# 項目配列の長さを調整する
 		diff = 5 - credit_entries.size
 
 		if 0 < diff 
	 		diff.times do |i|
		 		credit_entries.push([nil, nil])
		 	end
		end

 		unless params["memo"].blank?
			memo = params["memo"]
		end

	 	# 仕訳IDが指定されていない場合は新規登録
	 	if message.blank?

		 	if entry_id.blank?
	
			 	Entry.transaction do
	
					e_create = Entry.new(
						a_user_id: session["user"]["id"],
						a_date: entry_date,
						a_debit_id1: debit_entries[0][0],
						a_debit_id2: debit_entries[1][0],
						a_debit_id3: debit_entries[2][0],
						a_debit_id4: debit_entries[3][0],
						a_debit_id5: debit_entries[4][0],
						a_debit_money1: debit_entries[0][1],
						a_debit_money2: debit_entries[1][1],
						a_debit_money3: debit_entries[2][1],
						a_debit_money4: debit_entries[3][1],
						a_debit_money5: debit_entries[4][1],
						a_credit_id1: credit_entries[0][0],
						a_credit_id2: credit_entries[1][0],
						a_credit_id3: credit_entries[2][0],
						a_credit_id4: credit_entries[3][0],
						a_credit_id5: credit_entries[4][0],
						a_credit_money1: credit_entries[0][1],
						a_credit_money2: credit_entries[1][1],
						a_credit_money3: credit_entries[2][1],
						a_credit_money4: credit_entries[3][1],
						a_credit_money5: credit_entries[4][1],
						a_memo: memo,
						a_receipt1: receipt1,
						a_receipt2: receipt2,
						a_receipt3: receipt3,
						created_at: now_time.strftime("%Y-%m-%d %H:%M:%S"),
						updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
					)

					if e_create.save

						edit_flag = true
						message.push("登録が完了しました")

					else
						message.push("仕訳を登録することができませんでした")
					end
				end
	
			else

				entry_data = Entry.where(id: entry_id).where(a_user_id: session["user"]["id"])

				unless entry_data.blank?

					Entry.transaction do

						e_update = entry_data.update(
							a_date: entry_date,
							a_debit_id1: debit_entries[0][0],
							a_debit_id2: debit_entries[1][0],
							a_debit_id3: debit_entries[2][0],
							a_debit_id4: debit_entries[3][0],
							a_debit_id5: debit_entries[4][0],
							a_debit_money1: debit_entries[0][1],
							a_debit_money2: debit_entries[1][1],
							a_debit_money3: debit_entries[2][1],
							a_debit_money4: debit_entries[3][1],
							a_debit_money5: debit_entries[4][1],
							a_credit_id1: credit_entries[0][0],
							a_credit_id2: credit_entries[1][0],
							a_credit_id3: credit_entries[2][0],
							a_credit_id4: credit_entries[3][0],
							a_credit_id5: credit_entries[4][0],
							a_credit_money1: credit_entries[0][1],
							a_credit_money2: credit_entries[1][1],
							a_credit_money3: credit_entries[2][1],
							a_credit_money4: credit_entries[3][1],
							a_credit_money5: credit_entries[4][1],
							a_memo: memo,
							a_receipt1: receipt1,
							a_receipt2: receipt2,
							a_receipt3: receipt3,
							updated_at: now_time.strftime("%Y-%m-%d %H:%M:%S")
 						)
 						
 						if e_update

	 						edit_flag = true

	 					else
	 						message.push("仕訳を登録することができませんでした")
	 					end
					end
				end
			end
			
			# 1ヶ月分の仕訳データを返す
			if edit_flag === true

				res.push(true)
				message.push("更新しました")

				# 日付を取得する
				unless view_date.blank?
					entry_year = view_date.year
					entry_month = view_date.month
				else
					entry_year = Time.now.year
					entry_month = Time.now.month
				end
				
				entry_month_start = Date.new( entry_year, entry_month, 1)
				entry_month_end = Date.new( entry_year, entry_month, -1)
				
				get_onemonth_data = Entry.where("a_user_id = '#{session["user"]["id"]}' AND '#{entry_month_start}' <= a_date AND a_date <= '#{entry_month_end}'").order(a_date: :asc)

				unless get_onemonth_data.blank? && 0 < get_onemonth_data.size
					
					get_onemonth_data.each do |data|
						
						# Initialize per loop
						debit_item_label1 = nil
						debit_item_label2 = nil
						debit_item_label3 = nil
						debit_item_label4 = nil
						debit_item_label5 = nil
						credit_item_label1 = nil
						credit_item_label2 = nil
						credit_item_label3 = nil
						credit_item_label4 = nil
						credit_item_label5 = nil
						array_index = 0

						5.times do |i|

							array_index = i+1

							unless data["a_debit_id#{array_index}"].blank?
								
								item_data = Item.find(data["a_debit_id#{array_index}"])
								eval("debit_item_label#{array_index} = item_data.i_label")
							end

							unless data["a_credit_id#{array_index}"].blank?

								item_data = Item.find(data["a_credit_id#{array_index}"])
								eval("credit_item_label#{array_index} = item_data.i_label")
							end
						end


						res_entry_data.push({
							id: data.id,
							date: data.a_date.strftime("%Y年%m月%d日"),
							day: data.a_date.day,
							debit1: {
								id: data.a_debit_id1,
								label: debit_item_label1,
								number: data.a_debit_money1
							},
							debit2: {
								id: data.a_debit_id2,
								label: debit_item_label2,
								number: data.a_debit_money2
							},
							debit3: {
								id: data.a_debit_id3,
								label: debit_item_label3,
								number: data.a_debit_money3
							},
							debit4: {
								id: data.a_debit_id4,
								label: debit_item_label4,
								number: data.a_debit_money4
							},
							debit5: {
								id: data.a_debit_id5,
								label: debit_item_label5,
								number: data.a_debit_money5
							},
							credit1: {
								id: data.a_credit_id1,
								label: credit_item_label1,
								number: data.a_credit_money1
							},
							credit2: {
								id: data.a_credit_id2,
								label: credit_item_label2,
								number: data.a_credit_money2
							},
							credit3: {
								id: data.a_credit_id3,
								label: credit_item_label3,
								number: data.a_credit_money3
							},
							credit4: {
								id: data.a_credit_id4,
								label: credit_item_label4,
								number: data.a_credit_money4
							},
							credit5: {
								id: data.a_credit_id5,
								label: credit_item_label5,
								number: data.a_credit_money5
							},
							memo: data.a_memo,
							receipt1: data.a_receipt1,
							receipt2: data.a_receipt2,
							receipt3: data.a_receipt3
						})
					end
					
					res.push(res_entry_data)
				end

				# メッセージをレスポンスデータへ挿入
				res.push(message[0])

				# 新しいアクセストークンを挿入
				res.push(form_authenticity_token())
			end
		end

	 	if edit_flag === true
		 	render json: res
		else

			# レスポンスデータを生成
			res.push(false)
			res.push([])
			res.push(message[0])
			res.push(form_authenticity_token())

			render json: message, status: 422
		end

	end



	#------------------------------------------------------------
	# 仕訳 削除
	#------------------------------------------------------------
	def entrydelete

		# Initialize
		message = ''
		entry_id = ''
		entry_data_count = 0
		e_delete = false

		# IDを取得
		unless params["entry_id"].blank?

			entry_id = params["entry_id"]

			unless entry_id.blank? && session['user']['id'].blank?

				entry_data_count = Entry.where(id: entry_id).where(a_user_id: session['user']['id']).count

				if entry_data_count < 1
					message = '仕訳を削除することができませんでした'
				end
			end

		else
			message = '仕訳を削除することができませんでした'
		end

		# IDエラーの場合は終了
		unless message.blank?
			render text: message, status: 422
			return
		end

		Entry.transaction do
			e_delete = Entry.delete(entry_id)
		end

		if e_delete === 1
			render text: '仕訳を削除しました'
		else
			render text: '仕訳を削除することができませんでした', status: 422
		end
	end


	#------------------------------------------------------------
	# 総勘定元帳
	#------------------------------------------------------------
	def ledger

		# Initialize
		entry_i = nil
		items = []
		item_data = nil
		m_index = 1
		@view_date = nil
		@view_year = nil
		@view_param = nil
		@prev_month = nil
		@next_month = nil
		@view_data = []
		@item_select_data = []
		@selected = nil
		@entry_data = []
		@entry_not_blank_flag = false


		# 全項目のデータを取得
		items = Item.where(i_user_id: session["user"]["id"]).order(i_category: :asc).order(id: :asc)

		# Select要素作成		
		items.each do |data|

			@item_select_data.push([ data.i_label, data.id])
		end


		# 日付を取得する
		if params["t"].blank?
			@view_date = Time.now
		else
			@view_date = Time.strptime( params["t"], "%Y")
		end


		# 表示する項目を取得する
		if params["i"].blank?
			item_data = items[0]
		else
			item_data = Item.where(id: params["i"]).where(i_user_id: session["user"]["id"]).first
		end


		# 項目がなかった場合は仕訳帳へリダイレクト
		if item_data.blank?
			redirect_to action: :index
			return
		end


		# SELECT要素を選択された状態にする
		@selected = item_data.id

		# 仕訳データを取得
		12.times do |m|

			# Initialize per loop
			m_index = m+1
			monthly_data = nil
			start_date = nil
			end_date = nil
			@entry_data[m] = []

			# 仕訳データを取得するために、月初と月末の日付を取得
			start_date = Date.new( @view_date.year, m_index, 1)
			end_date = Date.new( @view_date.year, m_index, -1)

			# 仕訳データを取得			
			monthly_data = Entry.where(a_user_id: session["user"]["id"]).where("a_debit_id1 = '#{item_data["id"]}' OR a_debit_id2 = '#{item_data["id"]}' OR a_debit_id3 = '#{item_data["id"]}' OR a_debit_id4 = '#{item_data["id"]}' OR a_debit_id5 = '#{item_data["id"]}' OR a_credit_id1 = '#{item_data["id"]}' OR a_credit_id2 = '#{item_data["id"]}' OR a_credit_id3 = '#{item_data["id"]}' OR a_credit_id4 = '#{item_data["id"]}' OR a_credit_id5 = '#{item_data["id"]}'").where("'#{start_date}' <= a_date AND a_date <= '#{end_date}'").order(a_date: :asc).order(id: :asc)

			monthly_data.each do |data|

				# Initialize per loop
				entry_date = nil
				debit_items = []
				credit_items = []
				conflict_items = []
				conflict_prices = []
				index = 0
				item = nil
				debit_number = nil
				credit_number = nil

				if data.a_debit_id1 === item_data.id || data.a_debit_id2 === item_data.id || data.a_debit_id3 === item_data.id || data.a_debit_id4 === item_data.id || data.a_debit_id5 === item_data.id
					
					5.times do |parent_i|
						
						parent_index = parent_i + 1
						conflict_items = []
						conflict_prices = []
						
						# 項目の金額を取得
						if !data["a_debit_id#{parent_index}"].blank? && item_data.id === data["a_debit_id#{parent_index}"]

							5.times do |i|
		
								index = i+1
		
								# 対になる項目のラベルを取得
								unless data["a_credit_id#{index}"].blank?
		
									item = Item.where(i_user_id: session["user"]["id"]).where(id: data["a_credit_id#{index}"]).first
		
									unless item.blank?
										conflict_items.push(item.i_label)
										conflict_prices.push(data["a_credit_money#{index}"])
									end
								end
							end

							debit_number = data["a_debit_money#{parent_index}"]
	
							@entry_data[m].push({
								date: data["a_date"],
								date_format: data["a_date"].strftime("%m月%d日"),
								conflict_items: conflict_items,
								conflict_prices: conflict_prices,
								debit_number: debit_number,
								credit_number: credit_number
							})

						end
					end

				else

					5.times do |parent_i|

						parent_index = parent_i + 1
						conflict_items = []
						conflict_prices = []

						# 項目の金額を取得
						if !data["a_credit_id#{parent_index}"].blank? && item_data.id === data["a_credit_id#{parent_index}"]

							5.times do |i|

								index = i+1

								# 対になる項目のラベルを取得
								unless data["a_debit_id#{index}"].blank?
									
									item = Item.where(i_user_id: session["user"]["id"]).where(id: data["a_debit_id#{index}"]).first
		
									unless item.blank?
										conflict_items.push(item.i_label)
										conflict_prices.push(data["a_debit_money#{index}"])
									end
								end
							end

							# 項目の金額を取得
							credit_number = data["a_credit_money#{parent_index}"]

							@entry_data[m].push({
								date: data["a_date"],
								date_format: data["a_date"].strftime("%m月%d日"),
								conflict_items: conflict_items,
								conflict_prices: conflict_prices,
								debit_number: debit_number,
								credit_number: credit_number
							})

						end
					end

				end

				@entry_not_blank_flag = true

			end

		end

		# パラメータ生成
		prev_year = @view_date.ago 1.year
		next_year = @view_date.since 1.year

		unless item_data.blank?
			@prev_param = "?t=#{prev_year.year}&i=#{item_data['id']}"
			@next_param = "?t=#{next_year.year}&i=#{item_data['id']}"
			
		else
			@prev_param = "?t=#{prev_year.year}"
			@next_param = "?t=#{next_year.year}"
		end

	end


	#------------------------------------------------------------
	# 残高試算表
	#------------------------------------------------------------
	def balancecalc

		# Initialize
		start_date = nil
		end_date = nil
		items = []
		@selected = ''
		@data_cat1 = []
		@data_cat2 = []
		@data_cat3 = []
		@data_cat4 = []
		@data_cat5 = []
		@view_date = nil
		@prev_param = nil
		@next_param = nil
		@select_date_list = []


		# 日付を取得する
		if params["t"].blank?
			@view_date = Time.now
		else
			@view_date = Time.strptime( params["t"], "%Y%m")
		end

		# 取得データの期間を取得
		start_date = @view_date.strftime("%Y-01-01")
		end_date = DateTime.new( @view_date.year, @view_date.month, -1).strftime("%Y-%m-%d")

		# 年月選択用のSELECT生成
		@select_date_list = makeSelectDate(@view_date)
		@selected = @view_date.year.to_s + sprintf( "%02d", @view_date.month.to_s)

		# 全項目のデータを取得
		items = Item.where(i_user_id: session["user"]["id"]).order(i_category: :asc).order(id: :asc)

		# 項目ごとの合計金額を計算	
		items.each do |data|
			
			# Initalize
			debit_data = nil
			credit_data = nil
			entry_data = { label: data.i_label, total: 0}
			debit_total = 0
			credit_total = 0

			5.times do |i|
				
				index = i+1
				debit_data = nil
				credit_data = nil

				# 借方
				debit_data = Entry.where(a_user_id: session["user"]["id"]).where("a_debit_id#{index} = '#{data["id"]}'").where("'#{start_date}' <= a_date AND a_date <= '#{end_date}'")				

				if 0 < debit_data.size
				
					debit_data.each do |d_data|
						debit_total += d_data["a_debit_money#{index}"]
					end				
				end


				# 貸方
				credit_data = Entry.where(a_user_id: session["user"]["id"]).where("a_credit_id#{index} = '#{data["id"]}'").where("'#{start_date}' <= a_date AND a_date <= '#{end_date}'")

				if 0 < credit_data.size

					credit_data.each do |c_data|
						credit_total += c_data["a_credit_money#{index}"]
					end
				end
			end

			entry_data[:total] = debit_total - credit_total

			# 配列へ挿入
			case data.i_category

			when 1
				@data_cat1.push(entry_data)
			when 2
				entry_data[:total] = -(entry_data[:total])
				@data_cat2.push(entry_data)
			when 3
				entry_data[:total] = -(entry_data[:total])
				@data_cat3.push(entry_data)
			when 4
				entry_data[:total] = -(entry_data[:total])
				@data_cat4.push(entry_data)
			when 5
				@data_cat5.push(entry_data)
			end
		end
		
		# ページングのパラメータを生成
		@prev_param = @view_date.months_ago(1).strftime("%Y%m")
		@next_param = @view_date.months_since(1).strftime("%Y%m")
	end


	private

	#------------------------------------------------------------
	# 年月を選択するSelect要素を生成
	#------------------------------------------------------------
	def makeSelectDate( view_month)

		# Initialize
		before_end_year = ''
		after_end_year = ''
		push_date = ''
		index = 0
		select_date_list = []
		
		12.times do |m| 
			
			index = m+1
			
			if index === 1

				# 昨年末の日付を先頭に設定
				before_end_year = view_month.ago 1.year

				push_date = Time.mktime( before_end_year.year, 12)
				select_date_list.push([ push_date.strftime("%Y年%m月"), push_date.strftime("%Y%m")])
			end

			push_date = Time.mktime( view_month.year, index)
			select_date_list.push([ push_date.strftime("%Y年%m月"), push_date.strftime("%Y%m")])
			
			if index === 12
			
				# 来年の念書を末尾に設定
				after_end_year = view_month.since 1.year

				push_date = Time.mktime( after_end_year.year, 1)
				select_date_list.push([ push_date.strftime("%Y年%m月"), push_date.strftime("%Y%m")])
			end
		end

		return select_date_list		
	end


end
