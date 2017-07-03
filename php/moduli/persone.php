<?php
function getTerzaParte($idsito, $idpersona){
    require 'db.php'; 
    $sql = '';
    $num = 0;
    $data = '';
    $info = '';
    $sql = $db->prepare('SELECT * FROM persone_siti WHERE COD_Sito = '.$db->quote($idsito).' AND COD_Persona = '.$db->quote($idpersona));
    $sql->execute();
    //creo l' array con i dati se num > 0
    if ($sql->rowCount() === 1){
        $data[] = array(
            'status' => 'success',
            'numvalori' => '1',
            'messaggio' => ''
        );
    }else{
        $data[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Non esistono terze parti autorizzate per questo sito.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function getPersone(){
    require 'db.php';
    $sql = '';
    $num = 0;
    $data = '';
    $info = '';
    $num = 0;
    $sql = 'SELECT * FROM persone ORDER BY Stato';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['IdPersona'],
            'Nome' => $row['Nome'],
            'Cognome' => $row['Cognome'],
            'Email' => $row['Email'],
            'Stato' => $row['Stato']
        );
        $num++;
    }
    //creo l' array con i dati se num > 0
    if ($num > 0){
        $data[] = array(
            'status' => 'success',
            'numvalori' => $num,
            'messaggio' => ''
        );
    }else{
        $data[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Non esistono persone.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function deletePersona($idpersona, $idsito){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    //inizializzo la query
    $sql = $db->prepare('SELECT * FROM persone_siti WHERE COD_Sito = '.$db->quote($idsito).' AND COD_Persona = '.$db->quote($idpersona));
    // esecuzione della query 
    $sql->execute(); 
    if ($sql->rowCount() === 0){ 
        //dato non esistente
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Nessuna associazione rilevata.'
        );
    }else{ //l' account è già registrata
        $sql = $db->prepare('DELETE FROM persone_siti WHERE COD_Persona = '.$db->quote($idpersona).' AND COD_Sito = '.$db->quote($idsito));
        $sql->execute();
        //creo l' array con i dati
        $info[] = array(
            'status' => 'success',
            'numvalori' => '1',
            'messaggio' => ''
        );
    }
    echo base64_encode('{"info":'.json_encode($info).'}');
}
function addPersona($idsito, $idpersona){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = $db->prepare('SELECT * FROM persone_siti WHERE COD_Persona = '.$db->quote($idpersona).' AND COD_Sito = '.$db->quote($idsito));
    // esecuzione della query 
    $sql->execute(); 
    $dataTemp = '';
    if ($sql->rowCount() === 0) { //dato non esistente
        $sql = $db->prepare('INSERT INTO persone_siti (COD_Persona, COD_Sito) VALUES ('.$db->quote($idpersona).', '.$db->quote($idsito).')');
        $sql->execute();
        //creo l' array con i dati
        $info[] = array(
            'status' => 'success',
            'numvalori' => '1',
            'messaggio' => ''
        );
        //creo l' array con i dati
    }else{ //l' account è già registrata
        //inizializzo la query
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => "Esiste già questa autorizzazione."
        );
    }
    echo base64_encode('{"info":'.json_encode($info).'}');
}
function getSitiPersone($idpersona){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    $num = 0;
    $sql = 'SELECT * FROM persone_siti, siti WHERE COD_Persona = '.$db->quote($idpersona).' AND COD_Sito = IdSito ORDER BY Stato';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'Persona' => $row['COD_Persona'],
            'ID' => $row['IdSito'],
            'Nome' => $row['Nome'],
            'Indirizzo' => $row['Indirizzo'],
            'Citta' => $row['Citta'],
            'Provincia' => $row['Provincia'],
            'Cliente' => $row['COD_Cliente'],
            'Amministratore' => $row['COD_Amministratore'],
            'Stato' => $row['Stato']
        );
        $num++;
    }
    //creo l' array con i dati se num > 0
    if ($num > 0){
        $data[] = array(
            'status' => 'success',
            'numvalori' => $num,
            'messaggio' => ''
        );
    }else{
        $data[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Non ci sono siti associati..'
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function getDatiPersone($idpersona){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    $num = 0;
    $sql = "SELECT * FROM persone_siti, siti, apparecchiature, dati WHERE persone_siti.COD_Persona = ".$db->quote($idpersona)." AND siti.IdSito = persone_siti.COD_Sito AND siti.IdSito = apparecchiature.COD_Sito AND dati.Visualizzabile = '1' AND siti.Stato = '0' ORDER BY dati.IdDato DESC";
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['IdSito'],
            'Nome' => $row['Nome'],
            'Indirizzo' => $row['Indirizzo'],
            'Citta' => $row['Citta'],
            'Provincia' => $row['Provincia'],
            'Cliente' => $row['COD_Cliente'],
            'Amministratore' => $row['COD_Amministratore'],
            'Tipologia' => $row['Tipologia'],
            'Marca' => $row['Marca'],
            'Posizione' => $row['Posizione'],
            'Descrizione' => $row['Descrizione'],
            'DatiRilevati' => $row['DatiRilevati'],
            'Data' => $row['DataRilevazione'],
            'Ora' => $row['OraRilevazione'],
            'Errore' => $row['Errore']
        );
        $num++;
    }
    //creo l' array con i dati se num > 0
    if ($num > 0){
        $data[] = array(
            'status' => 'success',
            'numvalori' => $num,
            'messaggio' => ''
        );
    }else{
        $data[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Nessun dato visualizzabile.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}