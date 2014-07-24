<?php

function view($name, $data = array()){
    extract($data);
    include($_SERVER["DOCUMENT_ROOT"] . '/reddtip/views/' . $name . '.php');
}

function fullView($name, $data){
    view("header", $data);
    view($name, $data);
    view("footer", $data);
}

function o($thing){
    echo $thing;
}
function dbg($thing){
    var_dump($thing);
}
function post($key){
    if(!empty($_POST[$key])){
        return $_POST[$key];
    }

    return false;
}

function sqlStamp(){
    return date('Y-m-d H:i:s');
}