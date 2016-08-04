<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Permohonan Pinjaman</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
			<a data-rel="reload" href="#" onclick="refreshTable();"><i class="entypo-arrows-ccw"></i></a>
		</div>
	</div>
	<div class="panel-body with-table">
		<?php 
		
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'table-grid',
            'dataProvider'=>$dataTable->searchTableDash(),
            'template'=>"{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed table-responsive',
            'columns'=>array(				
                                array(
                                        'name'=>'nokeanggotaan',
                                        'type'=>'raw',
                                        'header'=>'Nomor Anggota',
                                ), 
                                array(
                                        'name'=>'nama_pegawai',
                                        'type'=>'raw',
                                        'header'=>'Nama Anggota',
                                ), 
                                array(
                                        'header'=>'Status',
                                        'type'=>'raw',
                                        'value'=>'!empty($data->approval_id)?($data->status_disetujui?"<span class=\"setuju\">Telah Disetujui</span>":"<span class=\"setuju\">Tidak Disetujui</span>"):"<span class=\"setuju\">Belum Disetujui</span>"',
                                ),
                                array(
                                        'header'=>'Jumlah Pinjaman',
                                        'name'=>'jmlpinjaman',
                                        'type'=>'raw',
                                        'value'=>'"Rp".number_format($data->jmlpinjaman)',
                                  'htmlOptions'=>array('style'=>'text-align: right;padding-right:20px;'),
                                ), 
			), 
			)
			);
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