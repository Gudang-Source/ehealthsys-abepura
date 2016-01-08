<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modPasienPenunjang)){
?>
<fieldset class="box">
    <legend class="rim">Data Pasien</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td>
                <?php
                    echo CHtml::activeTextField($modPasienPenunjang, 'tgl_pendaftaran', array('readonly'=>true));
                    echo CHtml::activeHiddenField($modPasienPenunjang, 'kelaspelayanan_id', array('readonly'=>true));
                ?>
            </td>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasienPenunjang->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasienPenunjang->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><label class="control-label">No. Pendaftaran - Penunjang</label></td>
            <td>
                <?php echo CHtml::activeTextField($modPasienPenunjang, 'no_pendaftaran', array('readonly'=>true, 'class'=>'span2')); ?>
                -
                <?php echo CHtml::activeTextField($modPasienPenunjang, 'no_masukpenunjang', array('readonly'=>true, 'class'=>'span2')); ?>
            </td>
            
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'ruanganasal_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienPenunjang, 'ruanganasal_nama', array('readonly'=>true)); ?></td>
            <td><?php echo CHtml::activeLabel($modPasienPenunjang, 'kelaspelayanan_nama',array('class'=>'control-label')); ?></td>
            <td>
                <?php echo CHtml::activeTextField($modPasienPenunjang, 'kelaspelayanan_nama', array('readonly'=>true)); ?>
                <?php echo CHtml::activeHiddenField($modPasienPenunjang, 'kelaspelayanan_id', array('readonly'=>true)); ?>
            </td>
        </tr>
    </table>
</fieldset>

<hr/>
<?php
} else {
    Yii::app()->user->setFlash('error',"Data pasien tidak ditemukan");
    $this->widget('bootstrap.widgets.BootAlert');
}

$js = <<< JS
$('#cekRiwayatPasien').change(function(){
        $('#divRiwayatPasien').slideToggle(500);
});
JS;
Yii::app()->clientScript->registerScript('JSriwayatPasien',$js,CClientScript::POS_READY);
?>
