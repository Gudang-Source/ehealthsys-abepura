<style>

label.checkbox{
        width:150px;
        display:inline-block;
}
</style>
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
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
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
                    <?php /*
			<div class="span6">
				<div class="control-group">
					<?php echo //CHtml::label('Unit Kerja', 'Unit Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                           // echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),
							//	'ruangan_id','ruangan_nama'),array('class'=>'span2','style'=>'width:140px','empty'=>'-- Pilih --')); 
                        ?>
					</div>
				</div>
			</div>
                     * 
                     */ ?>
		</div>
        <div class="form-actions">
            <?php
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
					array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>

            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl($this->id.'/LaporanPerubahanModal'), 
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
