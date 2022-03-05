<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}

  $arqVersion = 1.2;

  $cGeral->dbConnect();

  @$id = $_GET['id'];

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
  $sqlUserIds = $cGeral->dbSelect("SELECT * FROM vrp_user_ids WHERE user_id = '$id'");
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



  if(count($sqlUserLevel) > 0){
    $userLvData = json_decode($sqlUserLevel[0]['dvalue'], true);
    if(array_key_exists('Activity', $userLvData)){
      $arrLv = $userLvData['Activity']['level'];
      $arrXp = $userLvData['Activity']['xp'];
      $infoLv = $arrLv.'('.$arrXp.')';
    }else{
      $infoLv = '';
    }
  }else{
    $infoLv = '';
  }

?>



<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-body">
        <div class="row">
          <!--div class="col-md-1">
            <button class="btn btn-sm btn-info">Ban</button>
          </div-->
          <?php
          if($usPerm >= 51){
            ?>
          <div class="col-md-1">
                <button class="btn btn-sm btn-danger" onclick="setBan(<?php echo $id; ?>);">Ban</button>
          </div>
          <?php
        }
        ?>
          <div class="col-md-1">
            <button class="btn btn-sm btn-success" onclick="setWl(<?php echo $id; ?>);">Whitelist</button>
          </div>
          <?php
          if($usPerm >= 51){
            ?>
          <div class="col-md-1">
                <button class="btn btn-sm btn-warning" onclick="userEdit(<?php echo $id; ?>, 1);" <?php echo $disableSuporte; ?>>Editar Usuario</button>
          </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Resultado pesquisa de Usuario</h4>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Pessoal:</h4>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">ID:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $userId; ?>"></input>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">IDENTIDADE:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $identidade; ?>"></input>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">NOME:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $nome; ?>"></input>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">SOBRENOME:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $sobrenome; ?>"></input>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">IDADE:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $idade; ?>"></input>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">TELEFONE:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $telefone; ?>"></input>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group" >
                        <label class="bmd-label-floating">GRUPOS SETADOS:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo implodeArrayKeys($userData['groups']); ?>"></input>
                    </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group" >
                        <label class="bmd-label-floating">VIDA:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $userVida; ?>"></input>
                    </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group" >
                        <label class="bmd-label-floating">COLETE:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $userColete; ?>"></input>
                    </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group" >
                        <label class="bmd-label-floating">ULTIMO ACESSO:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $lastLogin; ?>"></input>
                    </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group" >
                        <label class="bmd-label-floating">WL:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $whiteList; ?>"></input>
                    </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group" >
                        <label class="bmd-label-floating">BAN:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $banned; ?>"></input>
                    </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group" >
                        <label class="bmd-label-floating">LIM. CARROS:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $limGaragem; ?>"></input>
                    </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group" >
                        <label class="bmd-label-floating">PRESO?</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $situacaoPrisao; ?>"></input>
                    </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-3">
                  <div class="form-group" >
                        <label class="bmd-label-floating">$ CARTEIRA:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo number_format($sqlUserMoney[0]['wallet'],0,',','.'); ?>"></input>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" >
                        <label class="bmd-label-floating">$ BANCO:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo number_format($sqlUserMoney[0]['bank'],0,',','.'); ?>"></input>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" >
                        <label class="bmd-label-floating">$ PAYPAL:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo number_format($saldoPaypal,0,',','.'); ?>"></input>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" >
                        <label class="bmd-label-floating">$ MULTAS:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo number_format($saldoMulta,0,',','.'); ?>"></input>
                    </div>
                </div>

              </div>


              <div class="row">
                <div class="col-md-3">
                  <div class="form-group" >
                        <label class="bmd-label-floating">LV ACTIVITY:</label><br>
                        <input class="form-control form-control-sm" type="text" readonly value="<?php echo $infoLv; ?>"></input>
                    </div>
                </div>
              </div>



            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Links / Identificações:</h4>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>PLATAFORMA</th>
                    <th>ID</th>
                  </tr>
                </thead>
                <tbody>

                    <?php
                    for($x=0; $x<count($sqlUserIds);$x++){
                      $identificador = $sqlUserIds[$x]['identifier'];
                      $ident = explode(':', $identificador);
                      $plataforma = $ident[0];
                      $idPlat = $ident[1];
                      echo "<tr><td>$plataforma</td> <td>$idPlat</td></tr>";
                    }
                    ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Equipado:</h4>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ITEM/ARMA</th>
                    <th>MUNIÇÃO</th>
                  </tr>
                </thead>
                <tbody>

                    <?php
                      foreach ($equipado as $key => $value) {
                        $item = 'wbody|'.$key;
                        $qtd = $value['ammo'];
                        $cItem = json_decode($cfgItem, true);

                        if (array_key_exists($item, $cItem)) {
                          $nomeItem = $cItem[$item]['nome'];
                          $icon = $cItem[$item]['icon'];
                        }else{
                          $nomeItem = $item;
                          $iton = '';
                        }


                        if($qtd == '-1'){
                          $qtd = 'Infinito';
                        }
                        echo "<tr><td><img src='http://noxcity.com/imgallstar/".$icon.".png' width='50' height='50'> $nomeItem</td> <td>$qtd</td></tr>";
                      }
                    ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>



        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Mochila:</h4>
              <?php
                $colunas = 6;
                $colTam = 2;
                $atual = 1;
                $cItem = json_decode($cfgItem, true);

                foreach ($inventario as $key => $value) {
                  $item = $key;
                  $qtd = $value['amount'];

                  if (array_key_exists($item, $cItem)) {
                    $nomeItem = $cItem[$item]['nome'];
                    $icon = $cItem[$item]['icon'];
                  }else{
                    $nomeItem = $item;
                    $icon = $item;
                  }

                  if($atual == 1){
                    echo '<div class="row">
                          <div class="col-md-'.$colTam.'">';
                                echo "<center> <img src='http://noxcity.com/imgallstar/$icon.png' width='50' height='50'> <br> $nomeItem <br> x$qtd </center>";
                    echo '</div>';
                    $atual++;
                  }else if($atual < $colunas){
                    echo '<div class="col-md-'.$colTam.'">';
                                echo "<center> <img src='http://noxcity.com/imgallstar/$icon.png' width='50' height='50'> <br> $nomeItem <br> x$qtd </center>";
                    echo '</div>';
                    $atual++;
                  }else{
                    echo '<div class="col-md-'.$colTam.'">';
                                echo "<center> <img src='http://noxcity.com/imgallstar/$icon.png' width='50' height='50'> <br> $nomeItem <br> x$qtd </center>";
                    echo '</div></div>';
                    $atual = 1;
                  }

                }

                if($atual != $colunas){
                  echo '</div>';
                }
              ?>
            </div>
          </div>
        </div>



        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Veiculos:</h4>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>VEICULO</th>
                    <th>DETIDO</th>
                    <th>MOTOR</th>
                    <th>CHASSI</th>
                    <th>COMBUSTIVEL</th>
                    <th>PORTA MALAS</th>
                  </tr>
                </thead>
                <tbody>

                    <?php

                    for($x=0; $x<count($sqlVeiculo); $x++){
                        $veiculo = $sqlVeiculo[$x]['vehicle'];
                        $detido = $sqlVeiculo[$x]['detido'];
                        $time = $sqlVeiculo[$x]['time'];
                        $motor = $sqlVeiculo[$x]['engine'];
                        $chassi = $sqlVeiculo[$x]['body'];
                        $combustivel = $sqlVeiculo[$x]['fuel'];
                        $ipva = $sqlVeiculo[$x]['ipva'];

                        $nomeChest = 'chest:u'.$id.'veh_'.$veiculo;

                        //$sqlUserLevel = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:level' AND user_id = '$id'");

                        echo "<tr>
                                <th><img src='http://noxcity.com/imgallstar/$veiculo.png' width='445' height='235'></th>
                                <th>$veiculo</th>
                                <th>$detido</th>
                                <th>$motor</th>
                                <th>$chassi</th>
                                <th>$combustivel</th>
                                <th><button class='btn btn-sm btn-primary' onClick='openPortaMala(\"$id\", \"$veiculo\")'>ABRIR</button></th>
                              </tr>";


                    }

                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>




        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Casas:</h4>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>CASA</th>
                    <th>VER BAU</th>
                  </tr>
                </thead>
                <tbody>

                    <?php

                    for($x=0; $x<count($sqlCasas); $x++){
                        $nomeCasa = $sqlCasas[$x]['home'];


                        echo "<tr>
                                <th>$nomeCasa</th>
                                <th><button class='btn btn-sm btn-primary' onClick='openBauCasa(\"$nomeCasa\")'>ABRIR</button></th>
                              </tr>";


                    }

                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>




      </div>
    </div>



  </div>


</div>
