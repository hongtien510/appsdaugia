<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BangmauModel
 *
 * @author root
 */
class App_Models_BangmauModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_BangmauModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }
	
	public function getList( $count = 10, $enable = -1) {
        $result = array();
        $output = 'id,
					ten,
					ma,
					`order`';
      
        $order = "";

      $query = "select " . $output . " from " . App_Entities_Bangmau::$TABLE . "  "  . $order;
        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
  			 return $data;
        }
        return '';
    }
    


}

