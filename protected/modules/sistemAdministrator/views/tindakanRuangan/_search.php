<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saruangan-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span5')); ?>
        <table>
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'kelompoktindakan_nama', Chtml::listData(KelompoktindakanM::model()->findAll("kelompoktindakan_aktif = TRUE ORDER BY kelompoktindakan_nama ASC"), 'kelompoktindakan_nama', 'kelompoktindakan_nama'),array('empty'=>'-- Pilih --','class'=>'span3','maxlength'=>50)); ?>
                    <?php echo $form->dropDownListRow($model,'komponenunit_nama', Chtml::listData(KomponenunitM::model()->findAll("komponenunit_aktif = TRUE ORDER BY komponenunit_nama ASC"), 'komponenunit_nama', 'komponenunit_nama'),array('empty'=>'-- Pilih --','class'=>'span3','maxlength'=>50)); ?>                    
                    <?php echo $form->dropDownListRow($model,'kategoritindakan_nama', Chtml::listData(KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama ASC"), 'kategoritindakan_nama', 'kategoritindakan_nama'),array('empty'=>'-- Pilih --','class'=>'span3','maxlength'=>50)); ?>                                        
                </td>
                 <td>
                    <?php echo $form->textFieldRow($model,'daftartindakan_kode',array('class'=>'span3','maxlength'=>20)); ?>
                    <?php echo $form->textAreaRow($model,'daftartindakan_nama',array('class'=>'span3','maxlength'=>200)); ?>
                </td>
            </tr>
        
               
              
        </table>
	<?php //echo $form->textFieldRow($moddaftartindakan,'daftartindakan_na',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'ruangan_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<?php // echo $form->textFieldRow($model,'ruangan_lokasi',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->checkBoxRow($model,'ruangan_aktif',array('checked'=>'ruangan_aktif')); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
