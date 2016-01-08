<?php if(isset($modPendaftarans)){ ?>
	<?php foreach ($modPendaftarans as $i => $modPendaftaran){ ?>
			<?php 
			$jenisTarif = ARTarifkapitasiM::model()->findAll();
			$no = $i+1;
			$jumlahTarif = 0;
			?>
			<tr>
				<td rowspan="6"><?php echo $no; ?></td>
				<td rowspan="6"><?php echo $modPendaftaran->pasien->no_rekam_medik."<br/>".$modPendaftaran->no_pendaftaran; 
								echo CHtml::hiddenField('ARPembayarankapitasidetailT['.$i.'][pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('class' => 'span3', 'readonly' => true));
								?></td>
				<td rowspan="6"><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
				<td rowspan="6"><?php echo CHtml::textField('ARPembayarankapitasidetailT['.$i.'][pembayarankapitasidetail_totalpembayaran]', number_format($jumlahTarif), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jumlahTarif integer ', 'readonly' => true)); ?></td>
			</tr>
			<?php foreach ($jenisTarif as $j => $tarif) { ?>
			<tr>
				<td><?php echo CHtml::checkBox('ARTarifkapitasiM['.$j.'][cekList]', false, array('value'=>$tarif->tarifkapitasi_nominal, 'class'=>'cek','onClick' => 'hitungTarif();')); ?></td>
				<td><?php echo $tarif->tarifkapitasi_nama; ?></td>
			</tr>
				<?php $jumlahTarif += $tarif->tarifkapitasi_nominal; ?>
			<?php } ?>
	<?php } ?>
<?php } ?>

