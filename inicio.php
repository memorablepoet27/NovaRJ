<?php
  require_once('assets/php/noxTop.php');
  require_once('segAut.php');

  $arqVersion = 1.2;

  $cGeral->dbConnect();

  // Imagens: noxcity.com/imgallstar
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
    <title><?php echo $cfg['title']; ?></title>
    <meta content="Admin Dashboard" name="description">
    <meta content="Themesbrand" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <?php require_once('assets/php/noxStyle.php'); ?>

    <style>
    .alertify-logs {
      z-index: 99999;
    }

    .map{
      width: 100%;
    }

    .map-250{
    		width:100%;
    		height:250px;
     }

     .map-400{
     		width:100%;
     		height:400px;
      }

      .map-500{
      		width:100%;
      		height:500px;
       }

       .map-700{
       		width:100%;
       		height:700px;
        }

    table:not(.tableQuebra){
      white-space: nowrap;
    }

    .myDivIcon path {
      stroke: black;
      stroke-width: 30px;
    }

    .myDivIcon{
      font-size: 10px;
      color: #0000FF;
      font-weight: bold;
      border-width: 3;
      text-shadow: 1px 0px 0px #FFF,
      -1px 0px 0px #FFF,
      0px 1px 0px #FFF,
      0px -1px 0px #FFF;
      /*
      background: -webkit-linear-gradient(#9c47fc, #356ad2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;*/

    }


    .select2-dropdown {
      z-index: 99999999;
    }


}
    </style>
</head>

<body>
  <!--a href="#" class='birdFloat'></a-->
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <!--div class="spinner"></div-->
            <img src="./assets/images/loadingC.gif?v=<?php echo $arqVersion; ?>" height="100">
        </div>
    </div>
    <div class="header-bg fixed-top">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">
                    <!-- Logo-->
                    <div class="d-block d-lg-none mr-5">
                        <a href="#" class="logo"><img src="assets/images/logo2.png?v=<?php echo $arqVersion; ?>" alt="" height="50" class="logo-small"></a>
                    </div>
                    <!-- End Logo-->
                    <div class="menu-extras topbar-custom navbar p-0">

                        <!-- Search input -->
                        <!--div class="search-wrap" id="search-wrap">
                            <div class="search-bar">
                                <input class="search-input" type="search" placeholder="Search"> <a href="#" class="close-search toggle-search" data-target="#search-wrap"><i class="mdi mdi-close-circle"></i></a></div>
                        </div-->
                        <ul class="list-inline ml-auto mb-0">

                            <!--li class="list-inline-item dropdown notification-list"><a class="nav-link waves-effect toggle-search" href="#" data-target="#search-wrap"><i class="mdi mdi-magnify noti-icon"></i></a></li>
                            <li class="list-inline-item dropdown notification-list"><a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><i class="mdi mdi-bell-outline noti-icon"></i> <span class="badge badge-pill noti-icon-badge">3</span></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-arrow dropdown-menu-lg">

                                    <div class="dropdown-item noti-title">
                                        <h5>Notificação (3)</h5></div>
                                    <div class="slimscroll-noti">

                                        <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                            <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                            <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                        </a>

                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                            <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
                                        </a>

                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-info"><i class="mdi mdi-filter-outline"></i></div>
                                            <p class="notify-details"><b>Your item is shipped</b><span class="text-muted">It is a long established fact that a reader will</span></p>
                                        </a>

                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                                            <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
                                        </a>

                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-warning"><i class="mdi mdi-cart-outline"></i></div>
                                            <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                        </a>
                                    </div>
                                    <a href="javascript:void(0);" class="dropdown-item notify-all">View All</a></div>
                            </li-->
                            <!-- User-->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                  <!--img src="assets/images/users/avatar-6.jpg" alt="user" class="rounded-circle"-->
                                  <span class="d-none d-md-inline-block ml-1"><?php echo $usuario; ?> <i class="fas fa-chevron-down"></i></span></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                  <!--a class="dropdown-item" href="#" onclick="alteraSenha()"><i class="fas fa-unlock text-muted"></i> Alterar Senha</a-->
                                  <!--a class="dropdown-item" href="lockScreen.php"><i class="fas fa-lock text-muted"></i> Tela de Bloqueio</a-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sair.php"><i class="fas fa-sign-out-alt text-muted"></i> Sair</a>
                              </div>
                            </li>
                            <li class="menu-item list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines"><span></span> <span></span> <span></span></div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
                        </ul>
                    </div>
                    <!-- end menu-extras -->
                    <div class="clearfix"></div>
                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <!-- Logo-->
                    <div class="d-none d-lg-block">
                        <!-- Text Logo
                            <a href="index.html" class="logo">
                                Foxia
                            </a>
                             -->
                        <!-- Image Logo --><a href="#" class="logo"><!-- <img src="assets/images/logo-sm.png" alt="" height="22" class="logo-small"> --> <img src="assets/images/logo2.png?v=<?php echo $arqVersion; ?>" alt="" height="50" class="logo-large"></a></div>
                    <!-- End Logo-->
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <?php require_once('menu.php'); ?>
                        <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
<div class="container-fluid"><!-- Page-Title -->
  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box" style="height: 10px;">
        <div class="row align-items-center" style="margin-top: -22px; padding-left: 20px;" id="detalhePagina"></div>
    </div>
  </div>
</div>
</div>

    </div>
    <div class="wrapper" style="padding-top: 140px; padding-bottom: 100px">
      <div id="conteudoPagina">

      </div>
        <!-- end container -->
    </div>


    <div class="modal fade" id="modalDetalhes" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modalDetalhesTitulo"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div id="modalDetalhesConteudo"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modalDetalhesXl" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="modalDetalhesTituloXl"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body" style="height: 700px; overflow-y: auto;">
                    <div id="modalDetalhesConteudoXl"></div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- end wrapper -->
    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">© 2019 Monisat.</div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

<?php require_once('assets/php/noxBottom.php'); ?>


    <script>
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};

      function maxlength(){
        !function(a){"use strict";var n=function(){};n.prototype.init=function(){a("input.labelMaxLength").maxlength({alwaysShow:!0,/*placement:"top-left",*/warningClass:"badge badge-info",limitReachedClass:"badge badge-warning"}),a("textarea.labelMaxLength").maxlength({alwaysShow:!0,warningClass:"badge badge-info",limitReachedClass:"badge badge-warning"})},a.AdvancedForm=new n,a.AdvancedForm.Constructor=n}(window.jQuery),function(a){"use strict";window.jQuery.AdvancedForm.init()}();
      }


      function maxLengthCheck(object) {
          if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
        }

      function tituloDetalhePagina(titulo){
        $('#detalhePagina').html(titulo);
      }



      var load;
      function openPage(link){
        if(load != undefined){
          load.abort();
        }

        $('#conteudoPagina').html('<center><img src="assets/images/loadingC.gif"></center>');
         load = $.ajax({
            url: link,
            success: function(data) {
              $("#conteudoPagina").html(data);
            }
          });

      /*  $('#conteudoPagina').html('<center><img src="assets/images/loadingC.gif"></center>');
        load = $('#conteudoPagina').load(link);*/
      }


      function fecharModal(){
        $('#modalDetalhes').modal('hide');
        $('#modalDetalhesXl').modal('hide');
      }



      function pageSemAcesso(){
        $('#modalDetalhes').modal('hide');
        $('#modalDetalhesXl').modal('hide');
        tituloDetalhePagina('');
        openPage('semAcesso.php');
      }





  $(document).ready(function () {
    openPage('dashBoard.php');
});

var x,y,top,left,down;

  function dataTableScroll(){
    $(".dataTables_scrollBody").mousedown(function(e){
        e.preventDefault();
        down=true;
        x=e.pageX;
        y=e.pageY;
        top=$(this).scrollTop();
        left=$(this).scrollLeft();
    });

    $(".dataTables_scrollBody").mousemove(function(e){
        if(down){
            var newX=e.pageX;
            var newY=e.pageY;

            //console.log(y+", "+newY+", "+top+", "+(top+(newY-y)));
            $(".dataTables_scrollBody").scrollTop(top-newY+y);
            $(".dataTables_scrollBody").scrollLeft(left-newX+x);
        }
    });

    $("body").mouseup(function(e){down=false;});
  }




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


  function openEquipado(id){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Equipado: '+id);
    //$('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "usuarioEquipado.php?id="+id,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }


  function openMochila(id){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Mochila: '+id);
    //$('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "usuarioMochila.php?id="+id,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }




  function setBan(id){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Ban/UnBan '+id);
    $('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "usuario_ban.php?id="+id,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }

  function setWl(id){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Wl/UnWl '+id);
    $('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "usuario_wl.php?id="+id,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }


  function userEdit(id, wh){
    $("#modalDetalhesConteudo").html('<center><img src="assets/images/loadingM.gif" width="50" height="50" alt="" /></center>');
    $("#modalDetalhesTitulo").html('Editar Usuario '+id);
    $('#modalDetalhes').modal('show');

    $.ajax({
      type: "GET",
      url: "usuario_edit.php?id="+id+"&wh="+wh,
      success: function(html){
        $("#modalDetalhesConteudo").html(html);
      }
    });
  }

    </script>
</body>

</html>
