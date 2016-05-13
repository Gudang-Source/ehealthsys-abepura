<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php
    Yii::app()->clientScript->registerScript('search', "

    $('form#formCari').submit(function(){
            $.fn.yiiGridView.update('daftarTindakan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ", CClientScript::POS_READY);
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'formCari',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SARuanganM_instalasi_id',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

)); ?>
<table width="100%">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif'=>true), array('order'=>'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelompoktindakan_id', CHtml::listData(KelompoktindakanM::model()->findAllByAttributes(array('kelompoktindakan_aktif'=>true), array('order'=>'kelompoktindakan_nama ASC')), 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'komponenunit_id', CHtml::listData(KomponenunitM::model()->findAllByAttributes(array('komponenunit_aktif'=>true), array('order'=>'komponenunit_nama ASC')), 'komponenunit_id', 'komponenunit_nama'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                    <?php echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_nama',array('style'=>'width:204px', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Ketik Nama Daftar Tindakan', 'maxlength'=>30)); ?>
                </td>
            </tr>
        </table>
<div class="form-actions">
     <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
                                                    array('class'=>'btn btn-blue', 'type'=>'button', 'onclick'=>'printTarif()')); ?>
	 <?php 
               $content = $this->renderPartial('../tips/informasiTarif',array(),true);
               $this->widget('UserTips',array('type'=>'admin','content'=>$content));
         ?>
</div>
<?php $this->endWidget(); ?>