<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>资源管理</title>
    <style>

        .requiredTip {
            display: inline-block;
            color: red;
            width: 8px;
        }

        .order_item {
            width: 170px;
            float: left;
        }

        .order_item div {
            float: left;
        }

        .order_item_time {
            width: 250px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#addIntoGroup").click(function () {
                $("#itemForm input[type=reset]").trigger("click");
                $(".js_resourceId").val("0");
                $(".js_t").val("addResource");
                $(".js_dialog1").show();
                $(".js_resourceNo").focus();
            });
            $(".btn_primary").click(function (e) {
                var di = $(this).attr("data-index");
                if (di == "0") {
                    $("#itemForm").submit();
                } else {
                    $(".delForm").submit();
                }
            });
            $(".btn_default").click(function (e) {
                $(".dialog_wrp").hide();
            });
            $(".pop_closed").click(function () {
                $(".dialog_wrp").hide();
            });

            //添加自定义校验规则numarr：只能英文逗号连接的数字
            jQuery.validator.addMethod("numarr", function (value, element) {
                var reg = /[^(\d|,)]/;
                return !reg.test(value);
            });

            //表单校验
            $('#itemForm').validate({
                onkeyup: false,
                //onsubmit:false,
                errorPlacement: function (e, ele) {
                    $(ele).closest("span").next().html("*");
                },
                success: function (label, ele) {
                    $(ele).closest("span").next().html("");
                },
                submitHandler: function (form) {
                    $(".mask").show();
                    form.submit();
                },
                rules: {
                    reg: {
                        required: true,
                        numarr: true
                    }
                }
            });
        });
        function delItem(itemId) {
            $(".delForm").attr("action", "?r=back/delResource");
            $(".delForm input[name=resourceId]").val(itemId);
            $(".js_dialog2").show();
        }
        function editItem(itemId) {
            $("#itemForm input[type=reset]").trigger("click");

            var rno = $(".js_list_resourceNo_" + itemId).attr("data-res");
            var rtn = $(".js_list_resourceTName_" + itemId).attr("data-res");
            var rreg = $(".js_list_resourceReg_" + itemId).attr("data-res");

            $(".js_resourceId").val(itemId);
            $(".js_resourceNo").val(rno);
            $(".js_resourceTypeName").val(rtn);
            $(".js_reg").val(rreg);

            $(".js_t").val("editResource");

            $(".js_dialog1").show();
            $(".js_resourceNo").focus();
        }
    </script>
</head>
<body class="zh_CN">

<div class="col_main user friendPage meetingFriendPage" style="padding-top:5px;">
    <div class="cLine sender_line" style="border-bottom:1px solid #d3d3d3;">
        <div class="left">
            <a id="addIntoGroup" class="btnGrayS b-dib" data-gid="">增加</a>

            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <!--
    <div class="listTitle">
        <div class="left title msg">
            <input type="checkbox" id="selectAll">全选
        </div>
        <div class="right title opt"></div>
    </div>
     -->
    <div id="userGroups">
        <ul id="listContainer" class="listContainer">
            <?php
            foreach ($resourceList as $res) {
                ?>



                <li class="listItem buddyRichInfoC">
                    <!--
                    <div class="left">
                        <input class="chooseFriend" type="checkbox" value="">
                    </div>
                     -->
                    <div class="order_item">
                        <div>桌号:&nbsp;&nbsp;</div>
                        <div class="js_list_resourceNo_<?php echo $res->id; ?>"
                             data-res="<?php echo $res->resourceNo; ?>">
                            <?php echo $res->resourceNo; ?>
                        </div>
                    </div>
                    <div class="order_item order_item_time">
                        <div>说明:&nbsp;&nbsp;</div>
                        <div class="js_list_resourceTName_<?php echo $res->id; ?>"
                             data-res="<?php echo $res->resourceTypeName; ?>">
                            <?php echo $res->resourceTypeName; ?>
                        </div>
                    </div>
                    <div class="order_item">
                        <div>可坐人数:&nbsp;&nbsp;</div>
                        <div class="js_list_resourceReg_<?php echo $res->id; ?>" data-res="<?php echo $res->reg; ?>">
                            <?php echo $res->reg; ?>
                        </div>
                    </div>


                    <div class="right listItemOpr">
                        <a class="b-dib btnGrayS js_msgSenderRemark"
                           href="javascript:editItem('<?php echo $res->id; ?>')">修改</a>
                        <a class="b-dib btnGrayS js_msgSenderRemark"
                           href="javascript:delItem('<?php echo $res->id; ?>')">删除</a>

                        <div class="clr"></div>
                    </div>
                </li>
            <?php } ?>

        </ul>
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
            <form id="itemForm" action="?r=back/addResource" method="post">
                <input type="hidden" class="js_resourceId" name="id" value="0">

                <div class="simple_dialog_content">
					<span class="frm_title">
						桌号/包厢号*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_resourceNo" type="text" name="resourceNo" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						说明*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_resourceTypeName" type="text" maxlength="20"
                            name="resourceTypeName" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						可坐人数*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_reg" type="text" name="reg"
                            placeholder="如4人桌可做1-4人，则输入：1,2,3,4" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						&nbsp;
					</span>
					<span class="" style="width:410px;vertical-align:middle;display:inline-block;"> 
					(请罗列出该桌所有可坐的人数，以英文逗号分割，系统将根据此信息自动处理订单，如包厢允许8到10人，则输入：8,9,10)
					</span>

                    <div class="requiredTip"></div>
                </div>
                <input type="reset" style="display:none;">
            </form>
        </div>

        <div class="dialog_ft">

            <a href="javascript:;" class="btn btn_primary js_btn" data-index="0">确定</a>

            <a href="javascript:;" class="btn btn_default js_btn">取消</a>

        </div>

    </div>
</div>
<div class="dialog_wrp ui-draggable js_dialog2"
     style="width: 720px; margin-left: -360px; margin-top: -178px; display:none;">
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

                        <form class="delForm" action="?r=back/delCat" method="post">
                            <input type="hidden" name="resourceId" value="">
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
<div class="dialog_wrp ui-draggable js_dialog3"
     style="width: 720px; margin-left: -360px; margin-top: -178px; display:none;">
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
<div class="mask">
    <div class="mask-img"></div>
</div>
</body>
</html>