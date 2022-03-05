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


  $sql = $cGeral->dbSelect("SELECT * FROM vrp_srv_data WHERE dvalue LIKE '%$id%' ORDER BY dkey ASC");

  $arrVeiculo = array();
  $arrCasa = array();

  for($x=0; $x<count($sql);$x++){
    $key = $sql[$x]['dkey'];

    $pesquisa = 'veh_';
    $pattern = '/' . $pesquisa . '/';
    if (preg_match($pattern, $key)) {
      $arrVeiculo[] = $key;
    }else{
      $arrCasa[] = $key;
    }
  }
?>

<div class="row">
  <div class="col-md-12">
    <div class="card card-body">
      <h4 class="card-title font-20 mt-0">Casas:</h4>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>CASA</th>
            <th>DONO</th>
            <th>ABRIR BAU</th>
          </tr>
        </thead>
        <tbody>

            <?php
            for($x=0; $x<count($arrCasa); $x++){
              $dVal = str_replace('chest:', '', $arrCasa[$x]);

              $sqlDono = $cGeral->dbSelect("SELECT *
                                                  FROM vrp_homes_permissions VH
                                                  WHERE VH.home = '$dVal' AND VH.owner = 1");

              if(count($sqlDono) > 0){
                $homeDono = $sqlDono[0]['user_id'];
              }else{
                $homeDono = '';
              }

                echo "<tr>
                        <td>$dVal</td>
                        <td>$homeDono</td>
                        <td><button class='btn btn-sm btn-primary' onClick='openBauCasa(\"$dVal\")'>ABRIR</button></td>
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
      <h4 class="card-title font-20 mt-0">Veiculos:</h4>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>VEICULO</th>
            <th>DONO</th>
            <th>ABRIR BAU</th>
          </tr>
        </thead>
        <tbody>

            <?php
            for($x=0; $x<count($arrVeiculo); $x++){
              $dVal = explode('veh_', $arrVeiculo[$x]);
              $uId = str_replace('chest:u', '', $dVal[0]);
              $dVeic = $dVal[1];


                echo "<tr>
                        <td>$dVeic</td>
                        <td>$uId</td>
                        <td><button class='btn btn-sm btn-primary' onClick='openPortaMala(\"$uId\", \"$dVeic\")'>ABRIR</button></td>
                      </tr>";
            }
            ?>

        </tbody>
      </table>
    </div>
  </div>
</div>




<script>
  function openPortaMala(id, veiculo){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Porta Malas: '+veiculo);
    //$('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "veiculoPortaMalas.php?id="+id+"&veic="+veiculo,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }


  function openBauCasa(id){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Bau da casa: '+id);
    //$('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "casaBau.php?id="+id,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }
</script>
