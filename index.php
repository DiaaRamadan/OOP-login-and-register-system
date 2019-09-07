<?php
require "core/init.php";

if (Session::exist('home')){
    echo "<p>". Session::flash('home')."</p>";
}


