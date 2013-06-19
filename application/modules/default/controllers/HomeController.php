<?php

class HomeController extends App_Controller_FrontController {

    public function init() {
        parent::init();
		$this->_SESSION=new Zend_Session_Namespace();
    }

    public function indexAction() {
	
		$facebook = new Ishali_Facebook();
		if($facebook->getParameterUrl()!=null)
		{
			$idPD = $facebook->getParameterUrl();
			$host = APP_DOMAIN;
			header("location: $host/product?idPD=$idPD");
		}

		$idpage = $_SESSION['idpage'];
		
		$daugia = $this->view->info = App_Models_DaugiaModel::getInstance();
		$ShowAllPhienDau = $daugia->ShowAllPhienDau($idpage);
		$this->view->ShowAllPhienDau = $ShowAllPhienDau;
        
        $sql = "Select baiviet From ishali_bid_baiviet where idbv = 4 and idpage = '". $idpage ."'";
        
        $data = $daugia->ThucThiTruyVan($sql);
        if(count($data) > 0)
			$this->view->tinthongbao = $data[0]["baiviet"];
		else
			$this->view->tinthongbao = "";
        
    }

   

}
