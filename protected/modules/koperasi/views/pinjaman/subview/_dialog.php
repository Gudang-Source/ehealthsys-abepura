<!-- Dialog Pegawai -->
<div class="modal fade custom-width" id="dialog_pemohon">
	<div class="modal-dialog" style="width:1200px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Permohonan Pinjaman</h4>
			</div>
			<div class="modal-body">
				<?php 
					$anggota = new InformasipermohonanpinjamanV;
					if (isset($_GET['InformasipermohonanpinjamanV'])) {
						$anggota->attributes = $_GET['InformasipermohonanpinjamanV'];
					}
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchPemohonApproved(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
						
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPemohonAjax("'.$data->nokeanggotaan.'"); $("#dialog_pemohon").modal("hide"); return false;'));
							},
						),
						array(
							'name'=>'tglpermohonanpinjaman',
							'value'=>'date("d/m/Y",strtotime($data->tglpermohonanpinjaman))'
							),
						array(
							'name'=>'nopermohonan',
							),
						array(
							'name'=>'nokeanggotaan',
							'header'=>'Nomor Anggota',
						),
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
						),
						array(
							'header'=>'Tempat Lahir',
							'name'=>'tempatlahir_pegawai',
						),
						// 'pegawai.tempatlahir_pegawai',
						array(
							'header'=>'Tanggal Lahir',
							'name'=>'tgl_lahirpegawai',
							'filter'=>false,
							'type'=>'raw',
							'value'=>'date("d/m/Y", strtotime($data->tgl_lahirpegawai))',
						),
						array(
							'header'=>'Jenis Kelamin',
							'name'=>'jeniskelamin',
							'filter'=>CHtml::activeDropDownList($anggota, 'jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
						),
						array(
							'name'=>'jenispinjaman_permohonan',
							'filter'=>CHtml::activeDropDownList($anggota, 'jenispinjaman_permohonan', array('UANG'=>'UANG','BARANG'=>'BARANG'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
							),
						array(
							'name'=>'jmlpinjaman',
							'value'=>'MyFormatter::formatNumberForPrint($data->jmlpinjaman)',
							'htmlOptions'=>array('style'=>'text-align:right;'),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
						),
						array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'namaunit', CHtml::listData(UnitM::model()->findAll(),'namaunit','namaunit'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
						),
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>'$data->golonganpegawai_nama',
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
						),
					),
				)); 
				?>
			</div>
		</div>
	</div>
</div>

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

<?php $this->renderPartial('subview/_dialogKonfirmasi'); ?>