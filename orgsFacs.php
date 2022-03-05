<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  $arqVersion = 1.2;

  @$cGeral->dbConnect();

?>
<div class="container-fluid">

  <div class="row">
    <div class="col-md-3">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Membros por Fac/Org</h4>

        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Qtd</th>
            </tr>
          </thead>
          <tbody>
        <?php
          @$cOrg = json_decode($cfgOrg, true);
          for($x=0; $x<count($cOrg); $x++){
            @$nome = $cOrg[$x]['nome'];
            @$set = str_replace("'", '"', $cOrg[$x]['set']);
            @$bauName = $cOrg[$x]['bau'];
            @$idAll = '';

            @$moneyFac = 0;
            @$moneySFac = 0;
            @$membros = $cGeral->dbSelect("SELECT *
                                                  FROM vrp_user_data UD
                                                  LEFT JOIN vrp_user_moneys UM ON (UM.user_id = UD.user_id)
                                                  where UD.dkey = 'vRP:datatable'
                                                  AND UD.dvalue LIKE ('%$set%')");
            for($y=0; $y<count($membros); $y++){
              $userId = $membros[$y]['user_id'];
              $carteira = $membros[$y]['wallet'];
              $bank = $membros[$y]['bank'];

              if($idAll == ''){
                $idAll = $userId;
              }else{
                $idAll = $idAll.','.$userId;
              }
              $moneyFac = $moneyFac + $carteira + $bank;
            }

            @$sqlCasas = $cGeral->dbSelect("SELECT * FROM vrp_homes_permissions WHERE user_id IN ($idAll) AND owner = 1");

            for($y=0; $y<count($sqlCasas); $y++){
              $nomeCasa = $sqlCasas[$y]['home'];
              $keyCasa = 'chest:'.$nomeCasa;
              @$sqlBauCasa = $cGeral->dbSelect("SELECT * FROM vrp_srv_data WHERE dkey = '$keyCasa' AND dvalue LIKE ('%dinheirosujo%')");
              if(count($sqlBauCasa) > 0){
                $bauFac = json_decode($sqlBauCasa[0]['dvalue'],true);
                $dSujo = $bauFac['dinheirosujo'];
                $dSujoQtd = $dSujo['amount'];
                $moneySFac = $moneySFac + $dSujoQtd;

              }
            }

            $keyFac = 'chest:'.$bauName;
            @$sqlBauFac = $cGeral->dbSelect("SELECT * FROM vrp_srv_data WHERE dkey = '$keyFac' AND dvalue LIKE ('%dinheirosujo%')");
            if(count($sqlBauFac) > 0){
              $bauFac = json_decode($sqlBauFac[0]['dvalue'],true);
              $dSujo = $bauFac['dinheirosujo'];
              $dSujoQtd = $dSujo['amount'];
              $moneySFac = $moneySFac + $dSujoQtd;

            }
            echo '<tr>
              <td>'.$nome.'</td>
              <td>'.count($membros).'</td>
            </tr>';

            $arrEcon[] = array(
              'nome' => $nome,
              'limpo' => $moneyFac,
              'sujo' => $moneySFac,
              'homes' => count($sqlCasas)
            );
          }
        ?>
      </tbody>
    </table>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Economia por Fac/Org</h4>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Limpo</th>
                <th>Sujo</th>
                <th>Total Homes</th>
              </tr>
            </thead>
            <tbody>
            <?php
              for($x=0; $x<count($arrEcon); $x++){
                $nome = $arrEcon[$x]['nome'];
                $limpo = number_format($arrEcon[$x]['limpo'],0,',','.');
                $sujo = number_format($arrEcon[$x]['sujo'],0,',','.');
                $totalHomes = number_format($arrEcon[$x]['homes'],0,',','.');

                echo '<tr>
                  <td>'.$nome.'</td>
                  <td>'.$limpo.'</td>
                  <td>'.$sujo.'</td>
                  <td>'.$totalHomes.'</td>
                </tr>';
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
