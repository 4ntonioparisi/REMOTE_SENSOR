<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li>
                <a href='dashboard.php'><i class="fa fa-home"></i> Home</a>
            </li>
            <li><a><i class="fa fa-table"></i> Gestisci ambienti <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <?php
                    $parametri = 'tipo=getSiti';
                    $siti = json_decode(base64_decode(file_get_contents('http://'.getHost().'/php/'.basename(getUrl($parametri)))));
                    $status = '';
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
                            if ($siti->infoQuery[$i]->Cliente === $id){
                    ?>
                    <li><a data-toggle="collapse" data-target="#sito<?php echo $siti->infoQuery[$i]->ID; ?>"><?php echo $siti->infoQuery[$i]->Nome; ?></a></li>
                    <?php
                            }
                        }
                    }else{
                    ?>
                    <li><a>Non sono presenti ambienti associati al tuo account.</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>

        </ul>
    </div>
</div>