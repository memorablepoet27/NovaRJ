<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}

  $arqVersion = 1.2;

  $cGeral->dbConnect();

  @$id = str_replace("'", '"', $_GET['id']);

  if(empty($id)){
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para pesquisar!");
    </script>
    <?php
    exit;
  }
  //echo $id;
  $sqlUserGroup = $cGeral->dbSelect("SELECT *
                                          FROM vrp_user_data UD
                                          LEFT JOIN vrp_users U ON (U.id = UD.user_id)
                                          LEFT JOIN vrp_user_identities UI ON (U.id = UI.user_id)
                                          WHERE UD.dkey = 'vRP:datatable' AND UD.dvalue LIKE ('%$id%')");

  if(count($sqlUserGroup) > 0){ } else{
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Nenhum cidadão localizado para esta Organização/Facção!");
    </script>
    <?php
    exit;
  }


  $dinheiroLimpo = 0;
  $dinheiroSujo = 0;

?>



<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Resultado pesquisa de Org / Fac</h4>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Membros Setados (InGame):</h4>
              <table class="table table-bordered table-striped">
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
                    for($x=0; $x<count($sqlUserGroup); $x++){
                      $userLimpo = 0;
                      $userSujo = 0;
                      $userId = $sqlUserGroup[$x]['id'];
                      $nome = $sqlUserGroup[$x]['name'];
                      $sobrenome = $sqlUserGroup[$x]['firstname'];
                      $lastLogin = $sqlUserGroup[$x]['last_login'];
                      $banned = $sqlUserGroup[$x]['banned'];

                      $sqlBanco = $cGeral->dbSelect("SELECT * FROM vrp_user_moneys WHERE user_id = $userId");

                      if(count($sqlBanco) > 0){
                        $dinheiroLimpo = $dinheiroLimpo + $sqlBanco[0]['wallet'];
                        $dinheiroLimpo = $dinheiroLimpo + $sqlBanco[0]['bank'];
                        $userLimpo = $userLimpo + $sqlBanco[0]['wallet'];
                        $userLimpo = $userLimpo + $sqlBanco[0]['bank'];
                      }

                      $sqlPaypal = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE user_id = $userId AND dkey = 'vRP:paypal'");

                      if(count($sqlPaypal) > 0){
                        $dinheiroLimpo = $dinheiroLimpo + $sqlPaypal[0]['dvalue'];
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
                          $dinheiroSujo = $dinheiroSujo + $dSujoQtd;
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





        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Bau Fac:</h4>
              <?php

                if($id == 'Mafia'){
                  $cId = 'MAFIAG';
                }else if($id == 'Nuestra'){
                  $cId = 'Triad';
                }else{
                  $cId = $id;
                }
              $nomeChess = "chest:".$cId;

              $sqlBauFac = $cGeral->dbSelect("SELECT *
                                                FROM vrp_srv_data
                                                where dkey = '$nomeChess'");


              if(count($sqlBauFac) == 0){

              }else{
                $bauFac = json_decode($sqlBauFac[0]['dvalue'],true);

                  $colunas = 6;
                  $colTam = 2;
                  $atual = 1;
                  $cItem = json_decode($cfgItem, true);

                  foreach ($bauFac as $key => $value) {

                    $item = $key;
                    $qtd = $value['amount'];



                    if (array_key_exists($item, $cItem)) {
                      $nomeItem = $cItem[$item]['nome'];
                      $icon = $cItem[$item]['icon'];
                    }else{
                      $nomeItem = $item;
                      $icon = $item;
                    }

                    if($nomeItem == 'dinheirosujo'){
                      $dinheiroSujo = $dinheiroSujo + $qtd;
                    }

                    if($atual == 1){
                      echo '<div class="row">
                            <div class="col-md-'.$colTam.'">';
                                  echo "<center> <img src='http://noxcity.com/imgallstar/".$icon.".png' width='50' height='50'> <br> $nomeItem <br> x$qtd </center>";
                      echo '</div>';
                      $atual++;
                    }else if($atual < $colunas){
                      echo '<div class="col-md-'.$colTam.'">';
                                  echo "<center> <img src='http://noxcity.com/imgallstar/".$icon.".png' width='50' height='50'> <br> $nomeItem <br> x$qtd </center>";
                      echo '</div>';
                      $atual++;
                    }else{
                      echo '<div class="col-md-'.$colTam.'">';
                                  echo "<center> <img src='http://noxcity.com/imgallstar/".$icon.".png' width='50' height='50'> <br> $nomeItem <br> x$qtd </center>";
                      echo '</div></div>';
                      $atual = 1;
                    }

                  }
                  if($atual != $colunas){
                    echo '</div></div>  </div> ';
                  }
              }

              ?>
           </div>



        <div class="row">
          <div class="col-md-12">
            <div class="card card-body">
              <h4 class="card-title font-20 mt-0">Economia da Fac/Org:</h4>

                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-body">
                      <h4 class="card-title font-20 mt-0">Dinheiro Limpo:</h4>
                      <h3>$ <?php echo number_format($dinheiroLimpo,0,',','.'); ?></h3>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card card-body">
                      <h4 class="card-title font-20 mt-0">Dinheiro Sujo:</h4>
                      <h3>$ <?php echo number_format($dinheiroSujo,0,',','.'); ?></h3>
                    </div>
                  </div>
                </div>

            </div>
          </div>
        </div>

</div>

      </div>
    </div>



  </div>


</div>


<script>

</script>
