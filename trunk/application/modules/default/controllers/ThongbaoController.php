<?php

class ThongbaoController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        /*
         * init layout
         */
        $option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/default');
        Zend_Layout::startMvc($option);
    }

    public function indexAction() {
        
    }


}
