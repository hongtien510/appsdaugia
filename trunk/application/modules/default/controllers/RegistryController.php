<?php

class RegistryController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        // TODO:
        $facebook = new Ishali_Facebook();
//        $id_fb_page = $facebook->getpageid();
//        $this->view->id_fb_page = 388347091211147;
//        $this->view->id_user = 9999;
        
        
                $facebook = new Ishali_Facebook();
  echo       $this->view->id_fb_page = $facebook->getpageid();
//   echo "<br/>";
       echo   $this->view->id_user   = $facebook->getuserfbid();
//echo "2222";
//exit;
        /*
         * init layout
         */
        $option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH . '/default');
        Zend_Layout::startMvc($option);
    }

    public function indexAction() {
        
    }

    public function registryAction() {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new App_Entities_Users();
            $user->id_fb = $this->view->id_user;
            $user->first_name = $request->getParam('first_name', '');
            $user->middle_name = $request->getParam('middle_name', '');
            $user->last_name = $request->getParam('last_name', '');
            $user->name = $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
            $user->email = $request->getParam('email', '');
            $user->birthday = $request->getParam('birthday', 0);
            $user->gender = $request->getParam('gender', 0);
            $user->time_created = time();

            $page = new App_Entities_Pages();
            $page->id_fb_page = $this->view->id_fb_page;
            $page->id_fb = $this->view->id_user;
            $page->templates = 'tmpl1';
            $page->date_create = time();

            if (App_Models_UsersModel::getInstance()->put($user) > 0) {
                if (App_Models_PagesModel::getInstance()->put($page) > 0) {
                    $this->_redirect('/index');
                } else {
                    $this->_redirect('/registry');
                }
            } else {
                $this->_redirect('/registry');
            }
        }
    }    

}
