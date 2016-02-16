<section class="content-header">
    <h1>
        Blog
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Blog</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form name="searchform" method="post" action="<?= site_url('blog') ?>">
                    <div class="box-header">
                        <h3 class="box-title">Search</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="input-group">
                            <input type="text" name="content" placeholder="Enter search key like title, content, user etc." class="form-control" value="<?= (isset($content) ? $content : "") ?>"/>
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div>
                </form>
            </div><!-- /.box -->

            <div class="box box-success">
                <div class="box-body">    

                        <div class=" col-md-12 table-responsive">
                    <table id="listcentres" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 250px">Title</th>
                                <th style="width:290px">Content</th>
                                <th style="width: 140px">User</th>
                                <th style="width:130px;">Published at</th>
                                <?php
                                if (_is("GR Admin")) {
                                    ?>
                                    <th style="width: 100px">Status</th>
                                <?php } ?>
                                <th style="width:135px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($blogs as $value) {
                                echo '<tr id="blog' . $value->id . '"><td>' . str_replace($content, "<b>$content</b>", closetags(sub_str(strip_tags($value->title), 0, 67))) . '</td>';
                                echo '<td>' . str_replace($content, "<b>$content</b>", closetags(sub_str(strip_tags($value->content), 0, 120))) . '</td><td>' . str_replace($content, "<b>$content</b>", $value->username) . '</td><td>' . time_elapsed_string($value->timestamp) . '</td>';
                                if (_is("GR Admin")) {
                                    echo '<td>';
                                    if ($value->status == 1) {
                                        echo '<input checked type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-offstyle="danger" value = "' . $value->id . '" >';
                                    } else {
                                        echo '<input type = "checkbox" class = "statuschanger" data-size = "small" data-onstyle = "success" data-offstyle="danger"  value = "' . $value->id . '" >';
                                    }
                                    echo '</td>';
                                }
                                ?>

                            <td>
                                <a href="<?php echo site_url('blog/view/' . $value->id) ?>" class="btn btn-sm btn-primary" title="view">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="<?php echo site_url('blog/update/' . $value->id) ?>" class="btn btn-sm bg-green" title="edit">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <span  data-link="<?php echo site_url('blog/delete_blog/' . $value->id) ?>" data-namevalue="<?= strip_tags($value->title) ?>" data-id="<?= $value->id ?>" class="deletecentre btn btn-sm btn-danger" title="delete">
                                    <i class="fa fa-remove"></i>
                                </span>

                            </td>
                            </tr>
                            <?php
                        }
                        ?>

                        </tbody>
                    </table>
                        </div>
                    <div class="col-md-12">   
                        <div class="col-md-2" style="margin: 20px auto;">
                            <select class="form-control" id="perpage" style="max-width:80px;">
                                <?php
                                if (isset($perpages)) {
                                    foreach ($perpages as $perpage) {
                                        if ($perpage === $per_page) {
                                            echo '<option value="' . $perpage . '" selected>' . $perpage . '</option>';
                                        } else {
                                            echo '<option value="' . $perpage . '">' . $perpage . '</option>';
                                        }
                                    }
                                }
                                ?>                                            
                            </select>
                        </div>
                        <div class="col-md-10 text-right">
                            <?= $pagination ?>
                        </div>
                    </div>
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div>

    </div><!-- /.row -->
    <script>
        $(window).load(function () {
            $('.statuschanger').bootstrapToggle({
                on: 'Published',
                off: 'Not published'
            });
            $("#perpage").change(function () {
                $.ajax({
                    url: "<?= site_url('blog/change_perpage') ?>/" + $(this).val() + '',
                    method: "post",
                    success: function () {
                        location.reload();
                    }
                });
            });
            $('.deletecentre').click(function () {
                var href = $(this).data('link');
                var id = $(this).data('id');
                var name = $(this).data("namevalue").toString();
                name=name.substring(0, 20);
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to undo this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function () {
                    $.ajax({
                        url: href,
                        method: "post",
                        success: function (result) {
                            if (result === '1') {
                                $("#blog" + id).remove();
                                swal("Deleted!", "Blog '" + name + "'.. has been deleted.", "success");
                            } else {
                                swal("Oops!", "Failed to delete", "error");
                            }
                        }
                    });
                });
            });
            
            $('.statuschanger').change(function () {
                var value1;
                if ($(this).prop('checked')) {
                    value1 = 1;
                } else {
                    value1 = 0;
                }
                var variablee = $(this);
                $.ajax({
                    url: "<?= site_url('blog/togglepublish') ?>/" + $(this).val() + '/' + value1,
                    method: "post",
                    success: function (result) {

                        if (result === '1') {
                            if(value1==1){
                                swal("Success!", "Blog has been published.", "success");
                            }else{
                                swal("Success!", "Blog has been un published.", "success");
                            }
                        } else {
                            if (variablee.prop('checked')) {
                                variablee.removeAttr('checked');
                            } else {
                                variablee.prop('checked');
                            }
                        }
                    }
                });
            });
        });
    </script>
</section>