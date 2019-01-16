class Tool
	include ActiveModel::Model
	require "nkf"
	include BCrypt


	# 指定した長さのランダム文字列を生成する
	def randomstring(length)

		res = ''
		random = Random.new
		strings = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9"]
		strings_size = strings.size - 1

		if 0 < length

			length.times do |i|
				res += strings[random.rand(0..(strings_size))]
			end

		end

		return res
	end


	# パスワードの形式、文字数を確認する
	def checkPasscodeFormat(data)

		# Initialize
		res = ''

		if /\A[A-Za-z]{1}\w{7,20}\z/ =~ data

			res = true

		else
			res = false
		end
		
		return res
	end


	# パスワードのハッシュ生成
	def makePasscode(data)
		return BCrypt::Password.create( data, :cost=>14)
	end


	# パスワード照合
	def checkPasscode( passcode, input_data)
		
		db_pass = Password.new(passcode)
		return db_pass == input_data

	end


	# ひらがなをカタカナへ変換
	def convertKatakana(data)

		return NKF.nkf("-h2 -W -w", data)
	end


	# 全角英数を半角英数へ変換
	def convertHankaku(data)

		return NKF.nkf("-m0Z1 -W -w", data)
	end


	# 電話番号の形式を確認
	def checkTelFormat(data)

		# Initialize
		res = ''

		if /\A[0-9]{8,11}\z/ =~ data
			res = true
		else
			res = false
		end

		return res
	end


	# 誕生日の形式を確認
	def checkBirthFormat( year, month, day)

		res = ''

		if /\A[0-9]{4}\z/ =~ year && /\A[0-9]{1,2}\z/ =~ month && /\A[0-9]{1,2}\z/ =~ day
			res = true
		else
			res = false
		end

		return res
	end


	# カテゴリーIDからカテゴリー名を取得
	def getCategoryName( category_id)
		
		# initialize
		res = nil

		case category_id
		when 1
			res = '資産'
		when 2
			res = '負債'
		when 3
			res = '資本'
		when 4
			res = '収入'
		when 5
			res = '費用'
		end

		return res
	end

end