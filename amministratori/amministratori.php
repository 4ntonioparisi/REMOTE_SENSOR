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
                                <h3>AMMINISTRATORI</h3>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Gestisci gli amministratori del sistema.</h2>
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
                                            if (isset($_POST['submitAggiungiAmministratore'])){
                                                //leggo i parametri in input
                                                $nome = addslashes(ucwords(strtolower($_POST['nome'])));
                                                $cognome = addslashes(ucwords(strtolower($_POST['cognome'])));
                                                $email = addslashes(strtolower($_POST['email']));
                                                $password1 = addslashes(strtolower($_POST['password1']));
                                                $password2 = addslashes(strtolower($_POST['password2']));
                                                //invio la richiesta di aggiunta //converto il risultato in array
                                                $parametri = 'tipo=addUtente&tipoAccesso=amministratori&nome='.urlencode($nome).'&cognome='.urlencode($cognome).'&email='.urlencode($email).'&password1='.urlencode($password1).'&password2='.urlencode($password2);
                                                //invio la richiesta
                                                $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                $stato = $responso->info[0]->status; //leggo lo status
                                                //se lo status è success
                                                if ($stato === 'success'){
                                            ?>
                                            <br><div class="alert alert-success">
                                            Registrazione completata con successo.
                                            </div>
                                            <?php }else{  //se lo status è error ?>
                                            <br><div class="alert alert-danger">
                                            <?php
                                                    if ($responso->info[0]->messaggio != ''){
                                                        echo $responso->info[0]->messaggio;
                                                    }else{
                                                        echo "Errore durante la registrazione dell' account.";
                                                    }
                                            ?>
                                            </div>
                                            <?php
                                                }
                                            }

                                            //modifica dei dati di un amministratore
                                            if(isset($_POST['modificaAmministratore'])){
                                                //leggo i dati in input
                                                $id = addslashes($_POST['idvalue']);
                                                $nome = addslashes(ucwords(strtolower($_POST['nome'])));
                                                $cognome = addslashes(ucwords(strtolower($_POST['cognome'])));
                                                $email = addslashes(strtolower($_POST['email']));
                                                //invio la richiesta di modifica
                                                $parametri = 'tipo=modifyAmministratore&id='.urlencode($id).'&nome='.urlencode($nome).'&cognome='.urlencode($cognome).'&email='.urlencode($email);
                                                $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                //converto il risultato in array
                                                $responso = json_decode($responso);
                                                //se lo status è success
                                                if ($responso->info[0]->status === 'success'){
                                                    if ($email === $_SESSION['Email']){
                                                        $_SESSION['Email'] = $email;
                                                        $_SESSION['Nome'] = $nome;
                                                        $_SESSION['Cognome'] = $cognome;
                                                    }
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
                                            <button class="btn btn-primary" data-toggle="collapse" data-target="#aggiungiAmministratore"><i class="fa fa-plus" aria-hidden="true"></i> Aggiungi amministratore
                                            </button>

                                            <div id="aggiungiAmministratore" class="collapse">
                                                <table id="" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Email</th>
                                                            <th>Nome</th>
                                                            <th>Cognome</th>
                                                            <th>Password</th>
                                                            <th>Conferma password</th>
                                                            <th>Operazioni</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <form method="POST">
                                                            <td>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <input type="email" id="email" name="email" required="required" class="form-control " placeholder="Inserisci l' email">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="nome" placeholder="Inserisci il nome" required="required" type="text">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="cognome" placeholder="Inserisci il cognome" required="required" type="text">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="password1" placeholder="Inserisci la password" required="required" type="password">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="password2" placeholder="Conferma la password" required="required" type="password">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <button name="submitAggiungiAmministratore" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i>
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
                                    <?php

                                    ?>
                                    <div class="x_content">
                                        <table id="datatable" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Email</th>
                                                    <th>Nome</th>
                                                    <th>Cognome</th>
                                                    <th>Operazioni</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $amministratori = '';
                                                //invio la richiesta alla pagina per ottenere gli amministratori
                                                $parametri = 'tipo=getAmministratori';
                                                $amministratori = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                                                //inizializzo la variabile che conterrà il numero degli amminstratori
                                                $num = 0;
                                                $status = '';
                                                //recupero il valore
                                                $num = $amministratori->info[0]->numvalori;
                                                $status = $amministratori->info[0]->status;
                                                //se ci sono amministratori
                                                if ($num > 0 && $status === 'success'){
                                                    $i = 0;
                                                    //imposto il ciclo che va da 0 fino al numero di amministratori
                                                    for ($i = 0; $i < $num; $i++){
                                                        //e li stampo a video
                                                ?>
                                                <tr>
                                                    <td><?php echo $amministratori->infoQuery[$i]->ID; ?></td>
                                                    <td>
                                                        <?php echo $amministratori->infoQuery[$i]->Email; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $amministratori->infoQuery[$i]->Nome; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $amministratori->infoQuery[$i]->Cognome; ?>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <button data-toggle="modal" data-target="#modifica<?php echo $amministratori->infoQuery[$i]->ID; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifica account
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
        $parametri = 'tipo=getAmministratori';
        $amministratori = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
        //inizializzo la variabile che conterrà il numero degli amminstratori
        $num = 0;
        $status = '';
        //recupero il valore
        $num = $amministratori->info[0]->numvalori;
        $status = $amministratori->info[0]->status;
        //se ci sono amministratori
        if ($num > 0 && $status === 'success'){
            $i = 0;
            //imposto il ciclo che va da 0 fino al numero di amministratori
            for ($i = 0; $i < $num; $i++){
                $status = '';
                //e li stampo a video
        ?>
        <div id="modifica<?php echo $amministratori->infoQuery[$i]->ID; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modifica i dati</h4>
                    </div>
                    <form method="POST">
                        <input type="hidden" name="idvalue" value="<?php echo base64_encode($amministratori->infoQuery[$i]->ID); ?>">
                        <div class="modal-body">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                    </tr>
                                </thead>
                                <td>
                                    <div class="item form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input type="email" id="email" name="email" required="required" class="form-control " placeholder="Inserisci l' email" value="<?php echo $amministratori->infoQuery[$i]->Email; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="item form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <input id="name" class="form-control " data-validate-length-range="6" data-validate-words="2" name="nome" placeholder="Inserisci il nome" required="required" type="text" value="<?php echo $amministratori->infoQuery[$i]->Nome; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input id="name" class="form-control" data-validate-length-range="6" data-validate-words="2" name="cognome" placeholder="Inserisci il cognome" required="required" type="text" value="<?php echo $amministratori->infoQuery[$i]->Cognome; ?>">
                                    </div>
                                </td>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button name="modificaAmministratore" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Salva
                            </button>
                            <button name="eliminaAmministratore" data-dismiss="modal" class="btn btn-danger"><i class="icon-remove-sign"></i> Annulla
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