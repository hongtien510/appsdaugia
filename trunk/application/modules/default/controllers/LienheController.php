<?php

class LienheController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		
        $sql = "Select baiviet from ishali_bid_baiviet where idbv = 2";
        $data = $daugia->ThucThiTruyVan($sql);
        
        $this->view->lienhe = $data[0]["baiviet"];
        
    }

   

}
