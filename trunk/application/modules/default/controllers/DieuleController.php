<?php

class DieuleController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		
        $sql = "Select dieule from ishali_bid_dieule";
        $data = $daugia->ThucThiTruyVan($sql);
        
        $this->view->DieuLe = $data[0]["dieule"];
        
    }

   

}
