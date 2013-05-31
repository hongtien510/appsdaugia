<?php

class HomeController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
	
		$facebook = new Ishali_Facebook();
		if($facebook->getParameterUrl()!=null)
		{
			$idPD = $facebook->getParameterUrl();
			$host = APP_DOMAIN;
			header("location: $host/product?idPD=$idPD");
		}

		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		$ShowAllPhienDau = $daugia->ShowAllPhienDau();
		$this->view->ShowAllPhienDau = $ShowAllPhienDau;
        
        $sql = "Select baiviet From ishali_bid_baiviet where idbv = 4";
        
        $data = $daugia->ThucThiTruyVan($sql);
        
        $this->view->tinthongbao = $data[0]["baiviet"];
    }

   

}
