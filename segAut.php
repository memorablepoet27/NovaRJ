<?php
require_once('assets/class/classGeral.php');

$cGeral = new Geral();
$cGeral->dbConnect();


@$usuario = $_COOKIE['usuario'];
@$senha = $_COOKIE['senha'];



  if(!empty($usuario) and !empty($senha)){

    $sql = "SELECT * FROM web_login WHERE login = '$usuario'";
    $acessoSite = $cGeral->dbSelect($sql);

    if(count($acessoSite) > 0){
      $senhaW = $acessoSite[0]['senha'];

      if($senhaW == $senha){
          $usPerm = $acessoSite[0]['permissao'];

          if($usPerm >= 99){
            $blockPermission = '';
            $readAdmin = '';
          }else{
            $blockPermission = 'disabled';
            $readAdmin = 'readonly';
          }

          if($usPerm >= 50){
            $disableSuporte = '';
            $readSuporte = '';
          }else{
            $disableSuporte = 'disabled';
            $readSuporte = 'readonly';
          }
      }else{
        setcookie ("usuario", "");
        setcookie ("senha", "");
        ?>
          <script> window.location.href = 'index.php'; </script>
        <?php
      	exit;
      }
    }else{
      setcookie ("usuario", "");
      setcookie ("senha", "");
      ?>
        <script> window.location.href = 'index.php'; </script>
      <?php
    	exit;
    }



  }else{
    setcookie ("usuario", "");
    setcookie ("senha", "");
    ?>
      <script> window.location.href = 'index.php'; </script>
    <?php
    exit;
  }



$cGeral->dbDisconnect();

?>
