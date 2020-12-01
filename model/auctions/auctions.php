<?php
class Auctions
{
    var $table_name = 'auctions';
    private $cols       = ['name','image','price','description','userId'];
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    function add($vals = []){
        $query = "insert into `". $this->table_name ."` (". $this->_getTableCols() .") values (". $this->_getTableVals($vals) .")";
        return mysqli_query($this->connection, $query);
    }

    function select($uid){
        $s = get('s');
        $s = intval(mysqli_real_escape_string($this->connection, (intval($s) != 0) ? intval($s) : 0));
        $s = ($s > 0) ? ($s-1) : 0;
        $s = $s * $GLOBALS['__TABLE_MAX_COUNT_PER_PAGE'];
        $e = $s + $GLOBALS['__TABLE_MAX_COUNT_PER_PAGE'];

        $query = "select auc.*,(select count(`id`) from `".$this->table_name."` where `userId` = '$uid') as totalRows,(select max(`value`) from `bids` where `auctionId`=auc.id) as highestOffer, (select count(`id`) from `bids` where `auctionId`=auc.id) as bidsCount from `". $this->table_name ."` as auc where auc.`userId`='$uid' order by auc.`id` desc limit $s,$e";
        $select = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($select) > 0)
            return $select;
        else
            return null;
    }

    function selectOne(){

        $id = get('id');
        $id = intval(mysqli_real_escape_string($this->connection, (intval($id) != 0) ? intval($id) : 0));

        $query = "select auc.*,`users`.username as username,(select max(`value`) from `bids` where `auctionId`=auc.id) as highestOffer, (select count(`id`) from `bids` where `auctionId`=auc.id) as bidsCount from `". $this->table_name ."` as auc left join `users` on (`users`.id = auc.`userId`) where auc.`id`='$id' order by auc.`id` desc limit 1";
        $select = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($select) > 0)
            return mysqli_fetch_array($select);
        else
            return null;
    }

    function lists($filter,$order){
        $s = get('s');
        $s = intval(mysqli_real_escape_string($this->connection, (intval($s) != 0) ? intval($s) : 0));
        $s = ($s > 0) ? ($s-1) : 0;
        $s = $s * $GLOBALS['__TABLE_MAX_COUNT_PER_PAGE'];
        $e = $s + $GLOBALS['__TABLE_MAX_COUNT_PER_PAGE'];

        $wh=null;
        $ord = "auc.`id` desc";
        if($filter != "" && $order != ""){
            $allowedOrders = ['latest','price-h','price-l','bids-h','bids-l'];
            $allowedFilters = ['all','rtb','to'];
            if(in_array($order, $allowedOrders)){
                switch ($order){
                    case 'latest':
                            $ord = "auc.`id` desc";
                        break;
                    case 'price-h':
                        $ord = "auc.`price` desc";
                        break;
                    case 'price-l':
                        $ord = "auc.`price` asc";
                        break;
                    case 'bids-h':
                        $ord = "`bidsCount` desc";
                        break;
                    case 'bids-l':
                        $ord = "`bidsCount` asc";
                        break;
                }
            }
            if(in_array($filter, $allowedFilters)){
                switch ($filter){
                    case 'all':
                        $wh = null;
                        break;
                }
            }
        }

        $query = "select auc.*,(select count(`id`) from `".$this->table_name."`) as totalRows,(select max(`value`) from `bids` where `auctionId`=auc.id) as highestOffer, (select count(`id`) from `bids` where `auctionId`=auc.id) as bidsCount from `". $this->table_name ."` as auc order by $ord limit $s,$e";
        $select = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($select) > 0)
            return $select;
        else
            return null;
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