<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-28
 * Time: 16:45
 */
class OrderItemService {

    public function getOrderItemsByOrderId($orderId, $companyId, $userName) {
        return OrderItem::model()->findAll('orderId=:orderId and companyId=:comId and orderPersonWXId=:userName',
            array(
                ':orderId' => $orderId,
                ':comId' => $companyId,
                ':userName' => $userName,
            ));
    }

    /**
     * 检查是否有暂存的菜单,如果有,返回排号,如果没有,返回0
     * <p>
     * 暂存菜单只保留1天，查询条件中暗含了时间条件
     * </p>
     * @param $companyId
     * @param $userName
     * @return int
     */
    public function getUnassignedOrderNum($companyId, $userName) {
        $sql = <<<sql
            select orderNum from orderItem where companyId=:comId
            and orderPersonWXId=:userName
            and orderId<1;
sql;
//            and date_format(createTime,'%Y%m%d')=:date limit 1;
//            + RequestUtil.getDate2Str(new Date(), "yyyyMMdd") + "' limit 1";

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $command->bindParam(":comId", $companyId, PDO::PARAM_STR);
        $command->bindParam(":userName", $userName, PDO::PARAM_STR);

        $rows = $command->queryAll();
        $result = 0;
        foreach ($rows as $row) {
            $result = $row['orderNum'];
        }
        return $result;

    }

    public function deleteOrderItemsByOrderId($orderId, $companyId, $userName) {
        $sql = <<<sql
delete from orderItem where companyId=:comId and orderPersonWXId=:userName and orderId=:orderId;
sql;

        OrderItem::model()->deleteAll('companyId=:comId and orderPersonWXId=:userName and orderId=:orderId', array(
            ':comId' => $companyId,
            ':userName' => $userName,
            ':orderId' => $orderId,
        ));
    }

    /**
     * 删除已有临时菜单后,再保存菜单. <br/>
     * 如果有未点菜的订单，就关联此订单<br/>
     * 如果没有订单,则查询是否已有临时菜单,如果有,则排号不变,删除已有菜单后保存,如果没有,则重新分配排号
     * list中的orderItem要是同一个商家和用户的
     * @param $list
     * @throws Exception
     */
    public function resetOrderItems($list) {
        if ($list == null || count($list) < 1) {
            return;
        }
        $o = $list[0];
        $companyId = $o->companyId;
        $userWXid = $o->orderPersonWXId;
        $orderId = $o->orderId;

        $order = null;
        $orderNum = 0; //

        $orderService = new OrderServices();
        if ($orderId < 1) {
            // 找出还没有点菜的订单
            $order = $orderService->getOrderWithoutItem($companyId, $userWXid);
        } else {
            $order = $orderService->getOrderById($orderId);
        }
        if ($order == null) {
            // 没有订单
            $orderNum = $this->getUnassignedOrderNum($companyId, $userWXid);
            if ($orderNum < 1) {
                // 分配的是当天的排号
                $counterCache = new CounterCache();
                $orderNum = $counterCache->addOrIncr($companyId,
                    date('Ymd'));
            }
        } else {
            // 前台取不到orderNum，所以这里要取订单的orderNum，此外，如果存在order，则order和orderItem的num一定是相等的。
            $orderNum = $order->orderNum;
            $orderId = $order->id;
        }
        $this->deleteOrderItemsByOrderId($orderId, $companyId, $userWXid);

        foreach ($list as &$o) {
            if ($companyId != $o->companyId
                || $userWXid != $o->orderPersonWXId
            ) {
                throw new Exception(
                    "can not save more than one company's orderItem together.");
            }
            $o->orderNum = $orderNum;
            $o->createTime = new CDbExpression('now()');
            $o->orderId = $orderId;
        }

        $this->saveOrderItems($list);
    }

    public function saveOrderItems($itemArr) {
        foreach ($itemArr as $item) {
            $item->save();
        }
    }

    public function updateUnassignedOrderNumByOrderId($companyId, $orderPersonWXId, $id) {
        OrderItem::model()->updateAll(array('orderId' => $id),
            'orderId<1 and companyId=:comId
                and orderPersonWXId=:userName', array(
                ':comId' => $companyId,
                ':userName' => $orderPersonWXId,
            ));
    }
}





//end class file. 