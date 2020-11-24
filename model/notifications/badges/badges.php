<?php

include_once __DIR__."/../../purchases/purchases.php";
include_once __DIR__."/../../auctions/auctions.php";

class Badges
{
    private $connection;
    private $session;
    private $purchases;
    private $auctions;

    function __construct($connection,$session)
    {
        $this->connection = $connection;
        $this->session = $session;

        $this->purchases = new Purchases($connection);
        $this->auctions = new Auctions($connection);
    }

    function purchases(){
        $query = "select count(`id`) as cc from `". $this->purchases->table_name ."` where `isSeen` = '0' limit 1";
        $select = mysqli_query($this->connection, $query);
        $data = mysqli_fetch_array($select);
        return intval($data['cc']);
    }

    function sellList(){
        $query = "select count(`id`) as cc from `". $this->auctions->table_name ."` where `soldStatus` = '1' and `isSeen` = '0' limit 1";
        $select = mysqli_query($this->connection, $query);
        $data = mysqli_fetch_array($select);
        return intval($data['cc']);
    }
}