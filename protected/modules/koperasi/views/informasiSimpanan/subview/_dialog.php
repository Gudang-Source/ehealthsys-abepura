<!-- Dialog Pegawai -->
<div class="modal fade custom-width" id="dialog_anggota">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Anggota</h4>
			</div>
			<div class="modal-body">
				<?php
					$anggota = new KeanggotaanV;
					if (isset($_GET['KeanggotaanV'])) {
						$anggota->attributes = $_GET['KeanggotaanV'];
						$anggota->golonganpegawai_id = $_GET['KeanggotaanV']['golonganpegawai_id'];
					}
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->search(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table table-striped table-condensed',
					'columns'=>array(

						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadAnggotaAjax("'.$data->nokeanggotaan.'"); $("#dialog_anggota").modal("hide"); return false;'));
							},
						),
						'nokeanggotaan',
						array (
							'header'=>'NIP',
							'name'=>'nomorindukpegawai',
							'value'=>'$data->nomorindukpegawai',
						), /*
						array(
							'header'=>'No Kartu PNS',
							'name'=>'no_kartupegawainegerisipil',
						), */
						//'pegawai.nomorindukpegawai',
						//'pegawai.no_kartupegawainegerisipil',
						//'pegawai_id',
						//'pegawai.noidentitas',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
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
							'value'=>'$data->jeniskelamin',
							'filter'=>CHtml::activeDropDownList($anggota, 'jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
						),
						/*array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'empty($data->unit_id)?"-":$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						),*/
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>function ($data) {
									$pegawai = PegawaiM::model()->findByPK($data->pegawai_id);
									return empty($pegawai->golonganpegawai_id)?'-':$pegawai->golonganpegawai->golonganpegawai_nama;
							},
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
					),
				));
				?>
			</div>
		</div>
	</div>
</div>

<!-- Dialog Simpana Pegawai -->
<div class="modal fade custom-width" id="dialog_simpanan">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Data Simpanan</h4>
			</div>
			<div class="modal-body">
				<?php
					$simpanan = new KartusimpananV();
					if (isset($_GET['KartusimpananV'])) {
						$simpanan->attributes = $_GET['KartusimpananV'];
                                                if (isset($_GET['KartusimpananV']['pegawai_id']))
                                                    $simpanan->pegawai_id = $_GET['KartusimpananV']['pegawai_id'];
					}
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'simpanan-m-grid',
					'dataProvider'=>$simpanan->search(),
					'filter'=>$simpanan,
					'itemsCssClass' => 'table table-striped table-condensed',
					'columns'=>array(

						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadSimpananAjax("'.$data->nosimpanan.'"); $("#dialog_simpanan").modal("hide"); return false;'));
							},
						),
						'nosimpanan',
					/*	array (
							'header'=>'NIP',
							'name'=>'nomorindukpegawai',
							'value'=>'$data->nomorindukpegawai',
						), */
            /*
						array(
							'header'=>'No Kartu PNS',
							'name'=>'no_kartupegawainegerisipil',
						), */
						//'pegawai.nomorindukpegawai',
						//'pegawai.no_kartupegawainegerisipil',
						//'pegawai_id',
						//'pegawai.noidentitas',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
						),
					/*	array(
							'header'=>'Tempat Lahir',
							'name'=>'tempatlahir_pegawai',
						), */
						// 'pegawai.tempatlahir_pegawai',
				/*		array(
							'header'=>'Tanggal Lahir',
							'name'=>'tgl_lahirpegawai',
							'filter'=>false,
							'type'=>'raw',
							'value'=>'date("d/m/Y", strtotime($data->tgl_lahirpegawai))',
						), */
						array(
							'header'=>'Jenis Kelamin',
							'name'=>'jeniskelamin',
							'value'=>'$data->jeniskelamin',
							'filter'=>CHtml::activeDropDownList($anggota, 'jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
						),
						/*array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'empty($data->unit_id)?"-":$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						),*/
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>function ($data) {
									$pegawai = PegawaiM::model()->findByPK($data->pegawai_id);
									return empty($pegawai->golonganpegawai_id)?'-':$pegawai->golonganpegawai->golonganpegawai_nama;
							},
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
					),
				));
				?>
			</div>
		</div>
	</div>
</div>
