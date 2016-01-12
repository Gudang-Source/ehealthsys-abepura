<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<div class="search-form" style="">
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
    ?>
    <fieldset class='box'>
		<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group ">
					<?php echo $form->labelEx($model, 'periodeposting_id', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php 
							echo $form->dropDownList($model, 'periodeposting_id', CHtml::listData(AKPeriodepostingM::model()->findAll(),'periodeposting_id','deskripsiperiodeposting'), array('empty' => '-- Pilih --',
							'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm'));
						?>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<?php echo CHtml::label('Unit Kerja', 'Unit Kerja', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
							echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama asc')),
								'ruangan_id','ruangan_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
						?>
					</div>
				</div>			
			</div>
		</div>
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
					array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/LaporanArusKas'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);')); ?>
		</div>
    </fieldset>
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
