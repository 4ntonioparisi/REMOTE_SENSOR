<?php
$db = '';
require 'db.php';
//leggo i parametri in input
$tipo = '';
$tipo = addslashes($_GET['tipo']);
//inizializzo una transazione
$db->beginTransaction();
//setto il set di caratteri delle query
$sql = $db->prepare('SET CHARACTER SET utf8');
$sql->execute();
//inizializzo gli array per il json
function chkEmail($email){
    //pulisco la stringa
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    //verifico e ritorno
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

require 'moduli/registrazione.php';
require 'moduli/login.php';
require 'moduli/clienti.php';
require 'moduli/amministratori.php';
require 'moduli/siti.php';
require 'moduli/apparecchiature.php';
require 'moduli/dati.php';
require 'moduli/persone.php';

if ($tipo === 'login'){
    //leggo i parametri in input
    $email = addslashes(strtolower($_GET['email']));
    $password = addslashes($_GET['password']);
    $tipoAccesso = addslashes(strtolower($_GET['tipoAccesso'])); //può contenere amministratori, clienti
    //stampo il responso
    echo htmlspecialchars(login($email, $password, $tipoAccesso));
}else if($tipo === 'addUtente'){
    //leggo i parametri in input
    $nome = addslashes(ucwords(strtolower($_GET['nome'])));
    $cognome = addslashes(ucwords(strtolower($_GET['cognome'])));
    $email = addslashes(strtolower($_GET['email']));
    $tipoAccesso = addslashes(strtolower($_GET['tipoAccesso'])); //può contenere amministratori, clienti, persone
    $password1 = addslashes($_GET['password1']);
    $password2 = addslashes($_GET['password2']);
    //stampo il responso
    echo htmlspecialchars(addUtente($nome, $cognome, $email, $tipoAccesso, $password1, $password2));
}else if($tipo === 'getClienti'){
    echo htmlspecialchars(getClienti());
}else if($tipo === 'modifyCliente'){
    //leggo i parametri in input
    $id = addslashes($_GET['id']);
    $nome = addslashes(ucwords(strtolower($_GET['nome'])));
    $cognome = addslashes(ucwords(strtolower($_GET['cognome'])));
    $email = addslashes(strtolower($_GET['email']));
    //stampo il responso
    echo htmlspecialchars(modifyCliente($id, $nome, $cognome, $email));
}else if($tipo === 'banCliente'){
    //leggo i parametri in input
    $id = addslashes($_GET['id']);
    //stampo il responso
    echo htmlspecialchars(banCliente($id));
}else if($tipo === 'unbanCliente'){
    //leggo i parametri in input
    $id = addslashes($_GET['id']);
    //stampo il responso
    echo htmlspecialchars(unbanCliente($id));
}else if($tipo === 'getAmministratori'){
    echo htmlspecialchars(getAmministratori());
}else if($tipo === 'modifyAmministratore'){
    //leggo i parametri in input
    $id = addslashes($_GET['id']);
    $nome = addslashes(ucwords(strtolower($_GET['nome'])));
    $cognome = addslashes(ucwords(strtolower($_GET['cognome'])));
    $email = addslashes(strtolower($_GET['email']));
    //stampo il responso
    echo htmlspecialchars(modifyAmministratore($id, $nome, $cognome, $email));
}else if($tipo === 'deleteAmministratore'){
    //leggo i parametri in input
    $email = addslashes(strtolower($_GET['email']));
    //stampo il responso
    echo htmlspecialchars(deleteAmministratore($email));
}else if($tipo === 'getSiti'){
    echo htmlspecialchars(getSiti());
}else if($tipo === 'addSito'){
    //leggo i parametri in input
    $nome = addslashes(ucwords(strtolower($_GET['nome'])));
    $indirizzo = addslashes(ucwords($_GET['indirizzo']));
    $citta = addslashes(ucwords($_GET['citta']));
    $provincia = addslashes(strtoupper($_GET['provincia']));
    $idcliente = addslashes(base64_decode($_GET['idcliente']));
    $idamministratore = addslashes(base64_decode($_GET['idamministratore']));
    //stampo il responso
    echo htmlspecialchars(addSito($nome, $indirizzo, $citta, $provincia, $idcliente, $idamministratore));
}else if($tipo === 'modifySito'){
    //leggo i parametri in input
    $id = addslashes(base64_decode($_GET['id']));
    $nome = addslashes(ucwords(strtolower($_GET['nome'])));
    $indirizzo = addslashes(ucwords($_GET['indirizzo']));
    $citta = addslashes(ucwords($_GET['citta']));
    $provincia = addslashes(strtoupper($_GET['provincia']));
    $idcliente = addslashes(base64_decode($_GET['idcliente']));
    //stampo il responso
    echo htmlspecialchars(modifySito($id, $nome, $indirizzo, $citta, $provincia, $idcliente));
}else if($tipo === 'banSito'){
    //leggo i parametri in input
    $id = addslashes($_GET['id']);
    //stampo il responso
    echo htmlspecialchars(banSito($id));
}else if($tipo === 'unbanSito'){
    //leggo i parametri in input
    $id = addslashes($_GET['id']);
    //stampo il responso
    echo htmlspecialchars(unbanSito($id));
}else if($tipo === 'addApparecchiatura'){
    //leggo i parametri in input
    $marca = addslashes(strtoupper($_GET['marca']));
    $posizione = addslashes(strtoupper($_GET['posizione']));
    $tipologia = addslashes(strtoupper($_GET['tipologia']));
    $descrizione = addslashes(strtoupper($_GET['descrizione']));
    $daticonsentiti = addslashes(strtolower($_GET['daticonsentiti']));
    $idsito = addslashes(base64_decode($_GET['idsito']));
    echo htmlspecialchars(addApparecchiatura($tipologia, $marca, $posizione, $descrizione, $daticonsentiti, $idsito));
}else if($tipo === 'getApparecchiature'){
    echo htmlspecialchars(getApparecchiature()); 
}else if($tipo === 'modifyApparecchiatura'){
    //leggo i parametri in input
    $id = addslashes(base64_decode($_GET['id']));
    $marca = addslashes(strtoupper($_GET['marca']));
    $posizione = addslashes(strtoupper($_GET['posizione']));
    $tipologia = addslashes(strtoupper($_GET['tipologia']));
    $descrizione = addslashes(strtoupper($_GET['descrizione']));
    $daticonsentiti = addslashes(strtolower($_GET['daticonsentiti']));
    $idsito = addslashes(base64_decode($_GET['idsito']));
    //stampo il responso
    echo htmlspecialchars(modifyApparecchiatura($id, $marca, $posizione, $tipologia, $descrizione, $daticonsentiti, $idsito));
}else if($tipo === 'getDati'){
    //leggo i parametri in input
    $idcliente = addslashes(base64_decode($_GET['idcliente']));
    echo htmlspecialchars(getDati($idcliente));
}else if($tipo === 'visibleDato'){
    $id = addslashes(base64_decode($_GET['iddato']));
    //stampo il responso
    echo htmlspecialchars(visibleDato($id));
}else if($tipo === 'hideDato'){
    $id = addslashes(base64_decode($_GET['iddato']));
    //stampo il responso
    echo htmlspecialchars(hideDato($id));
}else if($tipo === 'getTerzaParte'){
    $idpersona = addslashes(base64_decode($_GET['idpersona']));
    $idsito = addslashes(base64_decode($_GET['idsito']));
    echo htmlspecialchars(getTerzaParte($idsito, $idpersona));
}else if($tipo === 'getPersone'){
    echo htmlspecialchars(getPersone());
}else if($tipo === 'deletePersona'){
    $idpersona = addslashes(base64_decode($_GET['idpersona']));
    $idsito = addslashes(base64_decode($_GET['idsito']));
    echo htmlspecialchars(deletePersona($idpersona, $idsito));
}else if($tipo === 'addPersona'){
    $idpersona = addslashes(base64_decode($_GET['idpersona']));
    $idsito = addslashes(base64_decode($_GET['idsito']));
    echo htmlspecialchars(addPersona($idsito, $idpersona));
}else if($tipo === 'getSitiPersone'){
    $idpersona = addslashes(base64_decode($_GET['idpersona']));
    echo htmlspecialchars(getSitiPersone($idpersona));
}else if($tipo === 'getDatiPersone'){
    $idpersona = addslashes(base64_decode($_GET['idpersona']));
    echo htmlspecialchars(getDatiPersone($idpersona));
}
