<?php
//格式化时间
function d($time){
    return date('m-d H:i',strtotime($time));
}
?>
<style>
.iconEditInput {
	margin-left: 20px;
	width: 140px;
}

.groupEdit {
	display: none;
}
.order_item{
	width:170px;
	float: left;
}
.order_item div{
	float:left;
}
.order_item_time{
	width:220px;
}
</style>
<script type="text/javascript">
	function refuse(itemId){
		$(".delForm").attr("action","?r=back/refuseOrder");
		$(".delForm input[name=orderId]").val(itemId);
		$(".delForm").submit();
	}
	function confirm(id){
		$(".delForm").attr("action","?r=back/confirmOrder");
		$(".delForm input[name=orderId]").val(itemId);
		$(".delForm").submit();
	}
</script>

				<div class="col_main user friendPage meetingFriendPage">
<!-- 					<div class="cLine sender_line"> -->
<!-- 						<div class="left"> -->
<!-- 							<a id="addIntoGroup" class="btnGrayS b-dib" data-gid="">增加</a> -->
<!-- 							<div class="clr"></div> -->
<!-- 						</div> -->
<!-- 						<div class="clr"></div> -->
<!-- 					</div> -->
<!-- 					<div class="listTitle"> -->
<!-- 						<div class="left title msg"> -->
<!-- 							<input type="checkbox" id="selectAll">全选 -->
<!-- 						</div> -->
<!-- 						<div class="right title opt"></div> -->
<!-- 					</div> -->
					<div id="userGroups">
						<ul id="listContainer" class="listContainer">
<?php
foreach($orderArr as $order){
?>



							<li class="listItem buddyRichInfoC">
<!-- 								<div class="left order_num"> -->
<!--  									<input class="chooseFriend" type="checkbox" value=""> -->
<!-- 								</div> -->
								<div class="order_item order_item_time"><div>用餐时间:</div><div><?php echo d($order->orderTime); ?></div></div>
								<div class="order_item"><div>预订人:</div><div><?php echo $order->orderPersonName; ?></div></div>
								<div class="order_item"><div>用餐人数:</div><div><?php echo $order->orderPersonNum; ?></div></div>
								<div class="order_item"><div>处理意见:</div><div><?php echo $order->companyRemark; ?></div></div>
								<div class="order_item"><div>处理状态:</div><div><?php echo $order->dealSts; ?></div></div>

<!-- 								<div class="right listItemOpr"> -->
<!-- 									<a class="b-dib btnGrayS js_msgSenderRemark"  -->
<!-- 									href="javascript:confirm('<?php echo $order->id; ?>')">确认</a> --%>
<!-- 									<a class="b-dib btnGrayS js_msgSenderRemark"  -->
<!-- 									href="javascript:refuse('<?php echo $order->id; ?>')">拒绝</a> --%>
<!-- 									<div class="clr"></div> -->
<!-- 								</div> -->
							</li>
<?php
}
?>

						</ul>
					</div>
				</div>
			</div>

<div class="dialog_wrp simple js_dialog1"
		style="width: 726px; display: none; margin-left: -363px; margin-top: -220.5px;">
		<div class="dialog">
			<div class="dialog_hd">
				<h3>增加资源</h3>
				<a href="javascript:void(0);" class="icon16_opr closed pop_closed">关闭</a>
			</div>
			<div class="dialog_bd">
				<form id="itemForm" action="back" method="post">
				<input type="hidden" name="_t" value="addResource">
				<div class="simple_dialog_content">
					<span class="frm_title">
						桌号/包厢名
					</span>
					<span class="frm_input_box"> <input
						class="frm_input js_input" type="text" name="resourceNo">
					</span>
				</div>
				<div class="simple_dialog_content">
					<span class="frm_title">
						描述信息
					</span>
					<span class="frm_input_box"> <input
						class="frm_input js_input" type="text" maxlength="20" name="resourceTypeName">
					</span>
				</div>
				<div class="simple_dialog_content">
					<span class="frm_title">
						正则表达式
					</span>
					<span class="frm_input_box"> <input
						class="frm_input js_input" type="text" name="reg">
					</span>
				</div>
				</form>
			</div>

			<div class="dialog_ft">

				<a href="javascript:;" class="btn btn_primary js_btn" data-index="0">确定</a>

				<a href="javascript:;" class="btn btn_default js_btn">取消</a>

			</div>

		</div>
	</div>
<div class="dialog_wrp ui-draggable js_dialog2" style="width: 720px; margin-left: -360px; margin-top: -178px; display:none;">
  <div class="dialog" id="wxDialog_1">
    <div class="dialog_hd">
      <h3>温馨提示</h3>
      <a href="javascript:;" class="pop_closed">关闭</a>
    </div>
    <div class="dialog_bd">
      <div class="page_msg simple default ">
        <div class="inner group">
          <span class="msg_icon_wrapper"><i class="icon_msg warn "></i></span>
          <div class="msg_content ">
          <h4>确认删除</h4>
          <p>是否确定删除？</p>
          <form class="delForm" action="back?_t=delCat" method="post">
			  <input type="hidden" name="orderId" value="">
     	  </form>
          </div>
        </div>
      </div>
    </div> 
    <div class="dialog_ft">
      <a href="javascript:;" class="btn btn_primary js_btn" data-index="1">确定</a>
      <a href="javascript:;" class="btn btn_default js_btn">取消</a>
    </div>
  </div>
</div>
<div class="dialog_wrp ui-draggable js_dialog3" style="width: 720px; margin-left: -360px; margin-top: -178px; display:none;">
  <div class="dialog" id="wxDialog_1">
    <div class="dialog_hd">
      <h3>温馨提示</h3>
      <a href="javascript:;" class="pop_closed">关闭</a>
    </div>
    <div class="dialog_bd">
      <div class="page_msg simple default ">
        <div class="inner group">
          <span class="msg_icon_wrapper"><i class="icon_msg error"></i></span>
          <div class="msg_content ">
          <h4 class="js_errorMsgTitle">无法删除</h4>
          <p class="js_errorMsg">该分类下还有内容项，无法删除。请先删除内容或移至其他分类后再尝试操作。</p>
          </div>
        </div>
      </div>
    </div> 
    <div class="dialog_ft">
      <a href="javascript:;" class="btn btn_default js_btn">取消</a>
    </div>
  </div>
</div>
