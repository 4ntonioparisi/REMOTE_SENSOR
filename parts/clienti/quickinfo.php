<!-- menu profile quick info -->
<div class="profile clearfix">
    <div class="profile_pic">
        <img src="../images/user.png" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
        <span>Benvenuto, </span>
        <?php 
        $nomecognome = '';
        $nomecognome = strtoupper($_SESSION['Nome']).' '.strtoupper($_SESSION['Cognome']);
        ?>
        <h2><?php echo htmlspecialchars($nomecognome); ?></h2>
    </div>
</div>
<!-- /menu profile quick info -->