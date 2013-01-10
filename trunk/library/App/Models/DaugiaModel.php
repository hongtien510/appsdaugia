<?php
//$this->_SESSION=new Zend_Session_Namespace();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BangmauModel
 *
 * @author root
 */
class App_Models_DaugiaModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_DaugiaModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }
	
	public function ShowAllPhienDau()
	{
		$datenow = date("Y-m-d H:i:s");

/* 		$sql = "Select pd.idpd, pd.idsp, pd.giaban, tensp, urlhinh, giakhoidiem, buocgia, tgbatdau, tgketthuc, giadau ";
		$sql .= "from ishali_bid_phiendau pd, ishali_bid_sanpham sp, ishali_bid_daugia dg ";
		$sql .= "where pd.idsp = sp.idsp and pd.idpd = dg.idpd and tgketthuc > '2013-01-07 15:16:24' ";
		$sql .= "and dg.giadau >= (select MAX(giadau) as giadau from ishali_bid_daugia where dg.idpd = pd.idpd)"; */
		
		$sql  = "Select idpd, pd.idsp, pd.giaban, tensp, urlhinh, giakhoidiem, buocgia, tgbatdau, tgketthuc ";
		$sql .= "from ishali_bid_phiendau pd, ishali_bid_sanpham sp ";
		$sql .= "where pd.idsp = sp.idsp and tgketthuc > '" .$datenow ."'";
		//echo $sql;
		$data = $this->_db->executeReader($sql);
        if (!empty($data)) {
  			return $data;
        }
        return '12345';
	}
	
	public function GiaDauCaoNhat($idPhienDau)
	{
		$sql = "select MAX(giadau) as giadau from ishali_bid_daugia where idpd = " . $idPhienDau;
		$data = $this->_db->executeReader($sql);
		return $data[0]["giadau"];

	}
	
	public function CatThoigian($time)
	{
		$str1 = substr($time,11,5);
		$d = substr($time,8,2);
		$m = substr($time,5,2);
		$y = substr($time,0,4);
		$str2 = $d . "/" . $m . "/" . $y;
		
		return $str = $str1 . " " . $str2;
	}
	
	public function CatThoigian2($time)
	{
		$str1 = substr($time,11,8);
		$d = substr($time,8,2);
		$m = substr($time,5,2);
		$y = substr($time,0,4);
		$str2 = $d . "/" . $m . "/" . $y;
		
		return $str = $str1 . " " . $str2;
	}
	
	public function ShowPhienDau($idPD)
	{
		$sql  = "Select pd.idpd, pd.idsp, giaban, giakhoidiem, buocgia, tgbatdau, tgketthuc, ";
		$sql .= "tensp, urlhinh, gioithieu, thongso, hinhanh, video ";
		$sql .= "From ishali_bid_phiendau pd, ishali_bid_sanpham sp ";
		$sql .= "Where pd.idsp = sp.idsp and idpd = " . $idPD;
		
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function NguoiDauCaoNhat($idPD)
	{
		$sql = "Select dg.iduser, hoten, giadau, thoigiandau from ishali_bid_daugia dg, ishali_bid_user user where dg.iduser = user.iduser and idpd = " . $idPD . " and giadau >= (Select Max(giadau) as giadau from ishali_bid_daugia where idpd = " . $idPD . ")";
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function TinhPhanTramGiam($giaban, $giadau)
	{
		return ceil(($giadau/$giaban)*100);
	}
	
	// public function GetInfoUserFacebook()
	// {
		// $facebook = new Ishali_Facebook();
		// $fb = $facebook->getFB();		
		// $user = $fb->getUser();	
		// $pages = $fb->api('/'.$user);
		// return $pages;
	// }
	
	public function GetIdUserFB()
	{
		$facebook = new Ishali_Facebook();
		$fb = $facebook->getFB();		
		$user = $fb->getUser();	
		return $user;
	}
	
	public function DauGia($idpd, $iduser, $giadau)
	{
		$sql = "Insert into ishali_bid_daugia values('NULL', $idpd, $iduser, $giadau, now())";
		
		$this->_db->executeReader($sql);
	}
	
	public function DanhSachDauGia($idpd)
	{
		$sql = "Select dg.iduser, user.hoten, giadau, thoigiandau from ishali_bid_daugia dg, ishali_bid_user user where dg.iduser = user.iduser and idpd = ". $idpd ." order by thoigiandau desc";
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function DangNhap($username, $password, $IdUserFB)
	{
		$sql = "Select * from ishali_bid_user where username = '".$username."' and password = '".$password."' and iduserFB = '".$IdUserFB."'";
		//echo $sql;
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function KiemTraIdFB($iduserFB)
	{
		$sql = "Select 1 from ishali_bid_user where iduserFB = '$iduserFB'";
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	public function KiemTraUsername($username)
	{
		$sql = "Select 1 from ishali_bid_user where username = '$username'";
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function DangKyUser($IdUserFB, $username, $password, $hoten, $sdt, $email, $diachi)
	{
		$sql = "Insert into ishali_bid_user values('NULL', '". $IdUserFB ."', '". $username ."', '". $password ."', '". $hoten ."', '". $sdt ."', '". $email ."', '". $diachi ."')";
		
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function GetIdUserByIdUserFB()
	{
		$facebook = new Ishali_Facebook();
		$fb = $facebook->getFB();		
		$user = $fb->getUser();	
		
		$sql = "Select iduser from ishali_bid_user where iduserFB = ". $user;
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function KiemTraSessionIdUser()
	{
		$session = new Zend_Session_Namespace();
		if(isset($session->iduser))
			return $session->iduser;
		else
			return 0;
	}
	
	public function GetInfoUserByIdUser($iduser)
	{
		$sql = "Select hoten from ishali_bid_user where iduser = ".$iduser;
		$data = $this->_db->executeReader($sql);
		return $data[0]["hoten"];
	}
	
	public function ThucThiTruyVan($sql)
	{
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	

	

    


}

