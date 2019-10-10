<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>接入</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/page_user.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/lib.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/tmp_lib.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/pagination17e4f5.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/rich_buddy17e4f5.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/dropdown_menu17e4f5.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/emoji17e4f5.css">

    <style>
        .ruleLineNum{
            width: 10px;
            display: inline;
            float: left;
        }
        .rule{
            display: inline;
            float: right;
            width: 900px;
        }
        .frm_title2{
            width: 180px;
            display: inline-block;
            text-align: right;
        }
        .requiredTip{
            display: inline-block;
            color:red;
            width:8px;
        }
        .error_msg{
            color:red;
            text-align: center;
            padding: 0 0 10px 0;
        }
    </style>
    <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            //表单校验
            $('#joinForm').validate({
                onkeyup: false,
                errorPlacement : function(e,ele) {
                    $(ele).closest("span").next().html("*");
                },
                success:function(label,ele){
                    $(ele).closest("span").next().html("");
                },
                submitHandler: function(form) {
                    $(".mask").show();
                    form.submit();
                },
                rules:{
                    appId:{
                        required:true
                    },
                    appSecret:{
                        required:true
                    },
                    userName:{
                        required:true
                    },
                    authPwd:{
                        required:true
                    },
                    token:{
                        required:true
                    },
                    authCode:{
                        required:true,
                        number:true,
                        minlength:4,
                        maxlength:4
                    },
                    authPwd2:{
                        required:true,
                        equalTo: '#authPwd'
                    },
                    email:{
                        required:true,
                        email: true
                    }
                }
            });

        });

        function reset(){
            $("#joinForm input[type=reset]").trigger("click");
        }
        function submit(){
            //$('#joinForm').validate();
            $("#joinForm").submit();
        }
    </script>
</head>
<body class="zh_CN">
<div id="body" class="body ">
    <div class="container_box">
        <div class="container_hd">
            <h2>接入须知</h2>
        </div>
        <div class="container_bd">
            <div class="col_main user friendPage meetingFriendPage">
                <div id="userGroups">
                    <ul id="listContainer" class="listContainer">
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <div class="ruleLineNum">1:</div>
                            <div class="rule">
                                你在使用本系统前需要注册一个微信公众帐号。微信公众帐号可通过QQ号码或电子邮箱帐号进行绑定注册，注册地址参见腾讯微信公众帐号官方网页：<a href="http://mp.weixin.qq.com" target="_blank">http://mp.weixin.qq.com</a>

                            </div>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <div class="ruleLineNum">2:</div>
                            <div class="rule">
                                你通过本系统从事的任何活动不能违反国家或地区相关法律法规。同时，你也应遵守微信公众平台的服务协议：<a href="https://mp.weixin.qq.com/cgi-bin/readtemplate?t=home/agreement_tmpl&type=info&lang=zh_CN" target="_blank">《微信公众平台服务协议》</a>
                            </div>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <div class="ruleLineNum">3:</div>
                            <div class="rule">
                                接入本系统，即表示你已充分阅读并理解你的义务和权利，如你因违反微信公众平台协议或相关法律法规而导致的任何问题，本系统也将保留进一步追究的权利。
                            </div>
                        </li>
                    </ul>
                </div>


                <div class="dialog_bd" style="border-top: 1px solid #c8c8c8;padding:55px 45px 55px 100px;">

                    <h3>完成接入共需三个步骤，第一步：请填写必要的接入信息</h3><br/>
                    <form id="joinForm" action="?r=back/join" method="post">
                        <input type="hidden" name="_t" value="join">
                        <?php if(!empty($errorMsg)){ ?>
                            <div class="error_msg"><?php echo $errorMsg; ?></div>
                        <?php } ?>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								appId*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="text" name="appId" placeholder="微信公众号的appId">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								appSecret*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="text" name="appSecret" placeholder="微信公众号的appSecret">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								token*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="text" maxlength="20" name="token" placeholder="请任意填写一个您熟悉的字符串作为接入token">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								网站登录用户名*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="text" name="userName" placeholder="用于登录网站进行后台管理">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								网站登录用户密码*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="password" id="authPwd" name="authPwd" placeholder="请设置密码">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								网站登录用户密码确认*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="password" name="authPwd2" placeholder="请再输入一次密码">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								授权码*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="text" name="authCode" placeholder="四位数字，手机微信进行管理操作时的授权码，可随时修改">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <div class="simple_dialog_content">
							<span class="frm_title2">
								常用邮箱*:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input" type="text" name="email" placeholder="请输入一个您的常用邮箱地址">
							</span>
                            <div class="requiredTip"></div>
                        </div>
                        <input type="reset" style="display:none;">
                    </form>
                </div>
                <div class="" style="text-align: center;">
                    <a href="javascript:submit();" class="btn btn_primary " data-index="0">确定</a>
                    <a href="javascript:reset();" class="btn btn_default">重置</a>
                </div>



            </div>
        </div>
    </div>
</div>

<div class="mask"><div class="mask-img"></div></div>
</body>
</html>
