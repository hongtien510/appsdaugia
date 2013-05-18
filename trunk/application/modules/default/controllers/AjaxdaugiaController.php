<?php

class AjaxdaugiaController extends App_Controller_FrontController {

    public function init() {
        parent::init();
		$this->_SESSION=new Zend_Session_Namespace();
    }

    public function indexAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$data = $daugia->GetIdUserByIdUserFB();
		
		$iduser = $data[0]['iduser'];
		$idpd = $_POST["idpd"];
		$giadau = $_POST["giadau"];
		//$ip = $daugia->getRemoteIPAddress();
        $ip = "192.168.1.1";
		
		$daugia->DauGia($idpd, $iduser, $giadau, $ip);
		echo "Đấu giá thành công";
		
    }
	


	public function dsdaugiaAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$idpd = $_POST["idpd"];
		$data = $daugia->DanhSachDauGia($idpd);
		//$result="";
		$str = "<p class='title_tb_ds'>Danh sách người đấu giá</p><div class='content_tb_ds'><table class='dsdaugia'><tr><th width='160'>Tên</th><th>Giá Đấu</th><th width='145'>Thời Gian Đấu</th><th width='110'>Địa Chỉ IP</th></tr>";
		for($i=0; $i<count($data); $i++)
		{
			$tgdau = $daugia->CatThoigian2($data[$i]["thoigiandau"]);
			$str .= "<tr><td><a style='color: black' href='".$data[$i]["linkfb"]."' target='_blank' title='Link Facebook'>". $data[$i]["hoten"] ."</a></td><td>". number_format($data[$i]["giadau"],0,',','.') ."đ</td><td>". $tgdau ."</td><td>".$data[$i]["ip"]."</td></tr>";
		}
		echo $str."</table></div>";
		
	}
	public function kiemtradangnhapAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		//$this->_SESSION->iduser=12345;
		
		if(isset($this->_SESSION->iduser))
			$result = 1;
		else
			$result = 0;
		$kq=array('result'=>$result);
		echo Zend_Json::encode($kq);
	}
	
	public function dangxuatAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();

		unset ($this->_SESSION->iduser);
	}
	
	public function dangnhapAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$username = $_POST["username"];
		$password = sha1($_POST["password"]);
		$IdUserFB = $_POST["IdUserFB"];
		
		$data = $daugia->DangNhap($username, $password, $IdUserFB);
		//echo count($data);
		if(count($data)==1)
		{
			$result = 1;
			$this->_SESSION->iduser=$data[0]["iduser"];
			$kq=array('result'=>$result, 'data'=>$data);
			echo Zend_Json::encode($kq);
		}
		else
		{
			$result = 0;
			$kq=array('result'=>$result);
			echo Zend_Json::encode($kq);
		}
		
	}
	
	public function kiemtraidfacebookdadangkyAction(){
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$IdUserFB = $_POST["IdUserFB"];
		//$IdUserFB = '100002151254254';
		//$username = 'hongtien510';
		
		$data1 = $daugia->KiemTraIdFB($IdUserFB);
		
		if(isset($data1[0][1]))
			$kq1 = $IdUserFB;
		else
			$kq1 = 1;
		
		
		$kq=array('IdUserFB'=>$kq1,);
			echo Zend_Json::encode($kq);
	
	}
	
	
	public function kiemtrathongtindangkyAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		//$IdUserFB = $_POST["IdUserFB"];
		$username = $_POST["username"];
		//$IdUserFB = '100002151254254';
		//$username = 'hongtien510';
		
		//$data1 = $daugia->KiemTraIdFB($IdUserFB);
		$data2 = $daugia->KiemTraUsername($username);
		// if(isset($data1[0][1]))
			// $kq1 = 1;
		// else
			// $kq1 = 0;
		
		if(isset($data2[0][1]))
			$kq2 = 0;
		else
			$kq2 = 1;
		//echo $kq1.'    '.$kq2;
		$kq=array('username'=>$kq2);
			echo Zend_Json::encode($kq);
	}
	public function dangkyAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$IdUserFB = $_POST["IdUserFB"];
		$NameUserFB = $_POST["NameUserFB"];
		$LinkFB = $_POST["LinkFB"];
		$username = $_POST["username"];
		$password = sha1($_POST["password"]);
		$hoten = $_POST["hoten"];
		$sdt = $_POST["sdt"];
		$email = $_POST["email"];
		$diachi = $_POST["diachi"];
		//exit;
		
		
		$daugia->DangKyUser($IdUserFB, $username, $password, $hoten, $NameUserFB, $LinkFB, $sdt, $email, $diachi);
		echo "Đăng ký thành công";
		//echo $IdUserFB.'     '.$username.'     '.$password.'     '.$hoten.'     '.$sdt.'     '.$email.'     '.$diachi;
	}
	
	public function testAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$data = $daugia->getRealIPAddress();
		echo ($data);
		//echo $this->_SESSION->iduser;
	}
    
    public function kiemtraketthucphiendauAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
        $idPD = $_POST["idPD"];
        $sql = "Select tgketthuc, tgbatdau From ishali_bid_phiendau where idPD = " . $idPD;
        $data = $daugia->ThucThiTruyVan($sql);
        
		$TGBatDau = $data[0]['tgbatdau'];
        $TGKetThuc = $data[0]["tgketthuc"];
        $datenow = date("Y-m-d H:i:s");

		if($TGKetThuc < $datenow)
			$result = -1;//PD Ket Thuc
		else
		{
			if($TGBatDau > $datenow)
			{
				$result = 0;//PD Dang sap dien ra
			}
			else
				$result = 1;//PD Dang dien ra
		}

        $kq=array('result'=>$result);
        echo Zend_Json::encode($kq);
		
	}
    
    public function kiemtralandaugiaAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
        
        $idPD = @$_POST["idpd"];
		$data = $daugia->GetIdUserByIdUserFB();
		$idUser = $data[0]['iduser'];

 
		$sql  = "SELECT iduser ";
		$sql .= "FROM ishali_bid_daugia ";
		$sql .= "WHERE idpd = " .$idPD." ";
		$sql .= "AND giadau = ( ";
		$sql .= "SELECT MAX( giadau ) ";
		$sql .= "FROM ishali_bid_daugia ";
		$sql .= "WHERE idpd = ". $idPD ." )";
		//echo $sql;
		
        $data = $daugia->ThucThiTruyVan($sql);
		
		if(count($data) > 0)
		{
			//echo $data[0]["iduser"];
			if ($data[0]["iduser"]==$idUser){
				echo "0";
				return;
			}
			else{
				echo "1";
				return;
			}
		}
        else
		{
            echo "1";
			return;
		}
		
    }
	
	public function laymatkhauAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$email = $_POST['email'];
		$iduserfb = $_POST['iduserfb'];
		$username = $_POST['username'];
		
		$sql = "Select iduser from ishali_bid_user ";
		$sql.= "where email = '". $email ."' and ";
		$sql.= "iduserFB = '". $iduserfb ."' and ";
		$sql.= "username = '". $username ."'";
		$data = $daugia->ThucThiTruyVan($sql);
		//echo $data[0]['iduser'];
		
		if(count($data)==1)
		{
			$sql = "Update ishali_bid_user set `password` = '". sha1(123456). "' where iduser = ". $data[0]['iduser'];
			$data = $daugia->ThucThiTruyVan($sql);
			echo 1;
		}
		else
			echo 0;
		
	}
	
	public function thaydoimatkhauAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$iduserfb = $_POST['iduserfb'];
		$oldpass = sha1($_POST['oldpass']);
		$newpass = sha1($_POST['newpass']);
		
		$sql = "Select 1 from ishali_bid_user where iduserFB = '". $iduserfb ."' and `password` = '". $oldpass ."'";
		$data = $daugia->ThucThiTruyVan($sql);
		if(count($data)==1)
		{
			$sql = "Update ishali_bid_user set `password` = '". $newpass . "' where iduserFB = '". $iduserfb ."'";
			$data = $daugia->ThucThiTruyVan($sql);
			echo 1;
		}
		else
			echo 0;
		
	}
}
