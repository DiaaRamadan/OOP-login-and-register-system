<?php
require "core/init.php";

$user = DB::getInstance()->update('users',2,[

    'username' => 'newinsert',
    'password' => 'new password'

]);


