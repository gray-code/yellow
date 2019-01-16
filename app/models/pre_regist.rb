class PreRegist < ApplicationRecord

 	validates :t_email,
 		presence: true,
 		uniqueness: true



end
