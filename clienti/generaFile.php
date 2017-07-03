<?php
require 'header.php';

$idcliente = addslashes($_GET['idcliente']);
$idsito = addslashes($_GET['idsito']);
$status = '';
$status = generaFile($idcliente, $idsito);
if ($status === true){
    echo 'File generato; per vederlo <a href="generatedFile/data'.htmlspecialchars($idsito).'.txt">clicca qui</a>';
}
function generaFile($idcliente, $idsito){
    $parametri = 'tipo=getSiti';
    $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
    $numsiti = 0;
    $status = '';
    //leggo i dati
    $numsiti = $siti->info[0]->numvalori;
    $status = $siti->info[0]->status;
    //se ci sono amministratori
    if ($numsiti > 0 && $status === 'success'){
        $i = 0;        
        //imposto il ciclo che va da 0 fino al numero di siti
        for ($i = 0; $i < $numsiti; $i++){
            //se il sito che sto analizzando appartiene al cliente che ha effettuato il login
            if ($siti->infoQuery[$i]->Cliente === $idcliente && $siti->infoQuery[$i]->ID === $idsito){ //se il sito che sto analizzando ha lo stesso id della funzione e lo stesso id del cliente...
                //...è il nostro sito..scrivo il file
                $fp = fopen('generatedFile/'.basename('data'.$idsito.'.txt'), 'w+');
                //richiedo i dati
                $parametri = 'tipo=getDati&idcliente='.base64_encode(urlencode($idcliente));
                $dati = '';
                $dati = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                //dichiaro e inizializzo le variabili d' ambiente
                $k = 0;
                $j = 0;
                $numdati = 0;
                $num = 0;
                //leggo il valore dei dati ricevuti dai vari sensori
                $numdati = $dati->info[0]->numvalori;
                if ($numdati > 0){
                    //se è maggiore di 0 creo un array che conterrà tutti i sensori già utilizzati
                    $sensori = array('');
                    $trovato = '';
                    $trovato = false;
                    //faccio iniziare l' iterazione dall' ultimo dato che sarà il più recente
                    for ($k = 0; $k < $numdati; $k++){ //k conterrà gli indici delle varie misurazioni
                        if ($dati->infoQuery[$k]->Sito === $siti->infoQuery[$i]->ID){
                            $num++;
                            for ($j = 0; $j < count($sensori); $j++){
                                //controllo che il sensore non l' abbia già messo
                                if ($dati->infoQuery[$k]->Tipologia === $sensori[$j]){
                                    //se è stato trovato vuol dire che l' ho già immesso nel sintetizzatore
                                    $trovato = true;
                                }
                            }
                            if ($trovato != true){
                                array_push($sensori, $dati->infoQuery[$k]->Tipologia); //aggiunge in coda all' array
                                $info = '';
                                $info[] = array(
                                    'ID' => $dati->infoQuery[$k]->ID,
                                    'DatiRilevati' => $dati->infoQuery[$k]->DatiRilevati,
                                    'Data' => $dati->infoQuery[$k]->Data,
                                    'Ora' => $dati->infoQuery[$k]->Ora,
                                    'Apparecchiatura' => $dati->infoQuery[$k]->Apparecchiatura,
                                    'Tipologia' => $dati->infoQuery[$k]->Tipologia
                                );
                                $rilevazione = '{"info":'.json_encode($info).'}';
                                fwrite($fp, $rilevazione);
                            }
                            $trovato = false;
                        }
                    }
                }
                fclose($fp);
                return true;
            }
        }
    }else{
        return false;
    }
    return true;
}