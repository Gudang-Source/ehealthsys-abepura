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
						//$anggota->nomorindukpegawai = $_GET['KeanggotaanV']['nomorindukpegawai'];
						//$anggota->no _kartupegawainegerisipil = $_GET['KeanggotaanV']['no_kartupegawainegerisipil'];
						$anggota->nama_pegawai = $_GET['KeanggotaanV']['nama_pegawai'];
						//$anggota->noidentitas = $_GET['KeanggotaanV']['noidentitas'];
						$anggota->tempatlahir_pegawai = $_GET['KeanggotaanV']['tempatlahir_pegawai'];
						//$anggota->tgl_lahirpegawai = $_GET['KeanggotaanV']['tgl_lahirpegawai'];
						$anggota->jeniskelamin = $_GET['KeanggotaanV']['jeniskelamin'];
						$anggota->alamat_pegawai = $_GET['KeanggotaanV']['alamat_pegawai'];
						$anggota->unit_id = $_GET['KeanggotaanV']['unit_id'];
						$anggota->golonganpegawai_id = $_GET['KeanggotaanV']['golonganpegawai_id'];
					}
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->search(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table-bordered datatable dataTable',
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
							'value'=>'$data->nomorindukpegawai',
						),
						array(
							'header'=>'No Kartu PNS',
							'value'=>'$data->no_kartupegawainegerisipil',
						),
						/*array(
							'header'=>'No Identitas',
							'name'=>'noidentitas',
							'value'=>'$data->pegawai->noidentitas',
						),*/
						//'pegawai.nomorindukpegawai',
						//'pegawai.no_kartupegawainegerisipil',
						//'pegawai_id',
						//'pegawai.noidentitas',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
						),
						array(
							'header'=>'Tempat Lahir',
							'name'=>'tempatlahir_pegawai',
							'value'=>'$data->tempatlahir_pegawai',
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
							'filter'=>Params::getJenisKelamin(),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
							'value'=>'$data->alamat_pegawai',
						),
						array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'empty($data->unit_id)?"-":$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						),
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'value'=>'empty($data->golonganpegawai_id)?"-":$data->golonganpegawai_nama',
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
						),
						//'pegawai.jeniskelamin',
						//'pegawai.alamat_pegawai',
						/*
						array(
							'name'=>'pegawain.kelurahan_id',
							'value'=>'empty($data->kelurahan_id)?"-":$data->pegawai->kelurahan->kelurahan_nama',
							'filter'=>false,
						), */
						//'pegawai.unit.unit_nama',
						//'pegawai.golonganpegawai.golonganpegawai_nama',
						),

					));

				?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
//color font and hover header column
$('#anggota-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
	$('#anggota-m-grid').find("table >thead >tr >th").hover(function() {
	  $(this).css("color","#818DA2");
     },function(){
		  $(this).css("color","#373E4A");
	  });

$(document).ajaxSuccess(function() {
	//alert("An individual AJAX call has completed successfully");
	//$( "#pegawai-m-grid" ).find("table >thead").replaceWith(header);

   $('#anggota-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
	$('#anggota-m-grid').find("table >thead >tr >th").hover(function() {
	  $(this).css("color","#818DA2");
     },function(){
		  $(this).css("color","#373E4A");
	  });
});
</script>
