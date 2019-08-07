<div class="white-container">
<style>
	.num, .num-des {
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
/* @var $this PinjamanController */

$this->breadcrumbs=array(
	'Pinjaman',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pinjaman-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class = "rim2">Pencairan Pinjaman Anggota </legend>
<div class="col-md-12">
	<div class="panel panel-primary">		
		<div class="panel-body" >
                    <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Data Permohonan Anggota </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_anggota', array('form'=>$form, 'permintaan'=>$permintaan, 'poasuransi'=>$poasuransi)); ?>
                        </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Pinjaman </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_pinjaman', array('form'=>$form, 'pinjaman'=>$pinjaman)); ?>
                        </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Rincian Angsuran </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_angsuran', array('pinjaman'=>$pinjaman)); ?>
                        </div>
                     </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Kas Keluar </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_kaskeluar', array('form'=>$form, 'kaskeluar'=>$kaskeluar, 'pinjaman' => $pinjaman, 'konfig'=>$konfig, 'permil'=>$permil, 'poasuransi'=>$poasuransi)); ?>
                             </div>
                     </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
                        <legend class="rim"><span class='judul'>Persetujuan </span></legend>
                        <div class="row-fluid">
                            <?php echo $this->renderPartial('subview/_signature', array('form'=>$form, 'kaskeluar'=>$kaskeluar, 'pinjaman' => $pinjaman)); ?>
                        </div>
                     </fieldset>
                            <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                                    'buttonType'=>'button',
                                    'type'=>'primary',
                                    'label'=>'Simpan',
                                    'visible'=>$pinjaman->isNewRecord,
                                    'htmlOptions'=>array('class'=>'btn-success', 'onclick'=>'return cekValidasi();', 'onkeypress'=>'return formSubmit(this,event)'),
                            ));*/ ?>
                            <?php //if ($pinjaman->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
                            <?php //echo $this->renderPartial('subview/_dialog', array(), true); ?>
                            <?php //echo !$pinjaman->isNewRecord?CHtml::link('Print', $this->createUrl('print', array('id'=>$pinjaman->pinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success')):CHtml::link('Print', $this->createUrl('print', array('id'=>$pinjaman->pinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success','disabled'=>true)); ?>
                            <?php //echo !$kaskeluar->isNewRecord?CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue')):CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue','disabled'=>true)); ?>
                            <?php //echo CHtml::link('Ulang', $this->createUrl('index'), array('class' => 'btn btn-default')); ?>
                    
                    <?php
                                        if ($pinjaman->isNewRecord) {
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
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), $this->createUrl('print', array('id'=>$permintaan->permohonanpinjaman_id)), array('target'=>'_blank','class' => 'btn btn-info','disabled'=>false));
                                                    echo '&nbsp;';
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print BKK', array('{icon}'=>'<i class="entypo-print"></i>')), $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-info','disabled'=>false));
                                            }else{
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '', array('target'=>'_blank','class' => 'btn btn-info','disabled'=>true));
                                                    echo '&nbsp;';
                                                    echo CHtml::link(Yii::t('mds', '{icon} Print BKK', array('{icon}'=>'<i class="entypo-print"></i>')), '', array('target'=>'_blank','class' => 'btn btn-info','disabled'=>true));
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
<?php echo $this->renderPartial('subview/_js', array('permohonanId'=>$permohonanId, 'permintaan'=>$permintaan, 'arrAs'=>$arrAs)); ?>
</div>
