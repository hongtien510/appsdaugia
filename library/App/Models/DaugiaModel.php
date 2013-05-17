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
		$sql .= "where pd.idsp = sp.idsp and tgbatdau <= '" .$datenow ."' and tgketthuc > '" .$datenow ."'";
		//echo $sql;
		$data = $this->_db->executeReader($sql);
        if (!empty($data)) {
  			return $data;
        }
	}
    
    public function ShowAllPhienDauKetThuc()
	{
		$datenow = date("Y-m-d H:i:s");

/* 		$sql = "Select pd.idpd, pd.idsp, pd.giaban, tensp, urlhinh, giakhoidiem, buocgia, tgbatdau, tgketthuc, giadau ";
		$sql .= "from ishali_bid_phiendau pd, ishali_bid_sanpham sp, ishali_bid_daugia dg ";
		$sql .= "where pd.idsp = sp.idsp and pd.idpd = dg.idpd and tgketthuc > '2013-01-07 15:16:24' ";
		$sql .= "and dg.giadau >= (select MAX(giadau) as giadau from ishali_bid_daugia where dg.idpd = pd.idpd)"; */
		
		$sql  = "Select idpd, pd.idsp, pd.giaban, tensp, urlhinh, giakhoidiem, buocgia, tgbatdau, tgketthuc ";
		$sql .= "from ishali_bid_phiendau pd, ishali_bid_sanpham sp ";
		$sql .= "where pd.idsp = sp.idsp and tgketthuc < '" .$datenow ."'";
		//echo $sql;
		$data = $this->_db->executeReader($sql);
        if (!empty($data)) {
  			return $data;
        }
	}
	
	public function ShowAllPhienDauSapDienRa()
	{
		$datenow = date("Y-m-d H:i:s");

/* 		$sql = "Select pd.idpd, pd.idsp, pd.giaban, tensp, urlhinh, giakhoidiem, buocgia, tgbatdau, tgketthuc, giadau ";
		$sql .= "from ishali_bid_phiendau pd, ishali_bid_sanpham sp, ishali_bid_daugia dg ";
		$sql .= "where pd.idsp = sp.idsp and pd.idpd = dg.idpd and tgketthuc > '2013-01-07 15:16:24' ";
		$sql .= "and dg.giadau >= (select MAX(giadau) as giadau from ishali_bid_daugia where dg.idpd = pd.idpd)"; */
		
		$sql  = "Select idpd, pd.idsp, pd.giaban, tensp, urlhinh, giakhoidiem, buocgia, tgbatdau, tgketthuc ";
		$sql .= "from ishali_bid_phiendau pd, ishali_bid_sanpham sp ";
		$sql .= "where pd.idsp = sp.idsp and tgbatdau > '" .$datenow ."'";
		//echo $sql;
		$data = $this->_db->executeReader($sql);
        if (!empty($data)) {
  			return $data;
        }
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
		$sql .= "tensp, urlhinh, gioithieu, thongso, hinhanh, video, titlechiase, motachiase ";
		$sql .= "From ishali_bid_phiendau pd, ishali_bid_sanpham sp ";
		$sql .= "Where pd.idsp = sp.idsp and idpd = " . $idPD;
		
		$data = $this->_db->executeReader($sql);
		return $data;
	}
	
	public function TinhTongNgay($th)
	{
		$thang[0] = 0;
		$thang[1] = 31;
		$thang[2] = 28;
		$thang[3] = 31;
		$thang[4] = 30;
		$thang[5] = 31;
		$thang[6] = 30;
		$thang[7] = 31;
		$thang[8] = 31;
		$thang[9] = 30;
		$thang[10] = 31;
		$thang[11] = 30;
		$thang[12] = 31;
	
		$tong = 0;
		while($th > 0)
		{
			$th = $th-1;
			$tong = $tong + $thang[$th];
		}
		return $tong;
	}
	
	public function KhoangGiay($datebd, $datekt)
	{
		//2013-03-08 20:00:00
		//2013-05-17 10:00:25 -> now
		$datenow = date("Y-m-d H:i:s");
		//$datenow = '2013-05-17 11:55:00';
		
		$timenow['ng'] = substr($datenow,8,2);
		$timenow['th'] = substr($datenow,5,2);
		$timenow['nm'] = substr($datenow,0,4);
		$timenow['h'] = substr($datenow,11,2);
		$timenow['m'] = substr($datenow,14,2);
		$timenow['s'] = substr($datenow,17,2);
	
		$timebd['ng'] = substr($datebd,8,2);
		$timebd['th'] = substr($datebd,5,2);
		$timebd['nm'] = substr($datebd,0,4);
		$timebd['h'] = substr($datebd,11,2);
		$timebd['m'] = substr($datebd,14,2);
		$timebd['s'] = substr($datebd,17,2);
		
		$timekt['ng'] = substr($datekt,8,2);
		$timekt['th'] = substr($datekt,5,2);
		$timekt['nm'] = substr($datekt,0,4);
		$timekt['h'] = substr($datekt,11,2);
		$timekt['m'] = substr($datekt,14,2);
		$timekt['s'] = substr($datekt,17,2);
		
		$thang[0] = 0;
		$thang[1] = 31;
		$thang[2] = 28;
		$thang[3] = 31;
		$thang[4] = 30;
		$thang[5] = 31;
		$thang[6] = 30;
		$thang[7] = 31;
		$thang[8] = 31;
		$thang[9] = 30;
		$thang[10] = 31;
		$thang[11] = 30;
		$thang[12] = 31;
		
		$giay3 = ($timenow['ng'] - 1 + $this->TinhTongNgay($timenow['th']))*24*60*60;
		$giay4 = ($timenow['h']*60*60) + ($timenow['m']*60) + $timenow['s'];
		$giaynow = $giay3 + $giay4;
		
		$KhoangGiay = 0;
		$Flag = 0;
		//PD Dang dien ra
		if($datebd <= $datenow and $datekt > $datenow)
		{
			$giay1 = ($timekt['ng'] - 1 + $this->TinhTongNgay($timekt['th']))*24*60*60;
			$giay2 = ($timekt['h']*60*60) + ($timekt['m']*60) + $timekt['s'];
			$giaykt = $giay1 + $giay2;

			$KhoangGiay = $giaykt - $giaynow;
			$Flag = 1;
		}
		//PD Sap Dien Ra
		if($datebd > $datenow)
		{
			$giay1 = ($timebd['ng'] - 1 + $this->TinhTongNgay($timebd['th']))*24*60*60;
			$giay2 = ($timebd['h']*60*60) + ($timebd['m']*60) + $timebd['s'];
			$giaybd = $giay1 + $giay2;

			$KhoangGiay = $giaybd - $giaynow;
			$Flag = 0;
		}
			$result['khoanggiay'] = $KhoangGiay;
			$result['flag'] = $Flag;
		
		return $result;
	}
	
	public function ChenSoDu2DonVi($so)
	{
		if($so<10)
			return '0'.$so;
		return $so;
	}
	
	public function DoiGiayRaNgay($giay)
	{
		$Ngay = floor($giay / (24*60*60));
		$SoDu = $giay % (24*60*60);
		
		$Gio = floor($SoDu / (60*60));
		$SoDu1 = $SoDu % (60*60);
		
		$Phut = floor($SoDu1 / 60);
		$Giay = $SoDu1 % 60;
		
		$result['ngay'] = $this->ChenSoDu2DonVi($Ngay);
		$result['gio'] = $this->ChenSoDu2DonVi($Gio);
		$result['phut'] = $this->ChenSoDu2DonVi($Phut);
		$result['giay'] = $this->ChenSoDu2DonVi($Giay);
		
		return $result;
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
	
	
	public function DauGia($idpd, $iduser, $giadau, $ip)
	{
		$sql = "Insert into ishali_bid_daugia values('NULL', $idpd, $iduser, $giadau, now(), '$ip')";
		
        echo $sql;
		$this->_db->executeReader($sql);
	}
	
	public function DanhSachDauGia($idpd)
	{
		$sql = "Select dg.iduser, user.hoten, giadau, thoigiandau, ip, linkfb from ishali_bid_daugia dg, ishali_bid_user user where dg.iduser = user.iduser and idpd = ". $idpd ." order by thoigiandau desc";
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
	
	public function DangKyUser($IdUserFB, $username, $password, $hoten, $NameUserFB, $LinkFB, $sdt, $email, $diachi)
	{
		$sql = "Insert into ishali_bid_user values('NULL', '". $IdUserFB ."', '". $username ."', '". $password ."', '". $hoten ."', '". $NameUserFB ."', '". $LinkFB ."', '". $sdt ."', '". $email ."', '". $diachi ."', now())";
		
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
	
	public function TachThoiGian($time)
	{
		$ng =  substr($time,8,2);
		$th = substr($time,5,2);
		$nm = substr($time,0,4);
		$Ngay = $ng .'-'. $th .'-'. $nm;
		
		$Gio = substr($time,11,2);
		$Phut = substr($time,14,2);
		
		$data["ngay"] = $Ngay;
		$data["gio"] = $Gio;
		$data["phut"] = $Phut;
		
		return $data;
	}
	
	public function GomThoiGian($Ngay, $Gio, $Phut, $Giay)
	{
		$y = substr($Ngay,6,4);
		$th = substr($Ngay,3,2);
		$ng = substr($Ngay,0,2);
		
		$time = $y .'-'. $th .'-'. $ng .' '. $Gio .':'. $Phut .':'. $Giay;
		
		return $time;
	}
	
	public function GetInfoUserByIdUserFB($iduserFB)
	{
		$facebook = new Ishali_Facebook();
		$fb = $facebook->getFB();
		$info = $fb->api('/'.$iduserFB);
		return $info;
	}
	
    public function GetInfoUserFacebook()
	{
		$facebook = new Ishali_Facebook();
		$fb = $facebook->getFB();		
		$user = $fb->getUser();	
		$pages = $fb->api('/'.$user);
		return $pages;
	}

	// public function GetIdUserFB()
	// {
		// $facebook = new Ishali_Facebook();
		// $fb = $facebook->getFB();		
		// $user = $fb->getUser();	
		// return $user;
	// }
    
    function getRemoteIPAddress(){
    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    return $ip;
    }
      
    /* If your visitor comes from proxy server you have use another function
    to get a real IP address: */
    
    function getRealIPAddress(){  
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}





























