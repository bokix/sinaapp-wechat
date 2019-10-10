<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-28
 * Time: 16:38
 */
class ItemServices {
    public function getAllItemsByCompanyId($companyId) {
        $allItems = $this->getAllItems($companyId);
        $cs = new CategoryServices();
        $allCategory = $cs->getCategoryByCompany($companyId);
        $map = array();

        foreach ($allCategory as $cat) {
            $categoryItemsList = array();
            foreach ($allItems as $item) {
                if ($item->categoryId == $cat->categoryId) {
                    $categoryItemsList[] = $item;
                }
            }
            $map[] = array(
                'category' => $cat,
                'itemList' => $categoryItemsList,
            );
        }

        return $map;

    }

    public function getAllItems($comId) {
        $sql = "select * from item where companyId=:comId";
        return Item::model()->findAllBySql($sql, array(':comId' => $comId));
    }

    public function loadItems($idArr) {
        return Item::model()->findAllByPk($idArr);
    }

    public function changeItemCategory($itemId, $categoryId) {
        Item::model()->updateByPk($itemId,
            array('categoryId' => $categoryId
            ));
    }

    public function deleteItem($itemId) {
        Item::model()->deleteByPk($itemId);
    }

    public function loadItem($itemId) {
        return Item::model()->findByPk($itemId);
    }
}


//end class file. 