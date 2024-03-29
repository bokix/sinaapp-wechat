<?php
Yii::import('application.util.*');
class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex($errorMsg="") {

        $user = '';
        if (isset($_REQUEST['errorMsg'])) {
            $errorMsg = $_REQUEST['errorMsg'];
        }
        if (isset($_REQUEST['u'])) {
            $user = $_REQUEST['u'];
        }
        $this->renderPartial('login', array(
            'user' => $user,
            'errorMsg' => $errorMsg,
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (!isset($_POST['n'])) {
            return $this->actionIndex();
        }
        $name = $_POST['n'];
        $pass = $_POST['p'];

        $com = Company::model()->findBySql("select * from company where userName=:name",
            array("name" => $name));
        if (!$com) {
            return $this->actionIndex("用户名不存在");
        }

        if (strtoupper(sha1($pass)) != $com->authPwd) {
            return $this->actionIndex("密码错误。");
        }
        if ($com->companyId == false || strlen($com->companyId) < 5) {
            return $this->actionIndex("尚未完成接入。");
        }
        $sessionId = Yii::app()->session->sessionID;
        Yii::app()->session[$sessionId] = $com->companyId;


        $this->redirect(Yii::app()->homeUrl . "?r=back/main");
        //$this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}