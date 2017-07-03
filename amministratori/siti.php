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
        <!-- Latest compiled and minified CSS -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

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
                                <h3>SITI</h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Gestisci i siti dei tuoi clienti.</h2>
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
                                            if (isset($_POST['submitAggiungiSito'])){
                                                //leggo i parametri in input
                                                $nome = addslashes(ucwords(strtolower($_POST['nome'])));
                                                $indirizzo = addslashes(ucwords($_POST['indirizzo']));
                                                $citta = addslashes(ucwords($_POST['citta']));
                                                $provincia = addslashes(strtoupper($_POST['provincia']));
                                                $idcliente = addslashes($_POST['cliente']);
                                                //invio la richiesta di aggiunta //converto il risultato in array
                                                $id = 0;
                                                $id = $_SESSION['ID'];
                                                $parametri = 'tipo=addSito&nome='.urlencode($nome).'&indirizzo='.urlencode($indirizzo).'&citta='.urlencode($citta).'&provincia='.urlencode($provincia).'&idcliente='.urlencode($idcliente).'&idamministratore='.base64_encode(urlencode($id));
                                                $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri))))); //invio la richiesta
                                                $stato = $responso->info[0]->status; //leggo lo status
                                                //se lo status è success
                                                if ($stato === 'success'){
                                            ?>
                                            <br><div class="alert alert-success">
                                            Aggiunta completata con successo.
                                            </div>
                                            <?php }else{  //se lo status è error ?>
                                            <br><div class="alert alert-danger">
                                            <?php
                                                    if ($responso->info[0]->messaggio != ''){
                                                        echo $responso->info[0]->messaggio;
                                                    }else{
                                                        echo "Errore durante l' aggiunta del sito.";
                                                    }
                                            ?>
                                            </div>
                                            <?php
                                                }
                                            }

                                            //modifica dei dati di un sito
                                            if(isset($_POST['modificaSito'])){
                                                //leggo i dati in input
                                                $id = addslashes($_POST['idvalue']);
                                                $nome = addslashes(ucwords(strtolower($_POST['nome'])));
                                                $indirizzo = addslashes(ucwords($_POST['indirizzo']));
                                                $citta = addslashes(ucwords($_POST['citta']));
                                                $provincia = addslashes(strtoupper($_POST['provincia']));
                                                $idcliente = addslashes($_POST['cliente']);
                                                //invio la richiesta di modifica
                                                $parametri = 'nome='.urlencode($nome).'&indirizzo='.urlencode($indirizzo).'&citta='.urlencode($citta).'&provincia='.urlencode($provincia).'&tipo=modifySito&idcliente='.urlencode($idcliente).'&id='.urlencode($id);
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

                                            //operazioni per la sospensione dell' account cliente
                                            if(isset($_POST['sospendiSito'])){
                                                //leggo i dati in input
                                                $id = addslashes($_POST['idvalue']);
                                                //invio la richiesta di modifica
                                                $parametri = 'tipo=banSito&id='.urlencode($id);
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

                                            //operazioni per la riattivazione dell' account cliente
                                            if(isset($_POST['riattivaSito'])){
                                                //leggo i dati in input
                                                $id = addslashes($_POST['idvalue']);
                                                //invio la richiesta di modifica
                                                $parametri = 'tipo=unbanSito&id='.urlencode($id);
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
                                            <button class="btn btn-primary" data-toggle="collapse" data-target="#aggiungiSito"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi sito
                                            </button>

                                            <!--Aggiunta del sito-->
                                            <div id="aggiungiSito" class="collapse">
                                                <table id="" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Indirizzo</th>
                                                            <th>Città</th>
                                                            <th>Provincia</th>
                                                            <th>Cliente</th>
                                                            <th>Operazioni</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <form method="POST">
                                                            <td>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="nome" placeholder="Inserisci il nome del sito" required="required" type="text">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="indirizzo" placeholder="Inserisci l' indirizzo" required="required" type="text">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="citta" placeholder="Inserisci la città" required="required" type="text">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="provincia" placeholder="Inserisci la provincia" required="required" type="text">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <select class="form-control" id="sel1" name="cliente">
                                                                        <option value="<?php echo base64_encode('0'); ?>">-</option>
                                                                        <?php
                                                                        //invio la richiesta alla pagina per ottenere i clienti
                                                                        $parametri = 'tipo=getClienti';
                                                                        $clienti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                                        //inizializzo la variabile che conterrà il numero degli clienti
                                                                        $num = 0;
                                                                        $status = '';
                                                                        //recupero il valore
                                                                        $num = $clienti->info[0]->numvalori;
                                                                        $status = $clienti->info[0]->status;
                                                                        //se ci sono clienti
                                                                        if ($num > 0 && $status === 'success'){
                                                                            $stato = '';
                                                                            $i = 0;
                                                                            //imposto il ciclo che va da 0 fino al numero di clienti
                                                                            for ($i = 0; $i < $num; $i++){
                                                                                //stamp come valore che passerò l' id e come valore da mostrare la mail
                                                                        ?>
                                                                        <option value="<?php echo base64_encode($clienti->infoQuery[$i]->ID); ?>"><?php echo $clienti->infoQuery[$i]->Email; ?>
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
                                                                    <button name="submitAggiungiSito" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i>
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
                                                    <th>ID</th>
                                                    <th>Nome</th>
                                                    <th>Indirizzo</th>
                                                    <th>Città</th>
                                                    <th>Provincia</th>
                                                    <th>ID Cliente</th>
                                                    <th>ID Amministratore</th>
                                                    <th>Stato</th>
                                                    <th>Operazioni</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                //invio la richiesta alla pagina per ottenere gli siti
                                                $parametri = 'tipo=getSiti';
                                                $siti = '';
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
                                                        //e li stampo a video
                                                ?>
                                                <tr>
                                                    <td><?php echo $siti->infoQuery[$i]->ID; ?></td>
                                                    <td>
                                                        <?php echo $siti->infoQuery[$i]->Nome; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $siti->infoQuery[$i]->Indirizzo; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $siti->infoQuery[$i]->Citta; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $siti->infoQuery[$i]->Provincia; ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if ($siti->infoQuery[$i]->Cliente === 0){
                                                            echo 'Nessun cliente associato.';
                                                        }else{
                                                        echo $siti->infoQuery[$i]->Cliente; 
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $siti->infoQuery[$i]->Amministratore; ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if ($siti->infoQuery[$i]->Stato === '0') echo 'Attivo';
                                                        else echo 'Sospeso';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <button data-toggle="modal" data-target="#modifica<?php echo $siti->infoQuery[$i]->ID; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifica sito
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

        //invio la richiesta
        $parametri = 'tipo=getSiti';
        $siti = '';
        $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));

        //inizializzo la variabile che conterrà il numero degli amminstratori
        $num = 0;
        $status = '';
        //recupero il valore
        $numsiti = $siti->info[0]->numvalori;
        $status = $siti->info[0]->status;
        //se ci sono amministratori
        if ($numsiti > 0 && $status === 'success'){
            $i = 0;        
            //imposto il ciclo che va da 0 fino al numero di amministratori
            for ($i = 0; $i < $numsiti; $i++){
                $stato = '';
                //e li stampo a video
                if ($siti->infoQuery[$i]->Stato === '0'){
                    $stato = 'attivo';
                }else{
                    $stato = 'sospeso';
                }
                //e li stampo a video
        ?>
        <div id="modifica<?php echo $siti->infoQuery[$i]->ID; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modifica i dati</h4>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="idvalue" value="<?php echo base64_encode($siti->infoQuery[$i]->ID); ?>">
                        <div class="modal-body">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Indirizzo</th>
                                        <th>Città</th>
                                        <th>Provincia</th>
                                        <th>ID Cliente</th>
                                        <th>Stato</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>
                                        <div class="item form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="nome" placeholder="Inserisci il nome del sito" value="<?php echo $siti->infoQuery[$i]->Nome; ?>" required="required" type="text">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="indirizzo" placeholder="Inserisci l' indirizzo" value="<?php echo $siti->infoQuery[$i]->Indirizzo; ?>" required="required" type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="item form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="citta" placeholder="Inserisci la città" value="<?php echo $siti->infoQuery[$i]->Citta; ?>" required="required" type="text">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="provincia" placeholder="Inserisci la provincia" value="<?php echo $siti->infoQuery[$i]->Provincia; ?>" required="required" type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select class="form-control" id="sel1" name="cliente">
                                                <option value="<?php echo base64_encode('0'); ?>">-</option>
                                                <?php
                //invio la richiesta alla pagina per ottenere i clienti
                $parametri = 'tipo=getClienti';
                $clienti = '';
                $clienti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                //recupero il valore
                $num = $clienti->info[0]->numvalori;
                $status = $clienti->info[0]->status;
                //se ci sono clienti
                if ($num > 0 && $status === 'success'){
                    $k = 0;
                    //imposto il ciclo che va da 0 fino al numero di clienti
                    for ($k = 0; $k < $num; $k++){
                        //stamp come valore che passerò l' id e come valore da mostrare la mail
                                                ?>
                                                <option value="<?php echo base64_encode($clienti->infoQuery[$k]->ID); ?>"><?php echo $clienti->infoQuery[$k]->Email; ?>
                                                </option>
                                                <?php
                    }
                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                if ($stato === 'attivo') echo 'Attivo';
                else echo 'Sospeso';
                                        ?>
                                    </td>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button name="modificaSito" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Salva modifiche
                            </button>
                            <?php if ($stato === 'attivo') { ?>
                            <button name="sospendiSito" type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> Sospendi sito
                            </button>
                            <?php }else{ ?>
                            <button name="riattivaSito" type="submit" class="btn btn-danger"><i class="fa fa-refresh"></i> Riattiva sito
                            </button>
                            <?php } ?>
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
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</html>