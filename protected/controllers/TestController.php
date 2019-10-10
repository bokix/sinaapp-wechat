<?php

class TestController extends Controller
{
	public function actionTestList()
	{

        $meta=<<<meta
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
meta;
        echo "". $meta;
        Yii::log(Yii::app()->homeUrl);
        $arr = Item::model()->findBySql("select * from item where id=:id",
        array("id"=>12));
        if($arr){
            echo "true";
        }
        if(!$arr){
            echo "not true";
        }
        echo "<br/>";
//
//        foreach ($arr as $com) {
//            print_r($com);
//            echo "<br/>";
//
//        }
		return;
		//$this->render('testList');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}