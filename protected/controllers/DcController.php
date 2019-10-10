<?php

class DcController extends Controller {
    public $layout = null;

    public function actionSaveOrder() {

        $isTakeOut = $_POST["isTakeOut"];
        $name = $_POST["name"];
        $num = $_POST["num"];
        $remark = $_POST["remark"];
        $ot = $_POST["orderTime"];
        $phone = $_POST["phone"];
        $orderPersonWXId = $_POST["orderPersonWXId"];
        $companyId = $_POST["companyId"];

        $o = new Myorder();

        $o->companyId = $companyId;
        $o->dealSts = OrderDealStsEnum::NOT_DEAL;
        $o->isTakeOut = $isTakeOut;
        $o->orderPersonName = $name;
        $o->orderPersonNum = $num;
        $o->orderRemark = $remark;
        $o->orderTime = $ot;
        $o->phone = $phone;
        $o->createTime = new CDbExpression('now()');
        $o->isDelete = CommonEnum::NO;
        $o->orderPersonWXId = $orderPersonWXId;

        $os = new OrderServices();
        $b = $os->allocateOrderAndSave($o);

		if (!$b) {
//            request.setAttribute("msg", "保存订单出错");
//            request.getRequestDispatcher("/WEB-INF/page/error.jsp").forward(
//                request, resp);
            return;
        }
        $orderList = $os->getOrderByWXUser($o->companyId, $orderPersonWXId);

        $istakeoutStr = "" ;
        $dealStsStr = "";
        $msg =<<<str
    您有一个新的订单：\n
    姓名：$name \n
    电话：<a href="tel:$phone">$phone</a> \n
    人数：$num \n
    时间：$ot \n
    地点：$istakeoutStr \n
    备注：$remark \n
    状态：$dealStsStr \n
str;

		// 向商家的管理员发送微信通知。
        $SendService =new SendServices();;
        $companyCache =new CompanyCache();
        //TODO.
        //$SendService->sendTxtMsg($companyCache->getCompanyByCompanyId($companyId), $msg);

        $this->renderPartial('order-list', array(
            'orderList'=>$orderList,
            'companyId' => $companyId,
            'userName' => $orderPersonWXId,
        ));
}
    public function actionSaveItems() {
        $companyId = $_POST["companyId"];
        $userName = $_POST["userName"];
        $orderId = $_POST["orderId"];

        $itemIds = $_POST["ids"];
        $counts = $_POST["counts"];

        if (empty($itemIds)) {

            $ois = new OrderItemService();
            $ois->deleteOrderItemsByOrderId($orderId, $companyId,
                $userName);

            $os = new OrderServices();
            $orderList = $os->getOrderByWXUser($companyId, $userName);
            $this->renderPartial('order-list', array(
                'orderList' => $orderList,
                'companyId' => $companyId,
                'userName' => $userName,
            ));


            // $this->redirect('?r=dc/list&companyId=' . $companyId . "&userName=" . $userName);
            return;
        }

        $idArr = explode(",", $itemIds); // itemIds . split(",");
        $countArr = explode(",", $counts); // counts . split(",");
        if (count($idArr) != count($countArr)) {
            throw new Exception('id arr length not equals count arr.');
            return;
        }
        $idCountMap = array_combine($idArr, $countArr);
        $is = new ItemServices();
        $list = $is->loadItems(explode(',', $itemIds));
        $oiList = array();
        foreach ($list as $item) {
            $count = 0;
            if (array_key_exists($item->id, $idCountMap)) {
                $count = $idCountMap[$item->id];
            }
            if ($count == 0) {
                continue;
            }
            $oi = new OrderItem();
            $oi->categoryId = $item->categoryId;
            $oi->companyId = $item->companyId;
            $oi->count = $count;
            $oi->img80 = $item->img80;
            $oi->isValid = $item->isValid;
            $oi->itemDesc = $item->itemDesc;
            $oi->itemName = $item->itemName;
            $oi->orderPersonWXId = $userName;
            $oi->price = $item->price;
            $oi->totalPrice = $item->price * $count;
            $oi->unit = $item->unit;
            $oi->itemId = $item->id;
            $oi->orderId = $orderId;

            $oiList[] = $oi;
        }

        $ois = new OrderItemService();
        $ois->resetOrderItems($oiList);

        $this->redirect('?r=dc/list&companyId=' . $companyId . "&userName=" . $userName);
        return;
    }

    public function actionDetailItems() {
        $companyId = $_GET["companyId"];
        $userName = $_GET["userName"];
        $orderId = 0;
        if (isset($_REQUEST['orderId'])) {
            $orderId = $_REQUEST["orderId"];
        }
        $count = 0;
        $totalPrice = 0.0;
        $ois = new OrderItemService();
        $list = $ois->getOrderItemsByOrderId($orderId, $companyId,
            $userName);
        foreach ($list as $oi) {
            $count += $oi->count;
            $totalPrice += $oi->totalPrice;

        }

        $this->renderPartial('order-item-list', array(
            'count' => $count,
            'totalPrice' => $totalPrice,
            'userName' => $userName,
            'companyId' => $companyId,
            'orderId' => $orderId,
            'orderItemList' => $list,
        ));
    }

    public function actionList() {
        $companyId = $_GET["companyId"];
        $userName = $_GET["userName"];


        $os = new OrderServices();
        $orderList = $os->getOrderByWXUser($companyId, $userName);

        $this->renderPartial('order-list', array(
            'orderList' => $orderList,
            'companyId' => $companyId,
            'userName' => $userName,
        ));
    }

    public function actionAddOrder() {
        $companyId = $_GET["companyId"];
        $userName = $_GET["userName"];

        $this->renderPartial('add', array(
            'companyId' => $companyId,
            'userName' => $userName,
        ));

    }

    public function actionShowItems() {
        $companyId = $_GET["companyId"];
        $userName = $_GET["userName"];
        $orderId = 0;
        if (isset($_REQUEST['orderId'])) {
            $orderId = $_REQUEST["orderId"];
        }

        $is = new ItemServices();
        $itemMap = $is->getAllItemsByCompanyId($companyId);
        $mycategory = new Category();
        $mycategory->categoryId = 0;
        $mycategory->categoryName = $orderId > 0 ? "我的菜单" : "我的暂存菜单";
        $ois = new OrderItemService();
        $list = $ois->getOrderItemsByOrderId($orderId, $companyId,
            $userName);
        if ($list == null || $list == false) {
            $list = array();
        }

        array_unshift($itemMap, array(
            'category' => $mycategory,
            'itemList' => array(),
        ));
        $this->renderPartial('page', array(
            'userName' => $userName,
            'companyId' => $companyId,
            'orderId' => $orderId,
            'itemMap' => $itemMap,
            'orderItemList' => $list,
        ));
    }
}