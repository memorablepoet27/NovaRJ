<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  function implodeArrayKeys($array) {
        return implode(", ",array_keys($array));
}

  $arqVersion = 1.2;
  if($usPerm <= 50){
    exit;
  }
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


  if($banned == 0){
    ?>
    <div class="alert alert-danger" role="alert">
      Deseja banir o id: <?php echo $id; ?>? Este processo pode ser revertido posteriormente!
      <br>
      <button type="button" class="btn btn-sm btn-success" onclick="salvarBan()">Sim</button>
      <button type="button" class="btn btn-sm btn-danger"  onclick="fecharModal()">Não</button>
    </div>
    <div id="resultBan"></div>
    <?php
  }else{
    ?>
    <div class="alert alert-success" role="alert">
      Deseja retirar o banimento do id: <?php echo $id; ?>? Este processo pode ser revertido posteriormente!
      <br>
      <button type="button" class="btn btn-sm btn-success" onclick="salvarBan()">Sim</button>
      <button type="button" class="btn btn-sm btn-danger"  onclick="fecharModal()">Não</button>
    </div>
    <div id="resultBan"></div>
    <?php
  }
?>
  <script>
    function salvarBan(){
      $.post( "usuario_banSalvar.php", {id: <?php echo $id; ?>, ban: <?php echo $banned; ?>} )
      .done(function( data ) {
        $('#resultBan').html(data);
      });
    }
  </script>
