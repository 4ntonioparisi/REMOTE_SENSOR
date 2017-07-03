<?php
function addApparecchiatura($tipologia, $marca, $posizione, $descrizione, $daticonsentiti, $idsito){ 
    require 'db.php';
    $info = '';
    $sql = '';
    if ($tipologia != '') {
        if ($marca != '') {
            if ($posizione != '') {
                if ($daticonsentiti != '') {
                    if ($idsito > 0) {
                        //inizializzo la query
                        $sql = $db->prepare('SELECT * FROM siti WHERE IdSito = '.$db->quote($idsito));
                        // esecuzione della query 
                        $sql->execute(); 
                        if ($sql->rowCount() === 1) { //il sito esiste
                            $sql = $db->prepare('INSERT INTO apparecchiature (Tipologia, Marca, Posizione, Descrizione, DatiConsentiti, COD_Sito) VALUES ('.$db->quote($tipologia).', '.$db->quote($marca).', '.$db->quote($posizione).', '.$db->quote($descrizione).','.$db->quote($daticonsentiti).','.$db->quote($idsito).')');
                            $sql->execute();
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => '1',
                                'messaggio' => ''
                            );
                        }else{ //il sito non esiste
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'error',
                                'numvalori' => '0',
                                'messaggio' => 'Il sito non esiste.'
                            );
                        }
                    }else{ //il sito è vuoto
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Il sito non esiste.'
                        );
                    }
                }else{ //dati consentiti non validi
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'I dati consentiti non sono validi.'
                    );
                }
            }else{ //posizione non valida
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'Posizione non valida.'
                );
            }
        }else{ //marca non valida
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'La marca non è valida.'
            );
        }
    }else{ //tipologia non valida
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'La tipologia non è valida.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '{"info":'.json_encode($info).'}';
    return base64_encode($responso);
}
function getApparecchiature() {
    require 'db.php';
    $data = '';
    $info = '';
    $sql = '';
    $num = 0;
    $sql = 'SELECT * FROM Apparecchiature GROUP BY COD_Sito';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['Matricola'],
            'Tipologia' => $row['Tipologia'],
            'Marca' => $row['Marca'],
            'Posizione' => $row['Posizione'],
            'Descrizione' => $row['Descrizione'],
            'DatiConsentiti' => $row['DatiConsentiti'],
            'Sito' => $row['COD_Sito']
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
            'messaggio' => 'Non esistono apparecchiature.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function modifyApparecchiatura($id, $marca, $posizione, $tipologia, $descrizione, $daticonsentiti, $codsito) {
    require 'db.php';
    $info = '';
    $sql = '';
    if ($id > 0) {
        if ($marca != '' && $tipologia != '') {
            if ($posizione != '') {
                if ($daticonsentiti != '') {
                    if ($codsito > 0) {
                        //inizializzo la query
                        $sql = $db->prepare('SELECT * FROM apparecchiature WHERE Matricola = '.$db->quote($id));
                        // esecuzione della query 
                        $sql->execute(); 
                        $dataTemp = array();
                        if ($sql->rowCount() === 0){ //l' account non esiste
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'error',
                                'numvalori' => '0',
                                'messaggio' => 'Non ho trovato nessuna apparecchiatura.'
                            );
                        }else{ //l' account è già registrata
                            $sql = $db->prepare('UPDATE apparecchiature SET Marca = '.$db->quote($marca).', Posizione = '.$db->quote($posizione).', Tipologia = '.$db->quote($tipologia).', Descrizione = '.$db->quote($descrizione).', DatiConsentiti = '.$db->quote($daticonsentiti).', COD_Sito = '.$db->quote($codsito).' WHERE Matricola = '.$db->quote($id));
                            $query = $sql->execute();
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => '1',
                                'messaggio' => ''
                            );

                        }
                    }else{ //cod sito non valido
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Codice sito non valido.'
                        );
                    }
                }else{//dati consentiti non valido
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'I dati consentiti non sono validi.'
                    );    
                }
            }else{//posizione non valida
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'La posizione non è valida.'
                );   
            }
        }else{ //marca non valido
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Dati sul sensore non validi.'
            );
        }
    }else{ //id non valido
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => 'La matricola non è valida.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '{"info":'.json_encode($info).'}';
    return base64_encode($responso);
}

