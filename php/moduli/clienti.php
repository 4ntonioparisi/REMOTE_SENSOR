<?php
function getClienti(){
    require 'db.php';
    $sql = '';
    $num = 0;
    $data = '';
    $info = '';
    $num = 0;
    $sql = 'SELECT * FROM clienti ORDER BY Stato';
    foreach($db->query($sql) as $row){
        //$info[] = $row;
        $info[] = array(
            'ID' => $row['IdCliente'],
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
            'messaggio' => 'Non esistono clienti.'
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($info).', "info":'.json_encode($data).'}';
    return base64_encode($responso);
}
function modifyCliente($id, $nome, $cognome, $email){
    require 'db.php';
    $info = '';
    $id = base64_decode($id);
    if ($id > 0){
        if ($nome != ''){
            if ($cognome != ''){
                if (chkEmail($email)){
                    //inizializzo la query
                    $sql = $db->prepare('SELECT * FROM clienti WHERE IdCliente = '.$db->quote($id));
                    // esecuzione della query 
                    $sql->execute(); 
                    if ($sql->rowCount() === 0) { //l' account non esiste
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Non ho trovato nessun account.'
                        );
                    }else{ //l' account è già registrata
                        $sql = $db->prepare('UPDATE clienti SET Email = '.$db->quote($email).', Nome = '.$db->quote($nome).', Cognome = '.$db->quote($cognome).' WHERE IdCliente = '.$db->quote($id));
                        $sql->execute();
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'success',
                            'numvalori' => '1',
                            'messaggio' => ''
                        );

                    }
                }else{ //email non valida
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'E-mail non valida.'
                    );
                }
            }else{ //cognome non valido
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'Il cognome non è valido.'
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
            'messaggio' => 'Modifica non abilitata.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
function deleteCliente($id){
    require 'db.php';
    $info = '';
    if ($id > 0){
        if ($nome != ''){
            if ($cognome != ''){
                if (chkEmail($email)){
                    //inizializzo la query
                    $sql = $db->prepare('SELECT * FROM clienti WHERE IdCliente = '.$db->quote($id));
                    // esecuzione della query 
                    $sql->execute(); 
                    if ($sql->rowCount() === 0) { //l' account non esiste
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'Non ho trovato nessun account.'
                        );
                    }else{ //l' account è già registrata
                        $sql = $db->prepare('DELETE FROM clienti WHERE IdCliente = '.$db->quote($id).' AND Nome = '.$db->quote($nome).' AND Cognome = '.$db->quote($cognome).' AND Email = '.$db->quote($email));
                        $sql->execute();
                        //creo l' array con i dati
                        if ($query === true){
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => '1',
                                'messaggio' => ''
                            );
                        }else{
                            $info[] = array(
                                'status' => 'error',
                                'numvalori' => '1',
                                'messaggio' => "Dati non corretti per l' eliminazione."
                            );
                        }

                    }
                }else{ //email non valida
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'E-mail non valida.'
                    );
                }
            }else{ //cognome non valido
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'Il cognome non è valido.'
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
            'messaggio' => 'Modifica non abilitata.'
        );
    }
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
function banCliente($id){
    require 'db.php';
    $data = '';
    $info = '';
    $id = base64_decode($id);
    if ($id > 0){
        //inizializzo la query
        $sql = $db->prepare('SELECT * FROM clienti WHERE IdCliente = '.$db->quote($id));
        // esecuzione della query 
        $sql->execute(); 
        $dataTemp = '';
        if ($sql->rowCount() === 0) { //l' account non esiste
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Non ho trovato nessun account.'
            );
        }else{ //l' account è già registrata
            $sql = $db->prepare('UPDATE clienti SET Stato = "1" WHERE IdCliente = '.$db->quote($id));
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
function unbanCliente($id){
    require 'db.php';
    $info = '';
    $id = base64_decode($id);
    if ($id > 0){
        $sql = '';
        //inizializzo la query
        $sql = $db->prepare('SELECT * FROM clienti WHERE IdCliente = '.$db->quote($id));
        // esecuzione della query 
        $sql->execute(); 
        if ($sql->rowCount() === 0) { //l' account non esiste
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'Non ho trovato nessun account.'
            );
        }else{ //l' account è già registrata
            $sql = $db->prepare('UPDATE clienti SET Stato = "0" WHERE IdCliente = '.$db->quote($id));
            $sql->execute();
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
