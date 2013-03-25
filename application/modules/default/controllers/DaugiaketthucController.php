<?php

class DaugiaketthucController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		$ShowAllPhienDauKetThuc = $daugia->ShowAllPhienDauKetThuc();
        $this->view->ShowAllPhienDauKetThuc = $ShowAllPhienDauKetThuc;
    }

   

}
