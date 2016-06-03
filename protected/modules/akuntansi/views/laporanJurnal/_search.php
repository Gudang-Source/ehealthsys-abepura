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
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="row-fluid">
		<div class="span4">
			<?php echo CHtml::hiddenField('type', ''); ?>
			<div class = 'control-label'>Tgl. Posting</div>
			<div class="controls">  
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'tgl_awal',
					'mode' => 'datetime',
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
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
				<div class="controls">  
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'tgl_akhir',
						'mode' => 'datetime',
	//                                         'maxdate'=>'d',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,'class'=>'dtPicker2',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Jenis Jurnal', 'Jenis Jurnal', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
						echo $form->dropDownList($model,'jenisjurnal_id',CHtml::listData(JenisjurnalM::model()->findAll(),
								'jenisjurnal_id','jenisjurnal_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
					?>
				</div>
			</div>
		</div>
	</div>
    <div class="form-actions">
        <?php
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
				array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
        
        <?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/Index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
		?>
    </div>
</fieldset>
</div> 
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->	controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
