<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<?php
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/index.css"/>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function(){
            if($("input[name='n']").val()!=""){
                $("input[name='p']").focus();
            }else{
                $("input[name='n']").focus();
            }

            $("#loginBtn").bind("mousedown",function(){
                $(this).addClass("loginBtn-clicked");
            }).bind("mouseup",function(){
                    $(this).removeClass("loginBtn-clicked");
                });
            $(document).bind("keypress",function(e){
                if(e.keyCode=="13"){
                    login();
                }
            });
            $('#loginForm').validate({
                onkeyup: false,
                //onsubmit:false,
                errorPlacement : function(e,ele) {
                    $(ele).addClass("text-input-error");
                },
                success:function(label,ele){
                    $(ele).removeClass("text-input-error");
                },
                submitHandler: function(form) {
                    $(".errorMsg").html("login...");
                    form.submit();
                }
            });
        });
        function login(){
            $('#loginForm').submit();
        }
    </script>
    <title>51dc</title>
</head>
<body>
<div id="__01">
    <div id="id1-01">
    </div>
    <div id="id3-03">
        <div class="term">
            <a href="?r=back/joinStart" title="现在就加入我们">join</a>&nbsp;|&nbsp;<a href="help.html" title="查看帮助">help</a>
        </div>
    </div>
    <form id="loginForm" action="?r=site/login" method="post">
        <input type="hidden" name="_t" value="login">
        <div class="middle">
            <div id="id2-02">
            </div>
            <div id="id4-04">
                <input type="text" name="n" value="<?php echo $user; ?>" class="text-input" required>
            </div>
            <div id="Darshboard-Login-05">
                <input type="password" name="p" class="text-input" required>
            </div>
            <div id="id6-06">
                <img src="images/6_06.gif" id="loginBtn" width="367" height="67" onclick="login()">
            </div>
            <div id="id7-07" class="errorMsg">
                <?php echo $errorMsg ?>
            </div>
            <div id="id8-08">
            </div>
        </div>
    </form>
</div>
<!-- <div class="bg-repeat"> -->
<!-- </div> -->

</body>
<script>
    window.scrollTo(9999,9999);
</script>
</html>
