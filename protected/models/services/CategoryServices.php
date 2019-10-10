<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-2-28
 * Time: 16:54
 */
class CategoryServices {
    public function getCategoryByCompany($companyId) {
        $sql = "select * from category where companyId=:comId";
        return Category::model()->findAllBySql($sql, array(':comId' => $companyId));
    }

    public function createDefaultCategory($companyId) {
        $arr = array(
            "热菜", "冷菜", "酒水");
        foreach ($arr as $a) {

            $cat = new Category();
            $cat->categoryName = $a;
            $cat->companyId = $companyId;

            $cat->save();
        }

    }

    public function createCategory($cat) {
        $cat->save();
    }

    public function deleteCategory($categoryId) {
        Category::model()->deleteByPk($categoryId);
    }

    public function editCategory($categoryId, $categoryName) {
        Category::model()->updateByPk($categoryId,
            array('categoryName' => $categoryName
        ));
    }


}





//end class file. 