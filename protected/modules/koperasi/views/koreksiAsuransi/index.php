<div class="white-container">
<style>
	.num , .num-des {
		text-align: right;
	}
</style>

<?php
/* @var $this PotonganAsuransiController */

$this->breadcrumbs=array(
	'Potongan Asuransi',
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
<legend class="rim2">Koreksi Angsuran</legend>
<div class="col-md-12">			
		<div class="panel-body">
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Peminjam </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_peminjam', array('pinjaman'=>$pinjaman, 'form'=>$form)); ?>
                                </div>
                    </fieldset>
                    
                    <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Tabel Peminjam </span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_table', array('pinjaman'=>$pinjaman, 'form'=>$form)); ?>
                                </div>
                    </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Bukti Kas Keluar</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_kaskeluar', array('kaskeluar'=>$kaskeluar, 'form'=>$form)); ?>
                                </div>
                     </fieldset>
                    
                     <fieldset class="box" id="form-datapegawai">
				<legend class="rim"><span class='judul'>Persetujuan</span></legend>
				<div class="row-fluid">
                                    <?php echo $this->renderPartial('subview/_signature', array('kaskeluar'=>$kaskeluar, 'form'=>$form)); ?>
                                </div>
                     </fieldset>
			<?php echo $this->renderPartial('subview/_js', array('form'=>$form, 'kaskeluar'=>$kaskeluar), true); ?>
			<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
				
			<?php /*$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Simpan',
				'visible'=>$kaskeluar->isNewRecord,
				'htmlOptions'=>array('class'=>'btn-success', 'onclick'=>'if (!cekValidasi()) return false;', 'onkeypress'=>'return formSubmit(this,event)'),
			));*/ ?>
			<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>
			<?php //echo !$pinjaman->isNewRecord?CHtml::link('Print', $this->createUrl('print', array('id'=>$pinjaman->pinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success')):CHtml::link('Print', $this->createUrl('print', array('id'=>$pinjaman->pinjaman_id)), array('target'=>'_blank','class' => 'btn btn-success','disabled'=>true)); ?>
			<?php //echo !$kaskeluar->isNewRecord?CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue')):CHtml::link('Print BKK', $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-blue','disabled'=>true)); ?>
			<?php //echo CHtml::link('Ulang', $this->createUrl('index'), array('class' => 'btn btn-default')); ?>
                        
                        <?php
                                if ($pinjaman->isNewRecord){
                                        echo CHtml::htmlButton($pinjaman->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
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
                                    echo '&nbsp;';
                                    if (!$kaskeluar->isNewRecord){
                                        echo CHtml::link(Yii::t('mds', '{icon} Print BKK', array('{icon}'=>'<i class="entypo-print"></i>')), $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-info'));
                                    }else{
                                        echo CHtml::link(Yii::t('mds', '{icon} Print BKK', array('{icon}'=>'<i class="entypo-print"></i>')), $this->createUrl('/printKwitansi/kaskeluar', array('id'=>$kaskeluar->buktikaskeluarkop_id)), array('target'=>'_blank','class' => 'btn btn-info', 'disabled' => true));
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
<?php $this->endWidget(); ?>
</div>
