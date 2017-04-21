<script type="text/javascript">
	$(document).ready(function () {

        // Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Manajemen Registrasi'
            },
			subtitle: {
				text: 'POLDA YOGYAKARTA ',
			},
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Persentasi',
                colorByPoint: true,
                data: [
			
				<?php
				

					$this->db->group_by('asal_upt');
					$upt 	= $this->db->get('main')->result();
					$query	= "SELECT asal_upt, COUNT(no_reg) jumlah FROM main group by asal_upt";
					$jml	= $this->db->query($query)->result();
					// echo $this->db->last_query();
					
					$total = 0;
					foreach($jml as $row): 
	
						$total = $total + $row->jumlah;

					endforeach;					
					
					foreach($upt as $list):
						
						if(!$jml) {
							$nilai = '0.0';
						} else {
						
							foreach($jml as $row): 
								if($list->asal_upt == $row->asal_upt) {
									$nilai = $row->jumlah/$total*100;
									break;
								} else {
									$nilai = '0.0';
								}
							endforeach;
							
						}
				?>		
					{
						name: <?php echo "'$list->asal_upt'"; ?>,
						y: <?php echo $nilai; ?>
					},
						
				<?php endforeach; ?>
					
				]
            }]
        });
    });
</script>