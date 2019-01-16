class User < ApplicationRecord


	# メールアドレスの正規表現
	VALID_EMAIL_REGEX = /\A[\w+\-.]+@[a-z\d\-.]+\.[a-z]+\z/i

# 	validates :u_email,
# 		presence: true,
# 		uniqueness: true,
# 		format: { with: VALID_EMAIL_REGEX}


end
