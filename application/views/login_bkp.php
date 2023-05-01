<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>..:: Boutique Glamour ::..</title>
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/css/login.css" rel="stylesheet">
    <style>
    body {
        background-color: #108810ba;
    }
    </style>
</head>

<body>
    <!------ Include the above in your HEAD tag ---------->
    <div class="container" id="container-login">
        <div class="row">
            <!-- <div class="col-xs-12 col-sm-8 col-md-6 col-md-offset-4 col-login"> -->
            <div class="col-login" style="min-width: 360px;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="d-block text-center font-weight-bold mb-0">Boutique Glamour</h5>
                    </div>
                    <div class="card-body pb-1">
                        <img class="profile-img card-img-top" src="<?php echo base_url();?>/assets/img/security-1.png" alt="">
                    </div>
                    <div class="card-body pt-2">
                        <h4 class="text-login text-center">Ingresar al <span>Sistema</span></h4>
                        <form role="form" action="/admin/login" method="POST" id="frmLogin">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-user"></i>
                                            </span>
                                            <input class="form-control" placeholder="Usuario" name="username" id="username" type="text" autofocus>
                                        </div>
                                        <!-- <span class="text-danger"><?php echo form_error('username')?></span> -->
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-lock"></i>
                                            </span>
                                            <input class="form-control" placeholder="password" name="password" id="password" type="password" value="" autocomplete="nope">
                                        </div>
                                        <!-- <span class="text-danger"><?php echo form_error('password')?></span> -->
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="recordar" id="recordar">
                                        <label class="form-check-label font-weight-bold" for="recordar">Recordar Contraseña</label>
                                    </div>
                                    <div class="text text-danger" id="error" style="margin-top: -5px; margin-bottom: 5px;">
                                        <!-- <b><?php if(isset($error)) { echo $error; };?></b> -->
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Ingresar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
                <!-- <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong> Acceso usuarios</strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="/admin/login" method="POST" id="frmLogin">
                            <fieldset>
                                <div class="row">
                                    <div class="center-block">
                                        <img class="profile-img" src="<?php echo base_url();?>/assets/img/security-128.png" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <h3 class="text-center text-login">Ingresar al <span>Sistema</span></h3>
                                    <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </span>
                                                <input class="form-control" placeholder="Usuario" name="username" id="username" type="text" autofocus>
                                            </div>
                                            <span class="text-danger"><?php echo form_error('username')?></span>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-lock"></i>
                                                </span>
                                                <input class="form-control" placeholder="password" name="password" id="password" type="password" value="">
                                            </div>
                                            <span class="text-danger"><?php echo form_error('password')?></span>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="text text-danger" id="error" style="margin-top: -5px; margin-bottom: 5px;">
                                            <b><?php if(isset($error)) { echo $error; };?></b>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Ingresar">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    <div class="panel-footer">
                        Don't have an account! <a href="#" onClick=""> Sign Up Here </a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
    <!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->

    <script src="<?php echo base_url();?>assets/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/bootstrap.min.js"></script>

    <script>
    $(function() {
        $('#username').on('keyup', function(evt) {
            if ($(this).val()) {
                $(this).closest('.form-group').find('.text-danger').hide();
            }
        })
        $('#password').on('keyup', function(evt) {
            if ($(this).val()) {
                $(this).closest('.form-group').find('.text-danger').hide();
            }
        })

        $('#frmLogin').on('submit', function(e) {
            e.preventDefault();
            $('#error').html('');
            var username = $('#username').val();
            var password = $('#password').val();

            if (!password) {
                $('#password').closest('.form-group').find('.text-danger').text('El password es requerido.').show();
                $('#password').focus();
            }
            if (!username) {
                $('#username').closest('.form-group').find('.text-danger').text('El usuario es requerido.').show();
                $('#username').focus();
            }
            if (!username || !password) {
                return;
            }

            var url = "<?php echo base_url()?>admin/login_ajax";
            var user = $('#frmLogin').serialize();
            var login = function() {
                $.ajax({
                        method: 'POST',
                        url: url,
                        data: user,
                        dataType: 'json'
                    })
                    .done(function(data) {
                        console.log(data);
                        if (data.error == "") {
                            window.location.href = "<?php echo base_url();?>admin/panel";
                        } else {
                            $('#error').html('<b>' + data.error + '</b>');
                        }
                    })
                    .fail(function() {
                        console.log('ERROR LOGIN');
                    })
            };
            setTimeout(login, 200);
        })
    })
    </script>
</body>

</html>