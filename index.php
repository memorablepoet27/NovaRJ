<?php
  require_once('config.php');
  $arqVersion = 1.2;
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
    <!-- App Icons -->
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <?php require_once('assets/php/noxStyle.php'); ?>
</head>

<body>
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- Begin page -->
    <div class="accountbg"></div>
    <!--div class="home-btn d-none d-sm-block"><a href="index.html" class="text-white"><i class="mdi mdi-home h1"></i></a></div-->

    <div class="wrapper-page">
        <div class="card">

              <div class="card-body">
                <div class="p-3">
                    <div class="float-right text-right">
                        <h4 class="font-18 mt-3 m-b-5">Bem vindo !</h4>
                        <p class="text-muted">Efetue o login para continuar.</p>
                    </div>
                    <a href="index.php" class="logo-admin"><img src="assets/images/logo2.png?v=<?php echo $arqVersion; ?>" height="75" alt="logo"></a>
                </div>
                <div class="p-3">
                    <form class="form-horizontal m-t-10" id="login" method="POST" action="segLogin.php">
                        <div class="form-group">
                            <label for="username">Login</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Digite seu login!">
                        </div>
                        <div class="form-group">
                            <label for="userpassword">Senha</label>
                            <input type="password" class="form-control" name="userpassword" id="userpassword" placeholder="Digite sua senha!">
                        </div>
                        <div class="form-group row m-t-30">
                            <div class="col-sm-6">
                                <!--div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="loginManterLogado" name="loginManterLogado" value="S">
                                    <label class="custom-control-label" for="loginManterLogado">Manter conectado</label>
                                </div-->
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit" id="loginbtn">Entrar</button>
                            </div>
                        </div>
                        <div id="resultadologin"></div>
                        <div class="form-group m-t-30 mb-0 row">
                            <!--div class="col-12 text-center"><a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Esqueci minha senha</a></div-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="m-t-40 text-center text-white-50">
            <!--p>Don't have an account ? <a href="pages-register.html" class="font-600 text-white">Signup Now</a></p-->
            <p>© 2020 NoxCity - Desenvolvido por Otavio Nyo</p>
        </div>
    </div>
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js?v=<?php echo $arqVersion; ?>"></script>
    <script src="assets/js/bootstrap.bundle.min.js?v=<?php echo $arqVersion; ?>"></script>
    <script src="assets/js/modernizr.min.js?v=<?php echo $arqVersion; ?>"></script>
    <script src="assets/js/waves.js?v=<?php echo $arqVersion; ?>"></script>
    <script src="assets/js/jquery.slimscroll.js?v=<?php echo $arqVersion; ?>"></script>
    <!-- App js -->
    <script src="assets/js/app.js?v=<?php echo $arqVersion; ?>"></script>


    <script type="text/javascript">
function mudapagina(pagina){ window.location.href = pagina;  }

$(function(){var t=!1;$("#login").submit(function(){var e=$(this),n=$("#login #loginbtn"),o=n.val(),a=new FormData(this);function r(){n.removeAttr("disabled"),n.val(o),t=!1}return t||$.ajax({beforeSend:function(){t=!0,n.attr("disabled",!0),n.val("Entrando..."),$(".error").remove()},url:e.attr("action"),type:e.attr("method"),data:a,processData:!1,cache:!1,contentType:!1,success:function(t){r(),"OK"==t?alert("Dados enviados com sucesso"):$("#resultadologin").html(t)},error:function(t,e,n){r(),alert(t.responseText)}}),!1})});
    </script>

</body>

</html>
