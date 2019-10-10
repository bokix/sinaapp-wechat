<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/page_user.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/lib.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/tmp_lib.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/pagination17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/rich_buddy17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/dropdown_menu17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/emoji17e4f5.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/back-resources/base.css"/>
    <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jslib/jquery.validate.min.js" type="text/javascript"
            charset="utf-8"></script>


</head>
<body class="zh_CN">
<div class="head" id="header">
    <div class="head_box">
        <div class="inner wrp">
            <h1 class="logo">
                <a title="系统">系统</a>
            </h1>

            <div id="accountArea" class="account">
                <a
                    href="?r=back/main"
                    class="account_meta_link"><?php echo $this->getCurrentUser()->userName ?></a>
                <!--
                <a
                href="/cgi-bin/"
                class="account_meta_link">通知</a>
                -->
                &nbsp;|&nbsp;<a id="logout"
                                href="?r=site/logout"
                                class="account_meta_link">退出</a>
            </div>
        </div>
    </div>
    <div class="nav_box">
        <ul class="nav" id="navigatorBar">
            <li data-index="0" class="nav_item <?php echo 10>=$this->pageIndex?'selected':'' ?>"><a
                    href="?r=back/main">首页</a></li>
            <li data-index="1" class="nav_item <?php echo 20==$this->pageIndex?'selected':'' ?>"><a
                    href="?r=back/item">菜单管理</a></li>
            <li data-index="2" class="nav_item <?php echo 30==$this->pageIndex?'selected':'' ?>"><a
                    href="?r=back/resource">资源管理</a></li>
            <li data-index="3" class="nav_item <?php echo 40==$this->pageIndex?'selected':'' ?>"><a
                    href="?r=back/order">订单管理</a></li>
        </ul>
    </div>
</div>
<div id="body" class="body ">
    <div class="container_box">
        <div class="container_hd">
            <h2><?php echo CHtml::encode($this->pageTitle); ?></h2>
        </div>
        <div class="container_bd">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<div class="mask">
    <div class="mask-img"></div>
</div>
</body>
</html>