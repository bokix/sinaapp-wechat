<?php
$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
if(stripos($agent,'micromessenger')<0){
	//response.sendError(HttpServletResponse.SC_SERVICE_UNAVAILABLE);

}
?>

<link rel="stylesheet" href="http://lib.sinaapp.com/js/jquery-mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<link rel="stylesheet" href="http://lib.sinaapp.com/js/jquery-mobile/1.3.1/jquery.mobile.structure-1.3.1.min.css" />
<!-- <link rel="stylesheet" href="themes/default/jquery.mobile-1.3.2.min.css" /> -->
<!-- <link rel="stylesheet" href="themes/jquery.mobile.structure-1.3.2.min.css" /> -->
<!-- <script src="jslib/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script> -->
<!-- <script src="jslib/jquery.mobile-1.3.2.min.js" type="text/javascript" charset="utf-8"></script> -->
<script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
<script src="http://lib.sinaapp.com/js/jquery-mobile/1.3.1/jquery.mobile-1.3.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/util.js" type="text/javascript" charset="utf-8"></script>
<script>
try{
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	WeixinJSBridge.call('hideOptionMenu');
	});
}catch(e){}
try{
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	WeixinJSBridge.call('hideToolbar');
	});
}catch(e){}
var contextPath="<%=request.getContextPath()%>";

//所有jquery mobile页面，即手机端的页面绑定的事件
$(document).on("pagechange",function(event,obj){
	var pageId = obj.toPage[0].id;
	
	console.dir("page change.page Id:" + pageId);
	
	if("pre-order-page-confirm"==pageId){
		return addPageInit();
	}else if("item-page"==pageId){
		return updatePriceAndCount();
	}
});
function addPageInit(){
	console.dir("addPageInit...");
	var orderPersonName = Util.get('orderPersonName');
	if(orderPersonName!=null&&orderPersonName.length>0){
		$("#name2").val(orderPersonName);
	}

	var phone = Util.get('phone');
	if(phone!=null){
		var arr = phone.split(",");
		$("#tel-2").val(arr[arr.length-1]);
	}
	try{
		var d = new Date();//.Format("yyyy-MM-ddThh:mm");
		d.setMinutes(d.getMinutes()+30);
		var dd = d.Format("yyyy-MM-ddThh:mm");
		$("#datetime-4").val(dd);
	}catch(e){}
	
}
function updatePriceAndCount(){
	// 更新暂存菜单的数量和合计金额
	console.dir("updatePriceAndCount...");
	
		var count = 0;
		var totalPrice = 0;
		
		$(".js_tmpLi").each(function(index, ele) {
			var c = parseInt($(this).find("span.ui-li-count").html());
			var p = parseFloat($(this).find("a").attr("data-price"));
			count += c;
			totalPrice += c * p;
		});

		$(".js_totalPrice").html(totalPrice);
		$(".js_totalNum").html(count);
}
</script>
