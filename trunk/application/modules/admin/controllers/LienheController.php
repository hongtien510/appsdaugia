<?phpclass Admin_LienheController extends App_Controller_AdminController {    public function init() {        parent::init();        $this->_SESSION=new Zend_Session_Namespace();    }    public function indexAction() {        if(!isset($this->_SESSION->iduseradmin))			header("Location:loginadmin");		$daugia = App_Models_DaugiaModel::getInstance();                $sql = "Select baiviet from ishali_bid_baiviet where idbv = 2";        $data = $daugia->ThucThiTruyVan($sql);        $this->view->lienhe = $data[0]["baiviet"];    }        public function chinhsualienheAction(){        $this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();		        $daugia = App_Models_DaugiaModel::getInstance();	        $Lienhe = @$_POST["lienhe"];        echo $sql = "Update ishali_bid_baiviet Set baiviet = '$Lienhe' Where idbv = 2";            $data = $daugia->ThucThiTruyVan($sql);        header("Location: ../lienhe?result=2");    }	}