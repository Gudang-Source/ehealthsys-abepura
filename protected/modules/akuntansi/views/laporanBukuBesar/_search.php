<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<div class="search-form" style="">
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
?>
<style>

label.checkbox{
        width:150px;
        display:inline-block;
}
</style>
<fieldset class='box'>
    <legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
	<div class="row-fluid">
		<div class="span6">
			<!-- LNG-5705 -->
<!--			<div class="control-group ">
				<?php // echo $form->labelEx($modelLaporan, 'periodeposting_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php 
//						echo $form->dropDownList($modelLaporan, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll(),'periodeposting_id','periodeposting_nama'), array('empty' => '-- Pilih --',
//						'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
					?>
				</div>
			</div>-->
			<div class="control-group">
				<label class = 'control-label'>
					<?php echo CHtml::activeCheckBox($modelLaporan,'is_tglposting',array('onClick'=>'cekTanggal()','rel'=>'tooltip','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal posting')); ?>
					Tgl. Posting
				</label>
				<div class="controls">  
					<?php
					$modelLaporan->tgl_posting_awal = isset($modelLaporan->tgl_posting_awal) ? MyFormatter::formatDateTimeForUser($modelLaporan->tgl_posting_awal) : date('d M Y');
					$this->widget('MyDateTimePicker', array(
						'model' => $modelLaporan,
						'attribute' => 'tgl_posting_awal',
						'mode' => 'date',
	//                                          'maxDate'=>'d',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,'class'=>'dtPicker2',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>

			<div class="control-group">
				<label class = 'control-label'>
					<?php echo CHtml::activeCheckBox($modelLaporan,'is_tgltransaksi',array('onClick'=>'cekTanggal()','rel'=>'tooltip','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal transaksi')); ?>
					Tgl. Transaksi
				</label>
				<div class="controls">  
					<?php
					$modelLaporan->tgl_transaksi_awal = isset($modelLaporan->tgl_transaksi_awal) ? MyFormatter::formatDateTimeForUser($modelLaporan->tgl_transaksi_awal) : date('d M Y');
					$this->widget('MyDateTimePicker', array(
						'model' => $modelLaporan,
						'attribute' => 'tgl_transaksi_awal',
						'mode' => 'date',
	//                                          'maxDate'=>'d',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,'class'=>'dtPicker2',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>

			<div class="control-group">
				<?php echo CHtml::label('Unit Kerja', 'Unit Kerja', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                        echo $form->dropDownList($modelLaporan,'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE ORDER BY ruangan_nama ASC"),'ruangan_id', 'ruangan_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
                    ?>
                </div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')); ?>
				<div class="controls">  
					<?php
					$modelLaporan->tgl_posting_akhir = isset($modelLaporan->tgl_posting_akhir) ? MyFormatter::formatDateTimeForUser($modelLaporan->tgl_posting_akhir) : date('d M Y');
					$this->widget('MyDateTimePicker', array(
						'model' => $modelLaporan,
						'attribute' => 'tgl_posting_akhir',
						'mode' => 'date',
	//                                          'maxDate'=>'d',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,'class'=>'dtPicker2',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
                
			<div class="control-group">
				<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')); ?>
				<div class="controls">  
					<?php
					$modelLaporan->tgl_transaksi_akhir = isset($modelLaporan->tgl_transaksi_akhir) ? MyFormatter::formatDateTimeForUser($modelLaporan->tgl_transaksi_akhir) : date('d M Y');
					$this->widget('MyDateTimePicker', array(
						'model' => $modelLaporan,
						'attribute' => 'tgl_transaksi_akhir',
						'mode' => 'date',
	//                                          'maxDate'=>'d',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,'class'=>'dtPicker2',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
                    
			<div class='control-group'>
				<?php echo CHtml::label('Kode Rekening','koderekening', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php 
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modelLaporan,
							'attribute' => 'koderekening',
							'sourceUrl' => $this->createUrl('AutocompleteKodeRekening'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ) {
										$(this).val(ui.item.koderekening);
										return false;
								}',
								'select' => 'js:function( event, ui ) {
									$(this).val(ui.item.value);
									$("#' . CHtml::activeId($modelLaporan, 'kdrekening1') . '").val(ui.item.kdrekening1);
									$("#' . CHtml::activeId($modelLaporan, 'kdrekening2') . '").val(ui.item.kdrekening2);
									$("#' . CHtml::activeId($modelLaporan, 'kdrekening3') . '").val(ui.item.kdrekening3);
									$("#' . CHtml::activeId($modelLaporan, 'kdrekening4') . '").val(ui.item.kdrekening4);
									$("#' . CHtml::activeId($modelLaporan, 'kdrekening5') . '").val(ui.item.kdrekening5);
									return false;             
								}'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder'=>'Ketikan Kode Rekening',
								'class'=>'span3',
								'style'=>'width:150px;',
							),
						));
					?>
					<?php echo $form->hiddenField($modelLaporan,'kdrekening1',array('readonly'=>true,'class'=>'span3'));?>
					<?php echo $form->hiddenField($modelLaporan,'kdrekening2',array('readonly'=>true,'class'=>'span3'));?>
					<?php echo $form->hiddenField($modelLaporan,'kdrekening3',array('readonly'=>true,'class'=>'span3'));?>
					<?php echo $form->hiddenField($modelLaporan,'kdrekening4',array('readonly'=>true,'class'=>'span3'));?>
					<?php echo $form->hiddenField($modelLaporan,'kdrekening5',array('readonly'=>true,'class'=>'span3'));?>
				</div>
			</div>
			
			<div class='control-group'>
				<?php echo CHtml::label('Nama Rekening','namarekening', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modelLaporan,
							'attribute' => 'namarekening',
							'name'=>'namarekening',
							'sourceUrl' => $this->createUrl('AutocompleteNamaRekening'),
							'options' => array(
								'showAnim' => 'fold',
								'minLength' => 2,
								'focus' => 'js:function( event, ui ){
									return false;
								}',
								'select' => 'js:function( event, ui ){
									$(this).val(ui.item.value);  
									return false;
								}'
							),
							'htmlOptions' => array(
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'placeholder'=>'Ketikan Nama Rekening',
								'class'=>'span3',
								'style'=>'width:150px;',
							),
						));
					?>
				</div>
			</div>
		</div>
	</div>
	
    <div class="form-actions">
        <?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
				array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
        
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/Index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);')); ?>
    </div>
</div>  
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
cekTanggal();
function cekTanggal(){
    var is_tglposting = $('#<?php echo CHtml::activeId($modelLaporan,'is_tglposting'); ?>');
	var is_tgltransaksi = $('#<?php echo CHtml::activeId($modelLaporan,'is_tgltransaksi'); ?>');
    var pilih_tglposting = is_tglposting.attr('checked');
    var pilih_tgltransaksi = is_tgltransaksi.attr('checked');
    if(is_tglposting.is(":checked")){
		is_tglposting.attr('checked',true);
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_posting_awal'); ?>_date').attr("style","display:block;");
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_posting_akhir'); ?>_date').attr("style","display:block;");
		is_tgltransaksi.removeAttr('checked',true);
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_transaksi_awal'); ?>_date').attr("style","display:none;");
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_transaksi_akhir'); ?>_date').attr("style","display:none;");
    }else{
        is_tglposting.removeAttr('checked',true);
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_posting_awal'); ?>_date').attr("style","display:none;");
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_posting_akhir'); ?>_date').attr("style","display:none;");
		is_tgltransaksi.attr('checked',true);
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_transaksi_awal'); ?>_date').attr("style","display:block;");
		$('#<?php echo CHtml::activeId($modelLaporan,'tgl_transaksi_akhir'); ?>_date').attr("style","display:block;");
    }
}    
</script>