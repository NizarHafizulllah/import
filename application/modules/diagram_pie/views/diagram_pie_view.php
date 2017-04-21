<script src="<?php echo base_url("assets") ?>/js/jquery.dataTables.min.js"></script>

 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css">
<script src="<?php echo base_url('assets/highcharts/highcharts.js'); ?>"></script>

<div class="col-md-8">
	<div id="container">
		
	</div>
</div>
<div class="col-md-4">
	<table width="100%" border="0" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid">
	<thead>
  <tr> 
        <th width="10%" >No.</th>
        <th width="70%" >UPT</th>
        <th width="20%" >Jumlah</th>
    </tr>
  
</thead>
<tbody>
	<?php 
	$i = 1;
	foreach ($jml as $row ) { ?>
		<tr>
			<td><?php echo $i?></td>
			<td><?php echo $row['asal_upt']; ?></td>
			<td><?php echo $row['jumlah']; ?></td>
		</tr>

	<?php 
	$i++;	}
	?>
</tbody>
</table>
</div>

&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>






<?php
 	$this->load->view($this->controller."_view_js");
  ?>