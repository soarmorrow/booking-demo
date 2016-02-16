<section class="content-header">
    <h1>
        View User
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">View user</li>
    </ol>
</section>
<section class="content">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-success">
                    <div class="box-header">
                    </div><!-- /.box-header -->
                    <form name="createuser" method="post" id="createuser">

                        <div class="box-body">

                            <div class="row">                                
                                <div class="col-md-4">
                                    <?php
                                    if ($getuserdata->avatar != '') {
                                        echo '<img src="' . $getuserdata->avatar . '" style="max-height: 200px;max-width: 200px;width: 90%;margin-left: 9%"/>';
                                    } else {
                                        echo '<img src="' . base_url($theme_path . 'images/pp.jpg') . '" style="max-height: 200px;max-width: 200px;width: 90%;margin-left: 9%"/>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-8" style="padding-top: 5px;">
                                    <table id="listuser" class="table table-bordered table-striped">
                                        <thead>

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 150px">First Name</td>
                                                <td><?= $getuserdata->first_name ?></td>     
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">Last Name</td>
                                                <td><?= $getuserdata->last_name ?></td>     
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">E Mail</td>
                                                <td><?= $getuserdata->email ?></td>     
                                            </tr>
                                            <tr>
                                                <td style="width: 150px">User Name</td>
                                                <td><?= $getuserdata->username ?></td>     
                                            </tr>

                                            <tr>
                                                <td style="width: 150px">Phone Number</td>
                                                <td><?= $getuserdata->contact_number ?></td>     
                                            </tr>

                                            <tr>
                                                <td style="width: 150px">Roles assigned </td>
                                                <td>
                                                    <?php
                                                    $roles = explode(",", $getuserdata->role_name);
                                                    foreach ($roles as $value) {
                                                        echo '<a style="margin-right:3px" class="btn btn-primary btn-xs">' . $value . '</a>';
                                                    }
                                                    ?>
                                                </td>     
                                            </tr>

                                            <tr>
                                                <td style="width: 150px">Centers assigned</td>
                                                <td>

                                                    <?php
                                                    $centers = explode(",", $getuserdata->center_name);
                                                    foreach ($centers as $value) {
                                                        echo '<a style="margin-right:3px" class="btn btn-primary btn-xs">' . $value . '</a>';
                                                    }
                                                    ?></td>     
                                            </tr>

                                            <tr>
                                                <td style="width: 150px">Status</td>
                                                <td><?= ($getuserdata->active == 1) ? "Active" : "Inactive" ?></td>     
                                            </tr>

                                            <tr>
                                                <td style="width: 150px">Created time</td>
                                                <td><?= time_elapsed_string($getuserdata->created_at) ?></td>     
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">  
                            <a href="<?= site_url('user/edit/' . $getuserdata->id) ?>"><button type="button" class="btn btn-primary pull-right" onclick="">Edit</button></a>&nbsp;

                            <a onclick="history.go(-1);" class="btn-default btn  pull-right" style="margin-right: 5px;">
                                Back
                            </a>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!-- /.col -->

        </div><!-- /.row -->

    </section>
</section>

<script>
    $(window).load(function () {
        $('.statuschanger').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });
        $('.statuschanger').change(function () {
        });


        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen();
        }
    });
</script>
<script type="text/javascript">

</script>