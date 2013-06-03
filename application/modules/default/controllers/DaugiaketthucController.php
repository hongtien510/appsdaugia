<?php

class DaugiaketthucController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		$idpage = $_SESSION['idpage'];
		
		$ShowAllPhienDauKetThuc = $daugia->ShowAllPhienDauKetThuc($idpage);
        $this->view->ShowAllPhienDauKetThuc = $ShowAllPhienDauKetThuc;
    }

   

}
