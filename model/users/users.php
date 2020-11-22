<?php

class Users{

    private $table_name = 'users';
    private $cols       = ['username','password','isActive','lastLogin'];
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    function add($vals = []){
        $query = "insert into `". $this->table_name ."` (". $this->_getTableCols() .") values (". $this->_getTableVals($vals) .")";
        return mysqli_query($this->connection, $query);
    }

    function check($wh){
        $query = "select `id`,". $this->_getTableCols(true) ." from `".$this->table_name."` where `". mysqli_real_escape_string($this->connection,$wh[0]) ."` = '". mysqli_real_escape_string($this->connection, $wh[1]) ."' limit 1";
        $select = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($select) > 0){
            return mysqli_fetch_array($select);
        }else{
            return null;
        }
    }


    private function _getTableCols($safe = false){
        $result = '';
        foreach($this->cols as $col){
            if($safe){
               if($col == 'password'){
                   continue;
               }
            }
            $result .= '`'.$col.'`,';
        }
        return substr($result,0,strlen($result)-1);
    }
    private function _getTableVals($vals){
        $result = '';
        foreach($vals as $val){
            ($val != null) ? $result .= "'". mysqli_real_escape_string($this->connection,$val) ."'," : $result .= 'null,';
        }
        return substr($result,0,strlen($result)-1);
    }

}