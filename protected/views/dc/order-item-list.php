<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>菜单详情</title>

    <?php
    include_once('head.php');
    ?>
</head>
<body>
	<div data-role="page" id="order-list-page" data-url="<?php echo Yii::app()->request->baseUrl; ?>/?r=dc/detailItems&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>&orderId=<?php echo $orderId; ?>"  data-title="菜单详情">
		<div data-role="header" data-theme="b" >
		<a href="javascript:back2MyOrder()" data-mini="true" data-corners="false" class="ui-btn-left">返回</a>
		<h1></h1>
		<a href="javascript:editItem('<?php echo $orderId; ?>')" data-mini="true" data-corners="false" class="ui-btn-right">修改</a>
		</div>
<style type="text/css">
.order-list{
	font-weight: normal;
}
.liContent{
	float: right;
}
</style>
<script>
function back2MyOrder(){
	//$.mobile.changePage( "dc",{data :{t:"list",companyId:"<?php echo $companyId; ?>",userName:"<?php echo $userName; ?>"},type:"post"});
	$.mobile.navigate( "?r=dc/list&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>");
}
function editItem(_orderId){
	//这里只能用changePage，在page.jsp页面里绑定了pagechange事件;页面url的hash不能变，否则跳转后js不正常
	$.mobile.changePage( "?r=dc/showItems&orderId="+_orderId+"&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>",{
		 data :{orderId:_orderId}
		,type :"post"
		,reloadPage:true
	});
}
</script>	
		<div data-role="content">
	   		<ul data-role="listview" data-inset="false">
		        <li data-role="list-divider" data-theme="c">数量：<span><?php echo $count; ?></span><span class="ui-li-count">合计：<span><?php echo $totalPrice; ?></span>元</span></li>
	    	<?php
                foreach($orderItemList as $oi){
			?>
    			<li class="order-list">
		        <span><?php echo $oi->itemName; ?></span>
		        <span class="liContent"><?php echo $oi->price; ?>&nbsp;x&nbsp;<?php echo $oi->count; ?></span>
		        </li>
	    	<?php } ?>
			</ul>
		</div>
	</div>
</body>
</html>
