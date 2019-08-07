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
    <legend class="rim2">Ubah Anggota</legend>
<div class="col-md-12">
	
			<?php 
			echo $form->errorSummary($pegawai);
			echo $form->errorSummary($anggota);
			//echo $form->errorSummary($simpanan);
			?>
                        
                                    <?php echo $form->hiddenField($pegawai, 'pegawai_id'); ?>                                                        
			<?php echo $form->hiddenField($anggota, 'keanggotaan_id'); ?>
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Pegawai </span></legend>				
                                    <?php echo $this->renderPartial('subview/_pegawai', array('model'=>$pegawai, 'form'=>$form)); ?>
                        </fieldset>
    
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Keanggotaan </span></legend>
                                    <div class='row-fluid'>
                                    <?php echo $this->renderPartial('subview/_anggota', array('model'=>$anggota, 'form'=>$form)); ?>
                                    </div>
                        </fieldset>
			<?php // echo $this->renderPartial('subview/_simpanan', array('model'=>$simpanan, 'kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
			
			<div class="form-group">
				<div class="col-sm-12" >
					<?php //$this->widget('bootstrap.widgets.TbButton', array(
						//'buttonType'=>'submit',
						//'type'=>'primary',
						//'label'=>'Simpan',
						//'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)',),
					//)); ?>
                                        <?php //if ($anggota->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
					
					<?php //echo !$anggota->isNewRecord ? '&nbsp;&nbsp;'.CHtml::ResetButton('Print', array('class' => 'btn btn-primary', 'onclick'=>'printAnggota()')) : ""; ?>
					
					<?php //echo CHtml::link('Batal', $this->createUrl('informasi'),array('class' => 'btn btn-default')); ?>
                                    
                                        <?php
                                       // if (!isset($_GET['sukses'])) {
                                             //   echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                                         //   }else{
                                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => false));
                                          //  }
                                    ?>
                                    <?php
                                        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array('class' => 'btn btn-danger',
                                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
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
			<?php echo $this->renderPartial('subview/_js'); ?>
			<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
		
</div>

<?php $this->endWidget(); ?>
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
</div>