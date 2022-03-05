<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}

  $arqVersion = 1.2;

  $cGeral->dbConnect();

  @$id = $_GET['id'];
  @$veic = $_GET['veic'];

  if(empty($id)){
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para abrir o Porta Malas!");
    fecharModal();
    </script>
    <?php
    exit;
  }

  if(empty($veic)){
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um VEICULO para abrir o Porta Malas!");
    fecharModal();
    </script>
    <?php
    exit;
  }

  $nomeChess = "chest:u".$id."veh_".$veic;


  $sqlVeic = $cGeral->dbSelect("SELECT *
                                    FROM vrp_srv_data
                                    where dkey = '$nomeChess'");

  if(count($sqlVeic) > 0){ } else{
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Nenhum Veiculo localizado! Possivelmente vazio");
    fecharModal();
    </script>
    <?php
    exit;
  }

    $portaMala = json_decode($sqlVeic[0]['dvalue'],true);

?>

        <div class="row">
          <div class="col-md-12">
              <?php
                $colunas = 6;
                $colTam = 2;
                $atual = 1;
                foreach ($portaMala as $key => $value) {

                  $item = $key;
                  $qtd = $value['amount'];

                  $cItem = json_decode($cfgItem, true);

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
                  echo '</div>';
                }
              ?>
          </div>
        </div>

        <script>
            $('#modalDetalhes').modal('show');
        </script>
