<?php
namespace models;

use \includes\Model;

class DepartmentModel extends Model {
    private $mysqli;
    private $tableName;

    public function __construct() {
        $this->mysqli = $this->getInstance();
        $this->tableName = 'departments';
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
        return $rows[0];
    }

    public function getArray($param = array()) {
        $rows = $this->get($param);
        $result = array();

        foreach ($rows as $row) {
            $result[$row['id']] = $row['title'];
        }

        return $result;
    }
}
