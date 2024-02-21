<!doctype html>
<html lang="en" ng-app="KidyViewStudent">
<head>
    <title>Kidy</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content=" " />
    <meta name="keywords" content=" " />
    <meta name="author" content=" " />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>studentasset/img/favicon.png" />
    <!-- Common CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/fonts/icomoon/icomoon.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/css/morris/morris.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/css/all.css" />
    <!-- Chartist css -->
    <link href="<?php echo base_url(); ?>studentasset/css/chartist/chartist.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>studentasset/css/chartist/chartist-custom.css" rel="stylesheet" />
    <!-- global css -->
    <link href="<?php echo base_url(); ?>studentasset/css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/css/global.css" />
      <!-- database css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/css/datatables/dataTables.bs4.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>studentasset/css/datatables/dataTables.bs4-custom.css" />
    <script src="<?php echo base_url(); ?>studentasset/js/jquery.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular.min.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-route.min.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-animate.min.js"></script>
    <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-loader.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-sanitize.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/dirPagination.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/customDirPagination.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/ng-file-upload-all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <link href="<?php echo base_url(); ?>asset/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <script src="<?php echo base_url(); ?>asset/js/appStudent.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/controllersStudent.js"></script>
    <script src="<?php echo base_url(); ?>adminasset/js/ngdatatable/angular-datatables.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/js/ngdatatable/css/angular-datatables.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/bootstrap-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/bootstrap-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/core-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/core-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/daygrid-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/daygrid-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/list-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/list-main.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/timegrid-main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/timegrid-main.min.css">
    
   <script> 
   var BASE_URL 		= '<?php echo base_url(); ?>'; 
   var schoolID 		= '<?php echo $STUDENTDATA->schoolId;?>'; 
   var classID 		= '<?php echo $STUDENTDATA->childclass;?>'; 
   var xapikey 		= 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
   </script>
   
</head>

<body>
    <!-- start app wrap -->
    <div class="app-wrap">
        <?php
    // print_r($demo);die('czXczxv');
        $this->load->view('header-menu');?>
        <!-- start app container -->
        <div class="app-container">
        <?php $this->load->view('sidebar-menu');?>
            <!-- BEGIN .app-main -->
            <div style="width:100%" ng-view ng-animate="{enter: 'view-enter'}"></div>
            <!-- END: .app-main -->
        </div>
        <!-- END: .app-container -->
        <!-- BEGIN .main-footer -->
<footer class="main-footer fixed-btm">
    Copyright kidyview.admin 2019.
</footer>
<!-- END: .main-footer -->
</div>
<!-- END: .app-wrap -->

<script src="<?php echo base_url(); ?>studentasset/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/unifyMenu.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/onoffcanvas.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/moment.js"></script>
<!-- Morris Graphs -->
<script src="<?php echo base_url(); ?>studentasset/js/morris/raphael-min.js"></script>
<!-- Data Tables -->
<script src="<?php echo base_url(); ?>studentasset/js/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/datatables/custom-datatables.js"></script>
<!-- Flot Charts -->
<script src="<?php echo base_url(); ?>studentasset/js/flot/jquery.flot.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/flot/jquery.flot.time.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/flot/jquery.flot.stack.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/flot/line.js"></script>
<!-- Newsticker JS -->
<script src="<?php echo base_url(); ?>studentasset/js/newsticker/newsTicker.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/newsticker/custom-newsTicker.js"></script>
<!-- Form Wizard -->
<script src="<?php echo base_url(); ?>studentasset/js/formwizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/form-validation.js"></script>
<!-- Multiple Select -->
<script src="<?php echo base_url(); ?>studentasset/js/multiselect/select2.min.js" type="text/javascript"></script>
<!-- Data Tables -->
<script src="<?php echo base_url(); ?>studentasset/js/slimscroll/slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/slimscroll/custom-scrollbar.js"></script>
<!-- Common JS -->
<script src="<?php echo base_url(); ?>asset/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>studentasset/js/common.js"></script>
<script src="<?php echo base_url(); ?>asset/js/ui-calendar/calendar.js"></script>
<script src="<?php echo base_url(); ?>asset/js/ui-calendar/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.7.0/lodash.min.js"></script>
<script src="<?php echo base_url(); ?>studentasset/js/angularjs-dropdown-multiselect.min.js"></script>
<!------------- TextAngular----------->

<link rel='stylesheet' href='<?php echo base_url(); ?>studentasset/js/textAngular/dist/textAngular.css'>
<script src='<?php echo base_url(); ?>studentasset/js/textAngular/dist/textAngular-rangy.min.js'></script>
<script src='<?php echo base_url(); ?>studentasset/js/textAngular/dist/textAngular-sanitize.min.js'></script>
<script src='<?php echo base_url(); ?>studentasset/js/textAngular/dist/textAngular.min.js'></script>

<link rel='stylesheet' href='<?php echo base_url(); ?>studentasset/js/textAngular/dist/style.css'>
<link  rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
<?php /* 
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.7.0/spectrum.min.js"></script>
<script src='<?php echo base_url(); ?>studentasset/js/textAngular/dist/angular-spectrum-colorpicker.min.js'></script>
<script src='<?php echo base_url(); ?>studentasset/js/textAngular/dist/textAngular-dropdownToggle.js'></script>
<script src='<?php echo base_url(); ?>studentasset/js/textAngular/dist/textAngularSetup.js'></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.7.0/spectrum.min.css" />
<link  rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
<link rel='stylesheet' href='<?php echo base_url(); ?>studentasset/js/textAngular/dist/style.css'>
*/ ?>
</body>

</body>
</html>