<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Pasien Rujukan Ke Luar Hari Ini</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
			<a data-rel="reload" href="#" onclick="refreshTable();"><i class="entypo-arrows-ccw"></i></a>
		</div>
	</div>
	<div class="panel-body with-table">
		<?php 
		
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'table-grid',
            'dataProvider'=>$dataTable->searchDashboard(),
            'template'=>"{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed table-responsive',
            'columns'=>array(
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->pendaftaran->no_pendaftaran',
                ),
				
				array(
					'header'=>'Tgl. Dirujuk',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgldirujuk)',
				),
				array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->pasien->no_rekam_medik',
                ),
				array(
					'header'=>'Nama Pasien',
					'type'=>'raw',
					'value'=>'$data->pasien->namadepan." ".$data->pasien->nama_pasien',
				),
				array(
					'header'=>'RS Rujukan',
					'type'=>'raw',
					'value'=>'$data->rujukankeluar->rumahsakitrujukan',
				),
				array(
					'header'=>'Alasan Dirujuk',
					'type'=>'raw',
					'value'=>'$data->alasandirujuk',
				),
            ),
        )); 
    ?>
		
		
		<?php /*
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<td>No. Pendaftaran</td>
					<td>Tanggal Buat Janji</td>
					<td>Nama Pasien</td>
					<td>Poli Klinik</td>
					<td>Dokter</td>
					<td>Janji Melalui</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($dataTable as $updatePasien){ ?>
				<tr>
					<td><?php echo $updatePasien->no_pendaftaran; ?></td>
					<td><?php echo MyFormatter::formatDateTimeForUser(date("d-m-Y", strtotime($updatePasien->tgl_pendaftaran))); ?></td>
					<td><?php echo $updatePasien->pasien->nama_pasien; ?></td>
					<td><?php echo $updatePasien->pasien->jeniskelamin; ?></td>
					<td><?php echo $updatePasien->statuspasien; ?></td>
					<td><?php echo $updatePasien->getJumlahKunjungan(); ?> Kali Berkunjung</td>
				</tr>
				<?php } ?>
			</tbody>
		</table> */ ?>
	</div>
</div>

<script type="text/javascript">
function refreshTable(){
	$.fn.yiiGridView.update('table-grid');
}
</script>