<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  $arqVersion = 1.2;

  if($usPerm <= 50){
    exit;
  }

  $cGeral->dbConnect();

/*
print_r($_POST);
*/
$id = $_POST['id'];
@$wh = $_POST['wh'];

$sqlUser = $cGeral->dbSelect("SELECT dvalue FROM vrp_user_data where dkey = 'vRP:datatable' and user_id = '$id'");
  if(count($sqlUser) > 0){
    $dVal = json_decode($sqlUser[0]['dvalue'], true);
  }else{
    echo 'erro';
    exit;
  }
$identidade = $_POST['identidade'];
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$idade = $_POST['idade'];
$telefone = $_POST['telefone'];

$vida = $_POST['vida'];
$colete = $_POST['colete'];

$wl = $_POST['wl'];
$ban = $_POST['ban'];

$limCar = $_POST['limCar'];
$prisao = $_POST['prisao'];

$dCarteira = str_replace(',', '', str_replace('.', '', str_replace(' ', '', $_POST['moneyCarteira'])));
$dBanco = str_replace(',', '', str_replace('.', '', str_replace(' ', '', $_POST['moneyBanco'])));
$dPaypal = str_replace(',', '', str_replace('.', '', str_replace(' ', '', $_POST['moneyPaypal'])));
$dMulta = str_replace(',', '', str_replace('.', '', str_replace(' ', '', $_POST['moneyMulta'])));

$actLv = $_POST['activityLv'];
$actXp = $_POST['activityXp'];

$levelArr = '{"Activity":{"level":'.$actLv.',"xp":'.$actXp.'}}';

@$group = $_POST['selectGroup'];

$groups = array();

$groups2 = '';

if(!empty($group)){
  for($x=0; $x<count($group); $x++){
    if($groups2 == ''){
      $groups2 = $group[$x];
    }else{
      $groups2 = $groups2.','.$group[$x];
    }
    $groups[$group[$x]] = true;
  }
}

$dVal['groups'] = $groups;
$dVal['health'] = $vida;
$dVal['colete'] = $colete;


$inputDVal = json_encode($dVal);

// Seta os Dados pessoais do Cidadão
$cGeral->dbUpdate("UPDATE vrp_user_identities SET registration = '$identidade', phone = '$telefone', name = '$nome', firstname = '$sobrenome', age = '$idade' WHERE user_id = '$id'");

//Seta Dinheiro na Carteira e Banco
$cGeral->dbUpdate("UPDATE vrp_user_moneys SET wallet = '$dCarteira', bank = '$dBanco' WHERE user_id = '$id'");

// Seta WL, BAN e garagem
$cGeral->dbUpdate("UPDATE vrp_users SET whitelisted = '$wl', banned = '$ban', garagem = '$limCar' WHERE id = '$id'");

// Seta Paypal
$cGeral->dbUpdate("UPDATE vrp_user_data set dvalue = '$dPaypal' WHERE dkey = 'vRP:paypal' AND user_id = '$id'");
// Seta Multas
$cGeral->dbUpdate("UPDATE vrp_user_data set dvalue = '$dMulta' WHERE dkey = 'vRP:multas' AND user_id = '$id'");
// Seta Prisão
$cGeral->dbUpdate("UPDATE vrp_user_data set dvalue = '$prisao' WHERE dkey = 'vRP:prisao' AND user_id = '$id'");
// Seta Level
$cGeral->dbUpdate("UPDATE vrp_user_data set dvalue = '$levelArr' WHERE dkey = 'vRP:level' AND user_id = '$id'");
// Seta Groups, Vida e Colete
$cGeral->dbUpdate("UPDATE vrp_user_data set dvalue = '$inputDVal' WHERE dkey = 'vRP:datatable' AND user_id = '$id'");

if($wh == 1){
$msgWH = "```prolog\nEDICAO DE USUARIO:
[Usuario]: $usuario
[ID]: $id

[Nome]: $nome | [Sobrenome]: $sobrenome | [Idade]: $idade
[Identidade]: $identidade | [Telefone]: $telefone | [Lim. Garagem]: $limCar

[$ Carteira]: $dCarteira | [$ Banco]: $dBanco | [$ Paypal]: $dPaypal | [$ Multa]: $dMulta
[Prisao]: $prisao
[WhiteList]: $wl |[ Banimento]: $ban
[Vida]: $vida | [Colete]: $colete

[Grupos]: $groups2

[Lv (XP)]: $actLv ($actXp)```";

$cGeral->discordWH("LINK WEBHOOK AQUI", $msgWH);
}

//$msgWH = "```Usuario: $usuario editou o usuario [$id]```";
//$cGeral->discordWH($msgWH);


?>
  <script>
    alertify.logPosition("bottom right"),alertify.success("Usuario <?php echo $id; ?> editado com sucesso!");
    fecharModal();
  </script>
<?php

  exit;
