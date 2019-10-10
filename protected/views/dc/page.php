<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DC</title>
<?php
include_once('head.php');
?>
</head>
<body>
	<div data-role="page" id="item-page" data-title="菜单" data-url='<?php echo Yii::app()->request->baseUrl."/?r=dc/showItems&companyId=$companyId&userName=$userName"; ?>'>
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/page-resources/page.css" />
		<script>
		var PAGE_COMPANY_ID="<?php echo $companyId; ?>";
		var PAGE_USER_WX_ID="<?php echo $userName; ?>";
		var PAGE_ORDER_ID="<?php echo $orderId; ?>";
		</script>
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/page-resources/page.js" charset="utf-8"></script>
		
		<div data-role="header" data-theme="b" >
		<a href="javascript:goPreOrder()" data-mini="true" data-corners="false" class="ui-btn-left">我要下单</a>
		<h1></h1>
		<a href="javascript:back2MyOrder()" data-mini="true" data-corners="false"class="ui-btn-right">我的订单</a>
		</div>
		<div data-role="content" class="pageContent">
			<div data-role="popup" id="popupDetail" data-overlay-theme="a" data-theme="c" style="width:300px;max-width:290px;" class="ui-corner-all">
				<a href="javascript:void(0)" data-rel="back" data-role="button" data-theme="c" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<div class="popupTop">
					<div class="popupImg"><img class="js_popImg" width="120"/></div>
					<div class="popupDesc"></div>
				</div>
				<fieldset class="ui-grid-a popupBottom">
				    <div class="ui-block-a" style="padding-left:4px;">
					    <input type="tel" id="orderCount" data-clear-btn="false" value="1" max="10" min="1" step="1" autofocus="autofocus">
				    </div>
				    <div class="ui-block-b hidden"><button onclick="delPreOrder()" data-theme="c">删除</button></div>
				    <div class="ui-block-c"><button onclick="addPreOrder()" data-theme="b">确定</button></div>
				</fieldset>
			</div>
			<div id="collapsible-set-id" data-role="collapsible-set" data-theme="b" data-inset="false">
			<?php

				$collapsed="true";
				$index=0;
				$ulId="";
                foreach($itemMap as $itemArr){
				$cat = $itemArr['category'];
				$itemList = $itemArr['itemList'];

                    $index++;

					if($index==2){
						$collapsed="false";
					}else{
						$collapsed="true";
					}
					$ulId="cat-ul-" . $cat->categoryId;
			?>
			    <div data-role="collapsible" data-collapsed="<?php echo $collapsed; ?>">
			        <h2><?php echo $cat->categoryName; ?></h2>
			        <ul id="<?php echo $ulId; ?>" data-role="listview" data-filter="false" data-split-icon="edit" data-icon="false">
			        <?php if($cat->categoryId==0){ ?>
						<li data-role="list-divider" data-theme="c">数量：<span class="js_totalNum">0</span><span class="ui-li-count">合计：<span class="js_totalPrice">0</span>元</span></li>
				        <li class="ui-body ui-body-b">
				            <fieldset class="ui-grid-a">
								<div class="ui-block-a"><a href="javascript:clearPreOrder()" data-role="button" data-mini="true" data-theme="c">全部清空</a></div>
								<div class="ui-block-b"><a href="javascript:submitPreOrder()" data-role="button" data-mini="true" data-theme="b">提交保存</a></div>
				            </fieldset>
				        </li>
			        	<?php
                        foreach($orderItemList as $oi){
			        	?>
			        	<li class="js_tmpLi" id="pre-order-li-<?php echo $oi->itemId; ?>">
			        		 <a href="javascript:void(0)" onclick="showDetailTmp(this)" data-id="<?php echo $oi->itemId; ?>"
			        		 	data-price="<?php echo $oi->price; ?>" data-unit="<?php echo $oi->unit; ?>">
			        		 	<img src="<?php echo $oi->img80; ?>"/>
			        		 	<h3 class="js_name"><?php echo $oi->itemName; ?></h3>
			        		 	<p class="js_desc"><?php echo $oi->itemDesc; ?></p>
			        		 	<p class="ui-li-aside"><strong class="js_price"><?php echo $oi->price; ?></strong>(<?php echo $oi->unit; ?>)</p>
			        		 </a>
			        		 <span class="ui-li-count" style="right:9px;"><?php echo $oi->count; ?></span>
			        	</li>
			        	<?php } ?>
					<?php } ?>
			
			<?php      foreach($itemList as $item){ ?>
			            <li>
			            <a href="javascript:void(0)" onclick="showDetail(this)" data-id="<?php echo $item->id; ?>" data-unit="<?php echo $item->unit; ?>">
			                <img src="<?php echo $item->img80; ?>">
			                <h3 class="js_name"><?php echo $item->itemName; ?></h3>
			                <p class="js_desc"><?php echo $item->itemDesc; ?></p>
			                <p class="ui-li-aside"><strong class="js_price"><?php echo $item->price; ?></strong>(<?php echo $item->unit; ?>)</p>
			                </a>
			            </li>
                        <?php } ?>
			            
			        </ul>
			    </div>
			<?php
				}
			?>
			</div>
		</div>
		
	</div>
</body>
</html>