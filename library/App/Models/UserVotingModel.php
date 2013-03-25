<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserVotingoModel
 *
 * @author root
 */
class App_Models_UserVotingModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_UserVotingModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }

    public function put(App_Entities_UserVoting $item) {

        $item->id_users_binh_chon = $this->_db->safeParams($item->id_users_binh_chon, 1);
        $item->id_fb = $this->_db->safeParams($item->id_fb, 1);
        $item->id_thi_sinh = $this->_db->safeParams($item->id_thi_sinh, 1);
        $item->ngay_binh_chon = $this->_db->safeParams($item->ngay_binh_chon, 1);


        $input = 'id_fb
                ,id_thi_sinh
                ,ngay_binh_chon';

        $value = "'" . $item->id_fb . "'" .
                ",'" . $item->id_thi_sinh . "'" .
                ",'" . $item->ngay_binh_chon . "'";

        $question = "insert into " . App_Entities_UserVoting::$TABLE . " ($input) value ($value)";
        $result = $this->_db->executeNonQuery($question);

        if ($result != NULL) {
            $item->id_users_binh_chon = $this->_db->getNearIndex();
            return $item->id_users_binh_chon;
        }


        return 0;
    }

    public function remove($id) {
        $id = $this->_db->safeParams($id, 1);
        $question = "delete from " . App_Entities_UserVoting::$TABLE . " where id_thi_sinh=$id";
        $result = $this->_db->executeNonQuery($question);
        return $result;
    }

    public function checkVoting($id_thi_sinh, $id_fb) {

        $id_thi_sinh = $this->_db->safeParams($id_thi_sinh, 1);
        $id_fb = $this->_db->safeParams($id_fb, 1);

        $condition = "id_thi_sinh=" . $id_thi_sinh;
        $condition .= " and id_fb=" . $id_fb;

        $queryTotal = "select count(*) as total from " . App_Entities_UserVoting::$TABLE . " where " . $condition;

        $total = $this->_db->executeReader($queryTotal);
        
        if (!empty($total)) {
            if ($total[0]['total'] < 1) {
                return true;
            }
        }

        return false;
    }

    public function getList($id_thi_sinh, $page = 1, $count = 0) {
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;

        $output = 'id_users_binh_chon
                ,id_fb
                ,id_thi_sinh
                ,ngay_binh_chon';

        $id_thi_sinh = $this->_db->safeParams($id_thi_sinh, 1);
        $condition = "id_thi_sinh=" . $id_thi_sinh;
        $order = "";
        if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }

        $queryTotal = "select count(*) from " . App_Entities_UserVoting::$TABLE . " where " . $condition;

        $query = "select " . $output . " from " . App_Entities_UserVoting::$TABLE . " where " . $condition . $order . $limit;

        $total = $this->_db->executeReader($queryTotal);
        if (!empty($total)) {
            $result['total'] = $total[0];
        }
        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
            $result['data'] = $data;
        }
        return $result;
    }

}

