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
		
		$idpd = $_POST["idpd"];
		$iduser = $_POST["iduser"];
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
		$str = "<p class='title_tb'>Danh sách người đấu giá</p><div class='content_tb'><table class='dsdaugia'><tr><th width='160'>Tên</th><th>Giá Đấu</th><th width='125'>Thời Gian Đấu</th></tr>";
		for($i=0; $i<count($data); $i++)
		{
			$tgdau = $daugia->CatThoigian2($data[$i]["thoigiandau"]);
			$str .= "<tr><td>". $data[$i]["hoten"] ."</td><td>". number_format($data[$i]["giadau"],0,',','.') ."đ</td><td>". $tgdau ."</td></tr>";
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
	public function kiemtrathongtindangkyAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
		
		$IdUserFB = $_POST["IdUserFB"];
		$username = $_POST["username"];
		//$IdUserFB = '100002151254254';
		//$username = 'hongtien510';
		
		$data1 = $daugia->KiemTraIdFB($IdUserFB);
		$data2 = $daugia->KiemTraUsername($username);
		if(isset($data1[0][1]))
			$kq1 = 1;
		else
			$kq1 = 0;
		
		if(isset($data2[0][1]))
			$kq2 = 1;
		else
			$kq2 = 0;
		//echo $kq1.'    '.$kq2;
		$kq=array('IdUserFB'=>$kq1, 'username'=>$kq2);
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
        //echo $idPD = 19;
        $sql = "Select tgketthuc From ishali_bid_phiendau where idPD = " . $idPD;
        $data = $daugia->ThucThiTruyVan($sql);
        
        $TGKetThuc = $data[0]["tgketthuc"].'<br/>';
        $datenow = date("Y-m-d H:i:s");
        
        if($TGKetThuc>$datenow)
            $result = 1;
        else
            $result = 0;
            
        $kq=array('result'=>$result);
        echo Zend_Json::encode($kq);
	}
    
    public function kiemtralandaugiaAction() {
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		$daugia = App_Models_DaugiaModel::getInstance();
        
        $idPD = @$_POST["idpd"];
        $idUser = @$_POST["iduser"];
        
        $sql = "SELECT MAX( giadau ), iduser FROM ishali_bid_daugia WHERE idpd = ". $idPD;
        $data = $daugia->ThucThiTruyVan($sql);
        
        if ($data[0]["iduser"]==$idUser)
            echo "0";
        else
            echo "1";
    }
}
