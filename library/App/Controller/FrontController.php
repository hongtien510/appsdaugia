<?php
class App_Controller_FrontController extends Zend_Controller_Action {

    public function init() {
		//Duong dan den layout
        $option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/tmpdaugia');
        Zend_Layout::startMvc($option);
    }

    public function preDispatch() {
	
		
		$facebook = new Ishali_Facebook();
		$facebook->getuserfbid();
		if($facebook->getpageid() != "")
		{
			@$idpage = $facebook->getpageid();
			@$_SESSION['idpage'] = $idpage;
		}
		else
		{
			@$idpage = $_SESSION['idpage'];
		}
    }

    public function postDispatch() {
        
    }

}

