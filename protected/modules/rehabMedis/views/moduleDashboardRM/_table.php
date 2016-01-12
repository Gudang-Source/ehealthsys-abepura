<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="panel-title">Pasien Pemeriksaan Rehabilitasi Medis Terakhir</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
			<a data-rel="reload" href="#" onclick="refreshTable();"><i class="entypo-arrows-ccw"></i></a>
		</div>
	</div>
	<div class="panel-body with-table">
		<?php 
		
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'table-grid',
            'dataProvider'=>$dataTable->search10Terakhir(),
            'template'=>"{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed table-responsive',
            'columns'=>array(
                array(
                    'header'=>'Tgl. Masuk Penunjang',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->pasienmasukpenunjang->tglmasukpenunjang)',
                ),
                'pasienmasukpenunjang.no_masukpenunjang',
                'pasien.no_rekam_medik',
                'pendaftaran.no_pendaftaran',
				array(
					'header'=>'Nama Pasien',
					'type'=>'raw',
					'value'=>'$data->pasien->namadepan." ".$data->pasien->nama_pasien',
				),
				'pendaftaran.umur',
				'pasien.jeniskelamin',
            ),
        )); 
    ?>
	</div>
</div>

<script type="text/javascript">
function refreshTable(){
	$.fn.yiiGridView.update('table-grid');
}
</script>