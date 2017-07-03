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

                $parametri = 'tipo=getSitiPersone&idpersona='.base64_encode($id);
                $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Totale Siti</span>
                            <div class="count">
                                <?php echo $siti->info[0]->numvalori; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $parametri = 'tipo=getSitiPersone&idpersona='.base64_encode($id);
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
                            if ($siti->infoQuery[$i]->Persona === $id){
                    ?>
                    <div  id="sito<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Sito: <?php echo $siti->infoQuery[$i]->Nome; ?></h3>
                                <button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#visualizzaDati<?php echo $siti->infoQuery[$i]->ID; ?>">VISUALIZZA I DATI</button>
                            </div>
                            <div class="panel-body">
                                <div class="x_content">
                                    <!--visualizzatore dei dati completi-->
                                    <div id="visualizzaDati<?php echo $siti->infoQuery[$i]->ID; ?>" class="collapse">
                                        <div class="page-title">
                                            <div class="title_left">
                                                <h3>Visualizza i dati delle rilevazioni condivisi con te.</h3>
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
                                                    <th>Errore</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                $parametri = 'tipo=getDatiPersone&idpersona='.base64_encode($id);
                                $dati = '';
                                $dati = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                $k = 0;
                                $numdati = 0;
                                $num = 0;
                                $numdati = $dati->info[0]->numvalori;
                                if ($numdati > 0){
                                    for ($k =  0; $k < $numdati; $k++){
                                        if ($dati->infoQuery[$k]->ID === $siti->infoQuery[$i]->ID){
                                            $num++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $dati->infoQuery[$k]->Tipologia; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->DatiRilevati; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Data; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Ora; ?></td>
                                                    <td><?php echo $dati->infoQuery[$k]->Errore; ?></td>
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
