<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="Ronald Terrones">
    <title><?php "..:: Boutique Glamour ::.." ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/sb_admin/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- <link href="<?php echo base_url();?>assets/bootstrap4/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url();?>assets/sb_admin/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/sb_admin/dist/css/sb-admin-2.css" rel="stylesheet">
    
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url();?>assets/sb_admin/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <!-- <link href="<?php echo base_url();?>assets/sb_admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/sb_admin/dist/css/sb-admin-custom.css" rel="stylesheet">

    <?php if(isset($css)) : ?>
    <?php foreach($css as $style) : ?>
    <link href="<?php echo base_url();?>assets/css/<?php echo $style; ?>.css" rel="stylesheet">
    <?php endforeach; ?>
    <?php endif; ?>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- <div class="wrapper"> -->


     
<!-- </body>
</html> -->