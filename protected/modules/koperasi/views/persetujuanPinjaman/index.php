<div class = "white-container">
<?php

$this->breadcrumbs=array(
	'Persetujuan Pinjaman',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'persetujuan-pinjaman-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',	
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2">Persetujuan Pinjaman</legend>
<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body">
                    <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Data Pemohon </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_pemohon', array('form'=>$form, 'permintaan'=>$permintaan)); ?>
                        </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Persetujuan </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_persetujuan', array('form'=>$form, 'approval'=>$approval)); ?>
                        </div>
                     </fieldset>
			<?php /*$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Simpan',
				'visible'=>$permintaan->isNewRecord,
				'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false; '),
			));*/  ?>
                        <?php //if ($permintaan->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
			<?php //echo $this->renderPartial('subview/_dialog', array(), true); ?>
			<?php //echo !$permintaan->isNewRecord?
			//CHtml::link('Print', $this->createUrl('print', array('id'=>$permintaan->permohonanpinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success'))
			//:CHtml::link('Print', '', array('class' => 'btn btn-success', 'disabled'=>true)); ?>
			<?php //echo CHtml::link('Ulang', $this->createUrl('index'), array('class' => 'btn btn-default')); ?>
                    
                        <?php  //echo Chtml::button('OK', array('class' => 'btn btn-success btn-setuju', 'onclick'=>'kirimPersetujuan()')); ?>
                        <?php  //echo Chtml::button('Batal', array('class' => 'btn btn-danger btn-setuju', 'onclick'=>'$("#dialog_persetujuan").modal("hide")')); ?>
                    
                        <?php
                            if (!isset($_GET['sukses'])) {
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                                }else{
                                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true));
                                }
                        ?>
                       <?php
                            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'));
                        ?>
                        <?php
                                if(isset($_GET['sukses'])){
                                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
                                        echo '&nbsp;';                                        
                                }else{
                                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
                                        echo '&nbsp;';                                        
                                }
                        ?>

                        <?php
                            $tips = array(
                                '0' => 'autocomplete-search',
                                '1' => 'tanggal',
                                '2' => 'simpan',
                                '3' => 'ulang',
                                '4' => 'print',
                                '5' => 'status_print'
                            );
                            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                        ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php //echo $this->renderPartial('subview/_js'); ?>
</div>