<?php

/**
 * Created by bokix.
 * User: bokix
 * Date: 14-3-4
 * Time: 15:26
 */
class ResourceServices {

    public function allocateResource($myorder) {
        if(true){
            return;
        }
        $companyId = $myorder->companyId;
        if ($myorder->isTakeOut == OrderTakeOutEnum::TAKE_OUT) {
//            log.debug("order is take out. not need allocate.");
            return;
        }
/**
        $list = $resourceCache->getResource($companyId);
		if (list == null || list.size() < 1) {
            log . error("company[" + companyId + "] has no resource.");
            // myorder.setCompanyRemark("预定失败，没有可用的餐位。");
            // myorder.setDealSts(ORDER_dealSts.rejected.getCode());
            return;
        }
		int orderPersonNum = myorder . getOrderPersonNum();
		for (Resource resource : list) {
            if (resource . getIsUsed() == YesOrNo . YES . getCode()) {
                continue;
            }

            try {
                String regs = resource . getReg();
				String[] regArr = regs . split(",");
				for (String re : regArr) {
                    if (re . equals(orderPersonNum)) {
                        resource . setIsUsed(YesOrNo . YES . getCode());
                        ResourceCache . getInstance() . updateResourceList(
                            companyId, list);
                        myorder . setCompanyRemark("桌号："
                            + resource . getResourceNo());
                        myorder . setDealSts(ORDER_dealSts . confirmed . getCode());
                        myorder . setResourceId(resource . getId());
                        return;
                    }

                }
			} catch (Exception e) {
                log . error(e);
                continue;
            }
		}
		myorder . setCompanyRemark("预定失败，餐位已全部订满");
		myorder . setDealSts(ORDER_dealSts . rejected . getCode());
		return;
 * */
    }

    public function getResource($companyId) {
        //TODO.
        return array();
    }
}





//end class file. 