
<!-- Dialog pengurus koperasi -->
<div class="modal fade custom-width" id="dialog_pegawai_pengurus">
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
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table table-striped table-bordered table-condensed',
					'columns'=>array(
						array(
							'header'=>'Pilih',
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pegawai_pengurus").modal("hide"); return false;'));
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
							'value'=>'!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Pangkat',
							'type'=>'raw',
							'value'=>'!empty($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
							'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
							),
						array(
							'header'=>'Golongan',
							'type'=>'raw',
							'value'=>'!empty($data->golonganpegawai_id)?$data->golonganpegawai->golonganpegawai_nama:"-"',
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


<!-- Dialog informasi detail angsuran -->
<div class="modal fade custom-width" id="dialog_informasi_angsuran">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Detail Angsuran</h4>
			</div>
			<div class="modal-body">
			<?php $angsuran = new KartuangsurananggotaV; ?>
			<div class="form-horizontal">
				<div class="panel panel-body">
					<div class="panel-body col-sm-6">
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'nama_anggota', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'nama_pegawai',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'nomor_anggota', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'nokeanggotaan',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
                                            <?php /*
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'namaunit', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'namaunit',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div> */ ?>
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'golonganpegawai_nama', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'golonganpegawai_nama',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
					</div>
					<div class="panel-body col-sm-6" style="border-top: 0px !important;">
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'tgl_pinjaman', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'tglpinjaman',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'no_pinjaman', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'no_pinjaman',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'jml_pinjaman', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'jml_pinjaman',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
						<div class="form-group">
							<?php echo CHtml::activeLabelEx($angsuran, 'jasapinjaman', array('class'=>'control-label col-sm-4')); ?>
							<div class="col-sm-8">
								<?php echo CHtml::activeTextField($angsuran,'jasapinjaman',array('readonly'=>true,'class'=>'form-control')); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		<?php //echo CHtml::activeHiddenField($angsuran,'no_pinjaman');
		if (isset($_GET['KartuangsurananggotaV'])) {
			//$angsuran->attributes = $_GET['KartuangsurananggotaV'];
			$angsuran->no_pinjaman = $_GET['KartuangsurananggotaV']['no_pinjaman'];
		}	
		$provider = $angsuran->searchInformasi();
		$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'kartuangsuran-m-grid',
				'dataProvider'=>$provider,
				'filter'=>null,'summaryText'=>'',
				'itemsCssClass' => 'table table-striped table-bordered table-condensed',
				'columns'=>array(
					array(
						'header'=>'Angsuran Ke',
						'type'=>'raw',
						'value'=>'$data->angsuran_ke',
						'htmlOptions'=>array('style'=>'text-align:center'),
					),
					array(
						'header'=>'Tgl Angsuran',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tglangsuran))',
					),
					array(
						'header'=>'Tgl Jatuh Tempo',
						'type'=>'raw',
						'value'=>'date("d/m/Y", strtotime($data->tgljatuhtempoangs))',
						'footer'=>'<b>Total</b>',
           			'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
					),
					array(
						'header'=>'Angsuran Pokok',
						'type'=>'raw',
						'value'=>'empty($data->jmlpokok_angsuran)?"-":MyFormatter::formatNumberForPrint($data->jmlpokok_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($angsuran->getTotAP($provider)),
           			'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'type'=>'raw',
						'value'=>'empty($data->jmljasa_angsuran)?"-":MyFormatter::formatNumberForPrint($data->jmljasa_angsuran)',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($angsuran->getTotJA($provider)),
           			'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
					),
					array(
						'header'=>'Total Angsuran',
						'type'=>'raw',
						'value'=>'MyFormatter::formatNumberForPrint(
							(empty($data->jmlpokok_angsuran)?0:$data->jmlpokok_angsuran) + 
							(empty($data->jmljasa_angsuran)?0:$data->jmljasa_angsuran))',
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($angsuran->getSubTotAng($provider)),
           			'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
					),
					array(
						'header'=>'Sisa Angsuran',
						'type'=>'raw',
						'value'=>function($data) {
							$angsuran = JmlangsuranT::model()->findByPk($data->jmlangsuran_id);
							return MyFormatter::formatNumberForPrint($angsuran->sisa);
						},
						'htmlOptions'=>array('style'=>'text-align:right'),
						'footer'=>MyFormatter::formatNumberForPrint($angsuran->getTotSA($provider)),
           			'footerHtmlOptions'=>array('style'=>'text-align:right;color:#373E4A'),
					),
					array(
						'header'=>'Status Bayar',
						'type'=>'raw',
						'value'=>'($data->isudahbayar)? "LUNAS":"BELUM LUNAS"',
					),
				),
			));
		?>		
				</div>
		</div>
	</div>
</div>
<script type="text/javascript">
//color font and hover header column
$('#kartuangsuran-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
	$('#kartuangsuran-m-grid').find("table >thead >tr >th").hover(function() {
	  $(this).css("color","#818DA2");
     },function(){
		  $(this).css("color","#373E4A");
	  });

$(document).ajaxSuccess(function() {
	//alert("An individual AJAX call has completed successfully");
	//$( "#pegawai-m-grid" ).find("table >thead").replaceWith(header);
	
   $('#kartuangsuran-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
	$('#kartuangsuran-m-grid').find("table >thead >tr >th").hover(function() {
	  $(this).css("color","#818DA2");
     },function(){
		  $(this).css("color","#373E4A");
	  });
});
</script>