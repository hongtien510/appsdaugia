<?php

class LienheController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		$idpage = $_SESSION['idpage'];
        $sql = "Select baiviet from ishali_bid_baiviet where idbv = 2 and idpage = '". $idpage ."'";
        $data = $daugia->ThucThiTruyVan($sql);

		if(count($data)>0)
			 $this->view->lienhe = $data[0]["baiviet"];
		else
			$this->view->lienhe = "";
        
    }

   

}
