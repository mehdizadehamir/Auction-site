<?php
class Users{

    private $table_name = 'users';
    private $cols       = ['token','username','password'];
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    function add($vals = []){
        $query = "insert into `". $this->table_name ."` (". $this->_getTableCols() .") values (". $this->_getTableVals($vals) .")";
        return mysqli_query($this->connection, $query);
    }

    function getWallet($uid){
        $query = "select `wallet` from `". $this->table_name ."` where `id`='$uid' limit 1";
        $select = mysqli_query($this->connection,$query);
        if(mysqli_num_rows($select) > 0){
            $data = mysqli_fetch_array($select);
            return $data['wallet'];
        }else{
            return 0;
        }
    }
    function updateCredit($credit_value,$uid){
        $query = "insert into `credits` (`userId`,`value`) values ('$uid','$credit_value')";
        $select = mysqli_query($this->connection, $query);
        if($select){
            $query3 = "update `users` set `wallet`=`wallet` + ($credit_value) where `id`='$uid'";
            mysqli_query($this->connection,$query3);
            return true;
        }else{
            return false;
        }
    }
    function update($wh){
        $whes = '';
        foreach ($wh as $key => $value){
            $whes .= "`". mysqli_real_escape_string($this->connection,$key) ."`='". mysqli_real_escape_string($this->connection,$value) ."',";
        }
        $whes = substr($whes,0,strlen($whes));
        $query = "update `". $this->table_name ."` set $whes";
        $select = mysqli_query($this->connection, $query);
        if($select){
            return true;
        }else{
            return false;
        }
    }

    function checkLogin($u,$p){
        $query = "select `id`,". $this->_getTableCols(true) ." from `".$this->table_name."` where `username` = '". mysqli_real_escape_string($this->connection, $u) ."' and `password`='". mysqli_real_escape_string($this->connection, $p) ."' limit 1";
        $select = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($select) > 0){
            return mysqli_fetch_array($select);
        }else{
            return null;
        }
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