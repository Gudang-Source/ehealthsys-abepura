<?php
$this->breadcrumbs=array(
	'Treadmill',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'treadmill-mcu-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
//        'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'catatandokterpengirim'),
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<div class="white-container">
	<legend class="rim2">Transaksi <b>Treadmill</b></legend>
	<?php echo $form->errorSummary($modTreadmill); ?>
	<fieldset id="form-infopasien" class="box">
		<legend class="rim"><span class='judul'>Data Pasien </span></legend>
		<div class="row-fluid" id="rowfuild-infopasien">
			<?php $this->renderPartial('_formPasien', array('form'=>$form,'modTreadmill'=>$modTreadmill)); ?>
		</div>
	</fieldset>
	<fieldset id="form-treadmill" class="box">
		<legend class="rim"><span class='judul'>Data Treadmill </span></legend>
		<?php $this->renderPartial('_formTreadmill', array('form'=>$form,'modTreadmill'=>$modTreadmill,'modTreadmillDetail'=>$modTreadmillDetail)); ?>
	</fieldset>
	<div class="form-actions">
		<?php if(!isset($_GET['id'])){
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekInput();', 'onkeypress'=>'cekInputan();','disabled'=>false))."&nbsp";
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),$this->createUrl($this->id.'/index'),array('class'=>'btn btn-danger','onclick'=>'return refreshForm(this);'))."&nbsp";
			echo "<span id='btn-print'>";
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>true,'type'=>'button'))."&nbsp";
			echo "</span>";
			echo "<span id='btn-diagram'>";
			echo CHtml::htmlButton(Yii::t('mds','{icon} Diagram',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>true,'type'=>'button'))."&nbsp";
			echo "</span>";
		}else{
			echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true))."&nbsp";
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),$this->createUrl($this->id.'/index'),array('class'=>'btn btn-danger','onclick'=>'return refreshForm(this);'))."&nbsp";
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')','id'=>'btn-print'))."&nbsp";
			echo CHtml::link(Yii::t('mds','{icon} Diagram',array('{icon}'=>'<i class="icon-print icon-white"></i>')),$this->createUrl($this->id.'/grafik&treadmill_id='.$modTreadmill->treadmill_id.'&pendaftaran_id='.$modTreadmill->pendaftaran_id),array('class'=>'btn btn-primary-blue','disabled'=>false,"target"=>"frameDiagramTreadmillRJ","onclick"=>"$('#dialogGrafik').dialog('open');"))."&nbsp";
		} ?>
		<?php 
			$content = $this->renderPartial('tips/tipsTreadmill',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
		?> 
	</div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('modTreadmill'=>$modTreadmill,'modTreadmillDetail'=>$modTreadmillDetail)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogGrafik',
    'options' => array(
        'title' => 'Diagram Treadmill',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 520,
        'resizable' => false,
    ),
));
?>
<iframe name='frameDiagramTreadmillRJ' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>