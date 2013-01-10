<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleModel
 *
 * @author root
 */
class App_Models_ImageInfoModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_ImageInfoModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }

    public function put(App_Entities_ImageInfo $item, $isUpdate = 0) {

        $item->an_hien = $this->_db->safeParams($item->an_hien, 1);
        $item->cmnd = $this->_db->safeParams($item->cmnd);
        $item->email = $this->_db->safeParams($item->email);
        $item->gioi_thieu = $this->_db->safeParams($item->gioi_thieu);
        $item->gioi_tinh = $this->_db->safeParams($item->gioi_tinh, 1);
        $item->hinh_du_thi = $this->_db->safeParams($item->hinh_du_thi);
        $item->id_fb_page = $this->_db->safeParams($item->id_fb_page, 1);
        $item->id_fb_thi_sinh = $this->_db->safeParams($item->id_fb_thi_sinh, 1);
        $item->id_thi_sinh = $this->_db->safeParams($item->id_thi_sinh, 1);
        $item->luot_xem = $this->_db->safeParams($item->luot_xem, 1);
        $item->luot_binh_chon = $this->_db->safeParams($item->luot_binh_chon, 1);
        $item->mo_ta_bai_thi = $this->_db->safeParams($item->mo_ta_bai_thi);
        $item->ngay_sinh = $this->_db->safeParams($item->ngay_sinh, 1);
        $item->ngay_tham_gia = $this->_db->safeParams($item->ngay_tham_gia, 1);
        $item->so_dien_thoai = $this->_db->safeParams($item->so_dien_thoai);
        $item->ten_thi_sinh = $this->_db->safeParams($item->ten_thi_sinh);

        if ($isUpdate) {
            $value = "an_hien = '" . $item->an_hien . "'" .
                    ",cmnd = '" . $item->cmnd . "'" .
                    ",email = '" . $item->email . "'" .
                    ",gioi_thieu = '" . $item->gioi_thieu . "'" .
                    ",gioi_tinh = '" . $item->gioi_tinh . "'" .
                    ",hinh_du_thi = '" . $item->hinh_du_thi . "'" .
                    ",id_fb_page = '" . $item->id_fb_page . "'" .
                    ",id_fb_thi_sinh = '" . $item->id_fb_thi_sinh . "'" .
//                    ",luot_xem = '" . $item->luot_xem . "'" .
//                    ",luot_binh_chon = '" . $item->luot_binh_chon . "'" .
                    ",mo_ta_bai_thi = '" . $item->mo_ta_bai_thi . "'" .
                    ",ngay_sinh = '" . $item->ngay_sinh . "'" .
//                    ",ngay_tham_gia = '" . $item->ngay_tham_gia . "'" .
                    ",so_dien_thoai = '" . $item->so_dien_thoai . "'" .
                    ",ten_thi_sinh = '" . $item->ten_thi_sinh . "'";

            $question = "update " . App_Entities_ImageInfo::$TABLE . " set " . $value . " where id_thi_sinh=" . $item->id_thi_sinh;
            $result = $this->_db->executeNonQuery($question);

            if ($result != NULL) {
                return $item->id_thi_sinh;
            }
        } else {
            $input = 'an_hien
                ,cmnd
                ,email
                ,gioi_thieu
                ,gioi_tinh
                ,hinh_du_thi
                ,id_fb_page
                ,id_fb_thi_sinh
                ,luot_xem
                ,luot_binh_chon
                ,mo_ta_bai_thi
                ,ngay_sinh
                ,ngay_tham_gia
                ,so_dien_thoai
                ,ten_thi_sinh';

            $value = "'" . $item->an_hien . "'" .
                    ",'" . $item->cmnd . "'" .
                    ",'" . $item->email . "'" .
                    ",'" . $item->gioi_thieu . "'" .
                    ",'" . $item->gioi_tinh . "'" .
                    ",'" . $item->hinh_du_thi . "'" .
                    ",'" . $item->id_fb_page . "'" .
                    ",'" . $item->id_fb_thi_sinh . "'" .
                    ",'" . $item->luot_xem . "'" .
                    ",'" . $item->luot_binh_chon . "'" .
                    ",'" . $item->mo_ta_bai_thi . "'" .
                    ",'" . $item->ngay_sinh . "'" .
                    ",'" . $item->ngay_tham_gia . "'" .
                    ",'" . $item->so_dien_thoai . "'" .
                    ",'" . $item->ten_thi_sinh . "'";

            $question = "insert into " . App_Entities_ImageInfo::$TABLE . " ($input) value ($value)";
            $result = $this->_db->executeNonQuery($question);

            if ($result != NULL) {
                $item->id_thi_sinh = $this->_db->getNearIndex();
                return $item->id_thi_sinh;
            }
        }

        return 0;
    }

    public function remove($id) {
        $id = $this->_db->safeParams($id, 1);
        $question = "delete from " . App_Entities_ImageInfo::$TABLE . " where id_thi_sinh=$id";
        $result = $this->_db->executeNonQuery($question);
        return $result;
    }

    public function incrVote($id_thi_sinh) {
        $id_thi_sinh = $this->_db->safeParams($id_thi_sinh, 1);

        $output = 'luot_binh_chon';

        $question1 = "select " . $output . " from " . App_Entities_ImageInfo::$TABLE . " where id_thi_sinh=$id_thi_sinh";

        $result = $this->_db->executeReader($question1);
        $luot_binh_chon = 0;
        if (!empty($result)) {
            $luot_binh_chon = $result[0]['luot_binh_chon'];
        }
        $luot_binh_chon += 1;


        $value = "luot_binh_chon = '" . $luot_binh_chon . "'";

        $question = "update " . App_Entities_ImageInfo::$TABLE . " set " . $value . " where id_thi_sinh=" . $id_thi_sinh;
        $result = $this->_db->executeNonQuery($question);

        if ($result != NULL) {
            return $id_thi_sinh;
        }
        return 0;
    }

    public function incrView($id_thi_sinh) {
        $id_thi_sinh = $this->_db->safeParams($id_thi_sinh, 1);

        $output = 'luot_xem';

        $question1 = "select " . $output . " from " . App_Entities_ImageInfo::$TABLE . " where id_thi_sinh=$id_thi_sinh";

        $result = $this->_db->executeReader($question1);
        $luot_xem = 0;
        if (!empty($result)) {
            $luot_xem = $result[0]['luot_xem'];
        }
        $luot_xem += 1;


        $value = "luot_xem = '" . $luot_xem . "'";

        $question = "update " . App_Entities_ImageInfo::$TABLE . " set " . $value . " where id_thi_sinh=" . $id_thi_sinh;
        $result = $this->_db->executeNonQuery($question);

        if ($result != NULL) {
            return $id_thi_sinh;
        }
        return 0;
    }
    
    public function exist($id_fb_page,$id_fb_thi_sinh){
        $id_fb_page = $this->_db->safeParams($id_fb_page, 1);
        $id_fb_thi_sinh = $this->_db->safeParams($id_fb_thi_sinh, 1);

        $condition = "id_fb_page=" . $id_fb_page;
        $condition .= " and id_fb_thi_sinh=" . $id_fb_thi_sinh;

        $queryTotal = "select count(*) as total from " . App_Entities_ImageInfo::$TABLE . " where " . $condition;

        $total = $this->_db->executeReader($queryTotal);
        
        if (!empty($total)) {
            if ($total[0]['total'] < 1) {
                return true;
            }
        }
        return false;        
    }

    public function getDetail($id) {
        $item = new App_Entities_ImageInfo();

        $id = $this->_db->safeParams($id, 1);

        $output = 'id_thi_sinh
                ,an_hien
                ,cmnd
                ,gioi_thieu
                ,gioi_tinh
                ,hinh_du_thi
                ,id_fb_page
                ,id_fb_thi_sinh
                ,luot_xem
                ,luot_binh_chon
                ,mo_ta_bai_thi
                ,ngay_sinh
                ,ngay_tham_gia
                ,ten_thi_sinh
                ,email
                ,so_dien_thoai';

        $question1 = "select " . $output . " from " . App_Entities_ImageInfo::$TABLE . " where id_thi_sinh=$id";

        $result = $this->_db->executeReader($question1);
        if (!empty($result)) {
            $item = App_Entities_ImageInfo::buildData($result[0]);
        }

        return $item;
    }

    public function getListByFbPage($fbPageId, $page = 1, $count = 0) {
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;

        $output = 'id_thi_sinh
                ,an_hien
                ,cmnd
                ,gioi_thieu
                ,gioi_tinh
                ,hinh_du_thi
                ,id_fb_page
                ,id_fb_thi_sinh
                ,luot_xem
                ,luot_binh_chon
                ,mo_ta_bai_thi
                ,ngay_sinh
                ,ngay_tham_gia
                ,ten_thi_sinh';

        $fbPageId = $this->_db->safeParams($fbPageId, 1);
        $condition = "id_fb_page=" . $fbPageId;
        $condition.= " and an_hien=1";
        $order = "";
        if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }

        $queryTotal = "select count(*) as total from " . App_Entities_ImageInfo::$TABLE . " where " . $condition;

        $query = "select " . $output . " from " . App_Entities_ImageInfo::$TABLE . " where " . $condition . $order . $limit;

        $total = $this->_db->executeReader($queryTotal);
        if (!empty($total)) {
            $result['total'] = $total[0]['total'];
        }
        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
            foreach ($data as $item) {
                $imageInfo = App_Entities_ImageInfo::buildData($item);
                $result['data'][] = $imageInfo;
            }
        }
        return $result;
    }

    public function getListByFbPage_admin($fbPageId, $page = 1, $count = 0) {
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;

        $output = 'id_thi_sinh
                ,an_hien
                ,cmnd
                ,gioi_thieu
                ,gioi_tinh
                ,hinh_du_thi
                ,id_fb_page
                ,id_fb_thi_sinh
                ,luot_xem
                ,luot_binh_chon
                ,mo_ta_bai_thi
                ,ngay_sinh
                ,ngay_tham_gia
                ,ten_thi_sinh
                ,email
                ,so_dien_thoai
                ';

        $fbPageId = $this->_db->safeParams($fbPageId, 1);
        $condition = "id_fb_page=" . $fbPageId;
//        $condition.= " and an_hien=1";
        $order = "";
        if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }

        $queryTotal = "select count(*) as total from " . App_Entities_ImageInfo::$TABLE . " where " . $condition;

        $query = "select " . $output . " from " . App_Entities_ImageInfo::$TABLE . " where " . $condition . $order . $limit;

        $total = $this->_db->executeReader($queryTotal);
        if (!empty($total)) {
            $result['total'] = $total[0]['total'];
        }
        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
            foreach ($data as $item) {
                $imageInfo = App_Entities_ImageInfo::buildData($item);
                $result['data'][] = $imageInfo;
            }
        }
        return $result;
    }

    public function searchListByFbPage($fbPageId, $option, $page = 1, $count = 0) {
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;

        $output = 'id_thi_sinh
                ,an_hien
                ,cmnd
                ,gioi_thieu
                ,gioi_tinh
                ,hinh_du_thi
                ,id_fb_page
                ,id_fb_thi_sinh
                ,luot_xem
                ,luot_binh_chon
                ,mo_ta_bai_thi
                ,ngay_sinh
                ,ngay_tham_gia
                ,ten_thi_sinh';

        $fbPageId = $this->_db->safeParams($fbPageId, 1);
        $condition = "id_fb_page=" . $fbPageId;
        $condition.= " and an_hien=1";
        switch ($option['filter']) {
            case 1: {
                    $condition.= " and ten_thi_sinh like '%" . $this->_db->safeParams($option['name']) . "%'";
                    break;
                }
            case 2: {
                    $condition.= " and id_fb_thi_sinh='" . $this->_db->safeParams($option['name'], 1) . "'";
                    break;
                }
        }

        $order = "";
        if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }

        $queryTotal = "select count(*) as total from " . App_Entities_ImageInfo::$TABLE . " where " . $condition;

        $query = "select " . $output . " from " . App_Entities_ImageInfo::$TABLE . " where " . $condition . $order . $limit;

        $total = $this->_db->executeReader($queryTotal);
        if (!empty($total)) {
            $result['total'] = $total[0]['total'];
        }
        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
            foreach ($data as $item) {
                $imageInfo = App_Entities_ImageInfo::buildData($item);
                $result['data'][] = $imageInfo;
            }
        }
        return $result;
    }

    public function update_status(App_Entities_ImageInfo $item) {

        $item->an_hien = $this->_db->safeParams($item->an_hien, 1);
        $item->id_thi_sinh = $this->_db->safeParams($item->id_thi_sinh);

        if ($item->an_hien == 0) {
            $anhien = 1;
        } else {
            $anhien = 0;
        }
        $value = "an_hien = '" . $anhien . "'";

        $question = "update " . App_Entities_ImageInfo::$TABLE . " set " . $value . " where id_thi_sinh=" . $item->id_thi_sinh;
        $result = $this->_db->executeNonQuery($question);

        if ($result != NULL) {
            return $item->id_thi_sinh;
        }

        return 0;
    }

    public function getBinhchon($id,  $page = 1, $count = 0) {
   		if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;
        $id = $this->_db->safeParams($id, 1);
         if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }
		$tongbinhchon = "select count(userbc.id_users_binh_chon) as total from ishali_users_binh_chon AS userbc, ishali_thi_sinh AS thisinh where userbc.id_thi_sinh=thisinh.id_thi_sinh AND userbc.id_thi_sinh=$id ";
        $question1 = "select userbc.*, thisinh.ten_thi_sinh from ishali_users_binh_chon AS userbc, ishali_thi_sinh AS thisinh where userbc.id_thi_sinh=thisinh.id_thi_sinh AND userbc.id_thi_sinh=$id  $limit";
//        $result['total'] = $this->_db->executeReader($tongbinhchon);
        $result['data'] = $this->_db->executeReader($question1);
        
        
    	$total = $this->_db->executeReader($tongbinhchon);
        if (!empty($total)) {
            $result['total'] = $total[0]['total'];
        }
        
//         echo "<pre>";
//         print_r( $result);
//         echo "</pre>";
//         exit;	
        return $result;
    }

}

