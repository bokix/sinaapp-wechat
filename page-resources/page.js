var tmpObj = {};
function updateTmpObj(ele) {
	var _id = $(ele).attr("data-id");
	var _unit = $(ele).attr("data-unit");
	var _img = $(ele).find("img").attr("src");
	var _name = $(ele).find(".js_name").html();
	var _desc = $(ele).find(".js_desc").html();
	var _price = $(ele).find(".js_price").html();
	tmpObj = {};
	tmpObj.id = _id;
	tmpObj.unit = _unit;
	tmpObj.img = _img;
	tmpObj.name = _name;
	tmpObj.desc = _desc;
	tmpObj.price = _price;
}
function showDetailTmp(ele) {
	updateTmpObj(ele);
	var count = $(ele).next("span.ui-li-count").html();
	$("#orderCount").val(count);
	$(".js_popImg").attr("src", tmpObj.img);
	$(".popupDesc").html(tmpObj.desc);
	$("#popupDetail").find("fieldset").addClass("ui-grid-b");
	$("#popupDetail").find("div.ui-block-b").removeClass("hidden");

	$("#popupDetail").popup("open",{positionTo:"window"});
	$("#orderCount").focus().select();
}

function showDetail(ele) {
	updateTmpObj(ele);

	$("#orderCount").val(1);
	$(".js_popImg").attr("src", tmpObj.img);
	$(".popupDesc").html(tmpObj.desc);
	$("#popupDetail").find("fieldset").removeClass("ui-grid-b");
	$("#popupDetail").find("div.ui-block-b").addClass("hidden");

	$("#popupDetail").popup("open",{positionTo:"window"});
	$("#orderCount").focus().select();
}
// 添加到预定
function addPreOrder() {
	var orderCount = 1;
	try {
		var s = $("#orderCount").val();
		orderCount = parseInt(s);
		if (orderCount == 0) {
			// 如果数量是0，则直接返回.
			$("#popupDetail").popup("close");
			return;
		}
	} catch (e) {
		$("#popupDetail").popup("close");
		return;
	}
	var liid = "pre-order-li-" + tmpObj.id;
	var $li = $("#" + liid);
	if ($li.length < 1) {
		// 如果该项还没添加过，则添加
		var a = "<a href=\"javascript:void(0)\" onclick=\"showDetailTmp(this)\" data-id=\""
				+ tmpObj.id
				+ "\" data-price=\""
				+ tmpObj.price
				+ "\" data-unit=\"" + tmpObj.unit + "\"></a>";
		var img = "<img src=\"" + tmpObj.img + "\">";
		var h3 = "<h3>" + tmpObj.name + "</h3>";
		var p1 = "<p>" + tmpObj.desc + "</p>";
		var p2 = "<p class=\"ui-li-aside\"><strong>" + tmpObj.price
				+ "</strong>(" + tmpObj.unit + ")</p>";
		var num = "<span class=\"ui-li-count\" style=\"right:9px;\">"
				+ orderCount + "</span>";
		$li = $("<li class=\"js_tmpLi\" id=\"" + liid + "\" />").append(
				$(a).append(img).append(h3).append(p1).append(p2)).append(num);
		$("#cat-ul-0").append($li);
	} else {
		// 如果已经添加过，则更新数量
		// var oldNum = parseInt($li.find(".ui-li-count").html());
		$li.find("span.ui-li-count").html(orderCount);
	}
	// 更新数量和合计
	updatePriceAndCount();

	$("#cat-ul-0").listview("refresh");
	$("#popupDetail").popup("close");
}
function delPreOrder() {
	var liid = "pre-order-li-" + tmpObj.id;
	var $li = $("#" + liid);
	$li.remove();
	updatePriceAndCount();
	$("#popupDetail").popup("close");
}
// 全部清空
function clearPreOrder() {
	$(".js_tmpLi").remove();
	$(".js_totalPrice").html("0");
	$(".js_totalNum").html("0");
}
function submitPreOrder(){
	var _ids="";
	var _counts="";
	$(".js_tmpLi").each(function(index,ele){
		var id=$(this).find("a").attr("data-id");
		var count=$(this).find("span.ui-li-count").html();
		_ids+=id+",";
		_counts+=count+",";
	});
	$.mobile.changePage("?r=dc/saveItems",{
		data :{
			t:"saveItems",
			ids:_ids,
			counts:_counts,
			orderId:PAGE_ORDER_ID,
			companyId:PAGE_COMPANY_ID,
			userName:PAGE_USER_WX_ID
		},
		type:"post",
		changeHash:false
	});
}
function back2MyOrder(){
	var url = "?r=dc/list&companyId="+PAGE_COMPANY_ID+"&userName="+PAGE_USER_WX_ID;
	//$.mobile.navigate( url );
	$.mobile.changePage( url,{reloadPage:true,data :{t:"list",companyId:PAGE_COMPANY_ID,userName:PAGE_USER_WX_ID},type:"post"});
}
function goPreOrder(){
	var url = "?r=dc/addOrder&companyId="+PAGE_COMPANY_ID+"&userName="+PAGE_USER_WX_ID;
	$.mobile.navigate( url );
}
