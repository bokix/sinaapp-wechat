<?php
require_once('wechat/MyWechat.php');
class CoreController extends Controller
{
	public function actionWechat()
    {
	    $wechat = new MyWechat(TRUE);
	    $wechat->run();  
    }  
	private function saeLog($msg){
	    sae_set_display_errors(false);//关闭信息输出
	    sae_debug($msg);//记录日志
		sae_set_display_errors(true);//记录日志后再打开信息输出，否则会阻止正常的错误信息的显示
	}
}