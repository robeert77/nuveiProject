<?php
namespace includes;

use mysqli;

class Model {
    private static $mysqli;

   private function __construct() {}

   public function getInstance() {
       if (!isset(self::$mysqli)) {
           self::$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
           if (self::$mysqli->connect_errno) {
               throw new Exception('Failed to connect to database: ' . self::$mysqli->connect_error);
           }
       }
       return self::$mysqli;
   }

   public function getBySql($sql, $tableName, $param = array()) {
       $stmt = self::$mysqli->prepare($sql);

       if ($param) {
           $bindInfo = $this->getBindInfo($tableName, $param);
           $stmt->bind_param($bindInfo['type'], ...$bindInfo['values']);
       }
       $stmt->execute();

       $result = $stmt->get_result();
       $rows = $result->fetch_all(MYSQLI_ASSOC);
       $stmt->close();
       return $rows;
   }

   public function saveRow($sql, $tableName, $row) {
       $stmt = self::$mysqli->prepare($sql);

       if ($row) {
           $bindInfo = $this->getBindInfo($tableName, $row);
           $stmt->bind_param($bindInfo['type'], ...$bindInfo['values']);
       }
       $stmt->execute();

       $idRow = self::$mysqli->insert_id;
       $stmt->close();

       return $idRow;
   }

   protected function getSaveQuery($row, $tableName) {
       $sql = "INSERT INTO " . $tableName . " (" . implode(', ', array_keys($row)) . ")";
       $sql .= " VALUES (" . implode(', ', array_fill(0, count($row), '?')) . ")";

       return $sql;
   }

   protected function prepareQuery($tableName, $param = array(), $tableAlias = 't1') {
       $columns = $this->getColumns($tableName);
       $sql = '';

       foreach ($columns as $field => $type) {
           if (isset($param[$field])) {
               $sql .= " AND " . $tableAlias . "." . $field . " = ?";
           }

           if (isset($param["!" . $field])) {
               $sql .= " AND " . $tableAlias . "." . $field . " != ?";
           }
       }

       return $sql;
   }

   private function getBindInfo($tableName, $param = array()) {
       $columns = $this->getColumns($tableName);
       $result = array('type' => '', 'values' => array());

       foreach ($param as $field => $value) {
           if (isset($columns[$field])) {
               $result['type'] .= $columns[$field];
               $result['values'][] = $value;
           }

           if (isset($columns[substr($field, 1)])) { // for !column
               $result['type'] .= $columns[substr($field, 1)];
               $result['values'][] = $value;
           }
       }

       return $result;
   }

    private function getColumns($tableName) {
        $sql = "SHOW COLUMNS FROM " . $tableName;

        $stmt = self::$mysqli->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $columns = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[$row['Field']] = strpos($row['Type'], 'int') === false ? 's' : 'i';
        }

        return $columns;
    }
}
