<section class="content-header">
     <h1>
          View Centre Type
          <small></small>
     </h1>
</section>
<section class="content">
     <section class="content">
          <div class="row">
               <div class="col-md-12">
                    <div class="box  box-success">
                         <div class="box-header">
                              <h3 class="text-center"><?= $centre_type->name ?></h3>                                  
                         </div><!-- /.box-header -->
                         <div class="box-body">
                              <div class="row">

                                   <div class="col-md-6">
                                        <table class="table table-striped">
                                             <tr>
                                                  <td>Name</td>
                                                  <td><?= $centre_type->name ?></td>
                                             </tr>                                            

                                        </table>
                                   </div>
                              </div>  </div><!-- /.box-body -->
                         <div class="box-footer">  
                              <a href="<?= site_url('centre/update_type/' . $type_id) ?>" class="btn btn-primary" onclick="">Edit</a>

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