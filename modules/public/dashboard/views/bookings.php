<style type="text/css">
    .cancelbooking{
        padding: 8px 15px !important;
    }
    .rating-input{
        float: left;
        font-size: 15px;
        padding-left: 5px;
    }
     .rating-input > span.active:before, .rating-input > span.active ~ span:before{
        font-size: 15px;
    }
</style>
<div class="example-modal">
    <div class="modal" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2>Your Review</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="itemid" class="">                   
                        <input type="hidden" value="0" class="ratevalue"> 

                        <textarea id="review" rows="5" placeholder="<?=$user_id==0 ? 'Login to continue' : 'Review for this event'?>""Comments for this event""<?=$user_id==0 ? 'Login to continue' : 'Review for this event'?>" class="form-control" style=" border: 1px solid #ccc;"></textarea>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Rate the event now</label>
                        </div>
                        <div class="col-md-8 nopadding">
                            <div class="rating pull-left"><span data-value="5">&star;</span><span data-value="4">&star;</span><span data-value="3">&star;</span><span data-value="2">&star;</span><span data-value="1">&star;</span></div>
                        </div><!-- /.login-box-body -->
                    </div><!-- /.login-box -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>

                        <button type="button"  class="btn btn-info" id="update_type" style="margin-right:5px">Submit</button>
                    </div><br>
                    <div id="listReview">
                    </div>
                    <div class="clearfix"></div><br>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.example-modal -->
<div  style="padding-top: 150px;padding-bottom: 50px;" class="container">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?= site_url('search/clearsearch') ?>"><button class="btn btn-primary pull-right">Book New</button></a>
            <div class="clearfix"></div>
            <div class="table-responsive">
                <?php
                if(!empty($resultarray)){
                    ?>
                    <table class="table table-striped table-bordered">
                        <thead><tr>
                            <th>Booking ID</th>
                            <th>Event Name</th>
                            <th>Center Name</th>
                            <th>Booked Date</th>
                            <th>Attend</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($resultarray as $value) {
                            ?>
                            <tr>
                                <td><?= $value->id ?></td>
                                <td><?= $value->event_name ?></td>
                                <td><?= $value->center_name ?></td>
                                <td><?= date("Y:m:d h:i A", strtotime($value->timestamp)) ?></td>
                                <td><?= $value->attend ?></td>
                                <td>
                                    <?php
                                    if(strtotime($value->start_date) > time()){
                                        ?><button class="btn btn-warning cancelbooking" data-id="<?= $value->id ?>" id="">Cancel Booking</button>
                                        <?php
                                    }
                                    else if(strtotime($value->end_date) < time()){
                                        ?><button class="btn btn-success ratings review" data-id="<?= $value->event_id ?>" id="">Rate it</button>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <button class="btn btn-success ongoing" data-id="<?= $value->id ?>" id="">Event Ongoing</button>
                                        <?php
                                    }
                                    ?></td>

                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                            </tbody>
                        </table>
                        <?php
                    }
                    else{
                        ?>
                        <div style="color:red;font-size:24px">No bookings so far!!!</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $(".review").click(function () {
                $('#editModal #itemid').val($(this).data('id'));
                $('#editModal #review').val($(this).data('name'));
                $("#editModal").modal('show');
                var id = $(this).data('id');
                getDefaultCount();
                $.ajax({
                    url: "<?= site_url('user_dashboard/get_event_reviews') ?>/"+id,
                    method: "post",
                    success: function (result) {
                        $("#listReview").html(result);
                    }
                });

                $.getJSON("<?= site_url('rating/get_counts') ?>/"+id,function(data){
                    rates.update(data);
                });
            });
            $('#editModal').on('hidden.bs.modal', function (e) {
                $('#editModal #itemid').val("");
                $('#editModal #review').val("");

            });

            $("#update_type").click(function () {
                var id = $('#editModal #itemid').val();
                var review = $('#editModal #review').val();

                var rate=$('.ratevalue').val();

                $.ajax({
                    url: "<?= site_url('event_public/review') ?>/"+id,
                    method: "post",
                    data: {"id": id,"review":review,"rate":rate},
                    success: function (result) {
                        result = JSON.parse(result);
                        $("#editModal").modal('hide');
                        if ( result.code == 200) {

                            swal({
                                title: "Success",
                                text: "Review Updated Successfully",
                                type: "success",
                                timer: 3000,
                                animation: false,
                                showConfirmButton: false
                            });
                            window.location.reload();
                        } else if(result.code == 300) {
                            swal("Oops!", result.message, "error");
                        }
                        else{
                            swal("Oops!", result.message, "error");
                        }
                        $.getJSON("<?= site_url('rating/get_counts') ?>/"+id,function(data){
                            $('.ratevalue').val(data);
                            rates.clear();
                            rates.update(parseInt(data));
                        });

                        $.getJSON("<?= site_url('event_public/get_counts') ?>/"+id,function(data){
                            $('span#reviews').text(data);
                        });
                    }, error: function () {
                        swal("Oops!", "Failed to Comment", "error");
                    }
                });
});
var rates = {
    update: function(current_rate){
        for(var i = 1 ; i <= current_rate; i++){
            $("span[data-value='"+i+"']").css('color','#f90').html("&starf;");
        }
    },
    clear: function(){
        for(var i = 1 ; i <= 5; i++){
            $("span[data-value='"+i+"']").css('color','#00415d').html("&star;");
        }
    }
}
<?php
if(!empty($current_rating)){
    ?>
    rates.update(<?=$current_rating->rating?>);
    <?php
}
?>
$('.rating span').on('click',function(){
    var rate = $(this).data('value');
    $('.ratevalue').val(rate);
    rates.update(parseInt(rate));
    rates.clear();
});
$('.rating').hover(function(){
    rates.clear();
}, function(){
    getDefaultCount();
});


function getDefaultCount(){
    var id=$('#editModal #itemid').val();
    $.getJSON("<?= site_url('rating/get_counts') ?>/"+id,function(data){
        var rate=$('.ratevalue').val();
        rates.update(rate);
    });
}


$(".cancelbooking").click(function () {
    var cancelthis=$(this);
    swal({
        title: "Are you sure?",
        text: "Do you really want to cancel booking. Money will be stored in Goretreat wallet!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Cancel it!",
        closeOnConfirm: false
    },
    function () {
        var href = "<?= site_url('user_dashboard/cancelbooking/') ?>" + "/" + cancelthis.data('id');
        $.ajax({
            url: href,
            data: {},
            success: function (data) {
                swal({
                    title: "Cancelled!",
                    text: "Cancelled and refund money is stored in goretreat wallet.",
                    type: "success"
                },
                function (isConfirm) {
                    location.reload();
                }
                );
            }

        })
    });
});
})
</script>
