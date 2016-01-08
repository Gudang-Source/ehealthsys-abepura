
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array( 
    'action'=>Yii::app()->createUrl($this->route), 
    'method'=>'get', 
   'id'=>'search', 
        'type'=>'horizontal', 
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Tipe Paket','tipepaket_id',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'tipepaket_id',CHtml::listData(SATipePaketM::getItems(),'tipepaket_id','tipepaket_nama'),array('empty'=>'','class'=>'span3'));?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Kelompok Umur','kelompokumur_id',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'kelompokumur_id',CHtml::listData(SAKelompokUmurM::getItems(),'kelompokumur_id','kelompokumur_nama'),array('empty'=>'','class'=>'span3'));?>
			</div>
		</div>
		
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Kode Obat / Alkes','obatalkes_kode',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'obatalkes_kode',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Nama Obat / Alkes','obatalkes_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'obatalkes_nama',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		
		<div class="control-group">
			<?php echo CHtml::label('Daftar Tindakan','daftartindakan_nama',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'daftartindakan_nama',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Satuan Kecil','satuankecil_id',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'satuankecil_id',CHtml::listData(SASatuankecilM::getItems(),'satuankecil_id','satuankecil_nama'),array('empty'=>'','class'=>'span3'));?>
			</div>
		</div>
	</div>
</div>
	
    <?php //echo $form->textFieldRow($model,'tipepaket_id',array('class'=>'span5')); ?>

<!--    <div class="control-group ">
    	<label for="SAPaketbmhpM_tipepaketNama" class="control-label">Nama tipe paket</label>
    	<div class="controls">
    		<?php // echo $form->textField($model,'tipepaketNama',array('class'=>'span5','maxlength'=>50)); ?>
    	</div>
    </div>-->
    

    <div class="form-actions"> 
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    </div> 

<?php $this->endWidget(); ?>