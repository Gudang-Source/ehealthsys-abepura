<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sasubsubkelompok-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'subkelompok_id',array('class'=>'span5')); ?>
<table>
    <tr>
        <td>
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
            
        <div class="control-group">    
                <?php echo Chtml::label("Kelompok", 'kelompok_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'kelompok_id',CHtml::listData($model->getKelompokItems(), 'kelompok_id', 'kelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            </div>
        </div>
            
            <?php echo $form->dropDownListRow($model,'subkelompok_id',CHtml::listData(SubkelompokM::model()->findAll("subkelompok_aktif = TRUE ORDER BY subkelompok_nama ASC"), 'subkelompok_id', 'subkelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subsubkelompok_kode',array('class'=>'span5 angkadot-only','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'subsubkelompok_nama',array('class'=>'span5 custom-only','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'subsubkelompok_namalainnya',array('class'=>'span5 custom-only','maxlength'=>100)); ?>
            <br>
            <?php echo $form->checkBoxRow($model,'subsubkelompok_aktif',array('checked'=>'subsubkelompok_aktif')); ?>
        </td>
    </tr>
    
</table>

	

	

	

	<?php //echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
