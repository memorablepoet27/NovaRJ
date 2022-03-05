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
    alertify.logPosition("bottom right"),alertify.error("Obrigatorio informar um ID para abrir verificar o bau!");
    fecharModal();
    </script>
    <?php
    exit;
  }

  $nomeChest = 'chest:'.$id;


  $sqlBauCasa = $cGeral->dbSelect("SELECT *
                                    FROM vrp_srv_data
                                    where dkey = '$nomeChest'");

  if(count($sqlBauCasa) > 0){ } else{
    ?>
    <script>
    alertify.logPosition("bottom right"),alertify.error("Nenhum bau localizado! Possivelmente vazio");
    fecharModal();
    </script>
    <?php
    exit;
  }

    $bauC = json_decode($sqlBauCasa[0]['dvalue'],true);

?>

        <div class="row">
          <div class="col-md-12">
              <?php
                $colunas = 4;
                $colTam = 3;
                $atual = 1;
                foreach ($bauC as $key => $value) {

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
