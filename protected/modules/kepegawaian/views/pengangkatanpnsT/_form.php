<fieldset>
    <legend>Pegawai yang diusulkan</legend>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kppengangkatanpns-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<?php echo $this->renderPartial('_pegawai',array('model'=>$modPegawai, 'form'=>$form,  'data'=>$model)); ?>

	<?php echo $form->errorSummary($model); ?>
	
            <?php echo $form->hiddenField($model, 'jabatan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->hiddenField($model, 'pangkat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            <?php echo $form->hiddenField($model, 'pendidikan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <div class="row-fluid">
	    <div class="span5">    
			<?php echo $form->textAreaRow($model, 'keterangan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
		<div class="span6">
            <?php $this->renderPartial('_usulan', array('model' => $modUsulan, 'form' => $form)); ?>
        </div>
		<div class="span5">
            <legend class="rim"><?php echo $form->checkBox($model,'cekPersetujuan', array("onclick"=>"slide('persetujuan');")); ?>Persetujuan Pengangkatan Pegawai Negeri Sipil</legend>
            <div class="<?php echo (empty($model->cekPersetujuan)) ? "hide" : "";?> persetujuan">
               <?php $this->renderPartial('_persetujuan',array('model'=>$modPers, 'form'=>$form)); ?>
            </div>
		</div>
	
		<div class="span6">
            <legend class="rim"><?php echo $form->checkBox($model,'cekRealisasi', array("onclick"=>"slide('realisasi');")); ?>Realisasi Pengangkatan Pegawai Negeri Sipil</legend>
            <div class="<?php echo (empty($model->cekRealisasi)) ? "hide" : "";?> realisasi">
               <?php $this->renderPartial('_realisasi',array('model'=>$modRealisasi, 'form'=>$form)); ?>
            </div>
		</div>
	</div>
            
    
            
	<div class="form-actions">
            <?php if ($model->isNewRecord){ ?>
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php } else { ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'print("PRINT");', 'onclick'=>'print("PRINT");')); ?>
            <?php } ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('create'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);'));  ?>
            <?php 
$content = $this->renderPartial('../tips/transaksi',array(),true);
$this->widget('UserTips',array('type'=>'create', 'content'=>$content));?>
	</div>


<?php $this->endWidget(); ?>
        </fieldset>

<?php 
$urlPrint = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/print&id='.$model->pengangkatanpns_id);
Yii::app()->clientScript->registerScript('onheadfunction','
function slide(data){
    $("."+data).slideToggle();
}

function print(string){
    window.open("'.$urlPrint.'/&caraPrint=PRINT","","location=_new, width=900px");
}
', CClientScript::POS_HEAD); ?>