<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'salinen-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'linen_id',array('class'=>'span3')); ?>            
            
            <?php echo $form->dropDownListRow($model, 'jenislinen_id', CHtml::listData(JenislinenM::model()->findAll(array('order'=>'jenislinen_nama', )), 'jenislinen_id', 'jenislinen_nama'), array('empty'=>'-- Pilih --')); ?>

            <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll(array('order'=>'ruangan_nama'),array('condition'=>'ruangan_aktif = TRUE')), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --')); ?>            

           

            <?php //echo $form->textFieldRow($model,'kodelinen',array('class'=>'span3','maxlength'=>50)); ?>

            <?php //echo $form->textFieldRow($model,'tglregisterlinen',array('class'=>'span3')); ?>
        </td>
        <td>
             <?php echo $form->dropDownListRow($model, 'rakpenyimpanan_id', CHtml::listData(RakpenyimpananM::model()->findAll(array('order'=>'rakpenyimpanan_nama'),array('condition'=>'rakpenyimpanan_aktif = TRUE') ), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('empty'=>'-- Pilih --')); ?>                

            <?php echo $form->dropDownListRow($model, 'bahanlinen_id', CHtml::listData(BahanlinenM::model()->findAll(array('order'=>'bahanlinen_nama'),array('condition'=>'bahanlinen_aktif = TRUE') ), 'bahanlinen_id', 'bahanlinen_nama'), array('empty'=>'-- Pilih --')); ?>                               

            
            <?php //echo $form->textFieldRow($model,'noregisterlinen',array('class'=>'span3','maxlength'=>50)); ?>

            <?php //echo $form->textFieldRow($model,'namalinen',array('class'=>'span3','maxlength'=>200)); ?>

            <?php //echo $form->textFieldRow($model,'namalainnya',array('class'=>'span3','maxlength'=>200)); ?>

            <?php //echo $form->textFieldRow($model,'merklinen',array('class'=>'span3','maxlength'=>50)); ?>

            <?php //echo $form->textFieldRow($model,'beratlinen',array('class'=>'span3')); ?>

            <?php //echo $form->textFieldRow($model,'warna',array('class'=>'span3','maxlength'=>20)); ?>

            <?php //echo $form->textFieldRow($model,'tahunbeli',array('class'=>'span3','maxlength'=>6)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'barang_nama',array('class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($model,'jmlcucilinen',array('class'=>'span3')); ?>

            <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

            <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

            <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

            <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

            <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

            <?php echo $form->checkBoxRow($model,'linen_aktif', array('checked'=>'linen_aktif')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php //echo $form->textAreaRow($model,'gambarlinen',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
