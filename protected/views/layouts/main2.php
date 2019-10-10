<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="col_side l">
        <div class="catalogList" id="groupsList">
            <ul>
                <li class="group  <?php echo 1==$this->pageIndex?'selected':'' ?> js_groupList"><a class="title" href="?r=back/main">下单量报表</a></li>
                <li class="group  <?php echo 2==$this->pageIndex?'selected':'' ?> js_groupList"><a class="title" href="?r=back/msgConfig">消息通知配置</a></li>
            </ul>
        </div>
    </div>
    <div class="col_main user friendPage meetingFriendPage"
         style="padding-top: 5px;">
        <?php echo $content; ?>
    </div>
<?php $this->endContent(); ?>