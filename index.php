<?php
require "core/init.php";

$user = DB::getInstance()->get('users', array('username','=', 'diaa'));

if(!$user->count()){

    echo 'error';
}else{

   foreach ($user->results() as $result){

       echo $result->username;
   }
}

