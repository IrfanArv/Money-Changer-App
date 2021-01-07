<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"> 
    <title><?php echo $title;?></title>
    <meta content="Irfan Arifin" name="author">
    <link href="<?php echo base_url().'uploads/favicon.png'?>" rel="shortcut icon">
    <link href="<?php echo base_url().'uploads/favicon.png'?>" rel="apple-touch-icon">
    <!--Chartist Chart CSS -->
    <link href="<?php echo base_url().'assets/theme/assets/css/bootstrap.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/css/icons.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/css/metisMenu.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/css/style.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/css/pace.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/plugins/timepicker/bootstrap-material-datetimepicker.css'?>" rel="stylesheet">
    
    <!--  datatable -->
    <link href="<?php echo base_url().'assets/theme/assets/plugins/datatables/dataTables.bootstrap4.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/plugins/datatables/buttons.bootstrap4.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'assets/theme/assets/plugins/datatables/responsive.bootstrap4.min.css'?>" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url().'assets/theme/assets/plugins/sw/sweetalert.css'?>" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url().'assets/jquery-ui-1.12.1.custom/jquery-ui.css'?>" rel="stylesheet">
        <!-- jQuery  -->

    <link href="<?php echo base_url().'assets/theme/assets/plugins/morris/morris.css'?>" rel="stylesheet">    
        
    <script src="<?php echo base_url().'assets/theme/assets/js/jquery.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/js/bootstrap.bundle.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/js/metisMenu.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/js/waves.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/js/jquery.slimscroll.min.js'?>"></script>
    <!--Datatables-->
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/jquery.dataTables.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/dataTables.bootstrap4.min.js'?>"></script><!-- Buttons examples -->
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/dataTables.buttons.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/buttons.bootstrap4.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/jszip.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/pdfmake.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/vfs_fonts.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/buttons.html5.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/buttons.print.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/buttons.colVis.min.js'?>"></script><!-- Responsive examples -->
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/dataTables.responsive.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/datatables/responsive.bootstrap4.min.js'?>"></script>

    <script src="<?php echo base_url().'assets/theme/assets/plugins/sw/sweetalert.js'?>"></script>

    <script src="<?php echo base_url().'assets/theme/assets/js/sortcut.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/js/pace.min.js'?>"></script> 

    <script src="<?php echo base_url().'assets/jquery-ui-1.12.1.custom/jquery-ui.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/moment/moment.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/timepicker/bootstrap-material-datetimepicker.js'?>"></script>
    
    <script src="<?php echo base_url().'assets/theme/assets/plugins/raphael/raphael.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/theme/assets/plugins/morris/morris.min.js'?>"></script>
    

    <script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
    
    </script>
</head>

<body>
    <div class="topbar">
        <?php echo $_header; ?>
    </div>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <?php echo $_content; ?>
            </div>
        </div>
        <?php echo $_footer; ?>
    </div>
    



</body>

</html>