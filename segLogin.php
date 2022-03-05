<?php
require_once('assets/class/classGeral.php');


$cGeral = new Geral();
$cGeral->dbConnect();

@$usuario = $_POST['username'];
@$senha = $_POST['userpassword'];

setcookie ("usuario", "");
setcookie ("senha", "");

$sql = "SELECT * FROM web_login WHERE login = '$usuario' AND senha = '$senha'";
$acessoSite = $cGeral->dbSelect($sql);

if(count($acessoSite) > 0){
  setcookie ("usuario", $usuario, time() + (3600 * 356)); //Grava o Usuario em cookie;
  setcookie ("senha", $senha, time() + (3600 * 356)); // Grava a senha;

  echo '<div class="alert alert-success mb-0" role="alert"><strong>Ok!</strong> Acessando sistema...</div>';
  echo "<script>mudapagina('inicio.php');</script>";
}else{
  setcookie ("usuario", "");
  setcookie ("senha", "");
  echo '<div class="alert alert-danger mb-0" role="alert"><strong>Ops!</strong> Usuario ou senha incorretos!</div>';
}


$cGeral->dbDisconnect();

?>
