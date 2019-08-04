<?php
class DB{

    private static $_instance = null;
    private $_Pdo,
            $_query,
            $_error =flase,
            $_results,
            $count = 0;
}