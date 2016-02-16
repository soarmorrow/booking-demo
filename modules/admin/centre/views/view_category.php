<section class="content-header">
     <h1>
          View Centre Category
          <small></small>
     </h1>

</section>
<section class="content">
     <section class="content">
          <div class="row">
               <div class="col-md-12">
                    <div class="box  box-success">
                         <div class="box-header">
                              <h3 class="text-center"><?= $centre_cat->rc_category ?></h3>                                  
                         </div><!-- /.box-header -->
                         <div class="box-body">
                              <div class="row">

                                   <div class="col-md-6">
                                        <table class="table table-striped">
                                             <tr>
                                                  <td>Centre Type</td>
                                                  <td><?= $centre_cat->rc_category ?></td>
                                             </tr>                                            

                                        </table>
                                   </div>
                              </div>  </div><!-- /.box-body -->
                         <div class="box-footer">  
                              <a href="<?= site_url('centre/update_type/' . $cat_id) ?>" class="btn btn-primary" onclick="">Edit</a>

                         </div>
                    </div><!-- /.box -->
               </div><!-- /.col -->

          </div><!-- /.row -->

     </section>
</section>
<style>
     .logo_wrapper{
          height: 200px;
          width: 200px;
          border:1px solid #ddd;
          margin: 20px auto;
          border-radius: 5px;
          overflow: hidden;
     }
     .logo_wrapper img{
          width: 100%; border-radius: 5px;
     }

</style>