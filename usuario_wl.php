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
  $whiteList = $sqlUser[0]['whitelisted'];
  $banned = $sqlUser[0]['banned'];


  if($whiteList == 0){
    ?>
    <div class="alert alert-success" role="alert">
      Deseja adicionar a WL ao id: <?php echo $id; ?>? Este processo pode ser revertido posteriormente!
      <br>
      <button type="button" class="btn btn-sm btn-success" onclick="salvarWl()">Sim</button>
      <button type="button" class="btn btn-sm btn-danger"  onclick="fecharModal()">Não</button>
    </div>
    <div id="resultWl"></div>
    <?php
  }else{
    ?>
    <div class="alert alert-danger" role="alert">
      Deseja retirar a WL do id: <?php echo $id; ?>? Este processo pode ser revertido posteriormente!
      <br>
      <button type="button" class="btn btn-sm btn-success" onclick="salvarWl()">Sim</button>
      <button type="button" class="btn btn-sm btn-danger"  onclick="fecharModal()">Não</button>
    </div>
    <div id="resultWl"></div>
    <?php
  }
?>
  <script>
    function salvarWl(){
      $.post( "usuario_wlSalvar.php", {id: <?php echo $id; ?>, wl: <?php echo $whiteList; ?>} )
      .done(function( data ) {
        $('#resultWl').html(data);
      });
    }
  </script>
