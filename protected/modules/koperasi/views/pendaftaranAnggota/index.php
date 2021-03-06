<div class="white-container">

<?php
/* @var $this PendaftaranAnggotaController */

$this->breadcrumbs=array(
	'Pendaftaran Anggota',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pendaftaran-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
)); ?>
<style type="text/css">
	.input-group-addon{
		cursor: pointer;	
	}
</style>

<legend class="rim2">Pendaftaran Anggota</legend>

<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-body">
			<?php 
			echo $form->errorSummary($pegawai);
			echo $form->errorSummary($anggota);
			echo $form->errorSummary($simpanan);
			?>
			<fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Pegawai </span></legend>
				<div class="row-fluid">
					<?php echo $this->renderPartial('subview/_formInfoPegawai', array('modPegawai'=>$pegawai, 'form'=>$form, 'anggota'=>$anggota)); ?>
				</div>
			</fieldset>
			<fieldset class="box" id="form-kenggotaan">
				<legend class="rim"><span class='judul'>Keanggotaan </span></legend>
				<div class="row-fluid">
					<?php echo $this->renderPartial('subview/_anggota', array('model'=>$anggota, 'form'=>$form)); ?>
				</div>
			</fieldset>
			<fieldset class="box panel-simpanan">
				<legend class="rim"><span class='judul'>
					<input type="checkbox" name="is_simpanan" value="1" id="is_simpanan" checked onchange="checkPanelSimpanan()">
					Simpanan Pokok
				</span></legend>
				<div class="row-fluid">
					<?php echo $this->renderPartial('subview/_simpanan', array('model'=>$simpanan, 'kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
				</div>
			</div>
			
			
			
			
			<div class="form-group">
				<div class="col-sm-12">
					<?php /* $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Simpan',
						'visible'=>$anggota->isNewRecord,
						'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)',),
					)); ?>
					<?php 
					// echo CHtml::link('Print', $this->createUrl('print', array('id'=>$anggota->keanggotaan_id)),array('class' => 'btn btn-success', 'target'=>'_blank'));
					/*$this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'button',
						'type'=>'primary',
						'label'=>'Print',
						'visible'=>!$anggota->isNewRecord,
						'htmlOptions'=>array('class'=>'btn-success', 'onclick'=>'printAnggota()'),
					));*/ ?>
					<?php //if ($anggota->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
					
					<?php //echo !$anggota->isNewRecord ? '&nbsp;&nbsp;'.CHtml::ResetButton('Print', array('class' => 'btn btn-primary', 'onclick'=>'printAnggota()')) : ""; ?>
					
					<?php //echo $anggota->isNewRecord ? '&nbsp;&nbsp;'.CHtml::ResetButton('Ulang', array('class' => 'btn btn-default', 'onclick'=>'resetInput()')) : CHtml::link('Kembali', $this->createUrl('index'),array('class' => 'btn btn-default')); ?>
                                          <?php
                                        if ($anggota->isNewRecord) {
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
			<?php echo $this->renderPartial('subview/_js', array(), true); ?>
			<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>

</div>

<script type="text/javascript">

$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});

$('.alphaonlyK').bind('keyup blur',function(){ 
    $(this).val( $(this).val().replace(/[^a-zA-Z ]/g,'') );}
);

function convertToUpper(obj)
{
    var string = obj.value;
    $(obj).val(string.toUpperCase());
}
</script>
