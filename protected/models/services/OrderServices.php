<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-28
 * Time: 10:38
 */
class OrderServices {

    /**
     * @param $companyId
     * @param $startTime like yyyy-mm-dd
     * @param null $endTime like yyyy-mm-dd, null is default to current time
     * @return map
     */
    public function getEveryDaysOrderNum($companyId, $startTime, $endTime = null) {
        $sql = <<<sql
select date_format(createTime,'%c月%e日') as d,count(*) as n, createTime as od
from myorder where companyId=:companyId and createTime <=:endTime and createTime>=:startTime
group by date_format(createTime,'%c月%e日') order by od ASC;
sql;

        if (!isset($endTime)) {
            $endTime = date('Y-m-d');
        }
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":companyId", $companyId, PDO::PARAM_STR);
        $command->bindParam(":endTime", $endTime, PDO::PARAM_STR);
        $command->bindParam(":startTime", $startTime, PDO::PARAM_STR);

        $rows = $command->queryAll();
        $result = array();
        foreach ($rows as $row) {
            $result[$row['d']] = $row['n'];
        }
        return $result;

    }


    public function listOrder($whereSql) {
        $sql = "select mo.* from myorder mo where " . $whereSql;
        $orders = Myorder::model()->findAllBySql($sql);
        return $orders;
    }

    public function getOrderByWXUser($companyId, $userName) {
        if (!isset($companyId) || !isset($userName)) {
            return array();
        }
        $whereSql = <<<sql
select mo.* from myorder mo where isDelete=0 and companyId=:comId
and orderPersonWXId=:userName order by createTime DESC limit 3;
sql;

        Yii::log($whereSql);

        $list = Myorder::model()->findAllBySql($whereSql, array(
            ':comId' => $companyId,
            ':userName' => $userName,
        ));
        if ($list == null) {
            $list = array();
        }


        $orderItemService = new OrderItemService();
        $orderNum = $orderItemService->getUnassignedOrderNum($companyId,
            $userName);
        if ($orderNum > 0) {
            $tmp = new Myorder();
            $tmp->companyId = $companyId;
            $tmp->id = 0;
            $tmp->dealSts = OrderDealStsEnum::NOT_DEAL; //(EnumUtil.ORDER_dealSts.notDeal.getCode());
            $tmp->isDelete = CommonEnum::NO; //(YesOrNo.NO.getCode());
            $tmp->isTakeOut = CommonEnum::NO;
            $tmp->orderNum = $orderNum; //orderNum);
            $tmp->orderPersonWXId = $userName; //userWXid);
            $tmp->orderRemark = "临时订单，只保留1天";
            $tmp->createTime = date('Y-m-d H:i:s'); //2014-02-17 16:58:47
            $tmp->orderPersonName = "临时订单";
            $tmp->phone = "";

            array_unshift($list, $tmp);

        }

        return $list;
    }

    /**
     * 取用户尚未点菜的订单。
     * <p>
     * 取出的订单始终是大于当前时间的，即以往的订单是不会取出的。
     * </p>
     *
     * @param $companyId
     * @param $userWXid
     */
    public function getOrderWithoutItem($companyId, $userWXid) {
        $whereSql = <<<sql
select mo.* from myorder mo where
mo.isDelete=0 and mo.companyId=:comId and mo.orderPersonWXId=:userWXid and mo.orderTime>=:ot
 and not exists( select 1 from orderItem b where mo.id=b.orderId )
  order by mo.createTime DESC limit 1;
sql;

        return Myorder::model()->findBySql($whereSql, array(
            ':comId' => $companyId,
            ':userWXid' => $userWXid,
            ':ot' => date('Y-m-d H:i:s'),
        ));
    }

    public function getOrderById($orderId) {
        return Myorder::model()->findAllByPk($orderId, 'isDelete=0');
    }

    public function allocateOrderAndSave($myorder) {
        $rs = new ResourceServices();
        $rs->allocateResource($myorder);

        $orderItemService = new OrderItemService();
        $list = $orderItemService->getOrderItemsByOrderId(0,
            $myorder->companyId, $myorder->orderPersonWXId);
        $oi = null;
        if (!empty($list)) {
            // 如果有暂存的菜单，则更新此订单的排号，
            $oi = $list[0];
            $myorder->orderNum = $oi->orderNum;
        } else {
            // 无暂存的菜单，所以新分配排号
            $counterCache = new CounterCache();
            $orderNum = $counterCache->addOrIncr(
                $myorder->companyId, $myorder->orderTime);
			$myorder->orderNum = $orderNum;
		}

        $myorder->save();
        if (!empty($oi)) {

            $orderItemService->updateUnassignedOrderNumByOrderId(
                $myorder->companyId, $myorder->orderPersonWXId,
                $myorder->id);
        }
        return true;
    }
}

