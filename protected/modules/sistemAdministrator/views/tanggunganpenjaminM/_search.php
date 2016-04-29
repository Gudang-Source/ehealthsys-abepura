<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array( 
    //'action'=>Yii::app()->createUrl($this->module->id . '/tanggunganpenjaminM/admin'), 
    'action' => Yii::app()->createUrl($this->route),
    'method'=>'get', 
    'id'=>'sacara-bayar-m-search', 
        'type'=>'horizontal', 
)); ?>

    <?php //echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span5')); ?>

    <?php echo $form->dropDownListRow($modCaraBayar,'carabayar_id',CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true)), 'carabayar_id', 'carabayar_nama'),array('empty'=>'-- Pilih --','class'=>'span3','maxlength'=>50)); ?>
    <?php echo $form->dropDownListRow($modCaraBayar,'kelaspelayanan_id',CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true)), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('empty'=>'-- Pilih --','class'=>'span3','maxlength'=>50)); ?>
    <?php echo $form->dropDownListRow($modCaraBayar,'penjamin_id',CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true)), 'penjamin_id', 'penjamin_nama'),array('empty'=>'-- Pilih --','class'=>'span3','maxlength'=>50)); ?>

    <?php echo $form->checkBoxRow($modCaraBayar,'tanggunganpenjamin_aktif', array('checked'=>'tanggunganpenjamin_aktif')); ?>

   

    <div class="form-actions"> 
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    </div> 

<?php $this->endWidget(); ?>
