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
	$("#btn-menu").click(function(){

		viewSPMenu();

		return false;
	});


	/* Menu
	----------------------------------------*/
	$("#sp-back-sheet").click(function(){
		viewSPMenu();
	});


	$("#back-sheet").click(function(){
		return false;
	});





	/* Popup Window Close
	----------------------------------------*/
	$(document).on( 'click', '#popup-message a', function(){

		viewSwitch('popup-message');
		return false;
	});
});



//------------------------------------------------------------
// ポップアップメッセージの表示
//------------------------------------------------------------
function viewPopup(message) {

	viewSwitch('popup-message');

	if( message !== undefined ){
		$("#message-content").text(message);
	}

	setTimeout(function(){

		if( $('#popup-message').css("display") !== 'none' ) {
			$('#popup-message').fadeOut("Slow");
		}

	}, 2000);
}



//------------------------------------------------------------
// 表示・非表示の切り替え
//------------------------------------------------------------
function viewSwitch(elem_id) {
	
	if( $("#" + elem_id).css("display") !== "block" ) {
		$("#" + elem_id).css("display","block");
	} else {
		$("#" + elem_id).css("display","none");
	}
}


//------------------------------------------------------------
// バックシートのリサイズ
//------------------------------------------------------------
function resizeBackSheet() {

	var d_height = $(document).height();
	$("#back-sheet").css( "height", d_height + 'px');
	$("#sp-back-sheet").css( "height", d_height + 'px');
}


//------------------------------------------------------------
// SPナビのリサイズ
//------------------------------------------------------------
function resizeSPNavi() {

	var d_height = $(document).height();
	$("#sp-navigation").css( "height", d_height + 'px');
}



//------------------------------------------------------------
// SPメニュー表示
//------------------------------------------------------------
function viewSPMenu(){

	// SPメニューを表示
	if( $("#sp-navigation").css("right") !== "0px" ) {

		// ナビ & バックシートのサイズ調整
		resizeBackSheet();
		resizeSPNavi();
	
		// バックシートを表示
		viewSwitch("sp-back-sheet");
		viewSwitch("sp-navigation");

		$("#sp-back-sheet").animate({
			backgroundColor: "rgba( 0, 0, 0, 0.4)"
		}, "fast");

		$("#sp-navigation").animate({
			right: "0"
		}, "fast", "easeOutQuart");

	} else {
		
		// 表示する横幅を取得
		var w_width = $(window).width();

		if( 480 < w_width ) {

			$("#sp-navigation").animate({
				right: "-50%"
			}, "fast", "easeOutQuart", function(){
				viewSwitch("sp-navigation");
			});
		
		} else {

			$("#sp-navigation").animate({
				right: "-70%"
			}, "fast", "easeOutQuart", function(){
				viewSwitch("sp-navigation");
			});

		}

		// バックシートのサイズ調整
		resizeBackSheet();
		resizeSPNavi();
	
		// バックシートを非表示
		$("#sp-back-sheet").animate({
			backgroundColor: "rgba( 0, 0, 0, 0.0)"
		}, "fast", "", function(){
			viewSwitch("sp-back-sheet");
		});
	}
}


//------------------------------------------------------------
// SPメニュー表示
//------------------------------------------------------------
function viewBackSheet(){

	// SPメニューを表示
	if( $("#back-sheet").css("display") !== "block" ) {

		// バックシートのサイズ調整
		resizeBackSheet();

		// バックシート表示
		viewSwitch("back-sheet");

		$("#back-sheet").animate({
			backgroundColor: "rgba( 0, 0, 0, 0.4)"
		}, "fast");

	} else {

		// バックシートのサイズ調整
		resizeBackSheet();
	
		// バックシートを非表示
		$("#back-sheet").animate({
			backgroundColor: "rgba( 0, 0, 0, 0.0)"
		}, "fast", "", function(){
			viewSwitch("back-sheet");
		});
	}
}

