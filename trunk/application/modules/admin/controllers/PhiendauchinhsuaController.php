<?phpclass Admin_PhiendauchinhsuaController extends App_Controller_AdminController {    public function init(){        parent::init();    }    public function indexAction()	{		$daugia = App_Models_DaugiaModel::getInstance();		$idpd = $_GET["idpd"];		$status = @$_GET["st"];		$this->view->status = $status;				$sql = "Select * From ishali_bid_phiendau where idpd = '". $idpd ."'";		$data = $daugia->ThucThiTruyVan($sql);				$this->view->phiendauchitiet = $data;				$TGBD = $data[0]["tgbatdau"];		$TGBatDau = $daugia->TachThoiGian($TGBD);		$this->view->TGBatDau = $TGBatDau;				$TGKT = $data[0]["tgketthuc"];		$TGKetThuc = $daugia->TachThoiGian($TGKT);		$this->view->TGKetThuc = $TGKetThuc;						$sql = "Select idsp, tensp From ishali_bid_sanpham order by idsp desc";		$data = $daugia->ThucThiTruyVan($sql);				$this->view->sanpham = $data;    }		public function capnhatphiendauAction()	{		$this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();		$daugia = App_Models_DaugiaModel::getInstance();				echo $idPD = @$_POST["idpd"];		echo $tenPD = @$_POST["tenpd"];		echo $idSP = @$_POST["idsp"];		echo $GiaBan = @$_POST["giaban"];		echo $GiaKhoiDiem = @$_POST["giakhoidiem"];		echo $BuocGia = @$_POST["buocgia"];				$NgayBatDau = @$_POST["ngaybatdau"];		$GioBatDau = @$_POST["giobatdau"];		$PhutBatDau = @$_POST["phutbatdau"];				$NgayKetThuc = @$_POST["ngayketthuc"];		$GioKetThuc = @$_POST["gioketthuc"];		$PhutKetThuc = @$_POST["phutketthuc"];				$ThoiGianBatDau = $daugia->GomThoiGian($NgayBatDau, $GioBatDau, $PhutBatDau, '00');		$ThoiGianKetThuc = $daugia->GomThoiGian($NgayKetThuc, $GioKetThuc, $PhutKetThuc, '59');						$sql  = "Update ishali_bid_phiendau Set ";		$sql .= "idsp = '". $idSP ."', ";		$sql .= "tenpd = '". $tenPD ."', ";		$sql .= "giaban = '". $GiaBan ."', ";		$sql .= "giakhoidiem = '". $GiaKhoiDiem ."', ";		$sql .= "buocgia = '". $BuocGia ."', ";		$sql .= "tgbatdau = '". $ThoiGianBatDau ."', ";		$sql .= "tgketthuc = '". $ThoiGianKetThuc ."' ";		$sql .= "Where idpd = '". $idPD ."'";				$data = $daugia->ThucThiTruyVan($sql);		header("Location: ../phiendauchinhsua?st=1&result=2&idpd=".$idPD);    }	}