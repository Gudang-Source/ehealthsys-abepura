<legend class="rim">Pencarian</legend>


<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kppengangkatanpns-t-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->checkBoxRow($model,'pengangkatanpns_id'); ?>

	<?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3')); ?>

	<?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>

	 <?php echo $form->dropDownListRow($model,'jabatan', CHtml::listData(JabatanM::model()->findAll(), 
                                        'jabatan_id', 'jabatan_nama'), array('empty'=>'','style'=>'width:130px')); ?>

	<div class="form-actions">
            <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); 
                    
            ?>
            				<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('informasi'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));  ?>
							  	<?php
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
	</div>

<?php $this->endWidget(); ?>
