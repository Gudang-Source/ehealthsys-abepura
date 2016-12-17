<div class="white-container">
<?php
/* @var $this TransaksiSimpananController */

$this->breadcrumbs=array(
	'Transaksi Simpanan'=>array('/simpanan/transaksiSimpanan'),
	'Deposit',
);
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'simpanan-sukarela-pokok-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); 

// echo $form->errorSummary($simpanan);
// echo $form->errorSummary($anggota);
// echo $form->errorSummary($kasmasuk);

?>
    <legend class="rim2">Penerimaan <b>Simpanan</b></legend>
<div class="col-md-12">		
		<div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-12" style="text-align: center;">
                                <!-- view utama -->
                            <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Anggota</span></legend>
                                    <div class="row-fluid">
                                        <?php echo $this->renderPartial('subview/_pegawai', array('pegawai'=>$pegawai, 'anggota'=>$anggota, 'form'=>$form)); ?>
                                    </div>
                            </fieldset>
                                
                            <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Simpanan</span></legend>
                                    <div class="row-fluid">
                                        <?php echo $this->renderPartial('subview/_simpanan', array('simpanan'=>$simpanan, 'kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
                                    </div>
                            </fieldset>
                                
                                    
                            <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Persetujuan</span></legend>
                                    <div class="row-fluid">
                                        <?php echo $this->renderPartial('subview/_signature', array('kasmasuk'=>$kasmasuk, 'form'=>$form)); ?>
                                    </div>
                        </fieldset>

                                <!-- view dialog -->
                                <?php //echo $this->renderPartial('subview/_dialog', array(), true); ?>

                                <!-- submit/batal -->
                                <?php //$this->widget('bootstrap.widgets.TbButton', array(
                                        //'buttonType'=>'submit',
                                        //'type'=>'primary',
                                        //'label'=>'Simpan',
                                        //'visible'=>$simpanan->isNewRecord,
                                        //'htmlOptions'=>array('class'=>'btn-success', 'onkeypress'=>'return formSubmit(this,event)', 'onclick'=>'if (!cekValidasi()) return false;',),
                                //)); ?>
                                <?php //echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasukkop_id,'type'=>'deposito')), array('disabled'=>$kasmasuk->isNewRecord,'class'=>'print btn btn-green', 'target'=>'_blank','rel'=>'tooltip','title'=>'Klik Untuk Mencetak Kwitansi BKM'));?>
                                <?php //echo CHtml::link('Ulang', $this->createUrl('deposit'),array('class' => 'btn btn-default')); ?>
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
                                                    echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasukkop_id,'type'=>'deposito')), array('disabled'=>false,'class'=>'print btn btn-info', 'target'=>'_blank','rel'=>'tooltip','title'=>'Klik Untuk Mencetak Kwitansi BKM'));
                                            }else{
                                                    echo CHtml::link('Print BKM', $this->createUrl('/printKwitansi/kasmasuk', array('id'=>$kasmasuk->buktikasmasukkop_id,'type'=>'deposito')), array('disabled'=>true,'class'=>'print btn btn-info', 'target'=>'_blank','rel'=>'tooltip','title'=>'Klik Untuk Mencetak Kwitansi BKM'));
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
	
</div>

<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('subview/_js', array('form'=>$form)); ?>
<?php if (!$kasmasuk->isNewRecord): ?>
<script type="text/javascript">
   $(window).load(function() {
 		 $("html, body").animate({ scrollTop: $(document).height() }, 1000);
	});
	$('.print').tooltip('show');
</script>
<?php endif; ?>
</div>