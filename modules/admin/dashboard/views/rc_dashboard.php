<section class="content-header">

    <h1>
        <?= $center_name->name ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>150</h3>
                    <p>New Bookings</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Increase inj Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>44</h3>
                    <p>New Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->

            <!--/.nav-tabs-custom--> 

            <!-- solid sales graph -->
            <div class="box box-solid bg-teal-gradient">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title">Booking Graph</h3>
                    <div class="box-tools pull-right">
                        <!-- <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button> -->
                    </div>
                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div><!-- /.box-body -->
                
            </div><!-- /.box -->

        </section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

            <!-- Map box -->
<div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title">Visitors</h3>
                    <div class="box-tools pull-right">
                       <!--  <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button> -->
                    </div>
                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="revenue-chart" style="height: 250px;"></div>
                </div><!-- /.box-body -->
                
            </div><!-- /.box -->

            <!-- Map box -->
            
            <script>
                RCdashBoardinit();
            </script>
        </section><!-- right col -->
    </div><!-- /.row (main row) -->
</section><!-- /.content -->