<?php
//sostituisci il nome del dominio

//controllo la sessione
ini_set('error_reporting', E_ALL);
define('IDNULL', 0);
$id = 0;
$parametri = '';
$responso = '';
$pagina = '';
$url = '';
session_start();

function getHost(){
    return 'localhost/REMOTESENSOR';
}
function getUrl($parametri){
    $url = 'http://'.getHost().'/php/function.php?';
    return $url.$parametri;
}