<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<fieldset class="box">
    <legend class="rim">Identitas Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td>
				<?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
				<label class="control-label" >No. Pendaftaran</label>
            </td>
            <td>
				<?php //echo CHtml::textField('ASInforencanaaskepV[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
				<?php
				echo CHtml::textField('ASInforencanaaskepV[no_pendaftaran]', $modPasien->no_pendaftaran, array('readonly' => true));
				?>
            </td>
			<td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label ')); ?></td>
            <td><?php
				echo CHtml::textField('ASInforencanaaskepV[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
				?></td>
			<td><?php echo CHtml::activeLabel($modPasien, 'ruangan_id', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASInforencanaaskepV[ruangan_nama]', isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : '-', array('readonly' => true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASInforencanaaskepV[tgl_pendaftaran]', $modPasien->tgl_pendaftaran, array('readonly' => true)); ?></td>

			<td><?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASInforencanaaskepV[umur]', $modPasien->umur, array('readonly' => true)); ?></td>

			<td><?php echo CHtml::label('Kelas', 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASInforencanaaskepV[kelaspelayanan_nama]', isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : '-', array('readonly' => true)); ?></td>
        </tr>
        <tr>
			<td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label ')); ?></td>
            <td><?php
				echo CHtml::textField('ASInforencanaaskepV[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); 
				?></td>
			<td><?php echo CHtml::label('Diagnosa Medik Masuk', 'diagnosa_nama', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASInforencanaaskepV[diagnosa_nama]', isset($modPasien->diagnosa_nama) ? $modPasien->pendidikan_nama : '-', array('readonly' => true)); ?></td>

            <td><?php echo CHtml::label('No Kamar / No Bed', 'no_kamarbed', array('class' => 'control-label')); ?></td>
            <td><?php echo CHtml::textField('ASInforencanaaskepV[no_kamarbed]', isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : '' . '/' . isset($modPasien->kamarruangan_nobed) ? $modPasien->kamarruangan_nobed : '', array('readonly' => true)); ?></td>

        </tr>
    </table>
</fieldset> 