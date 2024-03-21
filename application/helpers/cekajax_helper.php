<?php
function cekajax(){
    if(!isset($_POST) OR !isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') exit('No direct script access allowed'); 
}
