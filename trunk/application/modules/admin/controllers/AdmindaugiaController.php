<?phpclass Admin_AdmindaugiaController extends App_Controller_AdminController {    public function init() {        parent::init();        $this->_SESSION=new Zend_Session_Namespace();    }    public function indexAction() {        if(!isset($this->_SESSION->iduseradminn))			header("Location:loginadmin");    }		public function xulythemsanphamAction() {        $this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();				$daugia = App_Models_DaugiaModel::getInstance();				$TenSP = $_POST["tensp"];		$GiaBan = $_POST["giaban"];		$file = @$_FILES["uploadhinhanh"];		$UrlHinh = @$file['name'];				$UrlHinh2 = APPLICATION_PATH ."/layouts/tmpdaugia/images/upload/images/" . $UrlHinh;		move_uploaded_file($file['tmp_name'],$UrlHinh2);		$GioiThieu = @$_POST["gioithieu"];		$ThongSo = @$_POST["thongso"];		$HinhAnh = @$_POST["hinhanh"];		$Video = @$_POST["video"];                $TitleFB = @$_POST["titlefb"];        $MetaFB = @$_POST["metafb"];						$sql  = "Insert into ishali_bid_sanpham Values (";		$sql .= "'null', ";		$sql .= "'". $TenSP ."', ";		$sql .= "'". $GiaBan ."', ";		$sql .= "'". $UrlHinh ."', ";		$sql .= "'". $GioiThieu ."', ";		$sql .= "'". $ThongSo ."', ";		$sql .= "'". $HinhAnh ."', ";		$sql .= "'". $Video ."', ";        $sql .= "'". $TitleFB ."', ";		$sql .= "'". $MetaFB ."')";				$kq = $daugia -> ThucThiTruyVan($sql);		header("Location: ../admindaugia?result=1");		    }		public function taophiendauAction() {        $this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();				$daugia = App_Models_DaugiaModel::getInstance();				echo 'Tao phien dau';		}		}