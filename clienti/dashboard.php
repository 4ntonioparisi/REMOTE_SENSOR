<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <!--
Author: Appy
Version: 1.0
Description: Dashboard del sistema
-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Appy Dashboard</title>


        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="../build/css/custom.min.css" rel="stylesheet">

    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <!-- header -->
                        <?php require '../parts/'.$pagina.'/header.php'; ?>
                        <!-- /header -->

                        <div class="clearfix"></div>
                        <!-- menu profile quick info -->
                        <?php require '../parts/'.$pagina.'/quickinfo.php'; ?>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <?php require '../parts/'.$pagina.'/sidebar.php'; ?>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <?php require '../parts/'.$pagina.'/menufooter.php'; ?>
                        <!-- /menu footer buttons -->

                    </div>
                </div>

                <!-- top navigation -->
                <?php require '../parts/'.$pagina.'/menutop.php'; ?>

                <?php
                $siti = '';
                $apparecchiature = '';

                $parametri = 'tipo=getSiti';
                $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                $n = 0;
                    $numsiti = $siti->info[0]->numvalori;
                    $status = $siti->info[0]->status;
                    if ($numsiti > 0 && $status === 'success'){
                        $i = 0;        
                        //imposto il ciclo che va da 0 fino al numero di siti
                        for ($i = 0; $i < $numsiti; $i++){ //la i viene utilizzata per scorrere il numro dei siti
                            //se il sito che sto analizzando appartiene al cliente che ha effettuato il login
                            if ($siti->infoQuery[$i]->Cliente === $id){
                                $n++;
                            }
                        }
                    }

                $parametri = 'tipo=getApparecchiature';
                $apparecchiature = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Totale Siti</span>
                            <div class="count">
                                <?php echo $n; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['visible'])){
                        $iddato = addslashes($_POST['iddato']);
                        $parametri = 'tipo=visibleDato&iddato='.urlencode($iddato);
                        $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                        //recupero il valore
                        $status = $responso->info[0]->status;
                        if ($status === 'success'){
                    ?>
                    <div class="alert alert-success">
                        Modifiche apportate con successo.
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($responso->info[0]->messaggio); ?>
                    </div>
                    <?php
                        }
                    }

                    if (isset($_POST['hide'])){
                        $iddato = addslashes($_POST['iddato']);
                        $parametri = 'tipo=hideDato&iddato='.urlencode($iddato);
                        $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                        //recupero il valore
                        $status = $siti->info[0]->status;
                        if ($status === 'success'){
                    ?>
                    <div class="alert alert-success">
                        Modifiche apportate con successo.
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($responso->info[0]->messaggio); ?>
                    </div>
                    <?php
                        }
                    }

                    if (isset($_POST['deletePersona'])){
                        $idpersona = addslashes($_POST['idpersona']);
                        $idsito = addslashes($_POST['idsito']);
                        $parametri = 'tipo=deletePersona&idpersona='.urlencode($idpersona).'&idsito='.urlencode($idsito);
                        $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                        //recupero il valore
                        $status = $siti->info[0]->status;
                        if ($status === 'success'){
                    ?>
                    <div class="alert alert-success">
                        Eliminazione della terza parte completata con successo.
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($responso->info[0]->messaggio); ?>
                    </div>
                    <?php
                        }
                    }

                    if (isset($_POST['addPersona'])){
                        $idpersona = addslashes($_POST['idpersona']);
                        $idsito = addslashes($_POST['idsito']);
                        $parametri = 'tipo=addPersona&idpersona='.urlencode($idpersona).'&idsito='.urlencode($idsito);
                        $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                        //recupero il valore
                        $status = $responso->info[0]->status;
                        if ($status === 'success'){
                    ?>
                    <div class="alert alert-success">
                        Terza parte aggiunta con successo.
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($responso->info[0]->messaggio); ?>
                    </div>
                    <?php
                        }
                    }

                    $parametri = 'tipo=getSiti';
                    $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                    $status = '';
                    //recupero il valore
                    $numsiti = $siti->info[0]->numvalori;
                    $status = $siti->info[0]->status;
                    //se ci sono siti
                    if ($numsiti > 0 && $status === 'success'){
                        $i = 0;        
                        //imposto il ciclo che va da 0 fino al numero di siti
                        for ($i = 0; $i < $numsiti; $i++){ //la i viene utilizzata per scorrere il numro dei siti
                            //se il sito che sto analizzando appartiene al cliente che ha effettuato il login
                            if ($siti->infoQuery[$i]->Cliente === $id){
                    ?>
                    <div  id="sito<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Sito: <?php echo $siti->infoQuery[$i]->Nome; ?></h3>
                                <button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#visualizzaTerzeParti<?php echo $siti->infoQuery[$i]->ID; ?>">GESTISCI LE TERZE PARTI</button>
                                <button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#esportaDati<?php echo $siti->infoQuery[$i]->ID; ?>">ESPORTA DATI</button>
                                <button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#visualizzaSintesi<?php echo $siti->infoQuery[$i]->ID; ?>">VISUALIZZA SINTESI</button>
                                <button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#visualizzaDati<?php echo $siti->infoQuery[$i]->ID; ?>">VISUALIZZA I DATI</button>
                            </div>
                            <div class="panel-body">
                                <div class="x_content">
                                    <!--visualizzatore terze parti-->
                                    <div id="visualizzaTerzeParti<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                                        <div class="page-title">
                                            <div class="title_left">
                                                <h3>Gestisci le terze parti che possono accedere ai dati del sistema.</h3>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <button class="btn btn-primary" data-toggle="collapse" data-target="#aggiungiTerzaPersona<?php echo $siti->infoQuery[$i]->ID; ?>"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi terza parte
                                        </button><br>
                                        <div id="aggiungiTerzaPersona<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                                            <form method="POST">
                                                <div class="col-md-10 col-sm-10 col-xs-10">
                                                    Seleziona la terza persona da autorizzare per la visione dei dati:<br>
                                                    <input type="hidden" name="idsito" value="<?php echo base64_encode($siti->infoQuery[$i]->ID); ?>">
                                                    <select class="form-control" id="sel1" name="idpersona" required>
                                                                        <option value="<?php echo base64_encode('0'); ?>">-</option>
                                                        <?php
                                //recupero le persone da inserire nella listbox

                                //invio la richiesta alla pagina per ottenere i clienti
                                $parametri = 'tipo=getPersone';
                                $persone = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                //inizializzo la variabile che conterrà il numero degli clienti
                                $numpersone = 0;
                                $status = '';
                                //recupero il valore
                                $numpersone = $persone->info[0]->numvalori;
                                $status = $persone->info[0]->status;
                                //se ci sono clienti
                                if ($numpersone > 0 && $status === 'success'){
                                    $stato = '';
                                    $k = 0;
                                    //imposto il ciclo che va da 0 fino al numero di clienti
                                    for ($k = 0; $k < $numpersone; $k++){
                                        $valore = $persone->infoQuery[$k]->Nome.' '.$persone->infoQuery[$k]->Cognome.' - '.$persone->infoQuery[$k]->Email;
                                        //stamp come valore che passerò l' id e come valore da mostrare la mail
                                                        ?>
                                                        <option value="<?php echo base64_encode($persone->infoQuery[$k]->ID); ?>"><?php echo htmlspecialchars($valore); ?>
                                                        </option>
                                                        <?php
                                    }
                                }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-xs-2"><br>
                                                    <button name="addPersona" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Cognome</th>
                                                    <th>E-mail</th>
                                                    <th>Operazioni</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                $parametri = 'tipo=getPersone';
                                $persone = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                $numpersone = 0;
                                $status = '';
                                $numpersone = $persone->info[0]->numvalori;
                                $status = $persone->info[0]->status;
                                if ($status === 'success' && $numpersone > 0){
                                    $k = 0;
                                    for ($k = 0; $k < $numpersone; $k++){ //k scorre le persone
                                        $sitoTemp = urlencode($siti->infoQuery[$i]->ID);
                                        $personaTemp = urlencode($persone->infoQuery[$k]->ID);
                                        $parametri = 'tipo=getTerzaParte&idsito='.base64_encode($sitoTemp).'&idpersona='.base64_encode($personaTemp);
                                        $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                        $numrelazioni = 0;
                                        $numrelazioni = $responso->info[0]->numvalori;
                                        if ($numrelazioni === '1'){
                                                ?>
                                                <tr>
                                                    <td><?php echo $persone->infoQuery[$k]->Nome; ?></td>
                                                    <td><?php echo $persone->infoQuery[$k]->Cognome; ?></td>
                                                    <td><?php echo $persone->infoQuery[$k]->Email; ?></td>
                                                    <td>
                                                        <form method="POST">
                                                            <input type="hidden" name="idpersona" value="<?php echo base64_encode($persone->infoQuery[$k]->ID); ?>">
                                                            <input type="hidden" name="idsito" value="<?php echo base64_encode($siti->infoQuery[$i]->ID); ?>">
                                                            <button type="submit" name="deletePersona" class="btn btn-success"><i class="fa fa-trash" aria-hidden="true"></i> Elimina terza parte</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                        }else{
                                                ?>
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                <?php
                                        }
                                    }
                                }else{
                                                ?>
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                <?php
                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--esportatore dei dati-->
                                    <div id="esportaDati<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                                        <div class="page-title">
                                            <div class="title_left">
                                                <h3>Esporta i dati dei tuoi sensori.</h3>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <a href="generaFile.php?idcliente=<?php echo urlencode($id); ?>&idsito=<?php echo urlencode($siti->infoQuery[$i]->ID); ?>">Clicca qui per visionare il file</a>
                                    </div>
                                    <!--visualizzatore di sintesi-->
                                    <div id="visualizzaSintesi<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                                        <?php
                                $parametri = 'tipo=getDati&idcliente='.base64_encode(urlencode($id));
                                $dati = '';
                                $dati = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                        ?>

                                        <div class="page-title">
                                            <div class="title_left">
                                                <h3>Visualizza le sintesi delle rilevazioni di ogni sensore.</h3>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Apparecchiatura</th>
                                                    <th>Dati rilevati</th>
                                                    <th>Data</th>
                                                    <th>Ora</th>
                                                    <th>Posizione</th>
                                                    <th>Errore</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
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
                                                ?>
                                                <tr>
                                                    <td><?php echo $dati->infoQuery[$k]->Tipologia; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->DatiRilevati; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Data; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Ora; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Posizione; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Errore; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            $trovato = false;
                                        }
                                    }
                                }
                                if ($numdati === 0 || $num === 0){
                                                ?>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <?php
                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--visualizzatore dei dati completi-->
                                    <div id="visualizzaDati<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                                        <?php
                                $parametri = 'tipo=getDati&idcliente='.base64_encode(urlencode($id));
                                $dati = '';
                                $dati = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                        ?>

                                        <div class="page-title">
                                            <div class="title_left">
                                                <h3>Visualizza la cronologia delle rilevazioni.</h3>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Dati rilevati</th>
                                                    <th>Data</th>
                                                    <th>Ora</th>
                                                    <th>Errore</th>
                                                    <th>Apparecchiatura</th>
                                                    <th>Modifica dato</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                $k = 0;
                                $numdati = 0;
                                $num = 0;
                                $numdati = $dati->info[0]->numvalori;
                                if ($numdati > 0){
                                    for ($k =  0; $k < $numdati; $k++){
                                        if ($dati->infoQuery[$k]->Sito === $siti->infoQuery[$i]->ID){
                                            $num++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $dati->infoQuery[$k]->DatiRilevati; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Data; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Ora; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Errore; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Tipologia; ?></td>
                                                    <td>
                                                        <form method="POST">
                                                            <input type="hidden" name="iddato" value="<?php echo base64_encode($dati->infoQuery[$k]->ID); ?>">
                                                            <?php
                                            if ($dati->infoQuery[$k]->Visualizzabile === '0'){ //se ora non è visualizzabile, creo il pulsante per renderlo visualizzabile
                                                            ?>
                                                            <button type="submit" name="visible" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Rendi visualizzabile a terzi
                                                            </button>
                                                            <?php
                                            }else{ //se ora non è invisualizzabile, creo il pulsante per renderlo nascosto
                                                            ?>
                                                            <button type="submit" name="hide" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Nascondi a terzi</button>
                                                            <?php 
                                            }
                                                            ?>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                        }
                                    }
                                }
                                if ($numdati === 0 || $num === 0){
                                                ?>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <?php
                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        }
                    }else{
                    ?>
                    <li><a>Non sono presenti ambienti associati al tuo account.</a></li>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>


    </body>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>s
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</html>
