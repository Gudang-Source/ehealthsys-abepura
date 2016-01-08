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
            <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'kategoritindakan_id',
                                CHtml::listData(KategoritindakanM::model()->findAll('kategoritindakan_id is not null and kategoritindakan_aktif=true'), 'kategoritindakan_id', 
                                        'kategoritindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); 
            ?>
        </td>
        <td>
            <?php 
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'kelaspelayanan_id',CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif=true'),
                            'kelaspelayanan_id', 'kelaspelayanan_nama'),array('class'=>'span3',
                                'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --'));
            ?>
        </td>
        <td>
            <?php
                    echo $form->textFieldRow($modTarifTindakanRuanganV,'daftartindakan_id',
                            array( 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30, 'autofocus'=>true, 'placeholder'=>'Nama daftar tindakan')); 
            ?>
        </td>
    </tr>
</table>
<div class="form-actions">
     <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	 <?php 
               $content = $this->renderPartial('../tips/transaksi',array(),true);
               $this->widget('UserTips',array('type'=>'admin','content'=>$content));
         ?>
</div>
<?php $this->endWidget(); ?>