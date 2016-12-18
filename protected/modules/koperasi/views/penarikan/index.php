<div class = "white-container">
<style>
	.num , .num-des {
		text-align: right;
	}
</style>

<?php
/* @var $this PenarikanController */

$this->breadcrumbs=array(
	'Penarikan',
);
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'penarikan-simpanan-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);',
	'enctype' => 'multipart/form-data'),
)); ?>
<legend class="rim2">Penarikan Simpanan</legend>
<div class="col-md-12">
	<div class="panel panel-primary">
	
		<div class="panel-body">
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Data Anggota </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_pegawai', array('penarikan'=>$penarikan, 'anggota'=>$anggota, 'kaskeluar'=>$kaskeluar, 'form'=>$form)); ?>
                                </div>
                    </fieldset>
                     <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Penarikan </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_penarikan', array('penarikan'=>$penarikan, 'anggota'=>$anggota, 'kaskeluar'=>$kaskeluar, 'form'=>$form)); ?>
                                </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Kas Keluar </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_kaskeluar', array('kaskeluar'=>$kaskeluar, 'form'=>$form)); ?>
                                </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Persetujuan </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_signature', array('kaskeluar'=>$kaskeluar, 'form'=>$form)); ?>
                                </div>
                    </fieldset>
                                    <?php echo $this->renderPartial('subview/_js', array('form'=>$form, 'kaskeluar'=>$kaskeluar, 'sp'=>$sp), true); ?>
                                    <?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
		</div>
		<div class="panel-body">
			<?php /* $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Simpan',
				'visible'=>$kaskeluar->isNewRecord,
				'htmlOptions'=>array('class'=>'btn-success', 'onclick'=>'if (!cekValidasi()) return false;', 'onkeypress'=>'return formSubmit(this,event)'),
			));*/ ?>
                         <?php //if ($kaskeluar->isNewRecord) echo CHtml::submitButton('Simpan', array('class'=>'btn btn-primary')); ?>
			<?php //echo Yii::app()->modal->register($this->renderPartial('subview/_dialog', null, true)); ?>
			<?php //echo !$pinjaman->isNewRecord?CHtml::link('Print', $this->createUrl('print', array('id'=>$pinjaman->pinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success')):CHtml::link('Print', $this->createUrl('print', array('id'=>$pinjaman->pinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success','disabled'=>true)); ?>
			<?php //echo !$kaskeluar->isNewRecord?CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue')):CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue','disabled'=>true)); ?>
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
                                                    echo CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue','disabled'=>true));
                                            }else{
                                                    echo CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue','disabled'=>false));
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
</div>
