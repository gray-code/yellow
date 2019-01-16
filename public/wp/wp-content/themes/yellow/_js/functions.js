$(function(){
	
	/* View the to page top button
	----------------------------------------*/
	$(window).scroll(function(){

		if( 400 < $(this).scrollTop() ) {

			if( $("#btn_to_top").css("display") !== "block" ) {
				$("#btn_to_top").fadeIn("fast");
			}

		} else {

			if( $("#btn_to_top").css("display") !== "none" ) {
				$("#btn_to_top").fadeOut("fast");
			}
		}
	});
	
	
	/* Menu
	----------------------------------------*/
	$("#btn_menu").click(function(){
		
		if( $("#header .sp_nav").css("display") !== "block" ) {
			$("#header .sp_nav").slideDown("fast");
		} else {
			$("#header .sp_nav").slideUp("fast");
		}

		return false;
	});
	
	
	/* Close menu
	----------------------------------------*/
	$("#btn_close_menu").click(function(){
		
		if( $("#header .sp_nav").css("display") !== "block" ) {
			$("#header .sp_nav").slideDown("fast");
		} else {
			$("#header .sp_nav").slideUp("fast");
		}

		return false;
	});
	
	
	/* Side Menu
	----------------------------------------*/
	$("#side_group_menu dt a").click(function(){

		var that = $(this);
		var img_src = null;
		var dt_index = that.parent("dt").index();
		var dd_elem = $("#side_group_menu dd").eq(dt_index/2);

		if( dd_elem.css("display") !== "block" ) {

			dd_elem.slideDown("fast");
			img_src = that.css("background-image");
			that.css("background-image", img_src.replace( /plus/, 'minus'));

		} else {

			dd_elem.slideUp("fast");
			img_src = that.css("background-image");
			that.css("background-image", img_src.replace( /minus/, 'plus'));
		}

		return false;
	});


	/* Side Menu
	----------------------------------------*/
	$("#group_list dl dt a").click(function(){

		var that = $(this);
		var img_src = null;
		var dt_index = that.parent("dt").index();
		var dd_elem = $("#group_list dl dd").eq(dt_index/2);

		if( dd_elem.css("display") !== "block" ) {

			dd_elem.slideDown("fast");
			img_src = that.css("background-image");
			that.css("background-image", img_src.replace( /plus/, 'minus'));

		} else {

			dd_elem.slideUp("fast");
			img_src = that.css("background-image");
			that.css("background-image", img_src.replace( /minus/, 'plus'));
		}

		return false;
	});
});