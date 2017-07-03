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

                <?php
                $amministratori = '';
                $clienti = '';
                $siti = '';
                $apparecchiature = '';
                $parametri = '';
                
                $parametri = 'tipo=getAmministratori';
                $amministratori = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                
                $parametri = 'tipo=getClienti';
                $clienti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                
                $parametri = 'tipo=getSiti';
                $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                
                $parametri = 'tipo=getApparecchiature';
                $apparecchiature = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                
                ?>
                <!-- page content -->
                <div class="right_col" role="main">
                    <!-- top tiles -->
                    <div class="row tile_count">
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Totale Amministratori</span>
                            <div class="count">
                                <?php echo $amministratori->info[0]->numvalori; ?>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Totale Utenti</span>
                            <div class="count">
                                <?php echo $clienti->info[0]->numvalori; ?>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Totale Siti</span>
                            <div class="count">
                                <?php echo $siti->info[0]->numvalori; ?>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                            <span class="count_top"><i class="fa fa-user"></i> Totale Apparecchiature</span>
                            <div class="count">
                                <?php echo $apparecchiature->info[0]->numvalori; ?>
                            </div>
                        </div>
                    </div>
                    <!-- /top tiles -->
                </div>
            </div>
        </div>
    </body>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
</html>
