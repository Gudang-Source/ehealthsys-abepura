<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$modPenjualan->noresep.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint=='PDF'){
	$table_width = "100%";
}else{
	$table_width = "50%";
}
?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<table width="<?php echo $table_width; ?>">
        <tbody><tr>
            <td width="80" valign="MIDDLE" align="CENTER" rowspan="3">
                 <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 80px; width:80px;"/>
            </td>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <b><font size="5" color="black" face="Liberation Serif">INSTALASI FARMASI APOTEK</font></b><br>
                <b><font size="4" color="black" face="Liberation Serif"><b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b></font></b>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif"><?php echo $modProfilRs->alamatlokasi_rumahsakit; ?></font>
            </td>
        </tr>
         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 9">
                <font color="black" face="Liberation Serif">Telp. <?php echo $modProfilRs->no_telp_profilrs; ?> Fax.  / <?php echo $modProfilRs->no_faksimili." - ".$modProfilRs->kabupaten->kabupaten_nama; ?></font>
            </td>
        </tr>
         <tr>
            <td height="2" style="border-bottom: 3px solid #000000" colspan=" 10"></td>
        </tr>
                     <tr>
                <td valign="MIDDLE" align="CENTER" colspan=" 10"><font color="black"><h3></h3></font></td>
            </tr>
                         <tr>
            <td valign="MIDDLE" align="CENTER" colspan=" 10"></td>
        </tr>  
</tbody>
</table>

<table width="<?php echo $table_width; ?>" >
    <tr>
        <td width='15%'>
			<label class='control-label'>Tanggal Resep</label>
        </td>
        <td width='35%'>: <?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
    </tr>
    <tr>
        <td width='15%'>
			<label class='control-label'>No. Resep</label>
        </td>
        <td width='35%'>: <?php echo $modPenjualan->noresep; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>No. Pendaftaran / NIP</label>
        </td>
		<td width='35%'>:<?php echo $modPendaftaran->no_pendaftaran; ?>  / <?php echo !empty($modPendaftaran->pasien->pegawai_id)?$modPendaftaran->pasien->pegawai->nomorindukpegawai:'-'; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Nama / Kel / Sis / Umur</label>
        </td>
		<td width='35%'>: <?php echo $modPendaftaran->pasien->nama_pasien; ?> / <?php echo $modPenjualan->pasien_id; ?> /  / <?php echo $modPendaftaran->umur; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Alamat Pasien</label>
        </td>
		<td width='35%'>: <?php echo $modPenjualan->pasien->alamat_pasien; ?></td>
    </tr>
	<tr>
        <td width='15%'>
            <label class='control-label'>Atas Tanggungan</label>
        </td>
		<td width='35%'>: <?php echo $modPendaftaran->penjamin->penjamin_nama; ?> - <?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
    </tr>
	<tr>
        <td width='15%'>
            <label class='control-label'>Nama Penanggung</label>
        </td>
		<td width='35%'>: <?php echo !empty($modPenjualan->pasien->pegawai_id)?$modPenjualan->pasien->pegawai->nama_pegawai:' - '; ?></td>
    </tr>
	<tr>
        <td width='15%'>
            <label class='control-label'>Poliklinik</label>
        </td>
		<td width='35%'>: <?php echo $modPenjualan->ruangan->ruangan_nama; ?></td>
    </tr>
	<tr>
        <td width='15%'>
            <label class='control-label'>Dokter</label>
        </td>
		<td width='35%'>: <?php echo $modPenjualan->pegawai->NamaLengkap; ?></td>
    </tr>
    </table>
<br/><br/><br/><br/>

<style>
	.iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 10px;
		background: #ffffff;
		color: #000000;
		/*text-align: left;*/
		width:  30%;
		margin-left: 70%;
		font-size: 100%;
	} 
	.iter legend .oabaru{
		font-weight: normal;
		font-size: 75%;
	}  
	.iter2 {
		font-size: 130%;
		font-weight: bold;
		font-family: "Lucida Console";
	} 
</style>



<?php
$iter_nol = true;
foreach($modDetailResep as $i => $detailresep){
	if($detailresep->iter == 0){
		$iter_nol &= true;
	}else{
		$iter_nol &= false;
	}
}
?>

<?php if(!$iter_nol){ ?>

	<?php foreach($kelompokiter as $i => $detail){ ?>
		<span class="iter2">Iter <?php echo $detail->iter; ?>x</span>
		<br><br>
		<?php $modDetailResepIBN = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id'=>$modReseptur->reseptur_id,'iter'=>$detail->iter), array('order'=>'rke ASC, resepturdetail_id ASC'));?>
		<?php foreach($modDetailResepIBN as $ii => $item){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php echo $item->rke; ?></td>
						<td width='50%' style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'></td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $item->signa_reseptur; ?></td>
						<td><?php echo $item->satuansediaan; ?></td>
						<td>No <?php echo ($item->qty_reseptur==0)?' - ':CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
			<fieldset class='iter'>
				<?php
				$status_copy = '';
				$modCopyResep = FACopyResepR::model()->findByAttributes(array('reseptur_id'=>$modReseptur->reseptur_id));
				
				$jmlresep = $item->qty_reseptur;
				$jmldilayani = $this->getJumlahDilayani($item->resepturdetail_id);
				$iterke = floor($jmldilayani/$jmlresep);
				
				if($iterke == 0){
					$status_copy = 'Orig &nbsp'.$jmldilayani;
				}else{
					$jmldilayani = $jmldilayani-($jmlresep*$iterke);
					$status_copy = 'Iter-'.$iterke.' &nbsp'.CustomFunction::Romawi($jmldilayani);
				}
				
				if($modObatAlkes[$ii]->qty_oa == 0){
					echo "<legend><i>Net Det &nbsp".$status_copy." </i></legend>";
				}else{
					echo "<legend><i>Det &nbsp".$status_copy." </i></legend>";
				}
				?>
			</fieldset>
		<?php } ?>
		<br><br>
	<?php } ?>
		
<?php }else{ ?>

	<?php foreach($kelompokiter as $i => $detail){ ?>
		<?php foreach($modDetailResep as $ii => $item){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td width='10%'>R <?php echo $item->rke; ?></td>
						<td width='50%' style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td width='25%'> </td>
						<td width='25%'></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $item->signa_reseptur; ?></td>
						<td><?php echo $item->satuansediaan; ?></td>
						<td>No <?php echo ($item->qty_reseptur==0)?' - ':CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
			<fieldset class='iter'>
				<?php
				$oa_baru = '';
				if($item->obatalkes_id != $modObatAlkes[$ii]->obatalkes_id){
					$oa_baru = $modObatAlkes[$ii]->obatalkes->obatalkes_nama;
				}
				if($modObatAlkes[$ii]->qty_oa == 0){
					echo "<legend><i>Net Det &nbsp <span class='oabaru'>".$oa_baru."</span>  &nbsp ".$item->qty_reseptur." </i></legend>";
				}else{
					echo "<legend><i>Det &nbsp <span class='oabaru'>".$oa_baru."</span>  &nbsp ".$modObatAlkes[$ii]->qty_oa." </i></legend>";
				}
				?>
			</fieldset>
		<?php } ?>
	<?php } ?>

<?php } ?>
		<br><br>
		<fieldset style="width:50%;">
			<h2 style='text-align: right; opacity: 0.7'><i>PCC</i></h2>
		</fieldset>