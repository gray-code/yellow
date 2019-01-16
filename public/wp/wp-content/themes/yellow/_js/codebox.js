/* MakeCodeBox v1.0 Copyright(c)2016 GRAYCODE */

(function($) {
	$.fn.codebox = function() {

		var selector = $(this).selector;
		var code_count = $(selector).length;
		var i = 0;

		while( i < code_count ) {

			var that = $(selector).eq(i);
			var text = that.children("code").text();

			var line_text = text.split("\n");

			var j = 1;
			var line_len = line_text.length;
			var line_num_string = null;

			while( j <= line_len ) {

				line_num_string = line_num_string + j + "\n";

				j = j+1;
			}

			// Make the Code box
			var code_div_elem = $("<div></div>");
			code_div_elem.addClass("code_wrap");

			that.wrap("<div class='code_box'></div>");
			that.wrap("<div class='code_wrap'></div>");

			// Make the Line box
			var line_div_elem = $("<div>");
			line_div_elem.addClass("line_nums");

			// Make the Line Element
			var line_pre_elem = $("<pre></pre>");
			line_pre_elem.text(line_num_string);
			line_div_elem.append(line_pre_elem);
			that.parent(".code_wrap").parent(".code_box").prepend(line_div_elem);
	
			i = i + 1;
		}
	};
})(jQuery);
