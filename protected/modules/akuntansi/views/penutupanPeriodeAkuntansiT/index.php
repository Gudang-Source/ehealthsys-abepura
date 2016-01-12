<div class="white-container">
	<legend class="rim2">Transaksi <b>Penutupan Periode Rekening<b/></legend>
<?php 
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'perioderekening-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event); '),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
	'focus'=>'#'.CHtml::activeId($modRekPeriod,'deskripsi'),
)); 
?>	
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <fieldset id="form-rekening" class="box">
        <legend class="rim"><span class='judul'>Periode Rekening </span></legend>
        <div>
            <?php $this->renderPartial('_periodeRekeningBaru', array('format'=>$format,'modRekPeriod'=>$modRekPeriod)); ?>
        </div>
    </fieldset>
    <div class="block-tabel">
        <h6>Tabel <b>Rekening</b></h6>
        <table class="items table table-striped table-condensed" id="table-rekening">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Rekening</th>
                    <th>Nama Rekening</th>
                    <th>Saldo Debit</th>
                    <th>Saldo Kredit</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;">TOTAL</td>
                        <td><?php echo CHtml::textField('totalDebit','',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true))?></td>
                        <td><?php echo CHtml::textField('totalKredit','',array('class'=>'span2 integer','style'=>'width:90px;','readonly'=>true))?></td>
					</tr>
                </tfoot>
        </table>
    </div>
    <fieldset class="box">
        <legend class="rim"><span class='judul'>Periode Rekening </span></legend>
		<div class="row-fluid">
			<?php echo $form->hiddenField($modRekPeriod, 'is_rekeningbaru', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
			<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
					'id'=>'form-rekeningbaru',
					'content'=>array(
						'content-rekeningbaru'=>array(
							'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk input rekening baru')).'<b> Rekening Baru</b>',
							'isi'=>$this->renderPartial('_formRekeningBaru',array(
									'form'=>$form,
									'format'=>$format,
									'modRekPeriod'=>$modRekPeriod,
									),true),
							'active'=>$modRekPeriod->is_rekeningbaru,
						),   
					),
			)); ?>
		</div>
    </fieldset>
    <div class="form-actions">
        <?php 
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['rekperiod_id'])) ? true : ($sukses > 0) ? true : false;; 
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'verifikasi();', 'onkeypress'=>'verifikasi();','disabled'=>$disableSave,)); ?>
        <?php 
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/index'), 
                array('class'=>'btn btn-danger',
                      'onclick'=>'return refreshForm(this);'));
        ?>
        <?php   $content = $this->renderPartial('/tips/transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php $this->renderPartial('_jsFunctions', array('modRekPeriod'=>$modRekPeriod)); ?>
<?php $this->endWidget(); ?>
