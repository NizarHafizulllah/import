 <link href="<?php echo base_url("assets") ?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url("assets") ?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url("assets") ?>/js/jquery.dataTables.min.js"></script>

 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css">


        <!-- Content Header (Page header) -->
        

          <!-- Default box -->
          

            

            <form role="form" action="" id="btn-cari" >
            <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="Tanggal">Tanggal Masuk</label>
                <input name="tgl_masuk" id="tgl_masuk" type="text" class="form-control tanggal" placeholder="Tanggal Masuk" data-date-format="dd-mm-yyyy"></input>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="Tanggal">Tanggal Ekspirasi</label>
                <input name="tgl_ekspirasi" id="tgl_ekspirasi" type="text" class="form-control tanggal" placeholder="Tanggal Ekspirasi" data-date-format="dd-mm-yyyy"></input>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="Tanggal">Asal UPT</label>
                <input name="asal_upt" id="asal_upt" type="text" class="form-control" placeholder="Asal UPT"></input>
              </div>
            </div>

            
            <div class="col-md-3">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama"></input>
              </div>
            </div>
            </div>
             <div class="row">
            <div class="col-md-1">
              <div class="form-group">
                <label></label>
                <button type="submit" class="btn btn-default form-control" id="btn_submit"><i class="fa">Cari</i></button>
              </div>
            </div>
            <div class="col-md-1">
              <div class="form-group">
                <label></label>
                <button type="reset" class="btn btn-default form-control" id="btn_reset"><i class="fa">Reset</i></button>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label></label>
                <a href="<?php echo site_url('import_data'); ?>" class="btn btn-default form-control" ><i class="fa">Import Data</i></a>
              </div>
            </div>
            </div>
            </form>
            


<table width="100%" border="0" id="biro_jasa" class="table table-striped 
             table-bordered table-hover dataTable no-footer" role="grid">
<thead>
  <tr  > 
        <th width="5%" >No. Reg</th>
        <th width="15%" >Nama</th>
        <th width="5%" >Tgl. Masuk</th>
        <th width="5%" >Tgl. Ekspirasi</th>
        <th width="15%" >Asal UPT</th>
        <th width="15%" >Pasal Kejahatan</th>
    </tr>
  
</thead>
</table>
            



<?php 
$this->load->view($this->controller."_view_js");
?>