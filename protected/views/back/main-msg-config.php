<style>
    .dialog_ft2{
        margin: 0 20px;
        padding: 25px 0 50px;
        text-align: center;
    }
    .configDesc{
        width:410px;vertical-align:middle;display:inline-block;
    }
    .configDesc li{
        list-style-type: decimal;
        margin: 0 0 5px 20px;
        font-family:serif;
    }
</style>
<script type="text/javascript">
    <?php
        if('ok'==$msg){
    ?>
            alert('操作成功');
    <?php    }
    ?>
    //alert("操作成功");
    function testSend(){
        var _loginName=$("#editForm input[name='loginName']").val();
        var _pwd=$("#editForm input[name='pwd']").val();
        var _fakeId=$("#editForm input[name='fakeId']").val();

        if(_loginName==""){
            alert("请输入登录名");
            return;
        }
        if(_pwd==""){
            alert("请输入密码");
            return;
        }
        if(_fakeId==""){
            alert("请输入fakeId");
            return;
        }
       // $(".mask").show();
        $.getJSON("?r=back/testSend",{
            loginName:_loginName,
            pwd:_pwd,
            fakeId:_fakeId

        },function(json){
            console.dir(json);
            $(".mask").hide();
            if(json.ok){
                alert("测试成功");
            }else{
                alert("发送失败");
            }
        });
    }
    function save(){
        var _loginName=$("#editForm input[name='loginName']").val();
        var _pwd=$("#editForm input[name='pwd']").val();
        var _fakeId=$("#editForm input[name='fakeId']").val();

        if(_loginName!="" && _pwd==""){
            alert("请输入密码");
            return;
        }

        $("#editForm").attr("action","?r=back/saveMsgConfig");
        $(".mask").show();
        $("#editForm").submit();
    }


</script>
<div class="cLine sender_line chart_container">
    <div>
        <span style="">重要说明：</span><span style="font-family:serif;">本方法是利用微信公众号的漏洞，通过模拟公众号登录的方式发送微信消息给特定用户，不排除腾讯公司日后封堵此漏洞导致方法失效，
					也不排除腾讯公司对利用此漏洞的公众号采取进一步惩罚措施的权利。
					当您的公众号通过认证后，腾讯将提供正规的、合法的消息发送接口，届时，本系统将自动、优先使用正规的消息发送接口。
					</span>
        <h5>我们强烈建议您申请微信认证，通过认证后，您将享受到更全面的微信公众平台服务。微信认证在微信公众帐号的“服务”-“服务中信”-“微信认证”</h5>

        <div class="dialog_bd">
            <form id="editForm" action="" method="post">

                <div class="simple_dialog_content">
							<span class="frm_title">
								登录名:
							</span>
							<span class="frm_input_box"> <input placeholder="微信公众号的登录帐号"
                                                                class="frm_input js_input js_edit_name" type="text"
                                                                name="loginName" value="<?php echo $com->loginName; ?>">
							</span>
                </div>
                <div class="simple_dialog_content">
							<span class="frm_title">
								登录密码:
							</span>
							<span class="frm_input_box"> <input placeholder="请输入登录密码"
                                                                class="frm_input js_input js_edit_desc" type="password"
                                                                name="pwd">
							</span>
                </div>
                <div class="simple_dialog_content">
							<span class="frm_title">
								用户fakeId:
							</span>
							<span class="frm_input_box"> <input
                                    class="frm_input js_input js_edit_desc" type="text" name="fakeId"
                                    placeholder="接收消息的微信用户的fakeId，请看说明" value="<?php echo $com->adminUserFakeId; ?>">
							</span>
                </div>
                <div class="simple_dialog_content">
							<span class="frm_title" style="vertical-align: top;">
								说明:
							</span>
							<span class="configDesc">
								<ol>
                                    <li>
                                        fakeId的获取方式：在微信公众平台的用户管理页面，点击用户的头像后，会进入”与xx聊天”的页面，在该页面的浏览器地址栏里，您能看到类似于：&tofakeid=3252711
                                        这样的字样，等号后边的那串数字就是我们所需的fakeId
                                    </li>
                                    <li>因微信的系统限制，想要正确的收到通知消息，接收消息通知的用户必须先关注公众号，同时，必须在24小时内向公众号发送过消息</li>
                                </ol>
							</span>

                    <div class="requiredTip"></div>
                </div>
                <input type="reset" style="display:none;">
            </form>
        </div>

        <div class="dialog_ft2">

            <a href="javascript:save();" class="btn btn_primary js_btn" data-index="2">保存</a>

            <a href="javascript:testSend();" class="btn btn_default js_btn">测试</a>

        </div>

    </div>
</div>
