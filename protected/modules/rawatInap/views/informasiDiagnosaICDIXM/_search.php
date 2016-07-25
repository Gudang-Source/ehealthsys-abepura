<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadiagnosa-icdixm-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'diagnosaicdix_kode'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'diagnosaicdix_kode',array('placeholder'=>'Ketik Kode Diagnosa','class'=>'span3','maxlength'=>10)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'diagnosaicdix_nama',array('placeholder'=>'Ketik Nama Diagnosa','class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
</table>

<?php //echo $form->textFieldRow($model,'diagnosaicdix_id',array('class'=>'span5')); ?>
<?php //cho $form->textFieldRow($model,'diagnosaicdix_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>
<?php //echo $form->textFieldRow($model,'diagnosatindakan_katakunci',array('class'=>'span5','maxlength'=>50)); ?>
<?php //echo $form->textFieldRow($model,'diagnosaicdix_nourut',array('class'=>'span5')); ?>
<?php //echo $form->checkBoxRow($model,'diagnosaicdix_aktif',array('checked'=>'diagnosaicdix_aktif')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
        array('class'=>'btn btn-danger',
              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php 
        $content = $this->renderPartial('gudangFarmasi.views.tips.informasiStokObatAlkesRJ',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>
<?php $this->endWidget(); ?>
