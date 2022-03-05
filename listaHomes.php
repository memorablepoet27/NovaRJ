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
              <th>NOME</th>
              <th>DONO</th>
              <th>BANIDO</th>
              <th>ULTIMO ACESSO</th>
              <th>AÇÃO</th>
            </tr>
          </thead>
          <tbody>
        <?php
        $sqlHomes = $cGeral->dbSelect("SELECT *
                                          FROM vrp_homes_permissions UP
                                          LEFT JOIN vrp_users U ON (UP.user_id = U.id)
                                          LEFT JOIN vrp_user_identities UI ON (UI.user_id = UP.user_id)
                                        WHERE UP.owner = 1");
        for($u=0; $u<count($sqlHomes); $u++){

          $homeName = $sqlHomes[$u]['home'];
          $userId = $sqlHomes[$u]['id'];
          $nome = $sqlHomes[$u]['name'];
          $sobrenome = $sqlHomes[$u]['firstname'];
          $lastLogin = $sqlHomes[$u]['last_login'];
          $banned = $sqlHomes[$u]['banned'];


            if($banned == 1){
            $banned = 'Banido';
          }else{
            $banned = 'Não';
          }

          echo "<tr>
                  <td>$homeName</td>
                  <td>$userId ($nome $sobrenome)</td>
                  <td>$banned</td>
                  <td>$lastLogin</td>
                  <td><button class='btn btn-sm btn-primary' onClick='openBauCasa(\"$homeName\")'>ABRIR</button></td>
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
