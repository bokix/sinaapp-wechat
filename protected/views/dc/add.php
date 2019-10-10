<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DC</title>
<?php include_once('head.php'); ?>
</head>
<body>
<div data-role="page" id="pre-order-page-confirm" data-title="我的预定">
		<div data-role="header" data-theme="b" >
		<a href="javascript:back2MyOrder()" data-mini="true" data-corners="false" class="ui-btn-left">我的订单</a>
		<h1></h1>
		<a href="javascript:showItems()" data-mini="true" data-corners="false"class="ui-btn-right">查看菜单</a>
		</div>
<div data-role="content">
<script>


	function submitPreOrder(){
		var b = $("#preOrderForm").valid();
		if(!b){
			return;
		}
		save2Localstorage();

		$.mobile.changePage("?r=dc/saveOrder",{
				data :$("#preOrderForm").serialize(),
				type:"post",
				changeHash:false
			});
	}
	function save2Localstorage(){
		var p = Util.get('phone');
		var phone = $("#tel-2").val();
		var arr=[];
		if(p!=null){
			arr = p.split(",");
		}
		if(jQuery.inArray(phone, arr)<0){
			arr.push(phone);
			if(arr.length>5){
				arr.shift();//删除第一个元素,保证数组大小为5
			}
			Util.set('phone',arr.join());
		}
		var orderPersonName = $("#name2").val();
		Util.set('orderPersonName',orderPersonName);
	}
	function back2MyOrder(){
		//$.mobile.changePage( "dc",{data :{t:"list",companyId:"<?php echo $companyId; ?>",userName:"<?php echo $userName; ?>"},type:"post"});
		$.mobile.navigate( "?r=dc/list&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>");
	}
	function showItems(){
		//$.mobile.navigate( "dc?t=showItems&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>");
		//这里只能用changePage，在page.jsp页面里绑定了pagechange事件;页面url的hash不能变，否则跳转后js不正常
		$.mobile.changePage( "?r=dc/showItems&companyId=<?php echo $companyId; ?>&userName=<?php echo $userName; ?>",{
			 data :{orderId:0}
			,type :"post"
			,reloadPage:true
		});
	}
		//添加自定义校验规则
		jQuery.validator.addMethod("dateValidate", function(value, element) {
			var day = new Date(value.replace("T"," ","gi"));
			var currentTime = new Date();
			console.dir("value:" + value);
			console.dir("day:" + day);
			console.dir("currentTime:" + currentTime);
			if(currentTime > day){
				//console.dir("currentTime > day");
				return false;
			}else{
				//console.dir("currentTime <= day");
				return true;
			}
		});
		$('#preOrderForm').validate({
			onkeyup: false,
			onsubmit:false,
			errorPlacement : function(e,ele) {
				$(ele).closest('div').addClass('error');
			},
			success:function(label,ele){
				$(ele).closest('div').removeClass('error');
				
			},
			rules:{
				orderTime:{
					required:true,
					dateValidate:true
				}
			}
		});
</script>
<style>
.error{
    border-color: #b94a48;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075)
}
</style>
<form id="preOrderForm">
<input type="hidden" name="t" value="saveOrder">
<input type="hidden" name="companyId" value="<?php echo $companyId; ?>">
<input type="hidden" name="orderPersonWXId" value="<?php echo $userName; ?>">
    <ul data-role="listview" data-inset="false">
    	<li data-role="list-divider" data-theme="b">预定信息</li>
        <li data-role="fieldcontain">
            <label for="name2">预定人*:</label>
            <input type="text" name="name" id="name2" minlength="2" maxlength="7" value="" data-clear-btn="true" required >
        </li>
        <li data-role="fieldcontain">
            <label for="tel-2">联系电话*:</label>
     		<input type="tel" data-clear-btn="true" name="phone" id="tel-2" value="" required>
        </li>
        <li data-role="fieldcontain">
            <label for="datetime-4">用餐时间*:</label>
    		<input type="datetime-local" data-clear-btn="true" name="orderTime" id="datetime-4" value="" required>
        </li>
        <li data-role="fieldcontain">
        	<label for="slider">用餐人数*:</label>
			<input type="range" name="num" id="slider" value="4" min="1" max="20" required>
        </li>
        <li data-role="fieldcontain">
           <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
			    <legend>用餐地点:</legend>
			        <input type="radio" name="isTakeOut" id="radio-choice-c" value="0" checked="checked">
			        <label for="radio-choice-c">堂食</label>
			        <input type="radio" name="isTakeOut" id="radio-choice-d" value="1">
			        <label for="radio-choice-d">外送</label>
			</fieldset>
        </li>
        <li data-role="fieldcontain">
            <label for="textarea2">备注:</label>
        <textarea cols="40" rows="16" name="remark" id="textarea2"></textarea>
        </li>
    	<li data-role="list-divider" data-theme="c">预定说明</li>
        <li>
            <label style="font-weight: normal;font-size: 90%">
            1.提交预定信息后，以商家处理结果为准。<br/>
            2.已经经过商家确认的预定信息，请在预订时间之前及时就餐，超过预定时间的，商家有权取消预订而不通知预订者。<br/>
            3.商家保留关于此系统产生的一切问题的解释权。<br/>
            </label>
        </li>
        <li>
			<div class="ui-grid-solo">
			    <div class="ui-block-a"><button type="button" data-mini="true" data-theme="b" onclick="submitPreOrder()">提交订单</button></div>
			</div>
        </li>
    </ul>
</form>
</div>
</div>	

</body>
</html>