<?phpclass Admin_SanphamchitietController extends App_Controller_AdminController {    public function init() {        parent::init();    }    public function indexAction() {        $daugia = App_Models_DaugiaModel::getInstance();				$idSP = @$_GET["idsp"];				$sql = "Select * from ishali_bid_sanpham where idsp = ". $idSP;				$data = $daugia->ThucThiTruyVan($sql);		$this->view->sanphamchitiet = $data;				    }		public function chinhsuasanphamAction() {		$this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();				$daugia = App_Models_DaugiaModel::getInstance();				$idSP = $_POST["idsp"];		$TenSP = $_POST["tensp"];		$GiaBan = $_POST["giaban"];		$GioiThieu = $_POST["gioithieu"];		$ThongSo = $_POST["thongso"];		$HinhAnh = $_POST["hinhanh"];		$Video = $_POST["video"];		$file = @$_FILES["uploadhinhanh"];		if($file["name"] !="")		{			$UrlHinh = @$file['name'];						$UrlHinh2 = APPLICATION_PATH ."/layouts/tmpdaugia/images/" . $UrlHinh;			move_uploaded_file($file['tmp_name'],$UrlHinh2);						$sql  = "Update ishali_bid_sanpham Set ";			$sql .= "tensp = '". $TenSP ."', ";			$sql .= "gia = '". $GiaBan ."', ";			$sql .= "urlhinh = '". $UrlHinh ."', ";			$sql .= "gioithieu = '". $GioiThieu ."', ";			$sql .= "thongso = '". $ThongSo ."', ";			$sql .= "hinhanh = '". $HinhAnh ."', ";			$sql .= "video = '". $Video ."' ";			$sql .= "Where idsp = '". $idSP ."'";		}		else		{			$sql  = "Update ishali_bid_sanpham Set ";			$sql .= "tensp = '". $TenSP ."', ";			$sql .= "gia = '". $GiaBan ."', ";			$sql .= "gioithieu = '". $GioiThieu ."', ";			$sql .= "thongso = '". $ThongSo ."', ";			$sql .= "hinhanh = '". $HinhAnh ."', ";			$sql .= "video = '". $Video ."' ";			$sql .= "Where idsp = '". $idSP ."'";		}						$daugia -> ThucThiTruyVan($sql);		header("Location: ../sanphamchitiet?result=2&idsp=".$idSP);	}			}