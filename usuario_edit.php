<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}


  if($usPerm <= 50){
    exit;
  }
  $arqVersion = 1.2;

  $cGeral->dbConnect();

  @$id = $_GET['id'];
  @$wh = $_GET['wh'];

  if(empty($wh)){
    $wh = 2;
  }

  if(empty($id)){
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para pesquisar!");
    </script>
    <?php
    exit;
  }

  $sqlUser = $cGeral->dbSelect("SELECT *
                                    FROM vrp_user_identities UI
                                    LEFT JOIN vrp_users U ON (UI.user_id = U.id)
                                    where UI.user_id = '$id'");

  if(count($sqlUser) > 0){ } else{
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Nenhum cidadão localizado!");
    </script>
    <?php
    exit;
  }



  $userId = $sqlUser[0]['user_id'];
  $identidade = $sqlUser[0]['registration'];
  $telefone = $sqlUser[0]['phone'];
  $nome = $sqlUser[0]['name'];
  $sobrenome = $sqlUser[0]['firstname'];
  $idade = $sqlUser[0]['age'];

  $lastLogin = $sqlUser[0]['last_login'];
  $whiteList = $sqlUser[0]['whitelisted'];
  $banned = $sqlUser[0]['banned'];
  $limGaragem = $sqlUser[0]['garagem'];

  $sqlUserMoney = $cGeral->dbSelect("SELECT * FROM vrp_user_moneys WHERE user_id = '$id'");
  $sqlUserData = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:datatable' AND user_id = '$id'");
  $userData = json_decode($sqlUserData[0]['dvalue'], true);
  $sqlUserLevel = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:level' AND user_id = '$id'");
  $sqlUserMulta = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:multas' AND user_id = '$id'");
  if(count($sqlUserMulta) > 0){
    $saldoMulta = $sqlUserMulta[0]['dvalue'];
  }else{
    $saldoMulta = 0;
  }
  $sqlUserPaypal = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:paypal' AND user_id = '$id'");
  if(count($sqlUserPaypal) > 0){
    $saldoPaypal = $sqlUserPaypal[0]['dvalue'];
  }else{
    $saldoPaypal = 0;
  }
  $sqlUserPrisao = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:prisao' AND user_id = '$id'");
  if(count($sqlUserPrisao) > 0){
    $situacaoPrisao = $sqlUserPrisao[0]['dvalue'];
  }else{
    $situacaoPrisao = -1;
  }

  $sqlVeiculo = $cGeral->dbSelect("SELECT * FROM vrp_user_vehicles WHERE user_id = '$id'");


  $sqlCasas = $cGeral->dbSelect("SELECT * FROM vrp_homes_permissions WHERE user_id = '$id' AND owner = 1");

  $equipado = $userData['weapons'];
  $inventario = $userData['inventory'];

  $userVida = $userData['health'];
  $userColete = $userData['colete'];


  $moneyCarteira = $sqlUserMoney[0]['wallet'];
  $moneyBanco = $sqlUserMoney[0]['bank'];

//  $newCarteira = $moneyCarteira + 50000;

  //$cGeral->dbUpdate("UPDATE vrp_user_moneys SET wallet = $newCarteira WHERE user_id = '$id'");
//exit;
  if(count($sqlUserLevel) > 0){
    $userLvData = json_decode($sqlUserLevel[0]['dvalue'], true);
    if(array_key_exists('Activity', $userLvData)){
      $arrLv = $userLvData['Activity']['level'];
      $arrXp = $userLvData['Activity']['xp'];
      $infoLv = $arrLv;
      $infoXp = $arrXp;
    }else{
      $infoLv = '';
      $infoXp = '';
    }
  }else{
    $infoLv = '';
    $infoXp = '';
  }
?>

  <form id="formEditUser" action="#" method="POST">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">ID:</label><br>
                      <input class="form-control form-control-sm" type="number" name="id" readonly value="<?php echo $userId; ?>"></input>
                      <input type="hidden" name="wh" value="<?php echo $wh; ?>"></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">IDENTIDADE:</label><br>
                      <input class="form-control form-control-sm" type="text" name="identidade" value="<?php echo $identidade; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">NOME:</label><br>
                      <input class="form-control form-control-sm" type="text" name="nome" value="<?php echo $nome; ?>"></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">SOBRENOME:</label><br>
                      <input class="form-control form-control-sm" type="text" name="sobrenome" value="<?php echo $sobrenome; ?>"></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">IDADE:</label><br>
                      <input class="form-control form-control-sm" type="number" name="idade" value="<?php echo $idade; ?>"></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">TELEFONE:</label><br>
                      <input class="form-control form-control-sm" type="text" name="telefone" value="<?php echo $telefone; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">VIDA:</label><br>
                      <input class="form-control form-control-sm" type="number" name="vida" value="<?php echo $userVida; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">COLETE:</label><br>
                      <input class="form-control form-control-sm" type="number" name="colete" value="<?php echo $userColete; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>

              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">WL:</label><br>
                      <select name="wl" id="wl">
                        <option value="1" <?php if($whiteList == 1){ echo 'selected'; } ?>>Liberado</option>
                        <option value="0" <?php if($whiteList != 1){ echo 'selected'; } ?>>Bloqueado</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">BAN:</label><br>
                      <select name="ban" id="ban" <?php echo $disableSuporte; ?>>
                        <option value="1" <?php if($banned == 1){ echo 'selected'; } ?>>Banido</option>
                        <option value="0" <?php if($banned != 1){ echo 'selected'; } ?>>Desbanido</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">LIM. CARROS:</label><br>
                      <input class="form-control form-control-sm" type="number" name="limCar" value="<?php echo $limGaragem; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-2">
                <div class="form-group" >
                      <label class="bmd-label-floating">PRESO?</label><br>
                      <input class="form-control form-control-sm" type="number" name="prisao" value="<?php echo $situacaoPrisao; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-3">
                <div class="form-group" >
                      <label class="bmd-label-floating">$ CARTEIRA:</label><br>
                      <input class="form-control form-control-sm" name="moneyCarteira" type="number" value="<?php echo $moneyCarteira; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" >
                      <label class="bmd-label-floating">$ BANCO:</label><br>
                      <input class="form-control form-control-sm" name="moneyBanco" type="number" value="<?php echo $moneyBanco; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" >
                      <label class="bmd-label-floating">$ PAYPAL:</label><br>
                      <input class="form-control form-control-sm" name="moneyPaypal" type="number" value="<?php echo $saldoPaypal; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" >
                      <label class="bmd-label-floating">$ MULTAS:</label><br>
                      <input class="form-control form-control-sm" name="moneyMulta" type="number" value="<?php echo $saldoMulta; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>

            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group" >
                      <label class="bmd-label-floating">LV ACTIVITY:</label><br>
                      <input class="form-control form-control-sm" name="activityLv" type="text" value="<?php echo $infoLv; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" >
                      <label class="bmd-label-floating">XP ACTIVITY:</label><br>
                      <input class="form-control form-control-sm" name="activityXp" type="text" value="<?php echo $infoXp; ?>" <?php echo $readAdmin; ?>></input>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" >
                      <label class="bmd-label-floating">GRUPOS SETADOS:</label><br>
                      <select class="form-control form-control-sm" name="selectGroup[]" multiple id="selectGroup" <?php echo $disableSuporte; ?>>
                          <option value="Motoclub">Motoclub</option>
                          <option value="Mafia">Mafia</option>
                          <option value="iunicorn">Unicorn</option>
                          <option value="Nustra">Nustra</option>
                          <option value="Families">Groove</option>
                          <option value="Ballas">Ballas</option>
                          <option value="Vagos">Vagos</option>
                          <option value="Policia">Policia</option>
                          <option value="PaisanaPolicia">Paisana Policia</option>
                          <option value="Paramedico">Paramedico</option>
                          <option value="PaisanaParamedico">Paisana Paramedico</option>
                          <option value="Mecanico">Mecanico</option>
                          <option value="PaisanaMecanico">Paisana Mecanico</option>
                          <option value="Advogado">Advogado</option>
                          <option value="Admin" <?php //echo $blockPermission; ?> >[GOD] Admin</option>
                          <option value="Mod" <?php //echo $blockPermission; ?>>[GOD] Mod</option>
                          <option value="Suporte" <?php //echo $blockPermission; ?>>[GOD] Suporte</option>
                          <option value="Bronze" <?php //echo $blockPermission; ?>>[VIP] Bronze</option>
                          <option value="Prata" <?php //echo $blockPermission; ?>>[VIP] Prata</option>
                          <option value="Ouro" <?php //echo $blockPermission; ?>>[VIP] Ouro</option>
                          <option value="Platina" <?php //echo $blockPermission; ?>>[VIP] Platina</option>
                          <option value="Nox" <?php// echo $blockPermission; ?>[VIP] Nox</option>

                      </select>
                      <?php
                        $groupArr = '[';
                        $i = 1;
                      foreach ($userData['groups'] as $key => $value) {

                          if($i==1){
                            $groupArr = $groupArr."'$key'";
                            $i = 2;
                          }else{
                            $groupArr = $groupArr.",'$key'";
                          }

                        }
                        $groupArr = $groupArr.']';
                      ?>

                  </div>
              </div>
            </div>

</form>
      <button class="btn btn-success btn-sm btn-block" onclick="salvarEditUser()">Salvar</button>

<div id="resultEditUser"></div>

            <script>
            $('#wl').select2();
            $('#ban').select2();
              $('#selectGroup').select2();
              $('#selectGroup').val(<?php echo $groupArr; ?>).trigger('change');

              function salvarEditUser(){
                $("#resultEditUser").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
                $.post( "usuario_editSalvar.php", $( "#formEditUser" ).serialize() )
                .done(function( data ) {
                  $('#resultEditUser').html(data);
                });
              }
            </script>
