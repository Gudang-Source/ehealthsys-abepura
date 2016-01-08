
<center>Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?</center>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<table>
    <tr>
        <td><label for="tglbatal" class="control-label required">Tanggal Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textField('tglbatal', date('Y-m-d H:i:s')); ?>
        </td>
    </tr>
    <tr>
        <td><label for="keterangan_batal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textArea('keterangan_batal', ''); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php 
        echo CHtml::hiddenField('pendaftaran_id', '');
        echo CHtml::hiddenField('statusperiksa', '');
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'onclick'=>'ubahPeriksa();', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Batal', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), array('type'=>'button','onclick'=>'$(\'#DialogBatalperiksa\').dialog(\'close\');','class'=>'btn btn-danger')); ?>
           			
<?php 
$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
		
</div>




