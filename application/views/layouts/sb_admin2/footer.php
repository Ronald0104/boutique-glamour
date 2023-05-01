
    </div>
    <!-- End Wrapper -->
    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/sb_admin/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/sb_admin/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/bootstrap4/js/bootstrap.min.js"></script> -->

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/sb_admin/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url();?>assets/sb_admin/vendor/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url();?>assets/sb_admin/vendor/morrisjs/morris.min.js"></script>
    <script src="<?php echo base_url();?>assets/sb_admin/data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/sb_admin/dist/js/sb-admin-2.js"></script>

    <!-- jQuery Validate -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>

    <!-- Js Customizado -->
    <script src="<?php echo base_url();?>assets/js/utils.js"></script>

    <?php if(isset($js)) : ?>
    <?php foreach($js as $script) : ?>
    <script src="<?php echo base_url();?>assets/js/<?php echo $script?>.js"></script>
    <?php endforeach; ?>
    <?php endif; ?>
    <!-- <script src="<?php echo base_url();?>assets/js/<?php echo $js?>.js"></script> -->
  
</body>
</html>