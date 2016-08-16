<div class="white-container">
    <legend class="rim2">Transaksi <b>Penilaian Pegawai</b></legend>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'sapegawai-m-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
		'focus'=>'#',
)); ?>
<?php
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash("success","Data berhasil disimpan!");
}
?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box" id="form-pegawai">  
	<legend class='rim'><span class='judul'>Data Pegawai </span>&nbsp;<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPegawaiReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data pegawai')); ?></span></legend>
	<div class="row-fluid">
		 <?php $this->renderPartial('_dataPegawai',array('model'=>$model,'modPegawai'=>$modPegawai,'form'=>$form)); ?>
	</div>
</fieldset>
<div id="form-riwayat">
	<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'tabel-riwayatpenilaian',
            'content'=>array(
                'content-detailpenilaian'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Riwayat Penilaian')).'<b> Tabel Riwayat Penilaian</b>',
                    'isi'=>$this->renderPartial('_tabelRiwayatPenilaian',array(
                            'tabelPenilaian'=>$tabelPenilaian,
                            'format'=>$format,
                            ),true),
                    'active'=>true,
                    ),   
                ),
	)); ?>  
</div>
<div class="block-tabel" id="fieldset-tabelpenilaian">  
    <h6>Tabel <b>Penilaian</b></h6>
        <?php $this->renderPartial('_tabelPenilaian',array('model'=>$model,'form'=>$form,'modPenilaianPegawaiDet'=>$modPenilaianPegawaiDet)); ?>
</div>
<fieldset class="box" id="fieldset-datapenilaian">
	<legend class='rim'>Data Penilaian</legend>
	<div class="row-fluid">
		 <?php $this->renderPartial('_dataPenilaian',array('model'=>$model,'form'=>$form)); ?>
	</div>
</fieldset>
<div class="form-actions">
	<?php 
	if(isset($_GET['sukses'])){
		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 
						'type'=>'button',
						'disabled'=>true));
	}else{
		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 
						'type'=>'button', 
						'onclick'=>'cekValiditas();', 
						'onkeypress'=>'cekValiditas();',
						'disabled'=>false));
	}
	?>
	<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			$this->createUrl($this->id.'/index'), 
			array('class'=>'btn btn-danger',
				  'onclick'=>'return refreshForm(this);')); ?>
	<?php 
	if(isset($_GET['sukses'])){
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
	}else{
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>true,'type'=>'button'));
	}
	?>
	<?php ?>
	<?php $this->widget('UserTips',array('type'=>'list'));?>
</div>
<?php $this->renderPartial('_jsFunctions',array('model'=>$model,'modPenilaianPegawaiDet'=>$modPenilaianPegawaiDet)); ?>
<?php $this->endWidget(); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM;
$modPegawai->pegawai_aktif = TRUE;

if (isset($_GET['PegawaiM']))
    $modPegawai->attributes = $_GET['PegawaiM'];
    $modPegawai->pegawai_aktif = TRUE;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modPegawai->search(),
	'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
                                          setDataPegawai(\"$data->pegawai_id\");
                                          $(\"#dialogPegawai\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),            
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->namaLengkap',
            'name' => 'nama_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),            
         array(
            'header' => 'Tempat Lahir',
            'value' => '$data->tempatlahir_pegawai',
            'name' => 'tempatlahir_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'tempatlahir_pegawai', array('class'=>'hurufs-only'))
        ),       
        array(
            'header'=>'Tanggal Lahir',
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter'=> $this->widget('MyDateTimePicker', array(
                    'model'=>$modPegawai, 
                    'attribute'=>'tgl_lahirpegawai', 
                    'mode' => 'date',                       
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date',
                        'size' => '10',
                        'style'=>'width:80%'
                    ),
                    'options' => array(  // (#3)                    
                        'dateFormat' => Params::DATE_FORMAT,                    
                        'maxDate' => 'd',                  
                ), 
                ),
                true),            
        ),
        array(
            'header'=>'Jenis Kelamin',
            'value'=>'$data->jeniskelamin',
            'filter' => Chtml::dropDownList('PegawaiM[jeniskelamin]',$modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --'))
        ),        
        array(
            'header'=>'Status Perkawinan',
            'value'=>'$data->statusperkawinan',
            'filter' => Chtml::dropDownList('PegawaiM[jabatan_id]',$modPegawai->jabatan_id, LookupM::getItems('statusperkawinan'), array('empty'=>'-- Pilih --'))
        ),    
        array(
            'header'=>'Jabatan',
            'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
            'filter'=> Chtml::dropDownList('PegawaiM[jabatan_id]',$modPegawai->jabatan_id, Chtml::ListData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'), array('empty'=>'-- Pilih --'))
        ),
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });    
            reinstallDatePicker();'    
    . '}',
));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>


<!------------------------------- Dialog Untuk Penilai --------------------------- -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPenilai',
    'options'=>array(
        'title'=>'Daftar Pegawai - Pilih Penilai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai2 = new PegawaiM;
if (isset($_GET['PegawaiM']))
    $modPegawai2->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai2-m-grid',
	'dataProvider'=>$modPegawai2->search(),
	'filter'=>$modPegawai2,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
									setDataPenilai(\"$data->pegawai_id\");
									$(\"#dialogPenilai\").dialog(\"close\");    
									return false;
                                "))',
        ),
         array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),            
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->namaLengkap',
            'name' => 'nama_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),            
         array(
            'header' => 'Tempat Lahir',
            'value' => '$data->tempatlahir_pegawai',
            'name' => 'tempatlahir_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'tempatlahir_pegawai', array('class'=>'hurufs-only'))
        ),       
        array(
            'header'=>'Tanggal Lahir',
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter'=> $this->widget('MyDateTimePicker', array(
                    'model'=>$modPegawai, 
                    'attribute'=>'tgl_lahirpegawai', 
                    'mode' => 'date',                       
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date1',
                        'size' => '10',
                        'style'=>'width:80%'
                    ),
                    'options' => array(  // (#3)                    
                        'dateFormat' => Params::DATE_FORMAT,                    
                        'maxDate' => 'd',
                    ),                  
                ), 
                true),
        ),           
        array(
            'header'=>'Jenis Kelamin',
            'value'=>'$data->jeniskelamin',
            'filter' => Chtml::dropDownList('PegawaiM[jeniskelamin]',$modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --'))
        ),        
        array(
            'header'=>'Status Perkawinan',
            'value'=>'$data->statusperkawinan',
            'filter' => Chtml::dropDownList('PegawaiM[jabatan_id]',$modPegawai->jabatan_id, LookupM::getItems('statusperkawinan'), array('empty'=>'-- Pilih --'))
        ),    
        array(
            'header'=>'Jabatan',
            'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
            'filter'=> Chtml::dropDownList('PegawaiM[jabatan_id]',$modPegawai->jabatan_id, Chtml::ListData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'), array('empty'=>'-- Pilih --'))
        ),
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });    
            reinstallDatePicker1();'    
    . '}',
));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker1', "
function reinstallDatePicker1(id, data) {        
    $('#datepicker_for_due_date1').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>

<!------------------------------- Dialog Untuk Pimpinan --------------------------- -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPimpinan',
    'options'=>array(
        'title'=>'Daftar Pegawai - Pilih Pimpinan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai3 = new PegawaiM;
if (isset($_GET['PegawaiM']))
    $modPegawai3->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai3-m-grid',
	'dataProvider'=>$modPegawai3->search(),
	'filter'=>$modPegawai3,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
									setDataPimpinan(\"$data->pegawai_id\");
									$(\"#dialogPimpinan\").dialog(\"close\");    
									return false;
                                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),            
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->namaLengkap',
            'name' => 'nama_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),            
         array(
            'header' => 'Tempat Lahir',
            'value' => '$data->tempatlahir_pegawai',
            'name' => 'tempatlahir_pegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'tempatlahir_pegawai', array('class'=>'hurufs-only'))
        ),       
        array(
            'header'=>'Tanggal Lahir',
            'name' => 'tgl_lahirpegawai',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter'=> $this->widget('MyDateTimePicker', array(
                    'model'=>$modPegawai, 
                    'attribute'=>'tgl_lahirpegawai', 
                    'mode' => 'date',                       
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date2',
                        'size' => '10',
                        'style'=>'width:80%'
                    ),
                    'options' => array(  // (#3)                    
                        'dateFormat' => Params::DATE_FORMAT,                    
                        'maxDate' => 'd',
                    ),
                  
                ), 
                true),
        ),           
        array(
            'header'=>'Jenis Kelamin',
            'value'=>'$data->jeniskelamin',
            'filter' => Chtml::dropDownList('PegawaiM[jeniskelamin]',$modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --'))
        ),        
        array(
            'header'=>'Status Perkawinan',
            'value'=>'$data->statusperkawinan',
            'filter' => Chtml::dropDownList('PegawaiM[jabatan_id]',$modPegawai->jabatan_id, LookupM::getItems('statusperkawinan'), array('empty'=>'-- Pilih --'))
        ),    
        array(
            'header'=>'Jabatan',
            'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
            'filter'=> Chtml::dropDownList('PegawaiM[jabatan_id]',$modPegawai->jabatan_id, Chtml::ListData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"),'jabatan_id','jabatan_nama'), array('empty'=>'-- Pilih --'))
        ),
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });    
            reinstallDatePicker2();'    
    . '}',
));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker2', "
function reinstallDatePicker2(id, data) {        
    $('#datepicker_for_due_date2').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>