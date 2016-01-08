<div class="white-container">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'retur-pembelian-m-form',
	'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this)'),
		'focus'=>'#GFReturPembelianT_ruangan_id',
)); ?>

<?php 
	if(isset($_GET['sukses'])){
		Yii::app()->user->setFlash('success',"Data Pembelian berhasil diretur !");
	}
?>
 <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Retur <b>Pembelian</b></legend>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($modPembelian); ?>
    <div class="row-fluid">
        <div class="span4">
                <?php echo $form->hiddenField($modPenerimaan,'penerimaanbarang_id'); ?>
                <?php echo $form->hiddenField($modPenerimaan,'fakturpembelian_id'); ?>
                <?php echo $form->textFieldRow($modPembelian,'tglretur',array('readonly'=>true,'class'=>'span2 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($modPembelian, 'ruangan_id', CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
                                                                array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
                <?php echo $form->dropDownListRow($modPembelian,'supplier_id', CHtml::listData(SupplierM::model()->getSupplierItems(),'supplier_id','supplier_nama'),
                                                                array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>

        </div>
        <div class="span4">
                <?php echo $form->textAreaRow($modPembelian,'alasanretur',array('cols'=>5, 'rows'=>3, 'onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
        </div>
        <div class="span4">
                <?php echo $form->textAreaRow($modPembelian,'keteranganretur',array('cols'=>5, 'rows'=>3, 'onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
        </div>
    </div>
    <div id="divTabelRetur">
        <?php echo $form->errorSummary($modPenerimaanDet); ?>
        <?php $this->renderPartial('_tblReturPembelian',array('modPenerimaanDet'=>$modPenerimaanDet)); ?>
    </div>

    <div class="form-actions">
		
        <?php
			if(!isset($_GET['sukses'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
				echo "&nbsp;";
			}
		?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/returPembelianOA'), 
                                                        array('class'=>'btn btn-danger',
                                                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
        <?php	$content = $this->renderPartial('../tips/tipsadd',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>