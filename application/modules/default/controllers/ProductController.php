<?php
class ProductController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
		echo $idpage = $_SESSION['idpage'];
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
		
		
		$sql = "select donvitien, thongtinsp, menuthongtinsp, link_page from ishali_config where idpage = '". $idpage ."'";
		$data = $daugia->SelectQuery($sql);
		
	//Thay doi don vi tien
		if($data[0]['donvitien'] == "")
			$donvitien = "VNĐ";
		else
			$donvitien = $data[0]['donvitien'];
			
        $this->view->donvitien = $donvitien;
		
	//Link Page de gan vao Plugin Like
		if($data[0]['link_page'] != "")
			$this->view->link_page = $data[0]['link_page'];
		else
			$this->view->link_page = 'http://www.facebook.com/AgencySocialMediaMarketing';
		
	//KT xem co tuy chon mo tab menu thong tin san pham
		if($data[0]['thongtinsp']==1)
		{
			$menu = $data[0]['menuthongtinsp'];
			$list_menu = explode(";", $menu);
			$this->view->list_menu = $list_menu;
			

			for($i=0; $i<count($list_menu); $i++)
			{
				$idsp = $ShowPhienDau[0]['idsp'];
				$sql = "select noidung from ishali_thongtinsp where idsp = '". $idsp ."' and keytab = '". ($i+1) ."'";
				$data = $daugia->SelectQuery($sql);
				if(count($data) > 0)
				{
					$noidung[$i] = $data[0]['noidung'];
				}
				else
				{
					$noidung[$i] = "";
				}
			}
			$this->view->noidung = $noidung;
			
		}
		else
		{
			$this->view->list_menu = "";
		}

    }

   

}
