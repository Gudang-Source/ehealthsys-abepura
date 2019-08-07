<div class="white-container">
<style>
.num {
	text-align: right;
}
.input-group-addon{
	cursor: pointer;
}
</style>

<?php
/* @var $this PengajuanPemotonganController */

$this->breadcrumbs=array(
	'Pengajuan Pemotongan',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'permintaan-potongan-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);',
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2"><b>Pengajuan Pemotongan Pinjaman</b></legend>
<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body">
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Pencarian</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_pencarian', array('form'=>$form, 'permintaan'=>$permintaan, 'permintaanv'=>$permintaanv, 'no'=>$no)); ?>
                                </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Angsuran</span></legend>
				<div class="row-fluid">
                                    <?php if (empty($no)) echo $this->renderPartial('subview/_tabelPermintaan', array('form'=>$form, 'permintaan'=>$permintaan, 'permintaanv'=>$permintaanv)); ?>
                                </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">				
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_signature', array('form'=>$form, 'permintaan'=>$permintaan, 'permintaanv'=>$permintaanv, 'no'=>$no)); ?>
                                    </div>
                    </fieldset>
                                    <?php //echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
                                    <?php  /*$this->widget('bootstrap.widgets.TbButton', array(
                                            'buttonType'=>'submit',
                                            'type'=>'primary',
                                            'label'=>'Simpan',
                                            'visible'=>empty($no),
                                            'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false; '),
                                    ));*/ ?>
                                    <?php //echo CHtml::link('Print', $this->createUrl('print', array('no'=>$no)), array('disabled'=>empty($no), 'target'=>'_blank','class' => 'btn btn-success')); ?>
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
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
                                            }else{
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
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
<?php echo $this->renderPartial('subview/_js', array()); ?>
<?php $this->endWidget(); ?>
</div>
