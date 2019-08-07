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
/* @var $this PembayaranAngsuranController */

$this->breadcrumbs=array(
	'Pembayaran Angsuran',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pembayaran-angsuran-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2"><b>Pembayaran Angsuran</b> </legend>

<div class="col-md-12">
	<div class="panel panel-primary">
		
		<div class="panel-body" >
                    <div class="panel-body">
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Anggota </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_anggota', array('form'=>$form, 'anggota'=>$anggota, 'pinjaman'=>$pinjaman, 'angsuran'=>$angsuran, 'bayar'=>$bayar)); ?>
                                </div>
                        </fieldset>
                        
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Rincian Angsuran </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_angsuran'); ?>
                                </div>
                        </fieldset>
                        
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Bukti Kas Masuk </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_bkm', array('form'=>$form, 'kasmasuk'=>$kasmasuk)); ?>
                                </div>
                        </fieldset>
                        
                        <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Persetujuan </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_signature', array('form'=>$form, 'kasmasuk'=>$kasmasuk)); ?>
                                </div>
                        </fieldset>
                                    <?php echo $this->renderPartial('subview/_js', array('ke'=>$ke,'no'=>$no, 'idAngsuran'=>$idAngsuran)); ?>
                                    <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                                            'buttonType'=>'submit',
                                            'type'=>'primary',
                                            'label'=>'Simpan',
                                            'visible'=>$bayar->isNewRecord,
                                            'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false; '),
                                    ));*/ ?>
                                    <?php //if ($bayar->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
                                    <?php //echo !empty($kasmasuk->buktikasmasuk_id)?CHtml::link('Print', $this->createUrl('//printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasuk_id)), array('target'=>'_blank','class' => 'btn btn-success')):''; ?>
                                    <?php //echo CHtml::link('Ulang', $this->createUrl('index'), array('class' => 'btn btn-default')); ?>
                            <?php
                                if ($bayar->isNewRecord){
                                        echo CHtml::htmlButton($bayar->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
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

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
</div>

<?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $idMutasi = isset($_GET['id'])?$_GET['id']:'';
    
    $js = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/&id=${idMutasi}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>