<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sasubkelompok-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
	<?php //echo $form->textFieldRow($model,'subkelompok_id',array('class'=>'span5')); ?>
        <div class="control-group">    
                <?php echo Chtml::label("Golongan", 'golongan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'golongan_id',CHtml::listData($model->getGolonganItems(), 'golongan_id', 'golongan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
            
            <div class="control-group">    
                <?php echo Chtml::label("Bidang", 'bidang_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'bidang_id',CHtml::listData($model->getBidangItems(), 'bidang_id', 'bidang_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        
	<?php echo $form->dropDownListRow($model,'kelompok_id',CHtml::listData($model->getKelompokItems(), 'kelompok_id', 'kelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        <?php echo $form->checkBoxRow($model,'subkelompok_aktif',array('checked'=>'subkelompok_aktif')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subkelompok_kode',array('class'=>'span2 angkadot-only','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subkelompok_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
        </td>
	

	<?php //echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>
	
</table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
