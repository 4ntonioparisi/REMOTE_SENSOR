<?php
function getDati($idcliente){
    require 'db.php';
    $sql = '';
    $num = 0;
    $data = '';
    $info = '';
    $sql = 'SELECT * FROM siti, apparecchiature, dati WHERE dati.COD_Apparecchiatura = apparecchiature.Matricola AND apparecchiature.COD_Sito = siti.IdSito AND siti.COD_Cliente = '.$db->quote($idcliente).' AND siti.Stato = "0" ORDER BY dati.IdDato DESC';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['IdDato'],
            'DatiRilevati' => $row['DatiRilevati'],
            'Data' => $row['DataRilevazione'],
            'Ora' => $row['OraRilevazione'],
            'Errore' => $row['Errore'],
            'Apparecchiatura' => $row['COD_Apparecchiatura'],
            'Sito' => $row['IdSito'],
            'Marca' => $row['Marca'],
            'Posizione' => $row['Posizione'],
            'Tipologia' => $row['Tipologia'],
            'Visualizzabile' => $row['Visualizzabile']
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
            'messaggio' => 'Non esistono dati relativi a questo ambiente.'
        );
    }
    // visualizzazione dei risultati 
    return base64_encode('{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}'); 
}
function visibleDato($iddato){//funzione che setta il flag visualizzabile ad 1
    require('db.php');
    $data = array();
    $info = array();

    //inizializzo la query
    $sql = $db->prepare("SELECT * FROM dati WHERE IdDato = ".$db->quote($iddato));
    // esecuzione della query 
    $sql->execute(); 
    $dataTemp = array();
    if ($sql->rowCount() === 0){
        //dato non esistente
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Non ho trovato nessun dato.'
        );
    }else{ //l' account è già registrata

        $sql = $db->prepare("UPDATE dati SET Visualizzabile = '1'  WHERE IdDato = ".$db->quote($iddato));
        $query = $sql->execute();
        //creo l' array con i dati
        $info[] = array(
            'status' => 'success',
            'numvalori' => '1',
            'messaggio' => ''
        );
    }
    echo base64_encode('{"info":'.json_encode($info).'}');
}
function hideDato($iddato){
    //funzione che setta il flag visualizzabile ad 0
    require('db.php');
    $data = array();
    $info = array();

    //inizializzo la query
    $sql = $db->prepare("SELECT * FROM dati WHERE IdDato = ".$db->quote($iddato));
    // esecuzione della query 
    $sql->execute(); 
    $dataTemp = array();
    if ($sql->rowCount() === 0){ //dato non esistente
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Non ho trovato nessun dato.'
        );
    }else{ 
        $sql = $db->prepare("UPDATE dati SET Visualizzabile = '0'  WHERE IdDato = ".$db->quote($iddato));
        $query = $sql->execute();
        //creo l' array con i dati
        $info[] = array(
            'status' => 'success',
            'numvalori' => '1',
            'messaggio' => ''
        );

    }
    echo base64_encode('{"info":'.json_encode($info).'}');
}