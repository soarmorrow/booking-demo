
<link href="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.css') ?>" rel="stylesheet"/>

<!-- Theme style -->
<!--<link href="//<?= base_url($theme_path . 'plugins/iCheck/all.css') ?>" rel="stylesheet" type="text/css" />-->
<link href="<?= base_url($theme_path . 'plugins/iCheck/flat/green.css') ?>" rel="stylesheet" type="text/css" />
<style>
    .loader{
        width: 100%;
        height: 100%;
        z-index: 2000;
        background-color: #333333;
        opacity: 0.8;
        position: fixed;
        top: 0;left: 0;
        display: none;

    }
    .loader img{
        margin-left: 45%;
        margin-top: 20%;
    }
</style>
<div class="loading-img loader">
    <img src="<?php echo base_url('/themes/admin/images/loading.gif'); ?>" width="200"/>
</div>
<section class="content-header">
    <h1>
        Roles
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Roles</a></li>
        <li class="active">Manage</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <?php
        if (_is("GR Admin")) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <div class="col-md-12">
                                <form method="post" action="" id="loadcenter">
                                    <div class="row"><div class="col-md-12"><label>Add Users to Center</label></div></div>
                                    <div class="row" style="padding-bottom: 20px;">
                                        <?php
                                        if (_is("GR Admin")) {
                                            ?>
                                            <div class="col-md-5">
                                                <label><small>Centers</small></label>
                                                <select class="form-control" name="center_id" id="idforcenter">
                                                    <!--<option value="">Root</option>-->
                                                    <?php
                                                    foreach ($centers as $val1) {
                                                        if ($center_id == $val1->id) {
                                                            echo '<option selected  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                        } else {
                                                            echo '<option  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                        }
                                                    }
                                                    ?> 
                                                </select>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-md-5">
                                            <label><small>Users</small></label>
                                            <select class="form-control" name="userid" id="userid">
                                                <option value="">Select</option>
                                                <?php
                                                foreach ($allusers as $val1) {
                                                    echo '<option  value="' . $val1->id . '">' . $val1->username . '</option>';
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                        <div class="col-md-2">   
                                            <div class="col-md-12">
                                                <label><small>&nbsp; </small></label></div>

                                            <button class="btn btn-primary" type="submit">Add user</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- /.box -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <?php
                        if (_is("GR Admin")) {
                            ?>
                            <div class="col-md-12">
                                <div class="row"><div class="col-md-11"><label>Assign roles to users</label></div></div>
                                <div class="row">
                                    <?php
                                    if (_is("GR Admin")) {
                                        ?>
                                        <div class="col-md-12">
                                            <label><small>Centers</small></label>
                                            <select class="form-control" name="center_id" id="centerid">
                                                <!--<option value="">Root</option>-->
                                                <?php
                                                foreach ($centers as $val1) {
                                                    if ($center_id == $val1->id) {
                                                        echo '<option selected  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                    } else {
                                                        echo '<option  value="' . $val1->id . '">' . $val1->name . '</option>';
                                                    }
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-md-11 right">
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body" style="min-height: 450px;">
                        <input type="hidden" value="<?= $center_id ?>" id="center_id"/>
                        <table id="listuser" class="table table-bordered table-striped" >
                            <thead>
                                <tr>
                                    <th style="">User/Role</th>
                                    <?php
                                    foreach ($roles as $val) {
                                        if (_is('RC Admin') && $val['role_name'] == "GR Admin") {
                                            
                                        } else {
                                            if ($val['role_name'] == "User") {
                                                
                                            } else {
                                                echo '<th style="font-weight:100;text-align:center">' . $val['role_name'] . '</th>';
                                            }
                                        }
                                    }
                                    ?>                  
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <?php
                                foreach ($users as $value) {
                                    echo '<tr>
                                    <td>' . $value->username . '</td>';
                                    foreach ($roles as $val) {
                                        if (_is('RC Admin') && $val['role_name'] == "GR Admin") {
//                                            echo '<td style="text-align:center"><input  ' . (in_array_r($value->id, $val['assignedusers'], true) ? 'checked' : '') . ' data-user="' . $value->id . '" data-role="' . $val['id'] . '" type="checkbox" class="iCheckmodule minimal"></td>';
                                        } else {
                                            if ($val['role_name'] == "User") {
                                                
                                            } else {
                                                echo '<td style="text-align:center"><input  ' . (in_array_r($value->id, $val['assignedusers'], true) ? 'checked' : '') . ' data-user="' . $value->id . '" data-role="' . $val['id'] . '" data-name="' . $value->first_name . '" data-rname="' . $val['role_name'] . '" type="checkbox" class="iCheckmodule minimal"></td>';
                                            }
                                        }
                                    }
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div><!-- /.row -->

    </section>
</section>
<script src="<?= base_url($theme_path . 'plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url($theme_path . 'plugins/datatables/dataTables.bootstrap.min.js') ?>"></script>

<!-- iCheck 1.0.1 -->
<script src="<?= base_url($theme_path . 'plugins/iCheck/icheck.min.js') ?>" type="text/javascript"></script>

<script>
    $(window).load(function () {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "500",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        loader();
        spge = '<?php echo $alertify_error; ?>';
        spse = '<?php echo $alertify_success; ?>';
        if (spge != '') {
            toastr["error"](spge);
        }
        if (spse) {
            toastr["success"](spse);
        }
    });    

    $('#idforcenter').change(function(event){    
        $('.loader').show();
        var formData = new FormData();
        formData.append('center_id',$(this).val()); 
        $('#center_id').val($(this).val());    
        $.ajax({
            url: "<?php echo site_url('relation/loadchangeadduser') ?>",
            type: "post",
            data: formData,
            dataType:'json',
            success: function(data) {
                var users=data['users'];
                $("#userid").html('<option value="">Select</option>');
                for(var i in users){                    
                    $("#userid").append('<option value="'+users[i]['id']+'">'+users[i]['username']+'</option>');
                }
                $('.loader').hide();
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
    });
    $('#centerid').change(function (event) {
        $('.loader').show();
        var formData = new FormData();
        formData.append('center_id',$(this).val());     
        $.ajax({
            url: "<?php echo site_url('relation/loadchangecenter') ?>",
            type: "post",
            data: formData,
            dataType:'json',
            success: function(data) {
                var ticked=data['ticked'];
                var roles=data['roles'];
                $("#tablebody").html('');
                for(var j in ticked){                    
                    var tr='<tr><td>' + ticked[j]['username'] + '</td>';
                    for(var k in roles){
                        var selected="";
                        if (getIndexIfObjWithAttr(roles[k]['assignedusers'],'user_id',ticked[j]['id']) > -1) {
                            selected="checked";
                        }
                        tr=tr+'<td style="text-align:center"><input  ' +selected+ ' data-user="' + ticked[j]['id'] + '" data-role="' + roles[k]['id'] + '" data-name="'+ ticked[j]['first_name'] + '" data-rname="' + roles[k]['role_name'] + '" type="checkbox" class="iCheckmodule minimal"></td>';
                    }
                    tr=tr+'</tr>';
                    $("#tablebody").append(tr);
                }
                if(!j){
                    $("#tablebody").html('<tr></tr>');
                }
                $('.loader').hide();
                loader();
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        
        
        
        var getIndexIfObjWithAttr = function(array, attr, value) {
            for(var i = 0; i < array.length; i++) {
                if(array[i][attr] === value) {
                    return i;
                }
            }
            return -1;
        }
            
    });
    function loader(){
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });
        $('input').on('ifChecked', function (event) {
            var name=$(this).attr('data-name');
            var rolename=$(this).attr('data-rname');
            var thisinput = $(this);
            var data = {role_id: $(this).attr('data-role'), user_id: $(this).attr('data-user'), center_id: $('#centerid').val()};
            $.ajax({
                url: "<?php echo site_url('relation/checkuserrole') ?>",
                type: 'POST',
                data: data,
                dataType: 'html',
                success: function (result) {
                    if (result == 'true') {
                        toastr["success"](rolename+" role Added to "+name);
                    } else {
                        toastr["error"](result);
                    }
                }
            });
        });
        //
        $('input').on('ifUnchecked', function (event) {
            var name=$(this).attr('data-name');
            var rolename=$(this).attr('data-rname');
            var thisinput = $(this);
            var data = {role_id: $(this).attr('data-role'), user_id: $(this).attr('data-user'), center_id: $("#centerid").val()};
            $.ajax({
                url: "<?php echo site_url('relation/uncheckuserrole') ?>",
                type: 'POST',
                data: data,
                dataType: 'html',
                success: function (result) {
                    if (result == 'true') {
                        toastr["success"](rolename+" role removed from "+name);
                    } else {
                        toastr["error"](result);
                    }
                }
            });
        });
    }
</script>