<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="span4">
	<div class="control-group">
		<?php echo CHtml::activeLabel($modInfoPasien, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'tgl_pendaftaran', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'pendaftaran_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'pasien_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'pasienadmisi_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'kelaspelayanan_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'carabayar_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'penjamin_id', array('readonly'=>true)); ?>
			<?php echo CHtml::activeHiddenField($modInfoPasien, 'jeniskasuspenyakit_id', array('readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="control-group">
		 <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
		 <div class="controls">
			 <?php 
				 $this->widget('MyJuiAutoComplete', array(
					'name'=>'no_pendaftaran',
					'value'=>$modInfoPasien->no_pendaftaran,
					'source'=>'js: function(request, response) {
								   $.ajax({
									   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
									   dataType: "json",
									   data: {
										   no_pendaftaran: request.term,
										   instalasi_id: $("#instalasi_id").val(),
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
					 'options'=>array(
						   'minLength' => 4,
							'focus'=> 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
						   'select'=>'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
								return false;
							}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogPasien'),
					'htmlOptions'=>array('placeholder'=>'Ketik No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
						),
				)); 
			 ?>
		 </div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($modInfoPasien, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($modInfoPasien, 'dokter_pemeriksa', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'nama_pegawai', array('readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_nama', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'kelaspelayanan_nama', array('readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($modInfoPasien, 'umur',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'umur', array('readonly'=>true)); ?>
		</div>
	</div>
</div>
<div class="span5">
	<div class="control-group">
		<?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
		<div class="controls">
			<?php 
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'no_rekam_medik',
					'value'=>$modInfoPasien->no_rekam_medik,
					'source'=>'js: function(request, response) {
								   $.ajax({
									   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
									   dataType: "json",
									   data: {
										   no_rekam_medik: request.term,
										   instalasi_id: $("#instalasi_id").val(),
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
					 'options'=>array(
						   'minLength' => 4,
							'focus'=> 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
						   'select'=>'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
								return false;
							}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogPasien'),
					'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
						),
				)); 
			?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class'=>'control-label required')); ?>
		<div class="controls">
			<?php echo CHtml::hiddenField('namadepan',$modInfoPasien->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
			<?php 
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'nama_pasien',
					'value'=>$modInfoPasien->nama_pasien,
					'source'=>'js: function(request, response) {
								   $.ajax({
									   url: "'.$this->createUrl('AutocompleteInfoPasien').'",
									   dataType: "json",
									   data: {
										   nama_pasien: request.term,
										   instalasi_id: $("#instalasi_id").val(),
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
					 'options'=>array(
						   'minLength' => 2,
							'focus'=> 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
						   'select'=>'js:function( event, ui ) {
								$(this).val( ui.item.value);
								setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
								return false;
							}',
					),
					'htmlOptions'=>array('placeholder'=>'Ketik Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						),
				)); 
			?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($modInfoPasien, 'nama_bin',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'nama_bin', array('readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::activeLabel($modInfoPasien, 'jeniskelamin',array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeTextField($modInfoPasien, 'jeniskelamin', array('readonly'=>true)); ?>
		</div>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::Label('No. Kamar / No. Bed','', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php if(isset($modInfoPasien->kamarruangan_id)){ ?>
			<?php echo CHtml::activeTextField($modInfoPasien, 'kamarruangan_nokamar', array('readonly'=>true, 'style'=>'width:40%')); ?> /
			<?php echo CHtml::activeTextField($modInfoPasien, 'kamarruangan_nobed', array('readonly'=>true, 'style'=>'width:40%')); ?>
			<?php }else{ ?>
			<?php echo CHtml::TextField('kamarruangan_nokamar', '', array('readonly'=>true, 'style'=>'width:40%')); ?> /
			<?php echo CHtml::TextField('kamarruangan_nobed', '', array('readonly'=>true, 'style'=>'width:40%')); ?>
			<?php } ?>
		</div>
	</div>
</div>
<div class="span3">
	<div align="center">
        <?php 
        $url_photopasien = (!empty($modInfoPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modInfoPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
    </div>
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogPasien = new RIInfopasienmasukkamarV('searchDialogKunjungan');
    $modDialogPasien->unsetAttributes();
    if(isset($_GET['RIInfopasienmasukkamarV'])) {
        $modDialogPasien->attributes = $_GET['RIInfopasienmasukkamarV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'datakunjungan-grid',
		'dataProvider'=>$modDialogPasien->searchDialogKunjungan(),
		'filter'=>$modDialogPasien,
		'template'=>"{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
				array(
					'header'=>'Pilih',
					'type'=>'raw',
					'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPendaftaran",
									"onClick" => "
										setInfoPasien($data->pendaftaran_id, \"\", \"\", \"\");
										$(\"#dialogPasien\").dialog(\"close\");
									"))',
				),
				'no_pendaftaran',
				array(
					'name'=>'tgl_pendaftaran',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
					'filter'=> false,
				),
				array(
					'name'=>'no_rekam_medik',
					'type'=>'raw',
					'value'=>'$data->no_rekam_medik',
				),
				'nama_pasien',
				array(
					'name'=>'jeniskelamin',
					'type'=>'raw',
					'filter'=>LookupM::model()->getItems('jeniskelamin'),
				),
				array(
					'name'=>'ruangan_nama',
					'type'=>'raw',
				),
				array(
					'name'=>'carabayar_nama',
					'type'=>'raw',
					'value'=>'$data->carabayar_nama',
				),


		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
$this->endWidget();
////======= end pendaftaran dialog =============
?>