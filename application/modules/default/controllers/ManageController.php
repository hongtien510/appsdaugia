<?php

class ManageController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        
    }

    public function configAction() {
        $request = $this->getRequest();
        $page = new App_Entities_Pages();

//         $facebook = new Ishali_Facebook();        	
//         $this->view->id_fb_page =  $_SESSION['idpage'];
//         $this->view->id_user   = $facebook->getuserfbid();
//         if($this->view->id_fb_page <= 0)
//         {
//       		   $this->view->id_fb_page =  $_SESSION['idpage'];
//         }else 
//         {
//        	  $_SESSION['idpage'] =  $this->view->id_fb_page;
//        	  
//         }


        $page = App_Models_PagesModel::getInstance()->getDetail($this->view->id_fb_page);
        if ($page->id_pages > 0) {
            if ($request->isPost()) {
                $page->an_hien = $request->getParam('status', 0);
                $page->background_color = $request->getParam('background_color', '');
                $page->background_images = $request->getParam('background_images', '');
                $page->banner = $request->getParam('banner', '');
                $page->banner_link = $request->getParam('banner_link', '');
                $page->cam_on_binh_chon = $request->getParam('cam_on_binh_chon', '');
                $page->cam_on_tham_gia = $request->getParam('cam_on_tham_gia', '');
                $page->color = $request->getParam('color', '');
                $page->font_size = $request->getParam('font_size', '');
                $page->footer = $request->getParam('footer', '');
                $page->like_binh_chon = $request->getParam('like_binh_chon', 0);
                $page->like_comment = $request->getParam('like_comment', 0);
                $page->like_tham_gia = $request->getParam('like_tham_gia', 0);
                $page->page_name = $request->getParam('page_name', '');
                $page->show_gioi_thieu = $request->getParam('show_gioi_thieu', 0);
                $page->show_gioi_tinh = $request->getParam('show_gioi_tinh', 0);
                $page->show_luot_xem = $request->getParam('show_luot_xem', 0);
                $page->show_ma = $request->getParam('show_ma', 0);
                $page->show_so_binh_chon = $request->getParam('show_so_binh_chon', 0);
                $page->show_ten = $request->getParam('show_ten', 0);
                $page->so_lan_binh_chon = $request->getParam('so_lan_binh_chon', 1);
                $page->templates = $request->getParam('tmpl', 'tmpl1');

                if (App_Models_PagesModel::getInstance()->put($page, 1) > 0) {
                    $this->view->message = 'Lưu thành công';
                } else {
                    $this->view->message = 'Lưu thất bại';
                }
            }
        }
        $this->view->pageItem = $page;
    }

    public function joinAction() {
        $this->view->errorCode = -1;
        $request = $this->getRequest();
        $info = new App_Entities_ImageInfo();

        if ($request->isPost()) {
            $info->id_fb_thi_sinh = $this->view->id_user;
            $info->id_fb_page = $this->view->id_fb_page;
            if (App_Models_ImageInfoModel::getInstance()->exist($info->id_fb_page, $info->id_fb_thi_sinh)) {
                $info->ngay_tham_gia = time();

                $info->an_hien = $request->getParam('status', 0);
                $info->cmnd = $request->getParam('cmnd', '');
                $info->so_dien_thoai = $request->getParam('so_dien_thoai', '');
                $info->email = $request->getParam('email', '');
                $info->gioi_thieu = $request->getParam('gioi_thieu', '');
                $info->gioi_tinh = $request->getParam('gender', 0);
                $hinh_du_thi = $request->getParam('hinh_du_thi', '');
                $arr = split("[;]", $hinh_du_thi);
                $info->hinh_du_thi = json_encode($arr);

                $info->mo_ta_bai_thi = $request->getParam('mo_ta_bai_thi', '');
                $birthday = $request->getParam('birthday', '');
                if (!empty($birthday)) {
                    $arr = split("[/,-,:, ]", $birthday);
                    $info->ngay_sinh = mktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
                }

                $info->ten_thi_sinh = $request->getParam('name', '');

                if (App_Models_ImageInfoModel::getInstance()->put($info) > 0) {
                    $this->view->message = 'Lưu thành công';
                    $this->view->errorCode = 0;
                } else {
                    $this->view->message = 'Lưu thất bại';
                }

                $this->view->hinh_du_thi = $hinh_du_thi;
            }else{
                $this->view->message = 'Bạn đã đăng ký tham gia rồi !!';
            }
        }

        $this->view->info = $info;
    }

    public function uploadAction() {
        $request = $this->getRequest();
        $callback = $request->getParam('callback', '');
        $data = array();
        $max_size = 1024 * 1024;
        if ($_FILES['data_src']['size'] < $max_size) {
            $path = App_Utils_Util::uploadFile($_FILES['data_src']);
            if ($path != '') {
                $data['errorCode'] = 0;
                $data['message'] = 'Upload thành công';
                $data['data'] = $path;
            } else {
                $data['errorCode'] = -1;
                $data['message'] = 'Có lỗi xảy ra!';
            }
        }
        $html = '<div id="data">' . json_encode($data) . '</div>';
        $html .= '<script type="text/javascript">
            var data;
            data = document.getElementById("data").innerHTML;            
            data = eval(\'(\'+data+\')\');
            parent.' . $callback . '(data);
            </script>';
        echo $html;
        exit();
    }

}
