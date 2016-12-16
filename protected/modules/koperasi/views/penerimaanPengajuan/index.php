<div class="white-container">
<style>
.num {
	text-align: right;
}
#tombolPrepare{
	cursor: pointer;
}
.input-group-addon{
	cursor: pointer;
}
</style>

<?php
/* @var $this PenerimaanPengajuanController */

$this->breadcrumbs=array(
	'Penerimaan Potongan',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penerimaan-potongan-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);',
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2"><b>Penerimaan Pengajuan Pemotongan</b></legend>
<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body">                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Pencarian</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial("subview/_pencarian", array('form'=>$form, 'permintaanv'=>$permintaanv)); ?>
                                </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Penerimaan Pengajuan Pemotongan</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial("subview/_tabelPenerimaan", array('form'=>$form, 'permintaanv'=>$permintaanv, 'angsuran'=>$angsuran)); ?>
                                 </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Bukti Kas Masuk</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial("subview/_kasmasuk", array('form'=>$form, 'permintaanv'=>$permintaanv, 'angsuran'=>$angsuran, 'kasmasuk'=>$kasmasuk)); ?>
                                </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Persetujuan</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial("subview/_signature", array('form'=>$form, 'permintaanv'=>$permintaanv, 'angsuran'=>$angsuran, 'kasmasuk'=>$kasmasuk)); ?>
                                </div>
                    </fieldset>
                                    <?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
                                    <?php echo $this->renderPartial("subview/_js", array()); ?>
                                    <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                                            'buttonType'=>'submit',
                                            'type'=>'primary',
                                            'label'=>'Simpan',
                                            'visible'=>$kasmasuk->isNewRecord,
                                            'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false; '),
                                    ));*/ ?>
                                    <?php //echo CHtml::link('Print', $this->createUrl('print', array('id'=>$kasmasuk->buktikasmasuk_id)), array('disabled'=>$kasmasuk->isNewRecord, 'target'=>'_blank','class' => 'btn btn-success')); ?>
                                    <?php //echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasuk_id)), array('disabled'=>$kasmasuk->isNewRecord, 'target'=>'_blank','class' => 'btn btn-success')); ?>
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
                                                    echo '&nbsp;';
                                                    echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasukkop_id)), array('disabled'=>$kasmasuk->isNewRecord, 'target'=>'_blank','class' => 'btn btn-info')); 
                                            }else{
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
                                                    echo '&nbsp;';
                                                    echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasukkop_id)), array('disabled'=>$kasmasuk->isNewRecord, 'target'=>'_blank','class' => 'btn btn-info', 'disabeld' => true)); 
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
<!-- function auto load no pengajuan yang dipilih dari menu Informasi Pengajuan Pemotongan -->
<?php if(!empty($_GET['no'])){
	$pengajuan = PengajuanpembayaranT::model()->findByAttributes(array('nopengajuan'=>$_GET['no']));
	echo '<script type="text/javascript">'
   . '$("#PengajuanpenerimaanangsuranV_nopengajuan").val("'.$_GET['no'].'");'
	 . '$("#PengajuanpenerimaanangsuranV_potongansumber_id").val("'.$pengajuan->potongansumber_id.'");'
   . '</script>'
;}
 ?>
</div>
