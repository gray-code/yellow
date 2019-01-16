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
	

	/* Edit Menu
	----------------------------------------*/
	$(".link-edit").click(function(){

		var cal_id = 2;
		var that = $(this);

		if( that.parent().find("#edit-menu").length == 0 ){

			$("#edit-menu").remove();

			var ul_elem = $("<ul></ul>", {
				id: 'edit-menu'
			});
			var li_elem1 = $("<li></li>");
			var li_elem2 = $("<li></li>");
			var li_elem3 = $("<li></li>");
			var a_elem1 = $("<a></a>", {
				href: '/edit/' + cal_id + '/',
				text: '編集',
				class: 'link-edit-window'
			});
			var a_elem2 = $("<a></a>", {
				href: '/copy/' + cal_id + '/',
				text: '複製',
				class: 'link-clone-window'
			});
			var a_elem3 = $("<a></a>", {
				href: '/delete/' + cal_id + '/',
				text: '削除',
				class: 'link-delete-window'
			});
			
			li_elem1.append(a_elem1);
			li_elem2.append(a_elem2);
			li_elem3.append(a_elem3);

			ul_elem.append(li_elem1);
			ul_elem.append(li_elem2);
			ul_elem.append(li_elem3);
	
			that.after(ul_elem);

		} else {
			$("#edit-menu").remove();
		}

		return false;
	});


	/* Item Edit Menu
	----------------------------------------*/
	$(".link-item-edit").click(function(){

		var cal_id = 2;
		var that = $(this);

		if( that.parent().find("#edit-menu").length == 0 ){

			$("#edit-menu").remove();

			var ul_elem = $("<ul></ul>", {
				id: 'edit-menu'
			});
			var li_elem1 = $("<li></li>");
			var li_elem2 = $("<li></li>");
			var a_elem1 = $("<a></a>", {
				href: '/edit/' + cal_id + '/',
				text: '編集',
				class: 'link-edit-window'
			});
			var a_elem2 = $("<a></a>", {
				href: '/delete/' + cal_id + '/',
				text: '削除',
				class: 'link-delete-window'
			});
			
			li_elem1.append(a_elem1);
			li_elem2.append(a_elem2);

			ul_elem.append(li_elem1);
			ul_elem.append(li_elem2);
	
			that.after(ul_elem);

		} else {
			$("#edit-menu").remove();
		}

		return false;
	});


	/* Register Execute
	----------------------------------------*/
	$("#btn-register").click(function(){

		// Set message
		$("#popup-message").find("p span").text("On!!!!!");

		viewPopup();
		return false;
	});


	/* Add Window Open
	----------------------------------------*/
	$(".btn-add-entry").click(function(){

		resizeBackSheet();
		viewSwitch("back-sheet");
		viewSwitch("add-entry");
		return false;
	});


	/* Item Add Window Open
	----------------------------------------*/
	$("#btn-add-item").click(function(){

		resizeBackSheet();
		viewSwitch("back-sheet");
		viewSwitch("add-item");

		return false;
	});


	/* Edit Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-edit-window', function(){

		$("#edit-menu").remove();

		resizeBackSheet();
		viewSwitch("back-sheet");
		viewSwitch("add-entry");
		viewSwitch("edit-item");

		return false;
	});


	/* Clone Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-clone-window', function(){

		$("#edit-menu").remove();

		resizeBackSheet();
		viewSwitch("back-sheet");
		viewSwitch("add-entry");

		return false;
	});


	/* Delete Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-delete-window', function(){

		$("#edit-menu").remove();

		resizeBackSheet();
		viewSwitch("back-sheet");
		viewSwitch("delete-entry");
		viewSwitch("delete-item");

		return false;
	});


	/* Add Window Close
	----------------------------------------*/
	$(".btn-add-close-action").click(function(){

		viewSwitch("add-entry");
		viewSwitch("add-item");
		viewSwitch("back-sheet");

		return false;
	});


	/* Edit Window Close
	----------------------------------------*/
	$(".btn-edit-close-action").click(function(){

		viewSwitch("add-entry");
		viewSwitch("edit-item");
		viewSwitch("back-sheet");

		return false;
	});


	/* Delete Window Close
	----------------------------------------*/
	$(".btn-delete-close-action").click(function(){

		viewSwitch("delete-item");
		viewSwitch("delete-entry");
		viewSwitch("back-sheet");

		return false;
	});


	/* Popup Window Close
	----------------------------------------*/
	$(document).on( 'click', '#popup-message a', function(){

		viewSwitch('popup-message');
		return false;
	});


	/* Debit price
	----------------------------------------*/
	$("input[name=debit-price1]").change(function(){
		sumDebitNumber();
	});
	$("input[name=debit-price2]").change(function(){
		sumDebitNumber();
	});
	$("input[name=debit-price3]").change(function(){
		sumDebitNumber();
	});
	$("input[name=debit-price4]").change(function(){
		sumDebitNumber();
	});
	$("input[name=debit-price5]").change(function(){
		sumDebitNumber();
	});	


	/* Credit price
	----------------------------------------*/
	$("input[name=credit-price1]").change(function(){
		sumCreditNumber();
	});
	$("input[name=credit-price2]").change(function(){
		sumCreditNumber();
	});
	$("input[name=credit-price3]").change(function(){
		sumCreditNumber();
	});
	$("input[name=credit-price4]").change(function(){
		sumCreditNumber();
	});
	$("input[name=credit-price5]").change(function(){
		sumCreditNumber();
	});	

	checkEqual();

//	viewPopup();
});



function viewPopup() {

	viewSwitch('popup-message');

	setTimeout(function(){

		if( $('#popup-message').css("display") !== 'none' ) {
			$('#popup-message').fadeOut("Slow");
		}

	}, 2000);
}


function viewSwitch(elem_id) {
	
	if( $("#" + elem_id).css("display") !== "block" ) {
		$("#" + elem_id).css("display","block");
	} else {
		$("#" + elem_id).css("display","none");
	}
}


function sumDebitNumber() {
	
	var debit_num1 = parseInt($("input[name=debit-price1]").val());
	var debit_num2 = parseInt($("input[name=debit-price2]").val());
	var debit_num3 = parseInt($("input[name=debit-price3]").val());
	var debit_num4 = parseInt($("input[name=debit-price4]").val());
	var debit_num5 = parseInt($("input[name=debit-price5]").val());

	if( isNaN(debit_num1) ) {
		debit_num1 = 0;
	}

	if( isNaN(debit_num2) ) {
		debit_num2 = 0;
	}
	
	if( isNaN(debit_num3) ) {
		debit_num3 = 0;
	}

	if( isNaN(debit_num4) ) {
		debit_num4 = 0;
	}

	if( isNaN(debit_num5) ) {
		debit_num5 = 0;
	}
	
	var total = debit_num1 + debit_num2 + debit_num3 + debit_num4 + debit_num5;

	$("#debit-total-num").text( total.toLocaleString() );
	
	checkEqual();
}


function sumCreditNumber() {
	
	var credit_num1 = parseInt($("input[name=credit-price1]").val());
	var credit_num2 = parseInt($("input[name=credit-price2]").val());
	var credit_num3 = parseInt($("input[name=credit-price3]").val());
	var credit_num4 = parseInt($("input[name=credit-price4]").val());
	var credit_num5 = parseInt($("input[name=credit-price5]").val());

	if( isNaN(credit_num1) ) {
		credit_num1 = 0;
	}

	if( isNaN(credit_num2) ) {
		credit_num2 = 0;
	}
	
	if( isNaN(credit_num3) ) {
		credit_num3 = 0;
	}

	if( isNaN(credit_num4) ) {
		credit_num4 = 0;
	}

	if( isNaN(credit_num5) ) {
		credit_num5 = 0;
	}

	var total = credit_num1 + credit_num2 + credit_num3 + credit_num4 + credit_num5;

	$("#credit-total-num").text( total.toLocaleString() );

	checkEqual();
}


function checkEqual() {

	var debit_price = parseInt( $("#debit-total-num").text().replace(/,/, ""));
	var credit_price = parseInt( $("#credit-total-num").text().replace(/,/, ""));

	if( debit_price === credit_price ) {
		$("#balance-check").removeClass("not-equal");
		$("#balance-check").addClass("equal");
	} else {
		$("#balance-check").removeClass("equal");
		$("#balance-check").addClass("not-equal");
	}
}


function resizeBackSheet() {

	var d_height = $(document).height();
	$("#back-sheet").css( "height", d_height + 'px');
}
