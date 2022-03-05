<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  $arqVersion = 1.2;

  $cGeral->dbConnect();

?>
<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Lista de Usuarios</h4>



        <table class="table table-bordered table-striped" id="tableEconomia">
          <thead>
            <tr>
              <th>ID</th>
              <th>NOME</th>
              <th>SOBRENOME</th>
              <th>BANIDO</th>
              <th>ULTIMO ACESSO</th>
              <th>$ LIMPO</th>
              <th>$ SUJO</th>
            </tr>
          </thead>
          <tbody>
        <?php
        $sqlUser = $cGeral->dbSelect("SELECT *
                                          FROM vrp_user_identities UI
                                          LEFT JOIN vrp_users U ON (UI.user_id = U.id)");
        for($u=0; $u<count($sqlUser); $u++){

          $userLimpo = 0;
          $userSujo = 0;
          $userId = $sqlUser[$u]['id'];
          $nome = $sqlUser[$u]['name'];
          $sobrenome = $sqlUser[$u]['firstname'];
          $lastLogin = $sqlUser[$u]['last_login'];
          $banned = $sqlUser[$u]['banned'];

          $sqlBanco = $cGeral->dbSelect("SELECT * FROM vrp_user_moneys WHERE user_id = $userId");

          if(count($sqlBanco) > 0){
          //  $dinheiroLimpo = $dinheiroLimpo + $sqlBanco[0]['wallet'];
          //  $dinheiroLimpo = $dinheiroLimpo + $sqlBanco[0]['bank'];
            $userLimpo = $userLimpo + $sqlBanco[0]['wallet'];
            $userLimpo = $userLimpo + $sqlBanco[0]['bank'];
          }

          $sqlPaypal = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE user_id = $userId AND dkey = 'vRP:paypal'");

          if(count($sqlPaypal) > 0){
          //  $dinheiroLimpo = $dinheiroLimpo + $sqlPaypal[0]['dvalue'];
            $userLimpo = $userLimpo + $sqlPaypal[0]['dvalue'];
          }


          $sqlCasas = $cGeral->dbSelect("SELECT * FROM vrp_homes_permissions WHERE user_id = $userId AND owner = 1");

          for($y=0; $y<count($sqlCasas); $y++){
            $nomeCasa = $sqlCasas[$y]['home'];
            $keyCasa = 'chest:'.$nomeCasa;
            $sqlBauCasa = $cGeral->dbSelect("SELECT * FROM vrp_srv_data WHERE dkey = '$keyCasa' AND dvalue LIKE ('%dinheirosujo%')");
            if(count($sqlBauCasa) > 0){
              $bauFac = json_decode($sqlBauCasa[0]['dvalue'],true);
              $dSujo = $bauFac['dinheirosujo'];
              $dSujoQtd = $dSujo['amount'];
              //$dinheiroSujo = $dinheiroSujo + $dSujoQtd;
              $userSujo = $userSujo + $dSujoQtd;

            //  echo $nomeCasa.' - '.$dSujoQtd.'<br>';

            }
          }

          if($banned == 1){
            $banned = 'Banido';
          }else{
            $banned = 'Não';
          }

          echo "<tr>
                  <td>$userId</td>
                  <td>$nome</td>
                  <td>$sobrenome</td>
                  <td>$banned</td>
                  <td>$lastLogin</td>
                  <td>$userLimpo</td>
                  <td>$userSujo</td>
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

<script>
  $('#tableEconomia').dataTable();
