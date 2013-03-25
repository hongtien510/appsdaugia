<?php
class ProductController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		$idPD = $_GET["idPD"];
		
		$daugia = App_Models_DaugiaModel::getInstance();
		$ShowPhienDau = $daugia->ShowPhienDau($idPD);
		$NguoiDauCaoNhat = $daugia->NguoiDauCaoNhat($idPD);
		
		$this->view->ShowPhienDau = $ShowPhienDau;
		$this->view->NguoiDauCaoNhat = $NguoiDauCaoNhat;
        

    }

   

}
