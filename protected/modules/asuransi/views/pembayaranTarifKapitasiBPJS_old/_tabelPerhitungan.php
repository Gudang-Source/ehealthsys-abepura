<!--<tr>
	<td>
        <span><?php //echo (!empty($perhitungan->no_pendaftaran) ? $perhitungan->no_pendaftaran : "") ?><br><?php (!empty($perhitungan->no_rekam_medik) ? $perhitungan->no_rekam_medik : "") ?></span>
    </td>  
	<td>
        <span><?php //echo (!empty($perhitungan->nama_pasien) ? $perhitungan->nama_pasien : "-") ?></span>
    </td>
</tr>-->

<tr >
	<td rowspan=6><?php $i ?></td>
				<td rowspan=6><?php $row->pasien->no_rekam_medik ?> <br/><?php $row->no_pendaftaran ?></td>
				<td rowspan=6> <?php $row->pasien->nama_pasien ?> </td>
				</tr>
				
				<?php foreach ($jenisTarif as $j => $tarif) { ?>
					<tr><td> <?php CHtml::checkBox('ARTarifkapitasiM['.$j.'][cekList]', true, array('value'=>$tarif->tarifkapitasi_nominal,'class' => 'cek', 'checked'=>false, 'onClick' => 'setAll();')) ?> </td>
						<td><?php $tarif->tarifkapitasi_nama ?> </td></tr>

				<?php } ?>