<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}

  $arqVersion = 1.2;
  if($usPerm <= 50){
    exit;
  }
  $cGeral->dbConnect();

  @$id = $_POST['id'];
  @$ban = $_POST['ban'];

  if(empty($id)){
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para pesquisar!");
    </script>
    <?php
    exit;
  }

  if($ban == 0){
    $banFinal = 1;
    $banResult = 'Banido';
  }else{
    $banFinal = 0;
    $banResult = 'Desbanido';
  }

  $sql = "UPDATE vrp_users SET banned = $banFinal WHERE id = $id";

  if($cGeral->dbInsert($sql)){
$msgWH = "```prolog\nBANIMENTO:
[Usuario]: $usuario
[ID]: $id
[Acao]: $banResult```";

$cGeral->discordWH($msgWH);

    ?>
      <script>
        alertify.logPosition("bottom right"),alertify.success("Usuario <?php echo $banResult; ?> com sucesso!");
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
