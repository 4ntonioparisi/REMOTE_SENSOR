<?php
//controllo la sessione
ini_set('error_reporting', E_ALL);
define('IDNULL', 0);
$id = 0;
$parametri = '';
$responso = '';
$pagina = '';
$url = '';
session_start();
$pagina = $_SESSION['Tipo'];
if ($id <= IDNULL || $pagina != 'amministratori'){
    if ($pagina === 'clienti')
        header('location: ../clienti/dashboard.php');
    if ($pagina === 'persone')
        header('location: ../persone/dashboard.php');
}
function getHost(){
    return 'localhost/REMOTESENSOR';
}
function getUrl($parametri){
    $url = 'http://'.getHost().'/php/function.php?';
    return $url.$parametri;
}
