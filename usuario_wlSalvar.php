<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}

  $arqVersion = 1.2;

  $cGeral->dbConnect();

  @$id = $_POST['id'];
  @$wl = $_POST['wl'];

  if(empty($id)){
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para pesquisar!");
    </script>
    <?php
    exit;
  }

  if($wl == 0){
    $banFinal = 1;
    $wlResult = 'Liberada';
  }else{
    $banFinal = 0;
    $wlResult = 'Retirada';
  }

  $sql = "UPDATE vrp_users SET whitelisted = $banFinal WHERE id = $id";

  if($cGeral->dbInsert($sql)){
    $msgWH = "```prolog\nWHITELIST:
[Usuario]: $usuario
[ID]: $id
[Acao]: $wlResult```";
    $cGeral->discordWH($msgWH);
    ?>
      <script>
        alertify.logPosition("bottom right"),alertify.success("Usuario teve a whitelist: <?php echo $wlResult; ?> com sucesso!");
        fecharModal();
      </script>
    <?php

      exit;
  }else{
    ?>
      <script>
        alertify.logPosition("bottom right"),alertify.error("Ocorreu um erro, tente novamente!");
      </script>
    <?php
      exit;
  }

?>
