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


	/* 仕訳帳で年月を選択した時のイベント
	----------------------------------------*/
	$("#entry_viewdate").change(function(){
		var that = $(this);
		select_date = that.val();

		if( select_date !== null && select_date !== undefined ) {

			// 選択した日付へリダイレクト
			window.location.href = '/book/?t=' + select_date;
		}
	});
	
	/* 残高試算表で年月を選択した時のイベント
	----------------------------------------*/
	$("#bs_viewdate").change(function(){
		var that = $(this);
		select_date = that.val();

		if( select_date !== null && select_date !== undefined ) {

			// 選択した日付へリダイレクト
			window.location.href = '/book/balancecalc/?t=' + select_date;
		}
	});


	/* Select Item
	----------------------------------------*/
	$("#entry_viewitem").change(function(){

		var that = $(this);
		select_item = that.val();
		view_year = $("#viewyear").val();

		if( select_item !== null && select_item !== undefined ) {

			// 選択した日付へリダイレクト
			window.location.href = '/book/ledger/?t=' + view_year + '&i=' + select_item;
		}
	});



	/* Edit Menu
	----------------------------------------*/
	$(document).on( 'click', '.link-edit', function(){

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


	/* Register Execute
	----------------------------------------*/
	$("#btn-submit-entry").click(function(){

		submitEntry($(this));
	});


	/* Add Window Open
	----------------------------------------*/
	$(".btn-add-entry").click(function(){

		// 仕訳入力ウインドウのサイズ調整
		resizeEntryWindow();

		viewBackSheet();
		viewSwitch("add-entry");

		sumDebitNumber();
		sumCreditNumber();

		return false;
	});
	
	
	/* Add Window Close
	----------------------------------------*/
	$(".btn-entry-close-action").click(function(){

		resetEntryForm();
		viewSwitch("add-entry");
		viewBackSheet();

		return false;
	});


	$("#back-sheet").click(function(){

/*
		resetEntryForm();
		
		if( $("#add-entry").css("display") !== "none" ) {
			viewSwitch("add-entry");
		}
		
		if( $("#delete-entry").css("display") !== "none" ) {
			viewSwitch("delete-entry");
		}

		if( $("#add-item").css("display") !== "none" ) {
			viewSwitch("add-item");
		}

		if( $("#edit-item").css("display") !== "none" ) {
			viewSwitch("edit-item");
		}

		if( $("#delete-item").css("display") !== "none" ) {
			viewSwitch("delete-item");
		}

		viewBackSheet();
*/

		return false;
	});


	/* Edit Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-edit-window', function(){

		var that = $(this);
		var parent_tr = that.parents("td").parent("tr");
		
		// データを取得
		var entry_id = parent_tr.find("input[name=entry_id]").val();
		var entry_date = parent_tr.find("input[name=entry_date]").val();
		var debit_id1 = parent_tr.find("input[name=debit_id1]").val();
		var debit_id2 = parent_tr.find("input[name=debit_id2]").val();
		var debit_id3 = parent_tr.find("input[name=debit_id3]").val();
		var debit_id4 = parent_tr.find("input[name=debit_id4]").val();
		var debit_id5 = parent_tr.find("input[name=debit_id5]").val();
		var debit_number1 = parent_tr.find("input[name=debit_number1]").val();
		var debit_number2 = parent_tr.find("input[name=debit_number2]").val();
		var debit_number3 = parent_tr.find("input[name=debit_number3]").val();
		var debit_number4 = parent_tr.find("input[name=debit_number4]").val();
		var debit_number5 = parent_tr.find("input[name=debit_number5]").val();
		var credit_id1 = parent_tr.find("input[name=credit_id1]").val();
		var credit_id2 = parent_tr.find("input[name=credit_id2]").val();
		var credit_id3 = parent_tr.find("input[name=credit_id3]").val();
		var credit_id4 = parent_tr.find("input[name=credit_id4]").val();
		var credit_id5 = parent_tr.find("input[name=credit_id5]").val();
		var credit_number1 = parent_tr.find("input[name=credit_number1]").val();
		var credit_number2 = parent_tr.find("input[name=credit_number2]").val();
		var credit_number3 = parent_tr.find("input[name=credit_number3]").val();
		var credit_number4 = parent_tr.find("input[name=credit_number4]").val();
		var credit_number5 = parent_tr.find("input[name=credit_number5]").val();
		var entry_memo = parent_tr.find("input[name=entry_memo]").val();

		$("#edit-menu").remove();

		// 借方項目の入力
		$("#add-entry").find("select[name='entry[debit_item1]']").val(debit_id1);
		$("#add-entry").find("select[name='entry[debit_item2]']").val(debit_id2);
		$("#add-entry").find("select[name='entry[debit_item3]']").val(debit_id3);
		$("#add-entry").find("select[name='entry[debit_item4]']").val(debit_id4);
		$("#add-entry").find("select[name='entry[debit_item5]']").val(debit_id5);
		$("#add-entry").find("input[name='entry[debit_number1]']").val(debit_number1);
		$("#add-entry").find("input[name='entry[debit_number2]']").val(debit_number2);
		$("#add-entry").find("input[name='entry[debit_number3]']").val(debit_number3);
		$("#add-entry").find("input[name='entry[debit_number4]']").val(debit_number4);
		$("#add-entry").find("input[name='entry[debit_number5]']").val(debit_number5);

		// 貸方項目の入力
		$("#add-entry").find("select[name='entry[credit_item1]']").val(credit_id1);
		$("#add-entry").find("select[name='entry[credit_item2]']").val(credit_id2);
		$("#add-entry").find("select[name='entry[credit_item3]']").val(credit_id3);
		$("#add-entry").find("select[name='entry[credit_item4]']").val(credit_id4);
		$("#add-entry").find("select[name='entry[credit_item5]']").val(credit_id5);
		$("#add-entry").find("input[name='entry[credit_number1]']").val(credit_number1);
		$("#add-entry").find("input[name='entry[credit_number2]']").val(credit_number2);
		$("#add-entry").find("input[name='entry[credit_number3]']").val(credit_number3);
		$("#add-entry").find("input[name='entry[credit_number4]']").val(credit_number4);
		$("#add-entry").find("input[name='entry[credit_number5]']").val(credit_number5);

		// ID・日付・メモを入力
		$("#add-entry").find("input[name='entry[editid]']").val(entry_id);
		$("#add-entry").find("input[name='entry[date]']").val(entry_date);
		$("#add-entry").find("textarea[name='entry[memo]']").val(entry_memo);

		viewBackSheet();
		viewSwitch("add-entry");
		
		sumDebitNumber();
		sumCreditNumber();

		return false;
	});


	/* Clone Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-clone-window', function(){

		var that = $(this);
		var parent_tr = that.parents("td").parent("tr");
		
		// データを取得
		var entry_date = parent_tr.find("input[name=entry_date]").val();
		var debit_id1 = parent_tr.find("input[name=debit_id1]").val();
		var debit_id2 = parent_tr.find("input[name=debit_id2]").val();
		var debit_id3 = parent_tr.find("input[name=debit_id3]").val();
		var debit_id4 = parent_tr.find("input[name=debit_id4]").val();
		var debit_id5 = parent_tr.find("input[name=debit_id5]").val();
		var debit_number1 = parent_tr.find("input[name=debit_number1]").val();
		var debit_number2 = parent_tr.find("input[name=debit_number2]").val();
		var debit_number3 = parent_tr.find("input[name=debit_number3]").val();
		var debit_number4 = parent_tr.find("input[name=debit_number4]").val();
		var debit_number5 = parent_tr.find("input[name=debit_number5]").val();
		var credit_id1 = parent_tr.find("input[name=credit_id1]").val();
		var credit_id2 = parent_tr.find("input[name=credit_id2]").val();
		var credit_id3 = parent_tr.find("input[name=credit_id3]").val();
		var credit_id4 = parent_tr.find("input[name=credit_id4]").val();
		var credit_id5 = parent_tr.find("input[name=credit_id5]").val();
		var credit_number1 = parent_tr.find("input[name=credit_number1]").val();
		var credit_number2 = parent_tr.find("input[name=credit_number2]").val();
		var credit_number3 = parent_tr.find("input[name=credit_number3]").val();
		var credit_number4 = parent_tr.find("input[name=credit_number4]").val();
		var credit_number5 = parent_tr.find("input[name=credit_number5]").val();
		var entry_memo = parent_tr.find("input[name=entry_memo]").val();

		$("#edit-menu").remove();

		// 借方項目の入力
		$("#add-entry").find("select[name='entry[debit_item1]']").val(debit_id1);
		$("#add-entry").find("select[name='entry[debit_item2]']").val(debit_id2);
		$("#add-entry").find("select[name='entry[debit_item3]']").val(debit_id3);
		$("#add-entry").find("select[name='entry[debit_item4]']").val(debit_id4);
		$("#add-entry").find("select[name='entry[debit_item5]']").val(debit_id5);
		$("#add-entry").find("input[name='entry[debit_number1]']").val(debit_number1);
		$("#add-entry").find("input[name='entry[debit_number2]']").val(debit_number2);
		$("#add-entry").find("input[name='entry[debit_number3]']").val(debit_number3);
		$("#add-entry").find("input[name='entry[debit_number4]']").val(debit_number4);
		$("#add-entry").find("input[name='entry[debit_number5]']").val(debit_number5);

		// 貸方項目の入力
		$("#add-entry").find("select[name='entry[credit_item1]']").val(credit_id1);
		$("#add-entry").find("select[name='entry[credit_item2]']").val(credit_id2);
		$("#add-entry").find("select[name='entry[credit_item3]']").val(credit_id3);
		$("#add-entry").find("select[name='entry[credit_item4]']").val(credit_id4);
		$("#add-entry").find("select[name='entry[credit_item5]']").val(credit_id5);
		$("#add-entry").find("input[name='entry[credit_number1]']").val(credit_number1);
		$("#add-entry").find("input[name='entry[credit_number2]']").val(credit_number2);
		$("#add-entry").find("input[name='entry[credit_number3]']").val(credit_number3);
		$("#add-entry").find("input[name='entry[credit_number4]']").val(credit_number4);
		$("#add-entry").find("input[name='entry[credit_number5]']").val(credit_number5);

		// 日付とメモを入力
		$("#add-entry").find("input[name='entry[date]']").val(entry_date);
		$("#add-entry").find("textarea[name='entry[memo]']").val(entry_memo);

		// 仕訳入力ウインドウのサイズ調整
		resizeEntryWindow();

		viewBackSheet();
		viewSwitch("add-entry");

		sumDebitNumber();
		sumCreditNumber();

		return false;
	});


	/* Delete Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-delete-window', function(){

		// Initialize
		var that = $(this)
		var entry_id = that.parents("td").find("input[name=entry_id]").val();
		//hat.re("").val();

		$("#delete_entry_id").val(entry_id);

		$("#edit-menu").remove();

		viewBackSheet();
		viewSwitch("delete-entry");
		viewSwitch("delete-item");

		return false;
	});


	/* Delete Entry
	----------------------------------------*/
	$("#btn-delete-entry").click(function(){

		var that = $(this);
		var parent_form = that.parents("form");
		var id_elem = null;
		var parent_li_elem = null;

		var authenticity_token = parent_form.find("input[name=authenticity_token]").val();
		var entry_id = parent_form.find("input[name='entry[deleteid]']").val();

		$.ajax({
			type: 'POST',
			url: '/book/entrydelete/',
			data: {
				"authenticity_token":authenticity_token,
				"entry_id":entry_id
			},
			dataType: 'text'
		}).then(
			function(res){

				viewSwitch("delete-entry");
				viewBackSheet();
				viewPopup(res);

				// 最新の情報へ更新
				id_elem = $("input[value=" + entry_id + "][name=entry_id]");
				parent_tr_elem = id_elem.parent("td").parent("tr").remove();
			},
			function(res){

				if( res !== undefined ) {
					$("#error-book-delete-text").text(res.responseText);
				} else {
					$("#error-book-delete-text").text("仕訳項目の削除に失敗しました");
				}

				if( $("#error-book-delete-text").css("display") !== "block" ){
					viewSwitch("error-book-delete-text");
				}
			}
		);

		return false;
	});




//----------------------------------------------------------------------------------------------------
//
// 仕訳項目
//
//----------------------------------------------------------------------------------------------------


	/* Item Edit Menu
	----------------------------------------*/
	$(document).on( 'click', '.link-item-edit', function(){

		var that = $(this);

		if( that.parent().find("#edit-menu").length == 0 ){

			$("#edit-menu").remove();

			var ul_elem = $("<ul></ul>", {
				id: 'edit-menu'
			});
			var li_elem1 = $("<li></li>");
			var li_elem2 = $("<li></li>");
			var a_elem1 = $("<a></a>", {
				href: '#',
				text: '編集',
				class: 'link-item-edit-window'
			});
			var a_elem2 = $("<a></a>", {
				href: '#',
				text: '削除',
				class: 'link-item-delete-window'
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


	/* Item Add Window Open
	----------------------------------------*/
	$("#btn-add-item").click(function(){

		viewBackSheet();
		viewSwitch("add-item");

		return false;
	});


	/* Item Add Execute
	----------------------------------------*/
	$("#add-item-action").click(function(){

		var that = $(this);
		var parent_form = that.parents("form");

		var authenticity_token = parent_form.find("input[name=authenticity_token]").val();
		var item_category = parent_form.find("select[name='item[category]']").val();
		var item_label = parent_form.find("input[name='item[label]']").val();
		var item_memo = parent_form.find("textarea[name='item[memo]']").val();

		$.ajax({
			type: 'POST',
			url: '/account/itemcreate/',
			data: {
				"authenticity_token":authenticity_token,
				"item_category":item_category,
				"item_label":item_label,
				"item_memo":item_memo
			},
			dataType: 'text'
		}).then(
			function(res){

				viewSwitch("add-item");
				viewBackSheet();
				viewPopup("項目を登録しました");

				parent_form.find("select[name='item[category]']").val("");
				parent_form.find("input[name='item[label]']").val("");
				parent_form.find("textarea[name='item[memo]']").val("");

				var new_elem = $(".asset-category ul li").eq(0).clone();
				new_elem.find("span").text(item_label);
				new_elem.children("input[name='item[id]']").val(res);
				new_elem.children("input[name='item[category]']").val(item_category);
				new_elem.children("input[name='item[label]']").val(item_label);
				new_elem.children("input[name='item[memo]']").val(item_memo);
				
				switch( item_category ) {
					case "1":
						new_elem.appendTo(".asset-category dd ul");
						break;

					case "2":
						new_elem.appendTo(".liabilities-category dd ul");
						break;

					case "3":

						new_elem.appendTo(".capital-category dd ul");
						break;

					case "4":
						new_elem.appendTo(".income-category dd ul");
						break;

					case "5":
						new_elem.appendTo(".cost-category dd ul");
						break;
				}
				
				
			},
			function(res){

				if( res !== undefined ) {
					$("#error-item-add-text").text(res.responseText);
				} else {
					$("#error-item-add-text").text("仕訳項目の登録に失敗しました");
				}

				if( $("#error-item-add-text").css("display") !== "block" ){
					viewSwitch("error-item-add-text");
				}
			}
		);

		return false;
	});


	/* Edit Window Open
	----------------------------------------*/
	$(document).on( 'click', '.link-item-edit-window', function(){

		var that = $(this);
		var parent_li = that.parents("ul").parent("li");
		var item_id = null;
		var item_label = null;
		var item_category = null;
		var item_memo = null;

		item_id = parent_li.find("input[name='item[id]']").val();
		item_label = parent_li.find("input[name='item[label]']").val();
		item_category = parent_li.find("input[name='item[category]']").val();
		item_memo = parent_li.find("input[name='item[memo]']").val();
		
		$("#edit-item").find("input[name='item[id]']").val(item_id);
		$("#edit-item").find("select[name='item[category]']").val(item_category);
		$("#edit-item").find("input[name='item[label]']").val(item_label);
		$("#edit-item").find("textarea[name='item[memo]']").val(item_memo);

		$("#edit-menu").remove();
		
		checkEditItem(item_id);

		// 仕訳入力ウインドウのサイズ調整
		resizeEntryWindow();

		viewBackSheet();
		viewSwitch("add-entry");
		viewSwitch("edit-item");

		sumDebitNumber();
		sumCreditNumber();

		return false;
	});


	/* Item Edit Execute
	----------------------------------------*/
	$("#edit-item-action").click(function(){

		var that = $(this);
		var parent_form = that.parents("form");
		var id_elem = null;
		var parent_li_elem = null;

		var before_category = null;

		var authenticity_token = parent_form.find("input[name=authenticity_token]").val();
		var item_id = parent_form.find("input[name='item[id]']").val();
		var item_category = parent_form.find("select[name='item[category]']").val();
		var item_label = parent_form.find("input[name='item[label]']").val();
		var item_memo = parent_form.find("textarea[name='item[memo]']").val();

		$.ajax({
			type: 'POST',
			url: '/account/itemmodify/',
			data: {
				"authenticity_token":authenticity_token,
				"item_id":item_id,
				"item_category":item_category,
				"item_label":item_label,
				"item_memo":item_memo
			},
			dataType: 'text'
		}).then(
			function(res){

				viewSwitch("edit-item");
				viewBackSheet();
				viewPopup(res);

				parent_form.find("input[name='item[id]']").val("");
				parent_form.find("select[name='item[category]']").val("");
				parent_form.find("input[name='item[label]']").val("");
				parent_form.find("textarea[name='item[memo]']").val("");

				// 最新の情報へ更新
				id_elem = $("input[value=" + item_id + "][name='item[id]']");
				parent_li_elem = id_elem.parent("li");

				before_category = parent_li_elem.find("input[name='item[category]']").val();

				parent_li_elem.children("span").text(item_label);
				parent_li_elem.children("input[name='item[category]']").val(item_category);
				parent_li_elem.children("input[name='item[label]']").val(item_label);
				parent_li_elem.children("input[name='item[memo]']").val(item_memo);

				// カテゴリーが変更になった場合は、リストを移動させる				
				if( before_category !== item_category ) {
					
					switch( item_category ) {
						case "1":
							parent_li_elem.clone().appendTo(".asset-category dd ul");
							parent_li_elem.remove();
							break;

						case "2":
							parent_li_elem.clone().appendTo(".liabilities-category dd ul");
							parent_li_elem.remove();
							break;

						case "3":

							parent_li_elem.clone().appendTo(".capital-category dd ul");
							parent_li_elem.remove();
							break;

						case "4":
							parent_li_elem.clone().appendTo(".income-category dd ul");
							parent_li_elem.remove();
							break;

						case "5":
							parent_li_elem.clone().appendTo(".cost-category dd ul");
							parent_li_elem.remove();
							break;
					}
				}

			},
			function(res){
				
				if( res !== undefined ) {
					$("#error-item-edit-text").text(res.responseText);
				} else {
					$("#error-item-edit-text").text("仕訳項目の更新に失敗しました");
				}

				if( $("#error-item-edit-text").css("display") !== "block" ){
					viewSwitch("error-item-edit-text");
				}
			}
		);

		return false;
	});	


	/* Delete Item
	----------------------------------------*/
	$(document).on( 'click', '.link-item-delete-window', function(){

		var that = $(this);
		var parent_li = that.parents("ul").parent("li");
		var item_id = null;
		var delete_flag = true;

		item_id = parent_li.find("input[name='item[id]']").val();
		item_label = parent_li.find("input[name='item[label]']").val();

		$("#delete-item-label").text(item_label);
		$("#item_deleteid").val(item_id);

		$("#edit-menu").remove();

		checkDeleteItem(item_id);

		viewBackSheet();
		viewSwitch("delete-item");

		return false;
	});


	/* Item Edit Execute
	----------------------------------------*/
	$("#delete-item-action").click(function(){

		var that = $(this);
		var parent_form = that.parents("form");
		var id_elem = null;
		var parent_li_elem = null;

		var authenticity_token = parent_form.find("input[name=authenticity_token]").val();
		var item_id = parent_form.find("input[name='item[deleteid]']").val();

		$.ajax({
			type: 'POST',
			url: '/account/itemdelete/',
			data: {
				"authenticity_token":authenticity_token,
				"item_id":item_id
			},
			dataType: 'text'
		}).then(
			function(res){

				viewSwitch("delete-item");
				viewBackSheet();
				viewPopup(res);

				// 最新の情報へ更新
				id_elem = $("input[value=" + item_id + "][name='item[id]']");
				parent_li_elem = id_elem.parent("li").remove();
			},
			function(res){

				if( res !== undefined ) {
					$("#error-item-delete-text").text(res.responseText);
				} else {
					$("#error-item-delete-text").text("仕訳項目の削除に失敗しました");
				}

				if( $("#error-item-delete-text").css("display") !== "block" ){
					viewSwitch("error-item-delete-text");
				}
			}
		);

		return false;
	});


	/* Add Window Close
	----------------------------------------*/
	$(".btn-add-close-action").click(function(){

		viewSwitch("add-entry");
		viewSwitch("add-item");
		viewBackSheet();

		return false;
	});


	/* Edit Window Close
	----------------------------------------*/
	$(".btn-edit-close-action").click(function(){

		viewSwitch("add-entry");
		viewSwitch("edit-item");
		viewBackSheet();
		
		if( $("#alert-item-edit-text").css("display") !== "none" ) {
			viewSwitch("alert-item-edit-text");
		}

		if( $("#error-item-edit-text").css("display") !== "none" ) {
			viewSwitch("error-item-edit-text");
		}

		return false;
	});


	/* Delete Window Close
	----------------------------------------*/
	$(".btn-delete-close-action").click(function(){

		viewSwitch("delete-item");
		viewSwitch("delete-entry");
		viewBackSheet();

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
	$("input[name='entry[debit_number1]']").change(function(){
		sumDebitNumber();
	});
	$("input[name='entry[debit_number2]']").change(function(){
		sumDebitNumber();
	});
	$("input[name='entry[debit_number3]']").change(function(){
		sumDebitNumber();
	});
	$("input[name='entry[debit_number4]']").change(function(){
		sumDebitNumber();
	});
	$("input[name='entry[debit_number5]']").change(function(){
		sumDebitNumber();
	});


	/* Credit price
	----------------------------------------*/
	$("input[name='entry[credit_number1]']").change(function(){
		sumCreditNumber();
	});
	$("input[name='entry[credit_number2]']").change(function(){
		sumCreditNumber();
	});
	$("input[name='entry[credit_number3]']").change(function(){
		sumCreditNumber();
	});
	$("input[name='entry[credit_number4]']").change(function(){
		sumCreditNumber();
	});
	$("input[name='entry[credit_number5]']").change(function(){
		sumCreditNumber();
	});


	/* Enter Key Action
	----------------------------------------*/
	$("input[name='entry[debit_number1]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[debit_number2]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[debit_number3]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[debit_number4]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[debit_number5]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});

	$("select[name='entry[debit_item1]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[debit_item2]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[debit_item3]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[debit_item4]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[debit_item5]']").keydown(function(){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});	

	$("input[name='entry[credit_number1]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[credit_number2]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[credit_number3]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[credit_number4]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("input[name='entry[credit_number5]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});

	$("select[name='entry[credit_item1]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[credit_item2]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[credit_item3]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[credit_item4]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});
	$("select[name='entry[credit_item5]']").keydown(function(e){
		if( e.keyCode === 13 ) { submitEntry($(this)); }
	});

	// 摘要のみAltキー + Enterキー
	$("textarea[name='entry[memo]']").keydown(function(e){
		if( e.altKey && e.keyCode === 13 ) { submitEntry($(this)); }
	});



	/* Focus
	----------------------------------------*/
	$("select[name='entry[debit_item1]']").change(function(){
		$("input[name='entry[debit_number1]']").focus();
	});
	
	$("select[name='entry[credit_item1]']").change(function(){
		$("input[name='entry[credit_number1]']").focus();
	});

	$("select[name='entry[debit_item2]']").change(function(){
		$("input[name='entry[debit_number2]']").focus();
	});
	
	$("select[name='entry[credit_item2]']").change(function(){
		$("input[name='entry[credit_number2]']").focus();
	});

	$("select[name='entry[debit_item3]']").change(function(){
		$("input[name='entry[debit_number3]']").focus();
	});
	
	$("select[name='entry[credit_item3]']").change(function(){
		$("input[name='entry[credit_number3]']").focus();
	});

	$("select[name='entry[debit_item4]']").change(function(){
		$("input[name='entry[debit_number4]']").focus();
	});
	
	$("select[name='entry[credit_item4]']").change(function(){
		$("input[name='entry[credit_number4]']").focus();
	});

	$("select[name='entry[debit_item5]']").change(function(){
		$("input[name='entry[debit_number5]']").focus();
	});
	
	$("select[name='entry[credit_item5]']").change(function(){
		$("input[name='entry[credit_number5]']").focus();
	});

	$("input[name='entry[date]']").change(function(){
		$("textarea[name='entry[memo]']").focus();
	});


	sumDebitNumber();
	sumCreditNumber();
	
	resetEntryForm();
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
// 表示・非表示の切り替え (インラインブロック用)
//------------------------------------------------------------
function viewIBSwitch(elem_id) {
	
	if( $("#" + elem_id).css("display") !== "inline-block" ) {
		$("#" + elem_id).css("display","inline-block");
	} else {
		$("#" + elem_id).css("display","none");
	}
}



//------------------------------------------------------------
// 仕訳入力の借方の金額を合計
//------------------------------------------------------------
function sumDebitNumber() {

	var debit_num1 = parseInt($("input[name='entry[debit_number1]']").val());
	var debit_num2 = parseInt($("input[name='entry[debit_number2]']").val());
	var debit_num3 = parseInt($("input[name='entry[debit_number3]']").val());
	var debit_num4 = parseInt($("input[name='entry[debit_number4]']").val());
	var debit_num5 = parseInt($("input[name='entry[debit_number5]']").val());

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


//------------------------------------------------------------
// 仕訳入力の貸方の金額を合計
//------------------------------------------------------------
function sumCreditNumber() {
	
	var credit_num1 = parseInt($("input[name='entry[credit_number1]']").val());
	var credit_num2 = parseInt($("input[name='entry[credit_number2]']").val());
	var credit_num3 = parseInt($("input[name='entry[credit_number3]']").val());
	var credit_num4 = parseInt($("input[name='entry[credit_number4]']").val());
	var credit_num5 = parseInt($("input[name='entry[credit_number5]']").val());

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


//------------------------------------------------------------
// 仕訳入力の合計値チェック
//------------------------------------------------------------
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
// 仕訳項目の更新
//------------------------------------------------------------
function checkEditItem(item_id) {

	if( item_id === undefined ) {
		return false;
	}

	$.ajax({
		type: 'GET',
		url: '/account/checkedit/',
		async: false,
		data: {
			"item_id":item_id
		},
		dataType: 'text'
	}).done(
		function(res){

			if( res === 'true' ){

				$("#edit-item").find("select[name='item[category]']").prop("disabled", false);
				$("#edit-item").find("input[name='item[label]']").prop("disabled", false);

			} else {

				if( $("#alert-item-edit-text").css("display") !== "block" ) {
					viewSwitch("alert-item-edit-text");
				}

				$("#edit-item").find("select[name='item[category]']").prop("disabled", true);
				$("#edit-item").find("input[name='item[label]']").prop("disabled", true);
			}
		}
	);
}



//------------------------------------------------------------
// 仕訳項目の削除
//------------------------------------------------------------
function checkDeleteItem(item_id) {

	if( item_id === undefined ) {
		return false;
	}

	$.ajax({
		type: 'GET',
		url: '/account/checkdelete/',
		async: false,
		data: {
			"item_id":item_id
		},
		dataType: 'text'

	}).done(function(res){

		if( res === 'true' ){

			// Hide Error Message
			if( $("#error-item-delete-text").css("display") !== "none" ) {
				viewSwitch("error-item-delete-text");
			}

			// View Submit button
			if( $("#delete-item-action").css("display") !== "inline-block" ) {
				viewIBSwitch("delete-item-action");
			}

		} else {

			// View Error Message
			if( $("#error-item-delete-text").css("display") !== "block" ) {
				viewSwitch("error-item-delete-text");
			}
			
			// Hide Submit button
			if( $("#delete-item-action").css("display") !== "none" ) {
				viewIBSwitch("delete-item-action");
			}
		}

	}).fail(function(res){

		if( res !== undefined ) {
			$("#error-item-delete-text").text(res.responseText);
		} else {
			$("#error-item-delete-text").text("こちらの仕訳項目は削除することができません");
		}

		// View Error Message
		if( $("#error-item-delete-text").css("display") !== "block" ) {
			viewSwitch("error-item-delete-text");
		}
		
		// Hide Submit button
		if( $("#delete-item-action").css("display") !== "none" ) {
			viewIBSwitch("delete-item-action");
		}
	});
}



//------------------------------------------------------------
// 仕訳帳データから、テーブルを再生成する
//------------------------------------------------------------
function makeBookTable(data){
	
	$("#book-table tr").remove();

	var tr_elem = $("<tr></tr>");
	var title_elem = $('<th class="cell-top-left th-date">日付</th><th class="th-debit">借方</th><th class="th-credit">貸方</th><th class="th-receipt">領収書</th><th class="cell-top-right cell-right">摘要</th>');
	
	tr_elem.append(title_elem);
	$("#book-table").append(tr_elem);
	
	$.each( data, function( i, value){

		tr_elem = $("<tr></tr>");
		td_elem = $('<td class="cell-date">' + value.day + '日</td>');
		tr_elem.append(td_elem);
		
		// 借方
		td_elem = $('<td class="cell-debit"></td>');
		ul_elem = $('<ul></ul>');
		
		for( i=1; i<=5; i++ ) {
			
			if( value["debit"+i]["id"] !== null ) {

				li_elem = $('<li>' + value["debit"+i]["label"] +' <samp>¥' + value["debit"+i]["number"].toLocaleString() + '</samp></li>');

				input_id = $("<input>", {
					'type': 'hidden',
					'name': 'debit_id' + i,
					'value': value["debit"+i]["id"],
				});

				input_number = $("<input>", {
					'type': 'hidden',
					'name': 'debit_number' + i,
					'value': value["debit"+i]["number"],
				});

				li_elem.append(input_id);
				li_elem.append(input_number);
				ul_elem.append(li_elem);
			}
		}

		td_elem.append(ul_elem);
		tr_elem.append(td_elem);
	
		
		// 貸方
		td_elem = $('<td class="cell-credit"></td>');
		ul_elem = $('<ul></ul>');
		
		for( i=1; i<=5; i++ ) {
			
			if( value["credit"+i]["id"] !== null ) {

				li_elem = $('<li>' + value["credit"+i]["label"] +' <samp>¥' + value["credit"+i]["number"].toLocaleString() + '</samp></li>');

				input_id = $("<input>", {
					'type': 'hidden',
					'name': 'credit_id' + i,
					'value': value["credit"+i]["id"]
				});

				input_number = $("<input>", {
					'type': 'hidden',
					'name': 'credit_number' + i,
					'value': value["credit"+i]["number"]
				});

				li_elem.append(input_id);
				li_elem.append(input_number);
				ul_elem.append(li_elem);
			}
		}

		td_elem.append(ul_elem);
		tr_elem.append(td_elem);


		// 領収書
		td_elem = $('<td class="cell-receipt"></td>');
		img_elem = $('<img src="/img/common/icon-non-check.png" alt="未アップロード">');

		td_elem.append(img_elem);
		tr_elem.append(td_elem);


		// 摘要
		memo = '';
		if( value.memo !== null ) {
			memo = value.memo;
		}
			
		td_elem = $('<td class="cell-right cell-memo"><a class="link-edit" href="#"><img src="/img/common/icon-arrow-edit.png"></a>' + memo +'</td>');

		input_id = $("<input>", {
			'type': 'hidden',
			'name': 'entry_id',
			'value': value.id
		});

		input_date = $("<input>", {
			'type': 'hidden',
			'name': 'entry_date',
			'value': value.date
		});

		input_memo = $("<input>", {
			'type': 'hidden',
			'name': 'entry_memo',
			'value': value.memo
		});
		
		td_elem.append(input_id);
		td_elem.append(input_date);
		td_elem.append(input_memo);
		tr_elem.append(td_elem);

		$("#book-table").append(tr_elem);
	});	

	return false;	
}


//------------------------------------------------------------
// 空の仕訳張テーブルを生成する
//------------------------------------------------------------
function makeEmptyTable() {

	$("#book-table tr").remove();

	var tr_elem = $("<tr></tr>");
	var title_elem = $('<th class="cell-top-left th-date">日付</th><th class="th-debit">借方</th><th class="th-credit">貸方</th><th class="th-receipt">領収書</th><th class="cell-top-right cell-right">摘要</th>');
	
	tr_elem.append(title_elem);
	$("#book-table").append(tr_elem);

	tr_elem = $("<tr></tr>");
	var td_elem = $('<td class="cell-empty" colspan="5">仕訳データがありません</td>');

	tr_elem.append(td_elem);
	$("#book-table").append(tr_elem);
}


//------------------------------------------------------------
// 仕訳入力フォームのリセット
//------------------------------------------------------------
function resetEntryForm() {

	// エラーメッセージの非表示
	if( $("#error-entry-text").css("display") !== "none" ){
		viewSwitch("error-entry-text");
	}

	// 入力値を全てリセット
	$("#add-entry select").val("");
	$("#add-entry input[type=number]").val("");
	$("#add-entry input[type=file]").val("");
	$("#add-entry textarea").val("");

	// 仕訳IDをリセット
	$("#entry_editid").val("");

	// 時間パラメータが空でない時は、パラメータをセット
	var param_date = location.search;
	var split_date = null;
	var now_date = new Date();
	var select_date = new Date();
	var set_year = null;
	var set_month = null;

	if( param_date !== '' ) {

		// パラメータを分割
		split_date = param_date.split("=");

		if( split_date[1].length === 6 ) {

			set_year = split_date[1].slice( 0, 4);
			set_month = split_date[1].slice( 4, 6);

			select_date = new Date( set_year, (parseInt(set_month)-1), 1);
		}
	}

	// 日付を再設定
	if( set_year !== null && set_month !== null && ( now_date.getFullYear() !== select_date.getFullYear() || now_date.getMonth() !== select_date.getMonth() ) ) {

		// パラメータの月を設定
		$("#btn-add-date").datepicker({
			dateFormat: "yy年mm月dd日"
		});
		$("#btn-add-date").datepicker( "setDate", set_year + '年' + set_month + '月01日');

	} else {
		
		// パラメータがない場合は本日の日付をセット
		$("#btn-add-date").datepicker({
			dateFormat: "yy年mm月dd日"
		});
		$("#btn-add-date").datepicker( "setDate", 'today');
	}
}


//------------------------------------------------------------
// 仕訳の登録
//------------------------------------------------------------
function submitEntry(elem) {

	// Initialize
	var authenticity_token = '';
	var entry_id = '';
	var entry_date = '';
	var debit_item1 = '';
	var debit_item2 = '';
	var debit_item3 = '';
	var debit_item4 = '';
	var debit_item5 = '';
	var debit_number1 = '';
	var debit_number2 = '';
	var debit_number3 = '';
	var debit_number4 = '';
	var debit_number5 = '';
	var credit_item1 = '';
	var credit_item2 = '';
	var credit_item3 = '';
	var credit_item4 = '';
	var credit_item5 = '';
	var credit_number1 = '';
	var credit_number2 = '';
	var credit_number3 = '';
	var credit_number4 = '';
	var credit_number5 = '';
	var memo = '';
	var receipt1 = '';
	var receipt2 = '';
	var receipt3 = '';
	var that = elem;
	var parent_form = that.parents("form");
	
	authenticity_token = parent_form.find("input[name=authenticity_token]").val();
	view_date = $("#entry_viewdate").val();

	// 日付を取得
	entry_date = $("#btn-add-date").val();

	// 借方項目を取得
	debit_item1 = parent_form.find("select[name='entry[debit_item1]']").val();
	debit_item2 = parent_form.find("select[name='entry[debit_item2]']").val();
	debit_item3 = parent_form.find("select[name='entry[debit_item3]']").val();
	debit_item4 = parent_form.find("select[name='entry[debit_item4]']").val();
	debit_item5 = parent_form.find("select[name='entry[debit_item5]']").val();
	debit_number1 = parent_form.find("input[name='entry[debit_number1]']").val();
	debit_number2 = parent_form.find("input[name='entry[debit_number2]']").val();
	debit_number3 = parent_form.find("input[name='entry[debit_number3]']").val();
	debit_number4 = parent_form.find("input[name='entry[debit_number4]']").val();
	debit_number5 = parent_form.find("input[name='entry[debit_number5]']").val();

	// 貸方項目を取得
	credit_item1 = parent_form.find("select[name='entry[credit_item1]']").val();
	credit_item2 = parent_form.find("select[name='entry[credit_item2]']").val();
	credit_item3 = parent_form.find("select[name='entry[credit_item3]']").val();
	credit_item4 = parent_form.find("select[name='entry[credit_item4]']").val();
	credit_item5 = parent_form.find("select[name='entry[credit_item5]']").val();
	credit_number1 = parent_form.find("input[name='entry[credit_number1]']").val();
	credit_number2 = parent_form.find("input[name='entry[credit_number2]']").val();
	credit_number3 = parent_form.find("input[name='entry[credit_number3]']").val();
	credit_number4 = parent_form.find("input[name='entry[credit_number4]']").val();
	credit_number5 = parent_form.find("input[name='entry[credit_number5]']").val();

	// その他の情報を取得
	entry_id = parent_form.find("input[name='entry[editid]']").val();
	memo = parent_form.find("textarea[name='entry[memo]']").val();

	$.ajax({
		type: 'POST',
		url: '/book/entry/',
		data: {
			"authenticity_token": authenticity_token,
			"view_date": view_date,
			"entry_id": entry_id,
			"entry_date": entry_date,
			"debit_item1": debit_item1,
			"debit_item2": debit_item2,
			"debit_item3": debit_item3,
			"debit_item4": debit_item4,
			"debit_item5": debit_item5,
			"debit_number1": debit_number1,
			"debit_number2": debit_number2,
			"debit_number3": debit_number3,
			"debit_number4": debit_number4,
			"debit_number5": debit_number5,
			"credit_item1": credit_item1,
			"credit_item2": credit_item2,
			"credit_item3": credit_item3,
			"credit_item4": credit_item4,
			"credit_item5": credit_item5,
			"credit_number1": credit_number1,
			"credit_number2": credit_number2,
			"credit_number3": credit_number3,
			"credit_number4": credit_number4,
			"credit_number5": credit_number5,
			"memo": memo
		},
		dataType: 'json'
	}).then(
		function(res){

			if( 0 < res[1].length ) {
				makeBookTable(res[1]);
			} else {
				makeEmptyTable();
			}

			// フォームリセット
			resetEntryForm();
			
			// 新しいアクセストークンを設定
			parent_form.find("input[name=authenticity_token]").val(res[3]);

			viewSwitch("add-entry");
			viewBackSheet();
			viewPopup(res[2]);
		},
		function(res){

			if( res !== undefined ) {

				errors = JSON.parse(res.responseText);
				
				$.each( errors, function( i, value){

					$("#error-entry-text li").remove();

					li_elem = $("<li></li>", {
						text: '・' + value,
					});
					$("#error-entry-text").append(li_elem);
				});					

			} else {
				$("#error-entry-text").text("仕訳の登録に失敗しました");
			}

			if( $("#error-entry-text").css("display") !== "block" ){
				viewSwitch("error-entry-text");
			}

		}
	);
}



//------------------------------------------------------------
// 実行するSubmitボタンを設定
//------------------------------------------------------------
function setEnterSubmitButton( elem, btn_name) {

	$(elem).keydown(function(e){

		// Enterキー(13)の時のみ
		if( e.keyCode === 13 ) {

			var form_elem = $(this).parents("form");
			form_elem.find(btn_name).click();

			return false;
		}
	});
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


//------------------------------------------------------------
// 仕訳入力シートのサイズ変更
//------------------------------------------------------------
function resizeEntryWindow() {
	
	// 表示する横幅を取得
	var w_width = $(window).width();
	var w_height = $(window).height();

	if( w_width < 660 ) {

		$(".middle-window").css( "height", w_height + 'px');
	}
}


