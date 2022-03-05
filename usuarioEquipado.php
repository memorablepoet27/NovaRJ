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
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para abrir a mochila!");
    fecharModal();
    </script>
    <?php
    exit;
  }


  $sqlUserData = $cGeral->dbSelect("SELECT * FROM vrp_user_data WHERE dkey='vRP:datatable' AND user_id = '$id'");


  if(count($sqlUserData) > 0){ } else{
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Nenhuma Mochila localizada! Possivelmente vazio");
    fecharModal();
    </script>
    <?php
    exit;
  }

    $userData = json_decode($sqlUserData[0]['dvalue'], true);
    $equipado = $userData['weapons'];

?>

        <div class="row">
          <div class="col-md-12">
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
                        $icon = '';
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

        <script>
            $('#modalDetalhes').modal('show');
        </script>
