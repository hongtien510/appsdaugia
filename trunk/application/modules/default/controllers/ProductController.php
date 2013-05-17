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
        
		//print_r($ShowPhienDau);
		//'2013-06-08 20:00:00';
		$datebd = $ShowPhienDau[0]['tgbatdau'];
		$datekt = $ShowPhienDau[0]['tgketthuc'];
		
		$data = $daugia->KhoangGiay($datebd, $datekt);
		$TimeCountDown = $daugia->DoiGiayRaNgay($data['khoanggiay']);
		$this->view->TimeCountDown = $TimeCountDown;
		$this->view->LoaiPhienDau = $data['flag'];

    }

   

}
