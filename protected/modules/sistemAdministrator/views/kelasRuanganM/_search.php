<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppruangan-m-search',
        'type'=>'horizontal',
)); ?>
	<?php 
	$display = "display:none;";
	if(Yii::app()->session['modul_id'] == Params::MODUL_ID_SISADMIN){ 
		$display = "";
	} ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group" style="<?php echo $display; ?>">
                    <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->textField($model,'instalasi_nama',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
            </div>
        </td>
        <td>
            <div class="control-group" style="<?php echo $display; ?>">
                    <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->textField($model,'ruangan_nama',array('class'=>'span3','maxlength'=>50)); ?>
                    </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                    <?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php echo CHtml::activeDropDownList($model, 'kelaspelayanan_id', CHtml::listData(SAKelasPelayananM::model()->getItems(),'kelaspelayanan_id','kelaspelayanan_nama'),array('empty'=>'--Pilih--')); ?>
                    </div>
            </div>
        </td>
    </tr>
</table>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
