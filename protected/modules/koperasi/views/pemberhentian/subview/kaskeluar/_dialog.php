<!-- Dialog pengurus koperasi -->
<div class="modal fade custom-width" id="dialog_pegawai">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Pegawai Koperasi</h4>
			</div>
			<div class="modal-body">
				<?php
					echo CHtml::hiddenField('target_attr', null);
					$pegawai = new PegawaiM;
					if (isset($_GET['PegawaiM'])) $pegawai->attributes = $_GET['PegawaiM'];
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
						array(
							'header'=>'Pilih',
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai").modal("hide"); return false;'));
							},
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
						),
						'nomorindukpegawai',
						//'no_kartupegawainegerisipil',
						//'pegawai_id',
						//'noidentitas',
						array(
							'header'=>'Nama Pegawai',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
							),
						array(
							'header'=>'Jabatan',
							'type'=>'raw',
							'value'=>'empty($data->jabatan_id)?"-":$data->jabatan->jabatan_nama',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Pangkat',
							'type'=>'raw',
							'value'=>'empty($data->pangkat_id)?"-":$data->pangkat->pangkat_nama',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Golongan',
							'type'=>'raw',
							'value'=>'empty($data->golonganpegawai_id)?"-":$data->golonganpegawai->golonganpegawai_nama',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
							'nomobile_pegawai',
							'alamatemail',
						),
					));
				?>
			</div>
		</div>
	</div>
</div>
