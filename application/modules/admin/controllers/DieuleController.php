<?phpclass Admin_DieuleController extends App_Controller_AdminController {    public function init() {        parent::init();        $this->_SESSION=new Zend_Session_Namespace();    }    public function indexAction() {        if(!isset($this->_SESSION->iduseradmin))		{			$link = APP_DOMAIN .'/admin/loginadmin';			header("Location:$link");        }            		$daugia = App_Models_DaugiaModel::getInstance();                $sql = "Select baiviet from ishali_bid_baiviet where idbv = 1";        $data = $daugia->ThucThiTruyVan($sql);        $this->view->dieule = $data[0]["baiviet"];    }        public function chinhsuadieuleAction(){        $this->_helper->viewRenderer->setNoRender(true);		$this->_helper->layout->disableLayout();						        $daugia = App_Models_DaugiaModel::getInstance();	        $DieuLe = @$_POST["dieule"];        echo $sql = "Update ishali_bid_baiviet Set baiviet = '$DieuLe' Where idbv = 1";            $data = $daugia->ThucThiTruyVan($sql);        header("Location: ../dieule?result=2");    }	}