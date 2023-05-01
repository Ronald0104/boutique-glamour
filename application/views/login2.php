<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login Form Template</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url()?>assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url()?>assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url()?>assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>assets/ico/apple-touch-icon-57-precomposed.png">
    </head>

    <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Boutique</strong> Mary</h1>
                            <div class="description">
                            	<p>Acceso al portal ::
                                    <a href="http://azmind.com"><strong>ADMINISTRADOR</strong></a>
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         
                        <?php if(isset($error)) { echo $error; }; ?>         
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Ingrese a su sitio</h3>
                                    <!-- <p>Ingrese su usuario y contraseña</p> -->                          
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form name="form-login" role="form" action="<?php echo base_url() ?>index.php/login" method="post" class="login-form2">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Usuario</label>
                                        <input type="text" name="username" placeholder="Usuario..." class="form-username form-control" id="form-username" autofocus>
                                        <!-- <?php echo form_error('username'); ?> -->
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="password" placeholder="Contraseña..." class="form-password form-control" id="form-password">
                                        <!-- <?php echo form_error('password'); ?> -->
			                        </div>
			                        <button type="submit" class="btn">Ingresar</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	<!-- <h3>...or login with:</h3> -->
                        	<div class="social-login-buttons">
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-facebook"></i> Facebook
	                        	</a>
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-twitter"></i> Twitter
	                        	</a>
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-google-plus"></i> Google Plus
	                        	</a>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <script>
            var base_url = '<?php echo base_url();?>';
            console.log(base_url);
        </script>    
        <!-- Javascript -->
        <!-- <script src="assets/js/jquery-1.11.1.min.js"></script> -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/scripts.js"></script>

        <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
        <!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>