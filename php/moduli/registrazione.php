<?php
function addUtente($nome, $cognome, $email, $tipoAccount, $password1, $password2){
    require 'db.php';
    define('PASSWORDLEN', 15);
    $data = '';
    $info = '';
    if ($nome != ''){
        if ($cognome != ''){
            if (chkEmail($email)){
                if (strlen($password1) <= PASSWORDLEN && $password2 === $password1){
                    if ($tipoAccount === 'amministratori' || $tipoAccount === 'clienti' || $tipoAccount === 'persone'){
                        $password1 = password_hash($password1, PASSWORD_BCRYPT, array('cost' => 13));
                        //inizializzo la query
                        $sql = '';
                        $sql = $db->prepare('SELECT * FROM '.$tipoAccount.' WHERE Email = '.$db->quote($email));
                        // esecuzione della query 
                        $sql->execute(); 
                        $dataTemp = '';
                        if ($sql->rowCount() === 0) { //l' account non esiste
                            $sql = $db->prepare('INSERT INTO '.$tipoAccount.' (Email, Password, Nome, Cognome) VALUES ('.$db->quote($email).', '.$db->quote($password1).', '.$db->quote($nome).', '.$db->quote($cognome).')');
                            $query = '';
                            $query = $sql->execute();
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'success',
                                'numvalori' => $sql->rowCount(),
                                'messaggio' => ''
                            );
                        }else{ //l' account è già registrata
                            //creo l' array con i dati
                            $info[] = array(
                                'status' => 'error',
                                'numvalori' => '0',
                                'messaggio' => "L' email digitata è già registrata nel database."
                            );
                        }
                    }else{ //password2 non valida
                        //creo l' array con i dati
                        $info[] = array(
                            'status' => 'error',
                            'numvalori' => '0',
                            'messaggio' => "Impossibile creare l' account; indicare il tipo."
                        );
                    }
                }else{ //password1 non valida
                    //creo l' array con i dati
                    $info[] = array(
                        'status' => 'error',
                        'numvalori' => '0',
                        'messaggio' => 'Attenzione! Le password devono avere: <br>-meno di 15 caratteri.<br>-devono essere uguali.'
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
    $risultato = '';
    $risultato = '{"info":'.json_encode($info).'}';
    echo base64_encode($risultato);
}
?>