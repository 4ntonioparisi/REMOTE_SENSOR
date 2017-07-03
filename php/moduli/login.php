<?php
function login($email, $password, $tipoAccesso){
    require 'db.php';
    define('PASSWORDLEN', 15);
    $data = '';
    $info = '';
    $sql = '';
    if ($email != ''){
        if (($password != '') && (strlen($password) <= PASSWORDLEN)){
            if ($tipoAccesso === 'clienti' || $tipoAccesso === 'amministratori' || $tipoAccesso === 'persone'){
                // preparazione della query 
                $sql = $db->prepare('SELECT * FROM '.$tipoAccesso.' WHERE Email = '.$db->quote($email));
                // esecuzione della query 
                $sql->execute(); 
                $dataTemp = array();
                if ($sql->rowCount() === 1) { //se ho ricevuto una riga l' account esiste
                    // creazione di un array dei risultati 
                    $dataTemp[] = $sql->fetchAll(); //lo fetcho nella cella 0
                    if (password_verify($password, $dataTemp[0][0]['Password'])) { // FIXED
                        $fetch[] = $dataTemp[0]; //lo fetcho nella cella 0
                        $id = '';
                        if ($tipoAccesso === 'clienti'){
                            if ($fetch[0][0]['Stato'] === '0'){ //se l' account del cliente è attivo
                                $data[] = array(
                                    'ID' => $fetch[0][0]['IdCliente'],
                                    'Email' => $fetch[0][0]['Email'],
                                    'Password' => $fetch[0][0]['Password'],
                                    'Nome' => $fetch[0][0]['Nome'],
                                    'Cognome' => $fetch[0][0]['Cognome'],
                                    'Tipo' => $tipoAccesso
                                );
                                //creo l' array con i dati
                                $info[] = array(
                                    'status' => 'success',
                                    'numvalori' => '1',
                                    'messaggio' => ''
                                );
                            }else{ //se l' account del cliente è sospeso
                                //creo l' array con i dati
                                $info[] = array(
                                    'status' => 'error',
                                    'numvalori' => '1',
                                    'messaggio' => 'Il tuo account è stato sospeso.'
                                );
                            }
                        }else if($tipoAccesso === 'amministratori'){
                            $data[] = array(
                                'ID' => $fetch[0][0]['IdAmministratore'],
                                'Email' => $fetch[0][0]['Email'],
                                'Password' => $fetch[0][0]['Password'],
                                'Nome' => $fetch[0][0]['Nome'],
                                'Cognome' => $fetch[0][0]['Cognome'],
                                'Tipo' => $tipoAccesso
                            );
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => '1',
                                'messaggio' => ''
                            );
                        }else{
                            $data[] = array(
                                'ID' => $fetch[0][0]['IdPersona'],
                                'Email' => $fetch[0][0]['Email'],
                                'Password' => $fetch[0][0]['Password'],
                                'Nome' => $fetch[0][0]['Nome'],
                                'Cognome' => $fetch[0][0]['Cognome'],
                                'Tipo' => $tipoAccesso
                            );
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => '1',
                                'messaggio' => ''
                            );
                        }
                    }else{ //se la password è sbagliata
                        //creo l' array con le informazioni
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => 'La password inserita è errata.'
                        );
                    }
                }else{ //se non ho nessuna riga l' account non esiste
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => "L' e-mail digitata non è registrata nel database."
                    );
                }
            }else{
                //creo l' array con i dati
                $info[] = array(
                    'status' => 'error',
                    'numvalori' => '0',
                    'messaggio' => 'Tipo non selezionato.'
                );
            }
        }else{
            //creo l' array con i dati
            $info[] = array(
                'status' => 'error',
                'numvalori' => '0',
                'messaggio' => 'La password inserita è errata. 2'
            );
        }
    }else{
        //creo l' array con i dati
        $info[] = array(
            'status' => 'error',
            'numvalori' => '0',
            'messaggio' => "L' e-mail digitata non è registrata nel database."
        );
    }
    // visualizzazione dei risultati 
    $responso = '';
    $responso = '{"infoQuery":'.json_encode($data).', "info":'.json_encode($info).'}';
    return base64_encode($responso);
}
