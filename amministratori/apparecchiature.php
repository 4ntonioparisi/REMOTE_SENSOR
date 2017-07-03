<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="it">
    <head>
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
                        <?php 
                        $pagina = '';
                        $pagina = pathinfo( $_SESSION['Tipo'])['basename'];
                        ?>
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

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>APPARECCHIATURE</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Gestisci le apparecchiature dei siti del sistema.</h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            //aggiungi amministratore
                                            if (isset($_POST['submitAggiungiApparecchiatura'])){
                                                //leggo i parametri in input
                                                $marca = addslashes(strtoupper($_POST['marca']));
                                                $posizione = addslashes(strtoupper($_POST['posizione']));
                                                $tipologia = addslashes(strtoupper($_POST['tipologia']));
                                                $descrizione = addslashes(strtoupper($_POST['descrizione']));
                                                $daticonsentiti = addslashes(strtolower($_POST['daticonsentiti']));
                                                $idsito = addslashes($_POST['sito']);
                                                //invio la richiesta di aggiunta //converto il risultato in array//invio la richiesta
                                                $parametri = 'tipo=addApparecchiatura&marca='.urlencode($marca).'&posizione='.urlencode($posizione).'&tipologia='.urlencode($tipologia).'&descrizione='.urlencode($descrizione).'&daticonsentiti='.urlencode($daticonsentiti).'&idsito='.urlencode($idsito);
                                                $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                $stato = $responso->info[0]->status; //leggo lo status
                                                //se lo status è success
                                                if ($stato === 'success'){
                                            ?>
                                            <br><div class="alert alert-success">
                                            Apparecchiatura aggiunta con successo.
                                            </div>
                                            <?php }else{  //se lo status è error ?>
                                            <br><div class="alert alert-danger">
                                            <?php
                                                    if ($responso->info[0]->messaggio != ''){
                                                        echo $responso->info[0]->messaggio;
                                                    }else{
                                                        echo "Errore durante l' aggiunta dell' apparecchiatura.";
                                                    }
                                            ?>
                                            </div>
                                            <?php
                                                }
                                            }
                                            //modifica dei dati di un amministratore
                                            if(isset($_POST['modificaApparecchiatura'])){
                                                //leggo i dati in input
                                                $id = addslashes($_POST['idvalue']);
                                                $marca = addslashes(strtoupper($_POST['marca']));
                                                $posizione = addslashes(strtoupper($_POST['posizione']));
                                                $tipologia = addslashes(strtoupper($_POST['tipologia']));
                                                $descrizione = addslashes(strtoupper($_POST['descrizione']));
                                                $daticonsentiti = addslashes(strtolower($_POST['daticonsentiti']));
                                                $idsito = addslashes($_POST['sito']);
                                                //invio la richiesta di modifica
                                                $parametri = 'tipo=modifyApparecchiatura&id='.urlencode($id).'&marca='.urlencode($marca).'&posizione='.urlencode($posizione).'&tipologia='.urlencode($tipologia).'&descrizione='.urlencode($descrizione).'&daticonsentiti='.urlencode($daticonsentiti).'&idsito='.urlencode($idsito);
                                                $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                //se lo status è success
                                                if ($responso->info[0]->status === 'success'){
                                            ?>
                                            <div class="alert alert-success">
                                                Modifiche apportate con successo.
                                            </div>
                                            <?php
                                                }else{ //se lo status è error
                                            ?>
                                            <div class="alert alert-danger">
                                                <?php echo $responso->info[0]->messaggio; ?>
                                            </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <button class="btn btn-primary" data-toggle="collapse" data-target="#aggiungiAmministratore"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi apparecchiatura
                                            </button>

                                            <div id="aggiungiAmministratore" class="collapse">
                                                <table id="" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Marca</th>
                                                            <th>Posizione</th>
                                                            <th>Tipologia</th>
                                                            <th>Descrizione</th>
                                                            <th>Dati consentiti</th>
                                                            <th>Sito associato</th>
                                                            <th>Operazioni</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <form method="POST">
                                                            <td>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <input type="text" id="marca" name="marca" required="required" class="form-control " placeholder="Inserisci la marca">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="posizione" placeholder="Inserisci la posizione del sensore" required="required" type="text">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="tipologia" placeholder="Inserisci la tipologia" required="required" type="text">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="descrizione" placeholder="Inserisci la descrizione" required="required" type="text">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="daticonsentiti" placeholder="Dati consentiti" required="required" type="text">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <select class="form-control" id="sel1" name="sito">
                                                                        <?php
                                                                        $parametri = 'tipo=getSiti';
                                                                        $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));

                                                                        //inizializzo la variabile che conterrà il numero degli siti
                                                                        $num = 0;
                                                                        $status = '';
                                                                        //recupero il valore
                                                                        $num = $siti->info[0]->numvalori;
                                                                        $status = $siti->info[0]->status;
                                                                        //se ci sono amministratori
                                                                        if ($num > 0 && $status === 'success'){
                                                                            $i = 0;
                                                                            //imposto il ciclo che va da 0 fino al numero di siti
                                                                            for ($i = 0; $i < $num; $i++){
                                                                                //stamp come valore che passerò l' id e come valore da mostrare il nome
                                                                        ?>
                                                                        <option value="<?php echo base64_encode($siti->infoQuery[$i]->ID); ?>"><?php echo $siti->infoQuery[$i]->Nome; ?>
                                                                        </option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <button name="submitAggiungiApparecchiatura" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i>
                                                                    </button>
                                                                    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </form>
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="x_content">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Matricola</th>
                                                    <th>Marca</th>
                                                    <th>Tipologia</th>
                                                    <th>Posizione</th>
                                                    <th>Descrizione</th>
                                                    <th>Dati consentiti</th>
                                                    <th>ID Sito associato</th>
                                                    <th>Operazioni</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $parametri = 'tipo=getApparecchiature';
                                                $apparecchiatura = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                //inizializzo la variabile che conterrà il numero delle apparecchiature
                                                $num = 0;
                                                $status = '';
                                                //recupero il valore
                                                $num = $apparecchiatura->info[0]->numvalori;
                                                $status = $apparecchiatura->info[0]->status;
                                                //se ci sono amministratori
                                                if ($num > 0 && $status === 'success'){
                                                    $i = 0;
                                                    //imposto il ciclo che va da 0 fino al numero delle apparecchiature
                                                    for ($i = 0; $i < $num; $i++){
                                                        //e li stampo a video
                                                ?>
                                                <tr>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->ID; ?></td>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->Marca; ?></td>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->Tipologia; ?></td>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->Posizione; ?></td>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->Descrizione; ?></td>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->DatiConsentiti; ?></td>
                                                    <td><?php echo $apparecchiatura->infoQuery[$i]->Sito; ?></td>
                                                    <td>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <button data-toggle="modal" data-target="#modifica<?php echo $apparecchiatura->infoQuery[$i]->ID; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifica apparecchiatura
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                }else{
                                                ?>
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->
            </div>
        </div>



        <?php
        //richiedo il numero degli amministratori per la creazione dei modal che utilizzerò per il cambio dati
        //invio la richiesta alla pagina per ottenere le apparecchiature
        $parametri = 'tipo=getApparecchiature';
        $apparecchiatura = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
        //inizializzo la variabile che conterrà il numero degli apparecchiature
        $numapp = 0;
        $status = '';
        //recupero il valore
        $numapp = $apparecchiatura->info[0]->numvalori;
        $status = $apparecchiatura->info[0]->status;
        //se ci sono apparecchiature
        if ($numapp > 0 && $status === 'success'){
            $i = 0;
            //imposto il ciclo che va da 0 fino al numero di apparecchiature
            for ($i = 0; $i < $numapp; $i++){
                $status = '';
        ?>
        <div id="modifica<?php echo $apparecchiatura->infoQuery[$i]->ID; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modifica i dati</h4>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="idvalue" value="<?php echo base64_encode($apparecchiatura->infoQuery[$i]->ID); ?>">
                        <div class="modal-body">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Tipologia</th>
                                        <th>Posizione</th>
                                        <th>Descrizione</th>
                                        <th>Dati consentiti</th>
                                        <th>Sito associato</th>
                                    </tr>
                                </thead>
                                <td>
                                    <div class="item form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="text" id="email" name="marca" required="required" class="form-control " placeholder="Inserisci la marca" value="<?php echo $apparecchiatura->infoQuery[$i]->Marca; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="tipologia" placeholder="Inserisci la tipologia" required="required" type="text" value="<?php echo $apparecchiatura->infoQuery[$i]->Tipologia; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="descrizione" placeholder="Inserisci la descrizione" required="required" type="text" value="<?php echo $apparecchiatura->infoQuery[$i]->Descrizione; ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="posizione" placeholder="Inserisci la posizione" required="required" type="text" value="<?php echo $apparecchiatura->infoQuery[$i]->Posizione; ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="daticonsentiti" placeholder="Inserisci i dati consentiti" required="required" type="text" value="<?php echo $apparecchiatura->infoQuery[$i]->DatiConsentiti; ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="sel1" name="sito">
                                            <?php

                $parametri = 'tipo=getSiti';
                $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));

                //inizializzo la variabile che conterrà il numero degli siti
                $num = 0;
                $status = '';
                //recupero il valore
                $num = $siti->info[0]->numvalori;
                $status = $siti->info[0]->status;
                //se ci sono amministratori
                if ($num > 0 && $status === 'success'){
                    $k = 0;
                    //imposto il ciclo che va da 0 fino al numero di siti
                    for ($k = 0; $k < $num; $k++){
                        //stamp come valore che passerò l' id e come valore da mostrare il nome
                                            ?>
                                            <option value="<?php echo base64_encode($siti->infoQuery[$k]->ID); ?>"><?php echo $siti->infoQuery[$k]->Nome; ?>
                                            </option>
                                            <?php
                    }
                }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button name="modificaApparecchiatura" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Salva
                            </button>
                            <button name="eliminaApparecchiatura" data-dismiss="modal" class="btn btn-danger"><i class="icon-remove-sign"></i> Annulla
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>

    </body>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</html>