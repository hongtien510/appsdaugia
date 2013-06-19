<?php
class App_Controller_FrontController extends Zend_Controller_Action {

    public function init() {
		//Duong dan den layout
        $option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/tmpdaugia');
        Zend_Layout::startMvc($option);
		$this->_SESSION=new Zend_Session_Namespace();
    }

    public function preDispatch() {
		$facebook = new Ishali_Facebook();
		$daugia = App_Models_DaugiaModel::getInstance();
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		if($facebook->getpageid() != "")
		{
			$idpage = $facebook->getpageid();
			$_SESSION['idpage'] = $idpage;
		}
		
		$userFB = $facebook->getuserfbid();
		
		if($userFB == 0){
			$infoPage = $daugia->thongTinTrang($idpage);
			
			$linkPage = $infoPage[0]['link_page'];
			$appId = $config->facebook->appid;
			
			$linkPageApp = $linkPage . '/app_' . $appId;
			$facebook->userlogin($linkPageApp);
		}
			
		
    }

    public function postDispatch() {
        
    }

}

