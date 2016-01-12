<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarianobat-form',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($modObat,'jenisstokopname'),
        ));
?>
<div class="row-fluid">
    <div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Jenis Stock Opname','jenisstokopname',array('class'=>'control-label')); ?>
			<div class="controls">
		        <?php 
				if(empty($model->formuliropname_id)){
					echo $form->dropDownList($modObat, 'jenisstokopname', LookupM::getItems('jenisstokopname'), array('class'=>'span3', 'onchange'=>'setJenisStokOpname();','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
				}else{
					echo $form->textField($modObat, 'jenisstokopname', array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
				}
				?>
			</div>
		</div>
		
        <?php echo $form->dropDownListRow($modObat, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --', 'class' => 'span3','onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($modObat, 'obatalkes_kode', array('placeholder'=>'Ketik Kode Obat Alkes','class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modObat, 'obatalkes_nama', array('placeholder'=>'Ketik Nama Obat Alkes','class' => 'span3', 'maxlength' => 200,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="span4">
        <?php echo $form->dropDownListRow($modObat, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($modObat, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50,'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="form-actions">
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tampilkan', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
<?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>
<?php $this->endWidget(); ?>
</div>