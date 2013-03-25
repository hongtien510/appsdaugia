<?php

class GioithieuController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		
        $sql = "Select baiviet from ishali_bid_baiviet where idbv = 3";
        $data = $daugia->ThucThiTruyVan($sql);
        
        $this->view->gioithieu = $data[0]["baiviet"];
        
    }

   

}
