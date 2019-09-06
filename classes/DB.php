<?php
class DB{

    private static $_instance = null;
    private $_Pdo,
            $_query,
            $_error =false,
            $_results,
            $_count = 0;

    private function __construct()
    {
        try{
            $this->_Pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db_name').'',
                Config::get('mysql/username'), Config::get('mysql/password'));
        }catch (PDOException $e){

            die($e->getMessage());
        }
    }

    public static function getInstance(){

        if(!isset(self::$_instance)){

             self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()){
        $this->_error = false;
        if($this->_query = $this->_Pdo->prepare($sql)){
            if(count($params)){
                $x = 1;
                foreach ($params as $param){

                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()){

                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();

            }else{

                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array()){

        if(count($where)){
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            $operators = array('=', '<', '>', ',<=', '>=');
            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if(!$this->query($sql, array($value))->error()){

                    return $this;
                }
            }

        }
        return false;
    }
    public function get($table, $where){
        return $this->action("SELECT * ", $table, $where);
    }

    public function delete($table, $where){
        return $this->action("delete", $table, $where);
    }

    public function insert($table, $fields = array()){

        $keys = array_keys($fields);
        $values = null;
        $count = 1;
        foreach($fields as $field){
            $values .='?';
            if($count < count($fields)){
                $values .= ',';
            }
            $count++;
        }
        $sql = "INSERT INTO $table (`".implode('`,`', $keys)."`) VALUES({$values})";
        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;
    }

    public function update($table, $id, $fields = array()){
        $set =" ";
        $count = 1;
        foreach ($fields as $key => $value){
            $set .=$key.'=?';
            if($count < count($fields)){
                $set .=',';
            }
            $count++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if (!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;

    }

    public function error(){

        return $this->_error;
    }

    public function count(){

        return $this->_count;
    }
    public function results(){
        return $this->_results;
    }
}