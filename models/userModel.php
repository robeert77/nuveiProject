<?php
namespace models;

use \includes\Model;

class UserModel extends Model {
    private $mysqli;
    private $tableName;

    public function __construct() {
        $this->mysqli = $this->getInstance();
        $this->tableName = 'users';
    }

    public function get($param = array(), $options = '') {
        $sql = "SELECT t1.* FROM " . $this->tableName . " AS t1";
        $sql .= " WHERE 1";
        $sql .= $this->prepareQuery($this->tableName, $param);
        $sql .= ' ' . $options;

        $rows = $this->getBySql($sql, $this->tableName, $param);
        return $rows;
    }

    public function getOne($param = array(), $options = '') {
        $rows = $this->get($param, $options . ' LIMIT 1');
        return $rows ? $rows[0] : array();
    }

    public function getArray($param = array()) {
        $rows = $this->get($param);
        $result = array();

        foreach ($rows as $row) {
            $result[$row['id']] = $row['title'];
        }

        return $result;
    }

    public function save($row) {
        $categories = $row['id_category'];
        unset($row['id_category']);

        $row['password'] = password_hash($row['password'], PASSWORD_DEFAULT);
        $row['id_department'] = $row['id_department'] ? $row['id_department'] : NULL;
        $row['id_hobby'] = $row['id_hobby'] ? $row['id_hobby'] : NULL;

        $sql = $this->getSaveQuery($row, $this->tableName);
        $idUser = $this->saveRow($sql, $this->tableName, $row);

        $row = array('id_user' => $idUser);
        foreach ($categories as $idCategory) {
            $row['id_category'] = $idCategory;
            $sql = $this->getSaveQuery($row, 'users2categories');
            $insertedInfo = $this->saveRow($sql, 'users2categories', $row);
        }

        return $idUser;
    }
}
