<?php

class DaugiasapdienraController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		
		$idpage = $_SESSION['idpage'];
		
		$ShowAllPhienDauSapDienRa = $daugia->ShowAllPhienDauSapDienRa($idpage);
        $this->view->ShowAllPhienDauSapDienRa = $ShowAllPhienDauSapDienRa;
    }

   

}
