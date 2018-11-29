         
<?php
include "db/db.php";
session_start();
$hid_user = $_SESSION['user'];
$user_level = $_SESSION['level'];
//$user_name = $_SESSION['u_name'];
//echo $user_name;
$is_admin = $user_level == 1;
$is_thetre = $user_level == 2;

$log = htmlspecialchars(trim($_SESSION['user']), ENT_QUOTES, 'UTF-8');
//$menu = htmlspecialchars(trim($_SESSION['menu']), ENT_QUOTES, 'UTF-8');
//$emp_id = htmlspecialchars(trim($_SESSION['emp_id']), ENT_QUOTES, 'UTF-8');

if (empty($log)) {
    $redirectUrl = "index.php";
    echo "<script type=\"text/javascript\">";
    echo "window.location.href = '$redirectUrl'";
    echo "</script>";
} else {

    $sqlu = "SELECT * FROM login WHERE user='$log' AND (level='1' OR level='2')";

    $resultu = mysqli_query($conn, $sqlu);
    $countu = mysqli_num_rows($resultu);

    if ($countu == 1) {
        $rowc = mysqli_fetch_assoc($resultu);
        $name = $rowc['user'];
    } else {
        $redirectUrl = "index.php";
        echo "<script type=\"text/javascript\">";
        echo "window.location.href = '$redirectUrl'";
        echo "</script>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Cinemax</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="dist/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="dist/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="plugins/iCheck/all.css">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="plugins/select2/select2.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="bootstrap-sweetalert/lib/sweet-alert.css" />

        <style>
            #mapCanvas {
                width: 100%;
                height: 300px;  
            }
            #infoPanel {

                margin: 10px;
            }
            #infoPanel div {
                margin-bottom: 5px;
            }
            .no_margin {
                margin-bottom:0px;
            }
            .content  {
                min-height:350px;
            }
        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="home.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><img src="img/logo1.png" width="100"></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><img src="img/logo1.png" width="100"></b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="logo-lg">
                            &nbsp;&nbsp;<font face="Lucida Sans Unicode, Lucida Grande, sans-serif">Cinemax</font></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/user2-160x160.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $name; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.png" class="img-circle" alt="User Image">
                                        <p>
                                            Cinemax

                                        </p>
                                    </li>
                                    <!-- Menu Body -->

                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">

                                        </div>
                                        <div class="pull-right">
                                            <a href="distroy.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <?php include "common/sidebar.php"; ?>  

                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        ADD THETRE
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- ************************************************* -->
                    <div class="box box-info "> 
                        <div class="box-header with-border"> 
                            <h3 class="box-title">Thetre Details</h3>
                        </div>

                        <div class="box-body"> 
                            <form id="form_projects" action="javascript:void(0);">


                                <input type="text"   style=" display: none" id="hid_uname" name="hid_uname" value="<?php echo $hid_user; ?>">

                                <div class="form-group"> 
                                    <label>Thetre Name :<font color="#FF0000"><strong>*</strong></font></label>
                                    <input type="text" class="form-control error" id="thetre_name" name="thetre_name" autocomplete="off" required>
                                </div>

                                <div class="form-group"> 
                                    <label>Address :<font color="#FF0000"><strong>*</strong></font></label>
                                    <input type="text" class="form-control error" id="des" name="des" autocomplete="off" required>
                                </div>

                                <div class="form-group"> 
                                    <label>Contact :<font color="#FF0000"><strong>*</strong></font></label>
                                    <input type="text" class="form-control error" id="contact" name="contact" autocomplete="off" required>
                                </div>




                                <div class="form-group"> 
                                    <label>Ticket Prices :<font color="#FF0000"><strong>*</strong></font></label>
                                    <input type="text" class="form-control error" id="ticket" name="ticket" autocomplete="off" required>
                                </div>


                                <div class="form-group"> 
                                    <label>Seating :<font color="#FF0000"><strong>*</strong></font></label>
                                    <input type="text" class="form-control error" id="seat" name="seat" autocomplete="off" required>
                                </div>


                                <div class="form-group"> 
                                    <div class="form-group">
                                        <label for="exampleInputFile">Select Image<font color="#FF0000"><strong>*</strong></font></label>
                                        <input type="file" class="form-control" id="img_upload" name="img_upload" accept="image/*" required="">
                                        <p class="help-block text-red">File Size 1280*818</p>

                                        <span id="valid_img" style="color: red; display: none">*Please Select Valid Image</span>
                                    </div>
                                </div>

                                <div class="form-group" > 
                                    <label>City:<font color="#FF0000"><strong>*</strong></font></label>
                                    <select class="form-control select2 error" id="city" name="city" style="width: 100%;" required>
                                        <option value="">Select City.....</option>
                                        <?php
                                        $sql_dis = "SELECT * FROM city WHERE city.deleted=0 ORDER BY id DESC";
                                        $result1 = mysqli_query($conn, $sql_dis);


                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            ?>
                                            <option value="<?php echo $row1['city']; ?>"><?php echo $row1['city']; ?></option>

                                        <?php } ?>




                                    </select>
                                </div>



                                <div class="form-group" > 
                                    <label>Location :<font color="#FF0000"><strong>*</strong></font></label>
                                    <div class="row" id="map" style="display: none">

                                        <div class="col-md-12">
                                            <div id="mapCanvas"></div>
                                            <div id="infoPanel"> <b>Marker status:</b>
                                                <div id="markerStatus"><i>Click and drag the marker.</i></div>
                                                <b>Current position:</b>
                                                <div id="info"></div>
                                                <input type="hidden" id="lat" />
                                                <input type="hidden" id="lng" />
                                                <b>Closest matching address:</b>
                                                <div id="address"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="text"  style=" display: none"  id="city_hid" name="city_hid">
                                <input type="text"   style=" display: none" id="lat" name="lat">
                                <input type="text"   style=" display: none" id="lng" name="lng">



                                <span style="color: red;" class="pull-right">* Required Fields</span>

                                <div class="box-footer">
                                    <button class="btn btn-primary">SUBMIT</button>
                                </div>
                            </form>
                        </div>	
                    </div>

                    <!-- /.table -->

                    <div class="box box-info"> 
                        <div class="box-header"> 
                            <h3 class="box-title">Film Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body"> 
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Thetre Name</th>
                                        <th>Description</th>
                                        <th>Contact</th>
                                        <th>Seating</th>
                                        <th>Ticket Prices</th>

                                        <th>Image</th>

                                        <th>Edit</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($is_admin) {

                                        $sql = "SELECT
* FROM thetre WHERE deleted=0
 ORDER BY thetre.id ASC";
                                    }if ($is_thetre) {
                                        $sql = "SELECT
* FROM thetre WHERE deleted=0 AND hid_user='$hid_user'
 ORDER BY thetre.id ASC";
                                    }

                                    $result = mysqli_query($conn, $sql);
                                    $x = 0;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $x++;
                                        ?>

                                        <tr>
                                            <td><?php echo $x; ?></td>
                                            <td><?php echo $row['thetre_name']; ?></td>
                                            <td><?php echo $row['des']; ?></td>
                                            <td><?php echo $row['contact']; ?></td>
                                            <td><?php echo $row['seat']; ?></td>
                                            <td><?php echo $row['ticket']; ?></td>


                                            <td align="center"><img src="upload/theatre/<?php echo $row['img']; ?>" width="70"></td>




                                            <td align="center">

                                                <button  class="btn btn-info btn-sm btn_up" data-toggle="modal" data-target="#edit" value="<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span> &nbsp;EDIT </button>

                                            </td>


                                            <td align="center">
                                                <button value="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm btn_dell">
                                                    <span class="glyphicon glyphicon-trash"></span> &nbsp;DELETE </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>

                </section>

            </div>
            <!-- /.End table -->
            <!-- ************************************************* -->

            <!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.box-body -->



    <div class="row">



    </div>
    <!-- /.col (right) -->


</div>
<footer class="main-footer"> 
    <div class="pull-right hidden-xs">

    </div>  <strong>Copyright &copy; Cinemax</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
        </div><!-- /.tab-pane -->

    </div><!-- /.tab-pane -->
</div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- Modal -->
<div class="modal fade" id="edit" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="test_id">Edit Thetre Details</h4>
            </div>
            <div class="modal-body">

                <form id="form_projects_up" action="javascript:void(0);">


                    <input type="text" id="hidden_id" name="hidden_id" hidden="">



                    <div class="form-group"> 
                        <label>Thetre Name :<font color="#FF0000"><strong>*</strong></font></label>
                        <input type="text" class="form-control error" id="up_thetre_name" name="up_thetre_name" autocomplete="off" required>
                    </div>

                    <div class="form-group"> 
                        <label>Description :<font color="#FF0000"><strong>*</strong></font></label>
                        <input type="text" class="form-control error" id="up_des" name="up_des" autocomplete="off" required>
                    </div>

                    <div class="form-group"> 
                        <label>Contact :<font color="#FF0000"><strong>*</strong></font></label>
                        <input type="text" class="form-control error" id="up_contact" name="up_contact" autocomplete="off" required>
                    </div>




                    <div class="form-group"> 
                        <label>Ticket Prices :<font color="#FF0000"><strong>*</strong></font></label>
                        <input type="text" class="form-control error" id="up_ticket" name="up_ticket" autocomplete="off" required>
                    </div>


                    <div class="form-group"> 
                        <label>Seating :<font color="#FF0000"><strong>*</strong></font></label>
                        <input type="text" class="form-control error" id="up_seat" name="up_seat" autocomplete="off" required>
                    </div>


                    <div class="form-group"> 
                        <div class="form-group">
                            <label for="exampleInputFile">Select Image<font color="#FF0000"><strong>*</strong></font></label>
                            <input type="file" class="form-control" id="up_img_upload" name="up_img_upload" accept="image/*" >
                            <p class="help-block text-red">File Size 1280*818</p>

                            <span id="valid_img" style="color: red; display: none">*Please Select Valid Image</span>
                        </div>
                    </div>




                    <span id="img_view"></span>





                    <span style="color: red;" class="pull-right">* Required Fields</span>

                    <div class="box-footer">
                        <input type="hidden" id="id_holder" name="id_holder">
                        <button class="btn btn-primary">UPDATE</button>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="bootstrap-sweetalert/lib/sweet-alert.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuWch6HsB-2Xj_a7gr0VpM-JJNOrLdMtE&v=3.exp&sensor=false"></script> 

<!-- Page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "yyyy-mm-dd"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "yyyy-mm-dd"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker

        $('#start').daterangepicker({timePicker: false, timePickerIncrement: 30, format: 'YYYY-MM-DD'});
        $('#end').daterangepicker({timePicker: false, timePickerIncrement: 30, format: 'YYYY-MM-DD'});


        $('#up_start').daterangepicker({timePicker: false, timePickerIncrement: 30, format: 'YYYY-MM-DD'});
        $('#up_end').daterangepicker({timePicker: false, timePickerIncrement: 30, format: 'YYYY-MM-DD'});

        $('#date_award_up').daterangepicker({timePicker: false, timePickerIncrement: 30, format: 'YYYY-MM-DD'});


        $('#exp_date_up').daterangepicker({timePicker: false, timePickerIncrement: 30, format: 'YYYY-MM-DD'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                },
                function (start) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY'));
                }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });


    });

    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

<!-- Map ---> 
<script type="text/javascript">

    $('document').ready(function (e) {
        $('#map').hide();

    });

    $("#city").change(function () {
        var id = $(this).val();
        // var id = $('#hid_city').val();

        if (id === '') {
            $('#map').hide();

        } else {
            $('#map').show();



            var map;
            var marker = null;
            initialize();
            function initialize() {
                var mapOptions = {
                    zoom: 8,
                    disableDefaultUI: true,
                    center: new google.maps.LatLng(7.8731, 80.7718), //center on sherbrooke
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById('mapCanvas'), mapOptions);
                google.maps.event.addListener(map, 'click', function (event) {
                    //call function to create marker
                    $("#coordinate").val(event.latLng.lat() + ", " + event.latLng.lng());
                    $("#coordinate").select();
                    //delete the old marker
                    if (marker) {
                        marker.setMap(null);
                    }
                    //creer à la nouvelle emplacement
                    marker = new google.maps.Marker({position: event.latLng, map: map});
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);


            var x = id;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({address: x}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    var geocoder = new google.maps.Geocoder();
                    var latLng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());

                    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                        zoom: 13,
                        center: latLng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var marker = new google.maps.Marker({
                        position: latLng,
                        title: id,
                        map: map,
                        draggable: true
                    });

                    // Update current position info.
                    updateMarkerPosition(latLng);
                    geocodePosition(latLng);

                    // Add dragging event listeners.
                    google.maps.event.addListener(marker, 'dragstart', function () {
                        updateMarkerAddress('Dragging...');
                    });

                    google.maps.event.addListener(marker, 'drag', function () {
                        updateMarkerStatus('Dragging...');
                        updateMarkerPosition(marker.getPosition());
                    });

                    google.maps.event.addListener(marker, 'dragend', function () {
                        updateMarkerStatus('Drag ended');
                        geocodePosition(marker.getPosition());
                    });

                    function geocodePosition(pos) {
                        geocoder.geocode({
                            latLng: pos
                        }, function (responses) {
                            if (responses && responses.length > 0) {
                                updateMarkerAddress(responses[0].formatted_address);
                            } else {
                                updateMarkerAddress('Cannot determine address at this location.');
                            }
                        });
                    }

                    function updateMarkerStatus(str) {
                        document.getElementById('markerStatus').innerHTML = str;
                    }

                    function updateMarkerPosition(latLng) {
                        document.getElementById('info').innerHTML = [
                            latLng.lat(),
                            latLng.lng()
                        ].join(', ');

                        document.getElementById('lat').value = latLng.lat();
                        document.getElementById('lng').value = latLng.lng();

                        /* assign latlng to hidden input valus*/
                        $('#lat').val(latLng.lat());
                        $('#lng').val(latLng.lng());

                    }

                    function updateMarkerAddress(str) {
                        document.getElementById('address').innerHTML = str;
                    }

                    // Onload handler to fire off the app.
                    google.maps.event.addDomListener(window, 'load', initialize);

                } else {
                    alert("Something got wrong " + status);
                }
            });


        }

    });

</script> 

<script>
    /****************************** Insert  *********************************************************/

    function isValidExt(img) {
        var file = img;
        var exts = ['png', 'jpg', 'jpeg'];

        // first check if file field has any value
        if (file) {
            // split file name at dot
            var get_ext = file.split('.');
            // reverse name to check extension
            get_ext = get_ext.reverse();
            // check file type is valid as given in 'exts' array
            if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {
                return true;
            } else {
                return false;
            }
        }
    }
    var img_ext_val = true;
    function img_ext_validation() {
        var len = $("#img_upload").val().length;

        if (len !== 0) {
            if (!isValidExt($("#img_upload").val())) {
                $("#valid_img").fadeIn();
                img_ext_val = false;
            }
            else {
                $("#valid_img").fadeOut();
                img_ext_val = true;
            }
        } else {
            $("#valid_img").fadeOut();
            img_ext_val = false;
        }
    }





    $("#form_projects").on('submit', (function (e) {

        /*for (instance in CKEDITOR.instances) {
         CKEDITOR.instances[instance].updateElement();
         }*/

        e.preventDefault();

        img_ext_validation();

        if (img_ext_val) {
            var img_upload = document.getElementById("img_upload").files[0].name;
            var form_data = new FormData();
            var ext = img_upload.split('.').pop().toLowerCase();

            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("img_upload").files[0]);
            var f = document.getElementById("img_upload").files[0];
            var fsize = f.size || f.fileSize;

            if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                swal("Invalid File Type!", "Please Try Again!", "warning")

            } else if (fsize > 1000000) { // 1MB
                swal("File Size is too big!", "Please Try Again!", "warning")

            } else {
                form_data.append("img_upload", document.getElementById('img_upload').files[0]);
                form_data.append("thetre_name", document.getElementById('thetre_name').value);
                form_data.append("des", document.getElementById('des').value);
                form_data.append("contact", document.getElementById('contact').value);
                form_data.append("ticket", document.getElementById('ticket').value);
                form_data.append("seat", document.getElementById('seat').value);
                form_data.append("city", document.getElementById('city_hid').value);
                form_data.append("lat", document.getElementById('lat').value);
                form_data.append("lng", document.getElementById('lng').value);
                form_data.append("hid_uname", document.getElementById('hid_uname').value);
                // form_data.append("end", document.getElementById('end').value);

                $.ajax({
                    url: "function/thetre_fun.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status === '1') {
                            setTimeout(function () {
                                swal({
                                    title: "",
                                    text: "Successfully Uploaded!",
                                    type: "success",
                                    confirmButtonText: "OK"
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        window.location.href = "thetre.php";
                                    }
                                });
                            }, 100);

                        } else if (data.status === '2') {
                            swal("Something Went Wrong", "File Name Already Exists!", "error");

                        } else if (data.status === '3') {
                            swal("Something Went Wrong", "Please Try Again!", "error"); //mysql error

                        } else if (data.status === '4') {
                            swal("Something Went Wrong", "Error While uploading file on the server!", "error");

                        } else if (data.status === '5') {
                            swal("Invalid File Format!", "File Format Must Be PNG, JPG, or JPEG", "error");
                        }
                    }

                });
            }
        }
        //alert("Done");
    }));



    /******************************************* Remove Contact **************************************/

    $(".btn_dell").click(function () {
        var x = $(this).val();

        swal({
            title: "Are you sure?",
            text: "Your may not be able to recover!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
        function () {
            del_func(x);
        }
        );
    });

    function del_func(thetre_id) {
        // alert(thetre_id);
        if (thetre_id === '') {

            swal("Warning!", "Please Select Valid Record!", "warning");

        } else {

            $.post("function/thetre_fun.php", {remove_thetre: "data", thetre_id: thetre_id}, function (data) {
                if (data.msgType === 1) {
                    swal({
                        title: "Deleted!",
                        text: "Successfully Deleted!",
                        type: "success",
                        confirmButtonText: "OK"
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.location.href = "thetre.php";
                        }
                    });
                } else {
                    swal("Oops...", "Something went wrong!", "warning");
                }
            }, "json");
        }
    }

    /******************************************* Load Form Data **************************************/

    $(".btn_up").click(function () {
        var x = $(this).val();
        load_form_data(x);


    });


    function load_form_data(thetre_id) {
        $.post("function/thetre_fun.php", {get_dataset: "data", thetre_id: thetre_id}, function (data) {
            $.each(data, function (index, data) {

                $('#hidden_id').val(data.id);
                $('#up_thetre_name').val(data.thetre_name);
                $('#up_des').val(data.des);
                //$("#supplier_up option[value='"+data.supplier+"']").attr("selected", "selected");
                $('#up_contact').val(data.contact);
                $('#up_ticket').val(data.ticket);
                $('#up_seat').val(data.seat);

                $('#img_view').html('<img src="upload/theare/' + data.img + '" class="img-responsive" width="200">');

            });

        }, "json");
    }

    /******************************************* Edit **************************************/
    $("#form_projects_up").on('submit', (function (e) {

        e.preventDefault();

        var id = $('#hidden_id').val();
        var thetre_name = $('#up_thetre_name').val();
        var des = $('#up_des').val();
        var contact = $('#up_contact').val();

        var ticket = $('#up_ticket').val();
        var seat = $('#up_seat').val();

        var img = $('#up_img_upload').val();


        if (img === '') {
            $.post('function/thetre_fun.php', {update_data: 'data', id: id, thetre_name: thetre_name, des: des, contact: contact, ticket: ticket, seat: seat},
            function (data) {
                if (data.msgType === 1) {
                    setTimeout(function () {
                        swal({
                            title: "",
                            text: "Successfully Updated!",
                            type: "success",
                            confirmButtonText: "OK"
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location.href = "thetre.php";
                            }
                        });
                    }, 100);

                } else if (data.msgType === 2) {
                    swal("MYSQL Error!", "Please Try Again!", "warning");
                }

            }, "json");

        } else {
            var form_data = new FormData();
            var img_upload = document.getElementById("up_img_upload").files[0].name;
            var ext = img_upload.split('.').pop().toLowerCase();

            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("up_img_upload").files[0]);
            var f = document.getElementById("up_img_upload").files[0];
            var fsize = f.size || f.fileSize;

            if (jQuery.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                swal("Invalid File Type!", "Please Try Again!", "warning")

            } else if (fsize > 1000000) { // 1MB
                swal("File Size is too big!", "Please Try Again!", "warning")

            } else {

                form_data.append("up_img_upload", document.getElementById('up_img_upload').files[0]);
                form_data.append("id", id);
                form_data.append("thetre_name", thetre_name);
                form_data.append("des", des);
                form_data.append("contact", contact);
                form_data.append("ticket", ticket);
                form_data.append("seat", seat);


                $.ajax({
                    url: "function/thetre_fun.php",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status === '1') {
                            setTimeout(function () {
                                swal({
                                    title: "",
                                    text: "Successfully Updated!",
                                    type: "success",
                                    confirmButtonText: "OK"
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        window.location.href = "thetre.php";
                                    }
                                });
                            }, 100);

                        } else if (data.status === '2') {
                            swal("Something Went Wrong", "File Name Already Exists!", "error");

                        } else if (data.status === '3') {
                            swal("Something Went Wrong", "Please Try Again!", "error"); //mysql error

                        } else if (data.status === '4') {
                            swal("Something Went Wrong", "Error While uploading file on the server!", "error");

                        } else if (data.status === '5') {
                            swal("Invalid File Format!", "File Format Must Be PNG, JPG, or JPEG", "error");
                        }
                    }
                });
            }
        }

    }));


    $('#city').change(function () {
        var id = $(this).val();
        load_city_id(id);

    });

    function load_city_id(id) {
        $.post("function/thetre_fun.php", {get_city: 'upData', id: id}, function (up) {//edit data table id pass to model
            $.each(up, function (index, data) {

                $('#city_hid').val(data.id);
            });
        }, "json");


    }


</script>	

</body>
</html>
