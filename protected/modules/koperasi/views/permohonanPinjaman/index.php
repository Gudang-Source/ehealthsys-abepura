<div class = "white-container">
<style>
	.num , .num-des {
		text-align: right;
	}
	#tombolAnggota{
		cursor: pointer;	
	}
	.input-group-addon{
		cursor: pointer;	
	}
</style>

<?php
/* @var $this PermohonanPinjamanController */

$this->breadcrumbs=array(
	'Permohonan Pinjaman',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'permohonan-pinjaman-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2">Permohonan Pinjaman</legend>
<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body" >
                    <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Data Anggota </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_anggota', array('form'=>$form, 'anggota'=>$anggota, 'pegawai'=>$pegawai, 'golongan'=>$golongan, 'permintaan'=>$permintaan)); ?>
                        </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Permohonan Pinjaman </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_permintaan', array('form'=>$form, 'permintaan'=>$permintaan, 'potongan'=>$potongan)); ?>
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
                                                    echo CHtml::link('Print', $this->createUrl('print', array('id'=>$permintaan->permohonanpinjaman_id)), array('target'=>'_blank','class' => 'btn btn-info','disabled'=>false));
                                            }else{
                                                    echo CHtml::link('Print', '', array('target'=>'_blank','class' => 'btn btn-info','disabled'=>true));
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