<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  $arqVersion = 1.2;

  $cGeral->dbConnect();

  $sqlUsers = $cGeral->dbSelect("SELECT * FROM vrp_user_identities");
  $totalUsers = count($sqlUsers);

  $sqlCasas = $cGeral->dbSelect("SELECT * FROM vrp_homes_permissions WHERE owner = 1");
  $totalCasas = count($sqlCasas);

  $sqlCarros = $cGeral->dbSelect("SELECT * FROM vrp_user_vehicles");
  $totalCarros = count($sqlCarros);


  $sqlEconomia = $cGeral->dbSelect("SELECT SUM(wallet) AS TOTCART, SUM(bank) AS TOTBANK FROM `vrp_user_moneys`");
  $totalWallet = $sqlEconomia[0]['TOTCART'];
  $totalBank = $sqlEconomia[0]['TOTBANK'];
  $totalDinheiroLimpo = $totalWallet + $totalBank;


  $sqlEconomiaSuja = $cGeral->dbSelect("SELECT * FROM vrp_srv_data WHERE dvalue LIKE ('%dinheirosujo%')");

  $totalDinheiroSujo = 0;
  for($x=0; $x<count($sqlEconomiaSuja); $x++){
    $val = json_decode($sqlEconomiaSuja[$x]['dvalue'], true);
    $totalDinheiroSujo = $totalDinheiroSujo + $val['dinheirosujo']['amount'];
  }



  $isCasa = array();
  $isVeic = array();

  $cItem = json_decode($cfgItemHack, true);
  foreach ($cItem as $key => $value) {

    $set = str_replace("'", '"', $key);;
    $nome = $value['nome'];

    $sqlItemSusp = $cGeral->dbSelect("SELECT * FROM vrp_srv_data WHERE dvalue LIKE '%$set%' ORDER BY dkey ASC");


    for($x=0; $x<count($sqlItemSusp);$x++){
      $dkey = $sqlItemSusp[$x]['dkey'];

      $pesquisa = 'veh_';
      $pattern = '/' . $pesquisa . '/';
      if (preg_match($pattern, $dkey)) {
        $isVeic[] = $dkey;
      }else{
        $isCasa[] = $dkey;
      }
    }

  }



?>
<div class="container-fluid">


  <div class="row">
    <div class="col-xl-2 col-md-6">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h5 class="float-right mt-0"><?php echo $totalUsers; ?></h5>
            <h6 class="mt-0 mb-3">Cidadões</h6>
            <p class="text-muted mb-0">Numero total de Cidadões!</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-6">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h5 class="float-right mt-0"><?php echo $totalCarros; ?></h5>
            <h6 class="mt-0 mb-3">Carros</h6>
            <p class="text-muted mb-0">Numero total de Carros!</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-6">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h5 class="float-right mt-0"><?php echo $totalCasas; ?></h5>
            <h6 class="mt-0 mb-3">Casas</h6>
            <p class="text-muted mb-0">Numero total de Casas!</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-6">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h5 class="float-right mt-0"><?php echo $totalDinheiroLimpo; ?></h5>
            <h6 class="mt-0 mb-3">Economia</h6>
            <p class="text-muted mb-0">Total $ Limpo!</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-2 col-md-6">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h5 class="float-right mt-0"><?php echo $totalDinheiroSujo; ?></h5>
            <h6 class="mt-0 mb-3">Economia</h6>
            <p class="text-muted mb-0">Total $ Sujo!</p>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-4">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h6 class="mt-0 mb-3">Itens Suspeitos (CASAS)</h6>
            <table class="table table-striped table-bordered" id="itemSusp">
              <thead>
                <tr>
                  <th>CASA</th>
                  <th>PROPRIETARIO</th>
                  <th>BANIDO?</th>
                  <th>AÇÃO</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  for($x=0; $x<count($isCasa); $x++){
                    $nomeCasa = str_replace('chest:', '', $isCasa[$x]);

                      $sqlHomes = $cGeral->dbSelect("SELECT *
                                                      FROM vrp_homes_permissions UP
                                                      LEFT JOIN vrp_users U ON (UP.user_id = U.id)
                                                      LEFT JOIN vrp_user_identities UI ON (UI.user_id = UP.user_id)
                                                    WHERE UP.owner = 1 AND UP.home = '$nomeCasa'");

                    if(count($sqlHomes) > 0){
                      $userId = $sqlHomes[0]['user_id'];
                      $nome = $sqlHomes[0]['name'];
                      $sobrenome = $sqlHomes[0]['firstname'];
                      $banned = $sqlHomes[0]['banned'];

                      if($banned == 1){
                        $banned = 'Banido';
                      }else{
                        $banned = 'Não';
                      }

                    }else{
                      $userId = '';
                      $nome = '';
                      $sobrenome = '';
                      $banned = '';
                    }



                    ?>
                      <tr>
                        <td><?php echo $nomeCasa; ?></td>
                        <td><?php echo $userId; ?> (<?php echo $nome.' '.$sobrenome; ?>)</td>
                        <td><?php echo $banned; ?></td>
                        <td><button class='btn btn-sm btn-primary' onClick='openBauCasa("<?php echo $nomeCasa; ?>")'>ABRIR</button></td>
                      </tr>
                    <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>



    <div class="col-md-4">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h6 class="mt-0 mb-3">Itens Suspeitos (CARROS)</h6>
            <table class="table table-striped table-bordered" id="itemSusp">
              <thead>
                <tr>
                  <th>CARRO</th>
                  <th>PROPRIETARIO</th>
                  <th>BANIDO?</th>
                  <th>AÇÃO</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  for($x=0; $x<count($isVeic); $x++){
                    $veicChest = $isVeic[$x];
                    $exp = explode('veh_', $veicChest);
                    $veicProp = str_replace('chest:u', '', $exp[0]);
                    $veicNome = $exp[1];

                    $sqlUser = $cGeral->dbSelect("SELECT *
                                                      FROM vrp_user_identities UI
                                                      LEFT JOIN vrp_users U ON (UI.user_id = U.id)
                                                      where UI.user_id = '$veicProp'");
                    if(count($sqlUser) > 0){
                      $nome = $sqlUser[0]['name'];
                      $sobrenome = $sqlUser[0]['firstname'];
                      $banned = $sqlUser[0]['banned'];

                      if($banned == 1){
                        $banned = 'Banido';
                      }else{
                        $banned = 'Não';
                      }
                    }else{
                      $nome = '';
                      $sobrenome = '';
                      $banned = '';
                    }

                    ?>
                      <tr>
                        <td><?php echo $veicNome; ?></td>
                        <td><?php echo $veicProp; ?> (<?php echo $nome.' '.$sobrenome; ?>)</td>
                        <td><?php echo $banned; ?></td>
                        <td><button class='btn btn-sm btn-primary' onClick='openPortaMala("<?php echo $veicProp; ?>", "<?php echo $veicNome; ?>")'>ABRIR</button></td>
                      </tr>
                    <?php
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>




    <div class="col-md-4">
      <div class="card mini-stats">
        <div class="p-3 mini-stats-content">
          <div class="mb-4">
            <div class="float-right text-right"></div>
          </div>
        </div>

        <div class="ml-3 mr-3">
          <div class="bg-white p-3 mini-stats-desc rounded">
            <h6 class="mt-0 mb-3">Itens Suspeitos (EQUIPADO/MOCHILA)</h6>
            <table class="table table-striped table-bordered" id="itemSusp">
              <thead>
                <tr>
                  <th>USUARIO</th>
                  <th>BANIDO?</th>
                  <th>AÇÃO</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($cItem as $key => $value) {

                  $set = str_replace("'", '"', $key);;
                  $nome = $value['nome'];

                  $sqlItemSusp = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey = 'vRP:datatable' AND dvalue LIKE '%$set%' ORDER BY user_id ASC");

                  for($x=0; $x<count($sqlItemSusp); $x++){
                    $uId = $sqlItemSusp[$x]['user_id'];

                    $sqlUser = $cGeral->dbSelect("SELECT *
                                                      FROM vrp_user_identities UI
                                                      LEFT JOIN vrp_users U ON (UI.user_id = U.id)
                                                      where UI.user_id = '$uId'");
                    if(count($sqlUser) > 0){
                      $nome = $sqlUser[0]['name'];
                      $sobrenome = $sqlUser[0]['firstname'];
                      $banned = $sqlUser[0]['banned'];

                      if($banned == 1){
                        $banned = 'Banido';
                      }else{
                        $banned = 'Não';
                      }
                    }else{
                      $nome = '';
                      $sobrenome = '';
                      $banned = '';
                    }
                    ?>
                      <tr>
                        <td><?php echo $uId; ?> (<?php echo $nome.' '.$sobrenome; ?>)</td>
                        <td><?php echo $banned; ?></td>
                        <td><button class='btn btn-sm btn-primary' onClick='openEquipado("<?php echo $uId; ?>")'>ABRIR EQUIPADO</button> <button class='btn btn-sm btn-primary' onClick='openMochila("<?php echo $uId; ?>")'>ABRIR MOCHILA</button></td>
                      </tr>
                    <?php
                  }
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
