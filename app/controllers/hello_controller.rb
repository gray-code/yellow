# coding: utf-8

class HelloController < ApplicationController
	
	def index
		render text: "Test"
#		test_var = Rails.application.config.assets.version
test_var = "Dog"
		puts test_var
	end
	
	def view
		
		#user = User.new(name:"テスト太郎",regist_date:"2017-02-01 10:00:00")
		render text: User.new

		#@message = user
		render 'hello/view'
	end
end
