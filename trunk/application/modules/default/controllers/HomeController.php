<?php

class HomeController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		$ShowAllPhienDau = $daugia->ShowAllPhienDau();
		$this->view->ShowAllPhienDau = $ShowAllPhienDau;
    }

   

}
