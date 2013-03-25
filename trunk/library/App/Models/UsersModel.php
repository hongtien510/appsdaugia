<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersModel
 *
 * @author root
 */
class App_Models_UsersModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_UsersModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }

    public function put(App_Entities_Users $item, $isUpdate = 0) {

        $item->id_users = $this->_db->safeParams($item->id_users, 1);
        $item->id_fb = $this->_db->safeParams($item->id_fb, 1);
        $item->email = $this->_db->safeParams($item->email);
        $item->name = $this->_db->safeParams($item->name);
        $item->first_name = $this->_db->safeParams($item->first_name);
        $item->middle_name = $this->_db->safeParams($item->middle_name);
        $item->last_name = $this->_db->safeParams($item->last_name);
        $item->birthday = $this->_db->safeParams($item->birthday, 1);
        $item->gender = $this->_db->safeParams($item->gender, 1);
        $item->time_created = $this->_db->safeParams($item->time_created, 1);


        if ($isUpdate) {
            $value = "id_fb = '" . $article->id_fb . "'," .
                    "email = '" . $article->email . "'," .
                    "first_name = '" . $article->first_name . "'," .
                    "middle_name = '" . $article->middle_name . "'," .
                    "last_name = '" . $article->last_name . "'," .
                    "birthday = '" . $article->birthday . "'," .
                    "gender = '" . $article->gender . "'," .
                    "time_created = '" . $article->time_created . "'";

            $question = "update " . App_Entities_Users::$TABLE . " set " . $value . " where id_users=" . $item->id_users;
            $result = $this->_db->executeNonQuery($question);

            if ($result != NULL) {
                return $item->id_users;
            }
        } else {
            $input = 'id_fb
                ,email
                ,first_name
                ,middle_name
                ,last_name
                ,birthday
                ,gender
                ,time_created';

            $value = "'" . $item->id_fb . "'" .
                    ",'" . $item->email . "'" .
                    ",'" . $item->first_name . "'" .
                    ",'" . $item->middle_name . "'" .
                    ",'" . $item->last_name . "'" .
                    ",'" . $item->birthday . "'" .
                    ",'" . $item->gender . "'" .
                    ",'" . $item->time_created . "'";

            $question = "insert into " . App_Entities_Users::$TABLE . " ($input) value ($value)";
            $result = $this->_db->executeNonQuery($question);

            if ($result != NULL) {
                $item->id_users = $this->_db->getNearIndex();
                return $item->id_users;
            }
        }

        return 0;
    }

    public function remove($id) {
        $id = $this->_db->safeParams($id, 1);
        $question = "delete from " . App_Entities_Users::$TABLE . " where id_users=$id";
        $result = $this->_db->executeNonQuery($question);
        return $result;
    }

    public function getDetail($id) {
        $item = new App_Entities_Users();

        $id = $this->_db->safeParams($id, 1);

        $output = 'id_users
                ,id_fb
                ,email
                ,first_name
                ,middle_name
                ,last_name
                ,birthday
                ,gender
                ,time_created';

        $question1 = "select " . $output . " from " . App_Entities_Users::$TABLE . " where id_users=$id";

        $result = $this->_db->executeReader($question1);
        if (!empty($result)) {
            $item = App_Entities_Users::buildData($result[0]);
        }

        return $item;
    }
    
    public function getList($page = 1, $count = 0) {
        if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;

        $output = 'id_users
                ,id_fb
                ,email
                ,first_name
                ,middle_name
                ,last_name
                ,birthday
                ,gender
                ,time_created';

        
        $condition = "";
        $order = "";
        if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }

        $queryTotal = "select count(*) from " . App_Entities_Users::$TABLE . " where " . $condition;

        $query = "select " . $output . " from " . App_Entities_Users::$TABLE . " where " . $condition . $order . $limit;

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

