<?phpclass Admin_QuanlydaugiaController extends App_Controller_AdminController {    public function init() {        parent::init();    }    public function indexAction()	{        $daugia = App_Models_DaugiaModel::getInstance();				$idpd = @$_GET["idpd"];				$sql  = "Select dg.iddg, dg.idpd, tenpd, hoten, giadau, thoigiandau ";		$sql .= "From ishali_bid_daugia dg, ishali_bid_phiendau pd, ishali_bid_user us ";		$sql .= "Where dg.idpd = pd.idpd And dg.iduser = us.iduser And dg.idpd = '". $idpd ."' Order By giadau desc";				$data = $daugia->ThucThiTruyVan($sql);		$this->view->daugia = $data;    }		public function xoanguoidauAction()	{		$this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();		$daugia = App_Models_DaugiaModel::getInstance();						$idDG = @$_GET["iddg"];		$idPD = @$_GET["idpd"];		$sql = "Delete from ishali_bid_daugia where iddg = '". $idDG ."'";		$daugia->ThucThiTruyVan($sql);		header("Location: ../quanlydaugia?result=3&idpd=". $idPD);	}		}