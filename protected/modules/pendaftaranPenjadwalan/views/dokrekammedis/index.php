<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#search').submit(function(){
			$.fn.yiiGridView.update('ppdokumenpasienrmbaru-v-grid', {
				data: $(this).serialize()
			});
			return false;
		});
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
	<?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Pengiriman Dokumen Rekam Medis berhasil disimpan!");
        }
    ?>
    <legend class="rim2">Kirim <b>Berkas RM</b></legend>

	<fieldset class="box">
		<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form">
    <?php $this->renderPartial('_searchPasienBaru',array(
        'model'=>$model,'format'=>$format
    )); ?>
    </div><!-- search-form -->
	</fieldset>
    <br/>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'ppdokrekammedis-m-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
		'focus'=>'#'.CHtml::activeId($modPengiriman,'petugaspengirim'),
	)); ?>
	<div class="block-tabel">
		<h6>Tabel Pengiriman <b>Dokumen Rekam Medis</b></h6>        
		<?php echo $this->renderPartial('_tabelPengiriman',array('model'=>$model)); ?>
	</div>	
    
	<?php echo $form->errorSummary($modDokRekamMedis); ?>
	<fieldset class="box">
        <legend class="rim">Pengiriman Dokumen Rekam Medis</legend>
		<?php $this->renderPartial('_formPengiriman',array('form'=>$form,'modDokRekamMedis'=>$modDokRekamMedis,'modPengiriman'=>$modPengiriman)); ?>
	</fieldset>
	
	<div class="form-actions">
		<?php 
			if(!isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button','onKeypress'=>'cekInputan();','onclick'=>'cekInputan();')); 
			}else {
				echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('disabled'=>true,'class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
			}
		?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
								$this->createUrl($this->id.'/index'), 
								array('class'=>'btn btn-danger',
									'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
		
		<?php 
			$content = $this->renderPartial('tips/dokrekamedis',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?>   
	</div>
</div>
<?php $this->endWidget(); ?>

<!-- ======================== Begin Widget Dialog Petugas Pengirim ============================= -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasPengirim',
    'options' => array(
        'title' => 'Petugas Pengirim',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<?php 
$modPetugasPengirim = new PPPegawaiV('searchDialog');
$modPetugasPengirim->unsetAttributes();
if(isset($_GET['PPPegawaiV'])) {
    $modPetugasPengirim->attributes = $_GET['PPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugaspengirim-grid',
	'dataProvider'=>$modPetugasPengirim->searchDialog(),
	'filter'=>$modPetugasPengirim,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
					"href"=>"",
					"id" => "selectPetugasPengirim",
					"onClick" => "
								  $(\"#'.CHtml::activeId($modPengiriman,'petugaspengirim').'\").val(\"$data->nama_pegawai\");
								  $(\"#dialogPetugasPengirim\").dialog(\"close\"); 
								  return false;
						"))',
		),
		array(
			'header'=>'NIP',
			'filter'=>  CHtml::activeTextField($modPetugasPengirim, 'nomorindukpegawai'),
			'value'=>'$data->nomorindukpegawai',
		),
		array(
			'header'=>'Nama Pegawai',
			'filter'=>  CHtml::activeTextField($modPetugasPengirim, 'nama_pegawai'),
			'value'=>'$data->nama_pegawai',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); ?>
<!-- =============================== endWidget Dialog Petugas Pengirim ============================ -->

<?php $this->renderPartial('_jsFunctions',array('modDokRekamMedis'=>$modDokRekamMedis)); ?>