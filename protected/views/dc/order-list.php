<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>我的订单</title>
<?php
include_once('head.php');
?>


</head>
<body>
	<div data-role="page" id="order-list-page" data-url='<?php echo Yii::app()->request->baseUrl."/?r=dc/list&companyId=$companyId&userName=$userName"; ?>'  data-title="我的订单">
		<div data-role="header" data-theme="b" >
		<a href="javascript:goPreOrder()" data-mini="true" data-corners="false" class="ui-btn-left">我要下单</a>
		<h1></h1>
		<a href="javascript:showItems()" data-mini="true" data-corners="false"class="ui-btn-right">查看菜单</a>
		</div>
<style type="text/css">
.order-list{
	font-weight: normal;
}
.confirm-msg{
	color: rgb(0,189,0);
}
.confirm-time{
	color:rgb(138,138,138);
}
.liContent{
	float: right;
}
</style>
<script>
function viewItem(_orderId){
	$.mobile.navigate( "?r=dc/detailItems&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>&orderId="+_orderId);
}
function showItems(){
	//$.mobile.navigate( "dc?t=showItems&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>");
	//这里只能用changePage，在page.jsp页面里绑定了pagechange事件;页面url的hash不能变，否则跳转后js不正常
	$.mobile.changePage( "?r=dc/showItems&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>",{
		 //data :{orderId:0}
		type :"post"
		,reloadPage:true
	});
}
function goPreOrder(){
	$.mobile.navigate( "?r=dc/addOrder&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>");
}

</script>
		<div data-role="content">
            <?php if(empty($orderList)){ ?>
			<ul data-role="listview" data-inset="false">
		        <li data-role="list-divider" data-theme="b">预定信息</li>
		        <li><label style="font-weight: normal;font-size: 80%">无</label></li>
		    </ul>
	    <?php }else{
            $i=0;
            foreach($orderList as $order){
	    		$isTakeOutStr = $order->isTakeOut==0?"堂食":"外送";
	    		$style="";
	    		if($i++ ==0){
	    			$style="";
	    		}else{
	    			$style="margin-top: 10px;padding-top:10px;";
	    		}
			?>
	    		<ul data-role="listview" data-inset="false" style="<?php echo $style; ?>">
			        <li data-role="list-divider" data-theme="b"><?php echo dateFormat($order->createTime); ?>&nbsp;预定信息</li>
			        <li class="order-list">
			        <span>排号:</span>
			        <span class="liContent"><?php echo $order->orderNum; ?></span>
			        </li>
			        <li class="order-list">
			        <span>订单状态:</span>
			        <span class="liContent"><?php echo OrderDealStsEnum::getDesc($order->dealSts); ?></span>
			        </li>
			        <li class="order-list">
			        <span>预定人:</span>
			        <span class="liContent"><?php echo $order->orderPersonName; ?></span>
			        </li>
			        <li class="order-list">
			        <span>联系电话:</span>
			        <span class="liContent"><?php echo $order->phone; ?></span>
			        </li>
			        <li class="order-list">
			        <span>用餐时间:</span>
			        <span class="liContent"><?php echo dateFormat($order->orderTime); ?></span>
			        </li>
			        <li class="order-list">
			        <span>用餐人数:</span>
			        <span class="liContent"><?php echo $order->orderPersonNum; ?></span>
			        </li>
			        <li class="order-list">
			        <span>用餐地点:</span>
			        <span class="liContent"><?php echo $isTakeOutStr; ?></span>
			        </li>
			        <li class="order-list">
			        <span>备注:</span>
			        <span class="liContent"><?php echo $order->orderRemark; ?></span>
			        </li>
			        <li class="order-list" onclick="viewItem('<?php echo $order->id; ?>')">
			        <span>菜单信息:</span>
			        <span class="liContent ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span>
			        </li>
			        <?php
                        if($order->dealSts!=OrderDealStsEnum::NOT_DEAL){
                    ?>
				        <li data-role="list-divider" data-theme="c">商家留言</li>
				        <li class="order-list">
				        	<h3 class="confirm-msg"><?php echo $order->companyRemark; ?></h3>
				        	<p class="confirm-time">时间：<?php echo dateFormat($order->companyDealTime); ?></p>
				        </li>
                    <?php } ?>
			    </ul>
	    	<?php
            }
	    }
	    ?>
		</div>
	</div>
</body>
</html>
<?php
function dateFormat($d){
	if($d==null){
		return"";
	}
    return date('m-d H:i', strtotime($d));
}
?>