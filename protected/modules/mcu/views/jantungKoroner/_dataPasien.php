<?php
if(!empty($modPasien)){
?>
<fieldset class="box">
    <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<?php echo CHtml::label("NIP", 'nomorindukpegawai', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPegawai, 'nomorindukpegawai', array('readonly'=>true)); ?>					
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::label("".$modPasien->getAttributeLabel('no_rekam_medik'), 'no_rekam_medik', array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?>
					<?php echo CHtml::activeHiddenField($modPasien, 'pasien_id', array('readonly'=>true)); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Status Merokok', '',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('status_merokok', '', array('readonly'=>false)); ?>
				</div>
			</div>
		</div>
		
		<div class="span6">
			<div class="control-group">
				<?php echo CHtml::label('Total Kolesterol', '',array('class'=>'control-label required')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner,'total_kolesterol',array('readonly'=>false,'class'=>'span1','onblur'=>'setLevelTotKolesterol();')); ?>
					<?php echo CHtml::dropDownList('total_kolesterol','',CHtml::listData(KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Cholesterol Total'"), 'klasifikasiatp_id', 'klasifikasiatp_nama'),
                                                          array('style'=>'width:160px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
					<?php echo $form->textField($modJantungKoroner, 'total_kolesterol_level', array('placeholder'=>'Level Koresterol','readonly'=>true,'class'=>'span2')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('Triglyceride', '',array('class'=>'control-label required')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner,'triglycerida',array('readonly'=>false,'class'=>'span1','onblur'=>'setLevelTriglycerida();')); ?>
					<?php echo CHtml::dropDownList('triglyceride','',CHtml::listData(KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Trigliserida'"), 'klasifikasiatp_id', 'klasifikasiatp_nama'),
                                                          array('style'=>'width:160px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
					<?php echo $form->textField($modJantungKoroner, 'triglycerida_level', array('placeholder'=>'Level Triglycerid','readonly'=>true,'class'=>'span2')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('HDL Kolesterol', '',array('class'=>'control-label required')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner,'hdl_kolesterol',array('readonly'=>false,'class'=>'span1','onblur'=>'setLevelHdl();')); ?>
					<?php echo CHtml::dropDownList('hdl_kolesterol','',CHtml::listData(KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Cholesterol HDL'"), 'klasifikasiatp_id', 'klasifikasiatp_nama'),
                                                          array('style'=>'width:160px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
					<?php echo $form->textField($modJantungKoroner, 'hdl_kolesterol_level', array('placeholder'=>'Level HDL','readonly'=>true,'class'=>'span2')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('LDL Kolesterol', '',array('class'=>'control-label required')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner,'ldl_kolesterol',array('readonly'=>false,'class'=>'span1','onblur'=>'setLevelLdl();')); ?>
					<?php echo CHtml::dropDownList('ldl_kolesterol','',CHtml::listData(KlasifikasiatpM::model()->findAll("klasifikasiatp_jenis='Cholesterol LDL'"), 'klasifikasiatp_id', 'klasifikasiatp_nama'),
                                                          array('style'=>'width:160px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
					<?php echo $form->textField($modJantungKoroner, 'ldl_kolesterol_level', array('placeholder'=>'Level LDL','readonly'=>true,'class'=>'span2')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('Tekanan Darah', '',array('class'=>'control-label required')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner,'tekanandarah',array('readonly'=>false,'class'=>'span1','onblur'=>'setLevelTekananDarah();')); ?>
					<?php echo CHtml::dropDownList('tekanan_darah','',LookupM::getItems('rangetdsistolic'),
                                                          array('style'=>'width:160px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo CHtml::label('Pernah menjalani pengobatan untuk tekanan darah', '',array('class'=>'control-label')); ?>
				<div class="controls form-inline">	
					<?php echo $form->radioButtonList($modJantungKoroner,'pengobatan_tekanandarah',array('Ya'=>'Ya', 'Tidak'=>'Tidak'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
				</div>
			</div>
		</div>
	</div>
</fieldset>

<?php
} else {
    Yii::app()->user->setFlash('error',"Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasien',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
    $modDataPasien = new MCPasienM('searchDialog');
    $modDataPasien->unsetAttributes();
    $format = new MyFormatter();
    $modDataPasien->ispasienluar = FALSE;
    if(isset($_GET['MCPasienM'])) {
        $modDataPasien->attributes = $_GET['MCPasienM'];
//        $modDataPasien->tanggal_lahir =  isset($_GET['MCPasienM']['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['MCPasienM']['tanggal_lahir']) : null;
        $modDataPasien->cari_kelurahan_nama = $_GET['MCPasienM']['cari_kelurahan_nama'];
        $modDataPasien->cari_kecamatan_nama = $_GET['MCPasienM']['cari_kecamatan_nama'];
		if(isset($_GET['MCPasienM']['nomorindukpegawai'])){
			$modDataPasien->nomorindukpegawai = $_GET['MCPasienM']['nomorindukpegawai'];
		}
        
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasien-m-grid',
            'dataProvider'=>$modDataPasien->searchDialog(),
            'filter'=>$modDataPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasien\").dialog(\"close\");
                                        "))',
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    'nama_bin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> LookupM::model()->getItems('jeniskelamin'),
                        'value'=>'$data->jeniskelamin'
                    ),
                
//                    array(
//                        'name'=>'tanggal_lahir',
//                        'type'=>'raw',
//                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
//                    ),
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$modDataPasien,
                                        'attribute'=>'tanggal_lahir',
                                        'mode'=>'date',
                                        'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),
                    'alamat_pasien',
                    'rw',
                    'rt',
                    array(
                        'header'=>'Nama Kelurahan',
                        'name'=>'cari_kelurahan_nama',
                        'type'=>'raw',
                        'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
                    ),
                    array(
                        'header'=>'Nama Kecamatan',
                        'name'=>'cari_kecamatan_nama',
                        'type'=>'raw',
                        'value'=>'$data->kecamatan->kecamatan_nama'
                    ),
                    'norm_lama',
                    array(
                        'name'=>'statusrekammedis',
                        'type'=>'raw',
                        'filter'=> LookupM::getItems('statusrekammedis'),
                        'value'=>'$data->statusrekammedis',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
    ));
    $this->endWidget();
    ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogPasienBadak',
        'options'=>array(
            'title'=>'Pencarian Data Pasien',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>1060,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
	
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pasienbadak-m-grid',
            'dataProvider'=>$modDataPasien->searchDialogBadak(),
            'filter'=>$modDataPasien,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                            setPasienLama(\"$data->pasien_id\");
                                            $(\"#dialogPasienBadak\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header'=>'NIP',
						'name'=> 'nomorindukpegawai',
                        'type'=>'raw',
                        'value'=>'$data->pegawai->nomorindukpegawai',
                    ),
                    'no_rekam_medik',
                    'nama_pasien',
                    'nama_bin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> LookupM::model()->getItems('jeniskelamin'),
                        'value'=>'$data->jeniskelamin'
                    ),
                
//                    array(
//                        'name'=>'tanggal_lahir',
//                        'type'=>'raw',
//                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
//                    ),
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$modDataPasien,
                                        'attribute'=>'tanggal_lahir',
                                        'mode'=>'date',
                                        'options'=> array(
                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tanggal_lahir','placeholder'=>'23 Jan 1993'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),
                    'alamat_pasien',
                    'rw',
                    'rt',
                    array(
                        'header'=>'Nama Kelurahan',
                        'name'=>'cari_kelurahan_nama',
                        'type'=>'raw',
                        'value'=>'isset($data->kelurahan_id) ? $data->kelurahan->kelurahan_nama : ""'
                    ),
                    array(
                        'header'=>'Nama Kecamatan',
                        'name'=>'cari_kecamatan_nama',
                        'type'=>'raw',
                        'value'=>'$data->kecamatan->kecamatan_nama'
                    ),
                    'norm_lama',
                    array(
                        'name'=>'statusrekammedis',
                        'type'=>'raw',
                        'filter'=> LookupM::getItems('statusrekammedis'),
                        'value'=>'$data->statusrekammedis',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
                
            
            }',
    ));
    $this->endWidget();
    ?>