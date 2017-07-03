<?php require 'header.php'; ?>
<?php

$pagina = '';
//se è loggato (cioè ha un id > 0)
if ($id > IDNULL){
    $pagina = $_SESSION['Tipo'];
    if ($pagina === 'clienti')
        header('location: clienti/dashboard.php');
    else if($pagina === 'amministratori')
        header('location: amministratori/dashboard.php');
    else
        header('location: persone/dashboard.php');
}

?>
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
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="POST" action="">
                        <h1> Crea un account </h1>
                        <div>
                            <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" required/>
                        </div>
                        <div>
                            <input type="text" id="cognome" name="cognome" class="form-control" placeholder="Cognome" required/>
                        </div>
                        <div>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email" required/>
                        </div>
                        <div>
                            <input type="password" id="password1" name="password1" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <input type="password" id="password2" name="password2" class="form-control" placeholder="Conferma password" required/>
                        </div>
                        <div>
                            <h3>Registrati come:</h3>
                            <select class="form-control" name="tipoAccesso" id="tipoAccesso">
                                <option value="clienti">Cliente</option>
                                <option value="persone">Terza parte autorizzata</option>
                            </select>
                        </div><br>
                        <div>
                            <button type="submit" name="submitRegistrazione" class="btn btn-default submit">Registrati</button>
                        </div>
                        <?php
                        if (isset($_POST['submitRegistrazione'])){
                            //leggo i parametri in input
                            $nome = addslashes(ucwords(strtolower($_POST['nome'])));
                            $cognome = addslashes(ucwords(strtolower($_POST['cognome'])));
                            $email = addslashes(strtolower($_POST['email']));
                            $tipoAccesso = addslashes(strtolower($_POST['tipoAccesso'])); //può contenere clienti, persone
                            $password1 = addslashes(strtolower($_POST['password1']));
                            $password2 = addslashes(strtolower($_POST['password2']));
                            $parametri = 'tipo=addUtente&nome='.urlencode($nome).'&cognome='.urlencode($cognome).'&email='.urlencode($email).'&password1='.urlencode($password1).'&password2='.urlencode($password2).'&tipoAccesso='.urlencode($tipoAccesso);
                            $responso = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri))))); //invio la richiesta
                            $stato = $responso->info[0]->status; //leggo lo status
                            if ($stato === 'success'){
                        ?>
                        <br><div class="alert alert-success">
                        Registrazione completata con successo.
                        </div>
                        <?php }else{ ?>
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
                        ?>
                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Sei già registrato?
                                <a href="login.php" class="to_register"> Accedi ora</a>
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
    </body>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
</html>
