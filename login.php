<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Iot Project</title>


        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom Theme Style -->
        <link href="build/css/custom.min.css" rel="stylesheet">
    </head>

    <body class="login">
        <div>
            <a class="hiddenanchor" id="signup"></a>
            <a class="hiddenanchor" id="signin"></a>

            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form method="POST" action="">
                            <h1>Accedi ora</h1>
                            <div>
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required/>
                            </div>
                            <div>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div>
                                <h3>Accedi come:</h3>
                                <select class="form-control" name="tipoAccesso" id="tipoAccesso">
                                    <option value="amministratori">Amministratore</option>
                                    <option value="clienti">Cliente</option>
                                    <option value="persone">Terza parte autorizzata</option>
                                </select>
                            </div><br>
                            <div>
                                <button type="submit" name="submitLogin" class="btn btn-default submit">Accedi</button>
                            </div>
                            <?php
                            if (isset($_POST['submitLogin'])){
                                //leggo i parametri in input
                                $email = addslashes(strtolower($_POST['email']));
                                $password = addslashes(strtolower($_POST['password']));
                                $tipoAccesso = addslashes(strtolower($_POST['tipoAccesso'])); //può contenere amministratori, clienti, persone
                                $parametri = 'tipo=login&email='.urlencode($email).'&password='.urlencode($password).'&tipoAccesso='.urlencode($tipoAccesso);
                                $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri))))); //invio la richiesta
                                if ($responso->info[0]->status === 'success'){
                                    $_SESSION['ID']     = $responso->infoQuery[0]->ID;
                                    $_SESSION['Tipo']   = $responso->infoQuery[0]->Tipo;
                                    $_SESSION['Nome']   = $responso->infoQuery[0]->Nome;
                                    $_SESSION['Cognome']   = $responso->infoQuery[0]->Cognome;
                                    $_SESSION['Email']   = $responso->infoQuery[0]->Email;
                                    $pagina = pathinfo($_SESSION['Tipo'])['basename'];
                                    //lo porto nella sua dashboard
                                    $pagina = $_SESSION['Tipo'];
                                    if ($pagina === 'clienti')
                                        header('location: clienti/dashboard.php');
                                    else if($pagina === 'amministratori')
                                        header('location: amministratori/dashboard.php');
                                    else 
                                        header('location: persone/dashboard.php');
                                    //se non è loggato
                                    
                                }else{
                            ?>
                            <br><div class="alert alert-danger">
                            <?php
                                    $messaggio = $responso->info[0]->messaggio; //leggo lo status
                                    if ($messaggio != ''){
                                        echo htmlspecialchars($messaggio);
                                    }else{
                                        echo "L' account digitato non esiste.";
                                    }
                            ?>
                            </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Non sei ancora registrato?
                                    <a href="registrazione.php" class="to_register"> Crea un account </a>
                                </p>

                                <div class="clearfix"></div>
                                <br />

                                <div>
                                    <h1><i class="fa fa-paw"></i> Powered by Appy</h1>
                                    <p>©2017 All Rights Reserved.</p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
</html>
