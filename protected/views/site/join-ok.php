<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>接入</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/base.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/page_user.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/lib.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/tmp_lib.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/pagination17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/rich_buddy17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/dropdown_menu17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/emoji17e4f5.css">

    <style>
        .ruleLineNum {
            width: 80px;
            display: inline;
            float: left;
        }

        .rule {
            display: inline;
            float: right;
            width: 820px;
        }
    </style>

    <script type="text/javascript">
    </script>
</head>
<body class="zh_CN">
<div id="body" class="body ">
    <div class="container_box">
        <div class="container_hd">
            <h2>操作成功</h2>
        </div>
        <div class="container_bd">
            <div class="col_main user friendPage meetingFriendPage">
                <div id="userGroups">
                    <ul id="listContainer" class="listContainer">
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <h3>第二步：请在微信公众平台的帐号设置页面的"服务器配置"填写以下信息：</h3>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <div class="ruleLineNum">URL：</div>
                            <div class="rule">
                                <?php echo $url; ?>
                            </div>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <div class="ruleLineNum">Token：</div>
                            <div class="rule">
                                <?php echo $token; ?>
                            </div>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <h3>第三步：完成以上设置后，请用任意微信号向公众帐号发送如下消息：</h3>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            <div class="ruleLineNum">发送消息：</div>
                            <div class="rule">
                                <?php echo $RGAmsg; ?>
                            </div>
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            完成所有上述三个步骤，您就彻底完成了接入过程，现在，用户可以在微信上体验您的公众帐号的新功能了。
                            <br/>
                            接下来，您可以点击<a href="?r=site&u=<?php echo $user; ?>" target="_self">&nbsp;这里&nbsp;</a>登录我们的后台系统进行更多的设置，您在我们网站上的登录用户为：<?php echo $user; ?>
                            。
                        </li>
                        <li class="listItem buddyRichInfoC" style="border:none;">
                            注：填写url和token需要将微信公众帐号选择为“开发模式”，微信公众平台的官方地址为：
                            <a href="http://mp.weixin.qq.com" target="_blank">http://mp.weixin.qq.com</a>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
</div>

</body>
</html>
