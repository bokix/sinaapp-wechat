<?php
Yii::import('application.util.*');
Yii::import('application.plantform.*');
Yii::import('application.plantform.storage.*');

class BackController extends Controller {
    private $layoutArr = array(
        0 => '//layouts/main',
        1 => '//layouts/main2',
    );
    public $layout = '//layouts/main';
    public $pageTitle = '首页';
    public $pageIndex = 10;

    public function filterErrorHandle($filterChain) {

        set_error_handler(array(&$this, 'errorHandler'));
        $filterChain->run(); // 以继续后续过滤器与动作的执行。
    }

    public function errorHandler($level, $msg, $file, $line) {
        SAELog::debug($msg . " in " . $file . ":" . $line);

        Yii::app()->end();
    }

    public function actionEditItem() {
        $com = $this->getCurrentUser();
        $id = $_POST["itemId"];
        $desc = $_POST["desc"];
        $n = $_POST["name"];
        $p = $_POST["price"];
        $unit = $_POST["unit"];

        Item::model()->updateByPk($id, array(
            'itemDesc' => $desc,
            'itemName' => $n,
            'price' => $p,
            'unit' => $unit,
        ));

        $this->redirect('?r=back/item&categoryId=' . $_POST['categoryId']);

    }

    public function actionDelItem() {
        $itemId = $_POST['itemId'];
        $is = new ItemServices();
        $item = $is->loadItem($itemId);
        if ($item == null || $item === false) {
            $this->redirect('?r=back/item&categoryId=' . $_POST['categoryId']);
            return;
        }
        $url = $item->img80;
        $item->delete();
        $com = $this->getCurrentUser();
        $fileName = strstr($url, "/" . $com->companyId);


        $saeStorage = new SAEStorageImpl();
        $saeStorage->delete($fileName);
        $this->redirect('?r=back/item&categoryId=' . $_POST['categoryId']);
    }

    public function actionAddItem() {
        $item = new Item();

        $com = $this->getCurrentUser();
        $item->categoryId = $_POST["categoryId"];
        $item->companyId = $com->companyId;
        $item->itemDesc = $_POST["desc"];
        $item->isValid = CommonEnum::YES;
        $item->itemName = $_POST["name"];
        $item->price = $_POST["price"];
        $item->unit = $_POST["unit"];

        if ($_FILES["img80"]["error"] > 0) {
            throw new CHttpException(500, 'file upload error.' . $_FILES["img80"]["error"]);
        }


        $fn = $_FILES['img80']['name']; //("img80");
        $suffix = strrchr($fn, "."); //like:".jpg"
        $destFilePathAndName = "/" . $com->companyId . "/" . $item->categoryId . '_' . time() . "_80x80_" . $suffix;
        $url = "";
        if (Yii::app()->params['localMode']) {
            $url = $this->save2localhost($destFilePathAndName);
        } else {
            $url = $this->save2storage($destFilePathAndName);
        }

        Yii::log("url:" . $url);

        $item->img80 = $url;

        $item->save();

        $this->redirect('?r=back/item&categoryId=' . $item->categoryId);
    }

    public function actionChangeCat() {
        $itemId = $_POST["itemId"];
        $categoryId = $_POST["gid"];
        $is = new ItemServices();
        $is->changeItemCategory($itemId, $categoryId);

        $this->redirect('?r=back/item&categoryId=' . $categoryId);

    }

    public function actionEditCat() {
        $gid = $_POST["gid"];
        $gname = $_POST["categoryName"];
        $cates = new CategoryServices();
        $cates->editCategory($gid, $gname);
        $this->redirect('?r=back/item&categoryId=' . $gid);
    }

    public function actionResource() {
        $com = $this->getCurrentUser();
        $rs = new ResourceServices();
        $resList = $rs->getResource($com->companyId);
        if ($resList == null) {
            $resList = array();
        }
        $this->layout = $this->layoutArr[0];
        $this->pageIndex = 30;
        $this->pageTitle = '资源管理';
        $this->render('resource', array(
            'resourceList' => $resList,
        ));
    }

    public function actionDelCat() {
        $categoryId = $_POST["categoryId"];
        $cates = new CategoryServices();
        $cates->deleteCategory($categoryId);
        $this->redirect('?r=back/item');
    }

    public function actionAddCat() {
        $cn = $_POST["categoryName"];
        $com = $this->getCurrentUser();
        $cat = new Category();
        $cat->categoryName = $cn;
        $cat->companyId = $com->companyId;

        $cates = new CategoryServices();
        $cates->createCategory($cat);

        $this->redirect('?r=back/item&categoryId=' . $cat->categoryId);
    }

    public function actionJoin() {
        $appId = $_POST["appId"];
        $appSecret = $_POST["appSecret"];
        $userName = $_POST["userName"];
        $authPwd = strtoupper(sha1($_POST["authPwd"]));
        $token = $_POST["token"];
        $authCode = $_POST["authCode"];
        $email = $_POST["email"];

        $com = new Company();
        $com->appId = $appId;
        $com->appSecret = $appSecret;
        $com->authCode = $authCode;
        $com->authPwd = $authPwd;
        $com->companyId = ""; //这个时候无法获取companyId,临时companyId的length需小于5
        $com->token = $token;
        $com->userName = $userName;
        $com->email = $email;

        $cs = new CompanyCache();
        $old = $cs->getCompanyByAppId($appId);
        if ($old != null) {
            throw new Exception("请勿重复接入。");
        }
        $com->save();
        $cs->setCompanyByAppId($com);

        if (!Yii::app()->params['localMode']) {
            $menuService = new MenuServices();;
            $menuService->deleteMenu($appId, $appSecret);
            $menuService->createMenu($appId, $appSecret, $menuService->getDefaultMenu());
        }

        $url = Yii::app()->homeUrl . '/?r=core/wechat&appId=' . $appId;

        $this->renderPartial('/site/join-ok', array(
            'url' => $url,
            'token' => $token,
            'user' => $userName,
            'RGAmsg' => "RGA" . $appId,
        ));
    }

    public function actionJoinStart() {
        $this->renderPartial('/site/join', array('errorMsg' => ''));
    }

    public function actionSaveMsgConfig() {
        $loginName = $_POST["loginName"];
        $pwd = $_POST["pwd"];
        $fakeId = $_POST["fakeId"];
        $com = $this->getCurrentUser();

        $com->adminUserFakeId($fakeId);
        $com->loginName($loginName);
        if (!empty($pwd)) {
            $com->loginPwd(strtoupper(md5($pwd)));
        } else {
            $com->loginPwd = null;
        }
        $com->save();

        $cc = new CompanyCache();
        $cc->setCompanyByAppId($com);

        $this->layout = $this->layoutArr[1];
        $this->pageIndex = 2;
        $this->render("main-msg-config", array(
            'msg' => 'ok',
            'com' => $this->getCurrentUser(),
        ));
    }

    public function actionTestSend() {
        $loginName = $_GET["loginName"];
        $pwd = $_GET["pwd"];
        $fakeId = $_GET["fakeId"];

        $tmp = new Company();
        $tmp->adminUserFakeId($fakeId);
        $tmp->loginName($loginName);
        $tmp->loginPwd(strtoupper(md5($pwd)));
        $sendService = new SendServices();
        $b = $sendService->sendMsgUseMockLogin($tmp, "这是一个测试消息");
        $o = new Json($b);

        $arr = array(
            'ok' => $o,
        );
        echo JsonUtil::getZhJson($arr);
        Yii::app()->end();
    }

    public function actionOrder() {
        $this->layout = $this->layoutArr[0];
        $this->pageIndex = 40;
        $this->pageTitle = '订单管理';
        $com = $this->getCurrentUser();
        $whereSql = " companyId='" . $com->companyId .
            "' order by orderTime desc limit 100";
        $os = new OrderServices();
        $orderList = $os->listOrder($whereSql);
        $this->render('/back/order', array('orderArr' => $orderList));
    }

    public function actionItem() {
        $com = $this->getCurrentUser();
        $is = new ItemServices();
        $itemMap = $is->getAllItemsByCompanyId($com->companyId);
        $defaultCategoryId = 0;
        $cat = $itemMap[0]['category'];
        $defaultCategoryId = $cat->categoryId;

        if (isset($_REQUEST['categoryId'])) {
            $defaultCategoryId = $_REQUEST['categoryId'];
        }
        $this->layout = $this->layoutArr[0];
        $this->pageIndex = 20;
        $this->pageTitle = '菜单管理';
        $this->render("item", array(
            'itemMap' => $itemMap,
            'defaultCategoryId' => $defaultCategoryId,
        ));
    }

    public function actionMsgConfig() {
        $this->layout = $this->layoutArr[1];
        $this->pageIndex = 2;
        $msg = "";
        if (isset($_REQUEST['msg'])) {
            $msg = $_REQUEST['msg'];
        }
        $this->render("main-msg-config", array(
            'msg' => $msg,
            'com' => $this->getCurrentUser(),
        ));
    }

    public function actionMain() {
        $this->layout = $this->layoutArr[1];
        $this->pageIndex = 1;
        $this->pageTitle = '首页';

        $com = $this->getCurrentUser();

        $catArr = $this->getLast12DaysStr(); //返回如：1月2日，

        $json = array(
            'title' => '近12天下单量',
            'categories' => $catArr,
            'datas' => array(),
        );
        $os = new OrderServices();
        $startTime = date('Y-m-d', strtotime('-12 day'));
        $endTime = "";
        $everyDaysOrderNumMap = $os->getEveryDaysOrderNum($com->companyId, $startTime);

        foreach ($catArr as $cat) {
            $num = 0;
            if ($everyDaysOrderNumMap != null && array_key_exists($cat, $everyDaysOrderNumMap)) {
                $num = $everyDaysOrderNumMap[$cat] + 0;
            }
            $json['datas'][] = $num;
        }
        $this->render("main-chart", array(
            'chartJson' => JsonUtil::getZhJson($json),
        ));
    }

    public function getCurrentUser() {
        $sessionId = Yii::app()->session->sessionID;
        $companyCache = new CompanyCache();
        $companyId = Yii::app()->session[$sessionId];

        $com = $companyCache->getCompanyByCompanyId($companyId);
        if ($com == null || $com == false) {
            $this->redirect(Yii::app()->homeUrl . '?errorMsg=please login!', true);
            return;
        }
        return $com;
    }

    private function getLast12DaysStr() {
        $arr = array();
        for ($i = 12; $i >= 1; $i--) {
            $s = "-" . $i . " day";
            $d = strtotime($s);
            $str = date('n月j日', $d);
            $arr[] = $str;
        }
        return $arr;
    }

    private function save2localhost($destFilePathName) {
        /**
         * echo "Upload: " . $_FILES["file"]["name"] . "<br />";
         * echo "Type: " . $_FILES["file"]["type"] . "<br />";
         * echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
         * echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
         */
        Yii::log('temp file:' . $_FILES["img80"]["tmp_name"]);
        $host = "http://localhost/~bokix/img";
        $url = $host . $destFilePathName;
        $uri = '/Users/bokix/Sites/img' . $destFilePathName;
        $path = dirname($uri);
        if (!file_exists($path)) {
            mkdir($path);
        }
        move_uploaded_file($_FILES["img80"]["tmp_name"],
            $uri);
        return $url;
    }

    private function save2storage($destFilePathAndName) {

        $upload = new SAEStorageImpl();
        $tmpName = $upload->getTmpFS() . $_FILES["img80"]["name"];

        SAELog::debug("tmpFS:[" . $tmpName . ']');

        move_uploaded_file($_FILES["img80"]["tmp_name"], $tmpName);

        $resizeFile = $upload->resizeImg($tmpName, 80, 80);

        $url = $upload->upload($resizeFile, $destFilePathAndName);

        return $url;
    }

}