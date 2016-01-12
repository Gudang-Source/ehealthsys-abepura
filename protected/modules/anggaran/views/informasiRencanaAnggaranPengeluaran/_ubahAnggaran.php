<div class="white-container">
<legend class="rim2">Ubah Rencana Anggaran Pengeluaran</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ubahanggaran-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event); '),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
        'focus'=>'#'.CHtml::activeId($model,'pegawaimengetahui_nama'),
)); ?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data rencana anggaran pengeluaran berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modDetail); ?>
    <fieldset id="form-rencanapengeluaran" class="box">
        <legend class="rim"><span class='judul'>Data Rencana Pengeluaran </span></legend>
        <div>
            <?php $this->renderPartial('_formRencanaPengeluaran', array('form'=>$form,'format'=>$format,'model'=>$model)); ?>
        </div>
    </fieldset>
	<fieldset id="form-rencanapengeluarandetail" class="box">
        <legend class="rim"><span class='judul'>Data Anggaran Program Kerja Unit </span></legend>
        <div id="detailRencAnggPeng">
            <?php $this->renderPartial('_formRencanaPengeluaranDetail', array('form'=>$form,'format'=>$format,'modDetail'=>$modDetail,'model'=>$model)); ?>
        </div>
    </fieldset>
	<div class="block-tabel">
        <h6>Tabel <b>Rencana Anggaran Pengeluaran</b></h6>
        <table class="items table table-striped table-condensed" id="table-rencanaanggaranpengeluaran">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Program</th>
                    <th>Kode Sub Program</th>
                    <th>Kode Kegiatan</th>
                    <th>Kode Sub Kegiatan</th>
                    <th>Program Kerja</th>
                    <th>Bulan</th>
                    <th>Nilai</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($modDetail) > 0){
                    foreach($modDetail AS $i=>$modRencanaDetail){
						echo $this->renderPartial('_rowRencanaAnggaranPengeluaran',array('format'=>$format,'modRencanaDetail'=>$modRencanaDetail,'i'=>$i));
                    }
                }
                ?>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align:right;">Total Anggaran</td>
                        <td><?php echo $form->textField($model,'total_nilairencpeng',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true))?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>  
    <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'verifikasi();', 'onkeypress'=>'verifikasi();')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('index'),array('class'=>'btn btn-danger','onclick'=>'if(!confirm("'.Yii::t('mds','Apakah anda akan mengulang input data ?').'")) return false;')); ?>
		<?php	$content = $this->renderPartial('../tips/transaksi1',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model,'modDetail'=>$modDetail)); ?>