<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  $arqVersion = 1.2;

  $cGeral->dbConnect();

?>

</style>
<script> tituloDetalhePagina('<ol class="breadcrumb m-0">\
                                <li class="breadcrumb-item">NoxCity</li>\
                                <li class="breadcrumb-item active" aria-current="page">Pesquisa</li>\
                              </ol>'); </script>
<div class="container-fluid">

  <div class="row">
    <div class="col-md-4">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Usuario</h4>
          <div class="form-group row">
            <label for="example-number-input" class="col-sm-2 col-form-label">ID:</label>
            <div class="col-sm-10">
              <input class="form-control form-control-sm" type="number" value="" id="inputIdUsuario">
            </div>
          </div>
          <button class="btn btn-block btn-sm btn-success" type="button" onclick="buscaUsuario()">Buscar</button>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Item</h4>
        <div class="form-group row">
          <label for="example-number-input" class="col-sm-2 col-form-label">Item:</label>
          <div class="col-sm-10">
            <select id="selectItem">
              <?php
                $cItem = json_decode($cfgItemSearch, true);

                foreach ($cItem as $key => $value) {

                  $set = $key;
                  $nome = $value['nome'];

                  echo '<option value="'.$set.'">'.$nome.'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <button class="btn btn-block btn-sm btn-success" onclick="buscaItem()">Buscar</button>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-body">
        <h4 class="card-title font-20 mt-0">Org / Fac</h4>
        <div class="form-group row">
          <label for="example-number-input" class="col-sm-2 col-form-label">Org/Fac</label>
          <div class="col-sm-10">
            <select id="selectOrgFac">
              <?php
                $cOrg = json_decode($cfgOrg, true);
                for($x=0; $x<count($cOrg); $x++){
                  $nome = $cOrg[$x]['nome'];
                  $set = $cOrg[$x]['set'];
                  echo '<option value="'.$set.'">'.$nome.'</option>';
                }
              ?>
            </select>
          </div>
        </div>
        <button class="btn btn-block btn-sm btn-success" type="button" onclick="buscaOrgFac()">Buscar</button>
      </div>
    </div>

  </div>


</div>
    <div id="resultPesquisa"></div>

<script>
  $('#selectItem').select2();
  $('#selectOrgFac').select2();


  function buscaUsuario(){
    var id = $("#inputIdUsuario").val();
    $("#resultPesquisa").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $.post( "pesquisaUsuario.php?id="+id)
    .done(function( data ) {
      $('#resultPesquisa').html(data);
    });
  }

  function buscaItem(){
    var id = $("#selectItem").val();
    $("#resultPesquisa").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $.post( "pesquisaItem.php?id="+id)
    .done(function( data ) {
      $('#resultPesquisa').html(data);
    });
  }

  function buscaOrgFac(){

    var id = $('#selectOrgFac').val();
    $.post( "pesquisaOrgFac.php?id="+id)
    .done(function( data ) {
      $('#resultPesquisa').html(data);
    });
  }
</script>
