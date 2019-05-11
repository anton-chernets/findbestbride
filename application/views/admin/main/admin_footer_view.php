            <hr>
            <footer>
				
            </footer>
        </div>
        <!--/.fluid-container-->
         <link href="<?=base_url()?>content/boot/vendors/datepicker.css" rel="stylesheet" media="screen">
        <link href="<?=base_url()?>content/boot/vendors/chosen.min.css" rel="stylesheet" media="screen">
        <link href="<?=base_url()?>content/boot/vendors/uniform.default.css" rel="stylesheet" media="screen">
        <link href="<?=base_url()?>content/boot/assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>content/boot/vendors/bootstrap-wysihtml5/src/bootstrap-wysihtml5.css">
        
        <script src="<?=base_url()?>content/boot/bootstrap/js/bootstrap.min.js"></script>
        <?php if ($this->uri->segment(2) == 'image') {?>
        <script src="<?=base_url()?>content/boot/assets/jquery.Jcrop.min.js"></script>
        <?php } ?>
        <script src="<?=base_url()?>content/boot/assets/scripts.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/chosen.jquery.min.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/jquery.uniform.min.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/datatables/js/jquery.dataTables.min.js"></script>
        <script src="<?=base_url()?>content/boot/assets/DT_bootstrap.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/bootstrap-datepicker.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
        <script src="<?=base_url()?>content/boot/vendors/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
        <script>
        	$('#bootstrap-editor').wysihtml5();
        	$(".chzn-select").chosen();
        	$(".uniform_on").uniform();
        	$(".datepicker").datepicker();
        	$('.popover-bottom').popover({placement: 'bottom', trigger: 'hover'});
        	$('.tooltip-bottom').tooltip({ placement: 'bottom' });
        	$('.tooltip-right').tooltip({ placement: 'right' });
        </script>

    </body>

</html>
