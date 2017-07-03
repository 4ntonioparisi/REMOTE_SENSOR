<?php
function getSiti(){
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    $num = 0;
    $sql = 'SELECT * FROM siti ORDER BY Stato';
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
            'messaggio' => 'Non esistono amministratori.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function addSito($nome, $indirizzo, $citta, $provincia, $idcliente, $idamministratore){
    require 'db.php';
    $info = '';
    $sql = '';
    if ($idamministratore > 0){
        if ($nome != ''){
            if ($indirizzo != '' && $citta != '' && $provincia != ''){
                //inizializzo la query
                if ((int) $idcliente > 0){
                    $sql = $db->prepare('SELECT * FROM clienti WHERE IdCliente = '.$db->quote($idcliente));
                    // esecuzione della query 
                    $sql->execute(); 
                    if ($sql->rowCount() === 0) { //l' account non esiste
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => "L' e-mail non è registrata nel database."
                        );
                    }else{
                        $sql = $db->prepare('INSERT INTO siti (Nome, Indirizzo, Citta, Provincia, COD_Cliente, COD_Amministratore) 
                                VALUES ('.$db->quote($nome).', '.$db->quote($indirizzo).', '.$db->quote($citta).', '.$db->quote($provincia).',
                                 '.$db->quote($idcliente).', '.$db->quote($idamministratore).')');
                        $sql->execute();
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'success',
                            'numvalori' => '1',
                            'messaggio' => ''
                        );
                    }
                }else if((int) $idcliente === 0){ //l' account è già registrato
                    $sql = $db->prepare('INSERT INTO siti (Nome, Indirizzo, Citta, Provincia, COD_Cliente, COD_Amministratore) 
                                VALUES ('.$db->quote($nome).', '.$db->quote($indirizzo).', '.$db->quote($citta).', '.$db->quote($provincia).',
                                 '.$db->quote($idcliente).', '.$db->quote($idamministratore).')');
                    $sql->execute();
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'success',
                        'numvalori' => '1',
                        'messaggio' => ''
                    );
                }else{
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'Non sei abilitato all\' aggiunta del sito.'
                    );
                }
            }else{ //cognome non valido
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'Dati residenza non validi.'
                );
            }
        }else{ //nome non valido
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Il nome non è valido.'
            );
        }
    }else{
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => "Non sei abilitato all' operazione."
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
function modifySito($id, $nome, $indirizzo, $citta, $provincia, $idcliente){
    require 'db.php';
    $info = '';
    $sql = '';
    if ($id > 0){
        if ($nome != ''){
            if ($indirizzo != '' && $citta != '' && $provincia != ''){
                if ($idcliente > 0){
                    //inizializzo la query
                    $sql = $db->prepare('SELECT * FROM siti WHERE IdSito = '.$db->quote($id));
                    // esecuzione della query 
                    $sql->execute(); 
                    if ($sql->rowCount() === 0) { //il sito non esiste
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Non ho trovato nessun sito.'
                        );
                    }else{ //il sito esiste
                        $sql = $db->prepare('UPDATE siti SET Nome = '.$db->quote($nome).', Indirizzo = '.$db->quote($indirizzo).', Citta = '.$db->quote($citta).', Provincia = '.$db->quote($provincia).', COD_Cliente = '.$db->quote($idcliente).' WHERE IdSito = '.$db->quote($id));
                        $query = $sql->execute();
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'success',
                            'numvalori' => '1',
                            'messaggio' => ''
                        );
                    }
                }else{ //email del cliente non valida
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => "L' e-mail del cliente non è registrata nel database."
                    );
                }
            }else{ //indirizzo non valido
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => "Dati di residenza errati."
                );
            }
        }else{ //nome non valido
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => "Nome dell' ambiente non è valido."
            );
        }
    }else{ //id sito non valido
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Errore generico.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
function banSito($id){
    require 'db.php';
    $info = '';
    $sql = '';
    $id = base64_decode($id);
    if ($id > 0){
        //inizializzo la query
        $sql = $db->prepare('SELECT * FROM siti WHERE IdSito = '.$db->quote($id));
        // esecuzione della query 
        $sql->execute(); 
        if ($sql->rowCount() === 0) { //l' account non esiste
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Non ho trovato nessun sito.'
            );
        }else{ //l' account è già registrata
            $sql = $db->prepare('UPDATE siti SET Stato = "1" WHERE IdSito = '.$db->quote($id));
            $query = $sql->execute();
            //creo l' array con i dati
            $info[] = array(
                'status' => 'success',
                'numvalori' => '1',
                'messaggio' => ''
            );
        }
    }else{
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Modifica non abilitata.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
function unbanSito($id){
    require 'db.php';
    $info = '';
    $sql = '';
    $id = base64_decode($id);
    if ($id > 0){
        //inizializzo la query
        $sql = $db->prepare('SELECT * FROM siti WHERE IdSito = '.$db->quote($id));
        // esecuzione della query 
        $sql->execute(); 
        if ($sql->rowCount() === 0) { //l' account non esiste
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Non ho trovato nessun sito.'
            );
        }else{ //l' account è già registrata
            $sql = $db->prepare('UPDATE siti SET Stato = "0" WHERE IdSito = '.$db->quote($id));
            $query = $sql->execute();
            //creo l' array con i dati
            $info[] = array(
                'status' => 'success',
                'numvalori' => '1',
                'messaggio' => ''
            );
        }
    }else{
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'Modifica non abilitata.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}