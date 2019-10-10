<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>菜单管理</title>

<style>
    .iconEditInput {
        margin-left: 20px;
        width: 140px;
    }

    .groupEdit {
        display: none;
    }

    .requiredTip {
        display: inline-block;
        color: red;
        width: 8px;
    }

    .price, .price:hover {
        margin-left: 250px;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: normal;
        text-decoration: none;
        cursor: default;
    }

    .itemdesc, .itemdesc:hover {
        display: block;
        float: left;
        width: 350px;
        position: absolute;
        margin-left: 68px;
        max-width: 350px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-wrap: normal;
        text-decoration: none;
        cursor: default;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $(".js_groupList").hover(function () {
            var s = $(this).find(".groupInputArea").css("display");
            if (s != "none") {
                return;
            }
            var $a = $(this).find("a.icon18");
            $a.show();
        }, function () {
            var s = $(this).find(".groupInputArea").css("display");
            if (s != "none") {
                return;
            }
            var $a = $(this).find("a.icon18");
            $a.hide();
        });
        $(".iconAdd").click(function () {
            $(".groupEdit").show();
            $(".groupInputArea").hide().siblings(".title").show();
            $(".iconEditInput").focus();
        });
        $("#addIntoGroup").click(function () {
            $(".js_dialog1").show();
            $(".frm_input_box input[name=name]").focus();
        });
        $(".btn_primary").click(function (e) {
            var di = $(this).attr("data-index");
            if (di == "0") {
                $("#itemForm").submit();
            } else if (di == "1") {
                $(".delForm").submit();
            } else if (di == "2") {
                $("#editForm").submit();
            }
        });
        $(".btn_default").click(function (e) {
            $(".dialog_wrp").hide();
        });
        $(".pop_closed").click(function () {
            $(".dialog_wrp").hide();
        });
        $(".js_iconDel").click(function () {
            var gid = $(this).attr("data-gid");
            var gnum = $(this).attr("data-gnum");//该分类下有多少items
            if (gnum > 0) {
                $(".js_errorMsg").html("该分类下还有内容项，无法删除。请先删除内容或移至其他分类后再尝试操作。");
                $(".js_dialog3").show();
                return;
            } else {
                var catArrLength = <?php echo count($itemMap); ?>;
                if (catArrLength <= 1) {
                    $(".js_errorMsg").html("请至少保留一个分类。");
                    $(".js_dialog3").show();
                    return;
                } else {
                    $(".delForm input[name=categoryId]").val(gid);
                    $(".js_dialog2").show();
                }
            }
        });
        $(".js_iconEdit").click(function () {
            var gid = $(this).attr("data-gid");
            $(".groupInputArea").hide().siblings(".title").show();
            $(".js_iconEditInput" + gid).show().siblings().hide();
            $(".js_iconEditInput" + gid).find("input").focus();

        });

        //编辑
        $(".groupInput").focusout(function (eo) {
            var v = $(this).val().trim();
            var gid = $(this).attr("data-gid");
            var gname = $(this).attr("data-gname");
            if (v != "" && v != gname) {
                $(".iconForm").attr("action", "?r=back/editCat");
                $(".iconForm").find("input[name=gid]").val(gid);
                $(".iconEditInput").val(v);
                $(".iconForm").submit();
            } else {
                $(this).val(gname);
                $(".groupInputArea").hide().siblings(".title").show();
            }
        });
        //新增
        $(".iconEditInput").focusout(function () {
            var v = $(".iconEditInput").val().trim();
            if (v != "") {
                $(".iconForm").attr("action", "?r=back/addCat");
                $(".iconForm").submit();
            } else {
                $(".iconEditInput").val("");
                $(".groupEdit").hide();
            }
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
                $(".js_dialog1").hide();
                $(".mask").show();
                form.submit();
            },
            rules: {
                price: {
                    required: true,
                    number: true
                }
            }
        });
        $('#editForm').validate({
            onkeyup: false,
            //onsubmit:false,
            errorPlacement: function (e, ele) {
                $(ele).closest("span").next().html("*");
            },
            success: function (label, ele) {
                $(ele).closest("span").next().html("");
            },
            rules: {
                price: {
                    required: true,
                    number: true
                }
            }
        });
    });
    function editItem(itemId) {
        $("#editForm input[type=reset]").trigger("click");

        var name = $(".js_list_name_" + itemId).attr("data-value");
        var desc = $(".js_list_desc_" + itemId).attr("data-value");
        var price = $(".js_list_price_" + itemId).attr("data-value");
        var unit = $(".js_list_price_" + itemId).attr("data-value2");

        $(".js_edit_itemId").val(itemId);
        $(".js_edit_name").val(name);
        $(".js_edit_desc").val(desc);
        $(".js_edit_price").val(price);
        $(".js_edit_unit").val(unit);

        $(".js_dialog4").show();
        $(".js_edit_name").focus();
    }
    function delItem(itemId) {
        $(".delForm").attr("action", "?r=back/delItem");
        $(".delForm input[name=itemId]").val(itemId);
        $(".js_dialog2").show();
    }
    function showDropDownItem(itemId) {
        var cls = ".js_singleDropdownList" + itemId;
        $(cls).toggle().mouseleave(function () {
            $(this).hide();
        });
    }
    function changeCat(itemId, newCatId) {
        var oldCatId = $("#selectArea" + itemId).attr("data-cid");
        if (oldCatId == newCatId) {
            return;
        }
        $(".iconForm").attr("action", "?r=back/changeCat");
        var itemHtml = "<input type='hidden' name='itemId' value='" + itemId + "'>";
        $(".iconForm").append(itemHtml);
        $(".iconForm").find("input[name=gid]").val(newCatId);
        $(".iconForm").submit();
    }
</script>
</head>
<body class="zh_CN">
<div class="col_side l">
    <div class="catalogList" id="groupsList">
        <ul>
            <?php
            $list = array();
            foreach ($itemMap as $arr) {
                $selected = "";
                $cat = $arr['category'];
                if ($defaultCategoryId == $cat->categoryId) {
                    $list = $arr['itemList'];
                    $selected = "selected";
                }
                ?>
                <li class="group <?php echo $selected; ?> js_groupList">
                    <a class="title"
                       href="?r=back/item&categoryId=<?php echo $cat->categoryId; ?>"><?php echo $cat->categoryName; ?>
                        (<?php echo count($arr['itemList']); ?>)</a>
		<span class="groupInputArea  js_iconEditInput<?php echo $cat->categoryId; ?>">
	    	<input type="text" value="<?php echo $cat->categoryName; ?>"
                   class="groupInput" data-gid="<?php echo $cat->categoryId; ?>"
                   data-gname="<?php echo $cat->categoryName; ?>"
                   data-gnum="<?php echo count($arr['itemList']); ?>" id="groupInput<?php echo $cat->categoryId; ?>">
	    </span>
                    <a title="删除" data-gid="<?php echo $cat->categoryId; ?>"
                       data-gnum="<?php echo count($arr['itemList']); ?>" href="javascript:;"
                       class="icon18 iconDel js_iconDel"></a>
                    <a title="编辑" data-gid="<?php echo $cat->categoryId; ?>" href="javascript:;"
                       class="icon18 iconEdit js_iconEdit"></a>
                </li>
            <?php } ?>

        </ul>
        <ul>
            <li class="groupEdit">
                <form class="iconForm" method="post" action="?r=back/addCat">
                    <input type="text" class="iconEditInput" name="categoryName">
                    <input type="hidden" name="categoryId" value="<?php echo $defaultCategoryId; ?>">
                    <input type="hidden" name="gid" value="">
                </form>
            </li>
            <li id="groupAdd" class="group groupAdd"><a
                    class="icon18C iconAdd" href="javascript:;">新建分类</a></li>
            <li id="friendSearch" class="selected  none"><span>搜索结果</span>
            </li>
        </ul>
    </div>
</div>
<div class="col_main user friendPage meetingFriendPage" style="padding-top:5px;">
    <div class="cLine sender_line" style="border-bottom:1px solid #d3d3d3;">
        <div class="left">
            <!--
                批量分组
                <div id="allGroup" class="selectArea b-dib dropdown_menu">
                    <a href="javascript:;" class="btn dropdown_switch jsDropdownBt"><label
                        class="jsBtLabel">未分组</label><i class="arrow"></i></a>
                    <ul class="dropdown_data_list jsDropdownList"
                        style="display: none;">


                        <li class="dropdown_data_item"><a href="javascript:;"
                            class="jsDropdownItem" data-value="0" data-name="未分组">未分组</a></li>

                        <li class="dropdown_data_item"><a href="javascript:;"
                            class="jsDropdownItem" data-value="1" data-name="黑名单">黑名单</a></li>

                        <li class="dropdown_data_item"><a href="javascript:;"
                            class="jsDropdownItem" data-value="2" data-name="星标组">星标组</a></li>


                    </ul>
                </div>
                <a id="putIntoGroupAll" class="btnGrayS b-dib" data-gid="">放入</a>
             -->
            <a id="addIntoGroup" class="btnGrayS b-dib" data-gid="">增加</a>

            <div class="clr"></div>
        </div>
        <!--  div class="right js_pageNavigator">
            <div class="pagination" id="wxPagebar_1379405800808">
                <span class="nav_area"> <a href="javascript:void(0);"
                    class="btn page_first dn"></a> <a href="javascript:void(0);"
                    class="btn page_prev dn"><i class="arrow"></i>上页</a> <span
                    class="page_num"> <label>1</label> <span class="num_gap">/</span>
                        <label>2</label>
                </span> <a href="javascript:void(0);" class="btn page_next"><i
                        class="arrow"></i>下页</a> <a href="javascript:void(0);"
                    class="btn page_last dn"></a>
                </span> <span class="goto_area"> <input type="text"> <a
                    href="javascript:void(0);" class="btn page_go">跳转</a>
                </span>
            </div>
        </div-->
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
            foreach ($list as $item) {
                ?>



                <li class="listItem buddyRichInfoC">
                    <!--
                    <div class="left">
                        <input class="chooseFriend" type="checkbox" value="">
                    </div>
                     -->
                    <a class="msgSenderAvatar left" style="margin-left:0"> <img height="48" width="48"
                                                                                src="<?php echo $item->img80; ?>"
                                                                                class="avatar left js_msgSenderAvatar">
                    </a>
                    <a class="msgSender f16 c-l b left js_list_name_<?php echo $item->id; ?>" style="width:100px;"
                       data-value="<?php echo $item->itemName; ?>"><?php echo $item->itemName; ?></a>
                    <a class="f12 c-l price js_list_price_<?php echo $item->id; ?>"
                       data-value="<?php echo $item->price; ?>"
                       data-value2="<?php echo $item->unit; ?>">单价：<?php echo $item->price; ?>
                        &nbsp;&nbsp;(<?php echo $item->unit; ?>)</a>


                    <div class="right listItemOpr">
                        <div id="selectArea<?php echo $item->id; ?>"
                             class="selectArea b-dib js_selectArea dropdown_menu"
                             data-fid="<?php echo $item->id; ?>" data-cid="<?php echo $item->categoryId; ?>">
                            <a href="javascript:showDropDownItem('<?php echo $item->id; ?>');"
                               class="btn dropdown_switch jsDropdownBt"><label
                                    class="jsBtLabel">分类选择</label><i class="arrow"></i></a>
                            <ul class="dropdown_data_list jsDropdownList js_singleDropdownList<?php echo $item->id; ?>"
                                style="display: none;">
                                <?php
                                foreach ($itemMap as $catArr) {
                                    $cat = $catArr['category'];
                                    ?>
                                    <li class="dropdown_data_item"><a
                                            href="javascript:changeCat('<?php echo $item->id; ?>','<?php echo $cat->categoryId; ?>');"
                                            class="jsDropdownItem"><?php echo $cat->categoryName; ?></a></li>

                                <?php } ?>

                            </ul>
                        </div>
                        <a class="b-dib btnGrayS js_msgSenderRemark"
                           href="javascript:editItem('<?php echo $item->id; ?>')">修改</a>
                        <a class="b-dib btnGrayS js_msgSenderRemark"
                           href="javascript:delItem('<?php echo $item->id; ?>')">删除</a>

                        <div class="clr"></div>
                    </div>
                    <a class="f14 c-l itemdesc js_list_desc_<?php echo $item->id; ?>"
                       data-value="<?php echo $item->itemDesc; ?>"><?php echo $item->itemDesc; ?></a>
                </li>
            <?php } ?>

        </ul>
    </div>
    <!--  div class="cLine sender_line">
        <div class="right js_pageNavigator">
            <div class="pagination" id="wxPagebar_1379405800808">
                <span class="nav_area"> <a href="javascript:void(0);"
                    class="btn page_first dn"></a> <a href="javascript:void(0);"
                    class="btn page_prev dn"><i class="arrow"></i>上页</a> <span
                    class="page_num"> <label>1</label> <span class="num_gap">/</span>
                        <label>2</label>
                </span> <a href="javascript:void(0);" class="btn page_next"><i
                        class="arrow"></i>下页</a> <a href="javascript:void(0);"
                    class="btn page_last dn"></a>
                </span> <span class="goto_area"> <input type="text"> <a
                    href="javascript:void(0);" class="btn page_go">跳转</a>
                </span>
            </div>
        </div>
    </div-->
</div>

<div class="dialog_wrp simple js_dialog1"
     style="width: 726px; display: none; margin-left: -363px; margin-top: -220.5px;">
    <div class="dialog">
        <div class="dialog_hd">
            <h3>增加菜品</h3>
            <a href="javascript:void(0);" class="icon16_opr closed pop_closed">关闭</a>
        </div>
        <div class="dialog_bd">
            <form id="itemForm" action="?r=back/addItem" method="post" enctype="multipart/form-data">
                <input type="hidden" name="categoryId" value="<?php echo $defaultCategoryId; ?>">

                <div class="simple_dialog_content">
					<span class="frm_title">
						菜品名称*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input" type="text" name="name" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						描述信息*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input" type="text" name="desc" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						价格*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input" type="text" name="price" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						计价单位*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input" type="text" value="份" name="unit" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						图片*:
					</span>
					<span class="frm_input_box"> 
					<input
                        class="" type="file" name="img80" required accept="image/*">
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						&nbsp;
					</span>
					<span class="" style="width:410px;vertical-align:middle;display:inline-block;"> 
					(图片请勿超过1M)
					</span>

                    <div class="requiredTip"></div>
                </div>
            </form>
        </div>

        <div class="dialog_ft js_addForm">

            <a href="javascript:;" class="btn btn_primary js_btn" data-index="0">确定</a>

            <a href="javascript:;" class="btn btn_default js_btn">取消</a>

        </div>

    </div>
</div>
<div class="dialog_wrp simple js_dialog4"
     style="width: 726px; display: none; margin-left: -363px; margin-top: -220.5px;">
    <div class="dialog">
        <div class="dialog_hd">
            <h3>修改菜品</h3>
            <a href="javascript:void(0);" class="icon16_opr closed pop_closed">关闭</a>
        </div>
        <div class="dialog_bd">
            <form id="editForm" action="?r=back/editItem" method="post">
                <input type="hidden" name="_t" value="editItem">
                <input type="hidden" class="js_edit_itemId" name="itemId" value="">
                <input type="hidden" name="categoryId" value="<?php echo $defaultCategoryId; ?>">

                <div class="simple_dialog_content">
					<span class="frm_title">
						菜品名称*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_edit_name" type="text" name="name" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						描述信息*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_edit_desc" type="text" name="desc" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						价格*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_edit_price" type="text" name="price" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <div class="simple_dialog_content">
					<span class="frm_title">
						计价单位*:
					</span>
					<span class="frm_input_box"> <input
                            class="frm_input js_input js_edit_unit" type="text" name="unit" required>
					</span>

                    <div class="requiredTip"></div>
                </div>
                <input type="reset" style="display:none;">
            </form>
        </div>

        <div class="dialog_ft">

            <a href="javascript:;" class="btn btn_primary js_btn" data-index="2">确定</a>

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
                            <input type="hidden" name="categoryId" value="<?php echo $defaultCategoryId; ?>">
                            <input type="hidden" name="itemId" value="">
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

                        <p class="js_errorMsg">error.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="dialog_ft">
            <a href="javascript:;" class="btn btn_default js_btn">取消</a>
        </div>
    </div>
</div>
</body>
</html>