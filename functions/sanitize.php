<?php

// function to escape the html characters and quotes
function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');

}
