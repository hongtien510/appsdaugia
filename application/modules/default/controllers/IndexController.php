<?php

class IndexController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
	
        /*         * *test lấy facebook */

//    	$facebook = new Ishali_Facebook();  
//    	$facebook->begins_works();
//    	echo $facebook->getpageid();
//    	echo '<br>';
//		$facebook->checkisadminpage();
//		$this->view->fbpageid = $facebook->getpageid();
//		$this->view->fbuserid = $facebook->getuserfbid();
//		$this->view->hasLikedPage = $facebook->haslikedpage();	
        /*         * *End test lấy facebook */

    	
    	
        $request = $this->getRequest();
        $this->view->curr_page = $request->getParam('search_page', 1);
        $this->view->count = 12;

        $result = App_Models_ImageInfoModel::getInstance()->getListByFbPage($this->view->id_fb_page, $this->view->curr_page, $this->view->count);
        $this->view->total = $result['total'];
        $this->view->listInfo = $result['data'];
        $paging = array();
        $paging['totalRecord'] = $result['total'];
        $paging['currentPage'] = $this->view->curr_page;
        $paging['numDisplay'] = 5;
        $paging['pageSize'] = $this->view->count;
        $paging['action'] = APP_DOMAIN . '/index';

        $this->view->paging = json_encode($paging);
    }

    public function detailAction() {
        $request = $this->getRequest();
        $id = $request->getParam('id', 0);

        $this->view->info = App_Models_ImageInfoModel::getInstance()->getDetail($id);
        App_Models_ImageInfoModel::getInstance()->incrView($id);
    }

    public function searchAction() {
        $request = $this->getRequest();
        $this->view->textSearch = $request->getParam('textSearch', '');
        $this->view->filter = $request->getParam('filter', 0);
        $this->view->curr_page = $request->getParam('search_page', 1);
        $this->view->count = 2;

        $option = array();
        $option['name'] = $this->view->textSearch;
        $option['filter'] = $this->view->filter;

        $result = App_Models_ImageInfoModel::getInstance()->searchListByFbPage($this->view->id_fb_page, $option, $this->view->curr_page, $this->view->count);
        $this->view->total = $result['total'];
        $this->view->listInfo = $result['data'];

        $paging = array();
        $paging['totalRecord'] = $result['total'];
        $paging['currentPage'] = $this->view->curr_page;
        $paging['numDisplay'] = 5;
        $paging['pageSize'] = $this->view->count;
        $paging['action'] = APP_DOMAIN . '/index/search';

        $this->view->paging = json_encode($paging);
        $this->view->keyword = '&textSearch='.$this->view->textSearch;
        $this->view->keyword .= '&filter='.$this->view->filter;

        $this->render('index');
    }

    public function votingAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $result = array();
        $result["errorCode"] = -1;
        $result["message"] = 'Có lỗi xảy ra';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $request->getParam('id', 0);
            if (App_Models_UserVotingModel::getInstance()->checkVoting($id, $this->view->id_user)) {
                $userVoting = new App_Entities_UserVoting();
                $userVoting->id_fb = $this->view->id_user;
                $userVoting->id_thi_sinh = $id;
                $userVoting->ngay_binh_chon = time();

                if (App_Models_UserVotingModel::getInstance()->put($userVoting) > 0) {
                    if (App_Models_ImageInfoModel::getInstance()->incrVote($id) > 0) {
                        $result["errorCode"] = 0;
                        $result["message"] = $this->view->page->cam_on_binh_chon;
                    }
                }
            }else{
                $result["message"] = 'Bạn đã bình chọn rồi !!';
            }
        }
        echo json_encode($result);
        exit();
    }

}
