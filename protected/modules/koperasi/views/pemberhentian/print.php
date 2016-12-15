<style>
		h1{
		font-size: 16px;
		margin-top: 0px;
	}
	body, table{
		width: 900px;	
		font-size: 11px;
   	margin-left: auto;
    	margin-right: auto;
	}
	.header{
		text-align: center;	
		padding-right: 100px;
	}
	hr.symbol {
		margin-top:0px;
		border-top: 2px solid #333;
		border-bottom: 1px solid #333;
		height:2px;
	}	
</style>
<table width="100%">
<tr>
<td>
<?php echo CHtml::image(Params::urlProfilGambar().$profil->path_valuesimage1, '', array('width'=>50)); ?>
</td>
<td class="header"><h1>
	<b>KOPERASI PEGAWAI REPUBLIK INDONESIA<br>
	<?php echo $profil->nama_profil; ?></b><br>
	<?php echo $profil->badanhukum; ?>
</h1>
</td>
</tr>
</table>
<hr class="symbol" />
<center>
	<h1>PERMINTAAN BERHENTI MENJADI ANGGOTA
	<br/>
	<u>KPRI RUMAH SAKIT UMUM KARAWANG</u></h1>
</center>
<br/>
<div>
	Saya yang bertanda tangan di bawah ini :
	<table>
		<tr>
			<td style="padding-left:50px;width:80px;">Nama</td>		
			<td style="padding-left:50px;">: <?php echo $anggota->pegawai->NamaLengkap?></td>		
		</tr>
		<tr>
			<td style="padding-left:50px;">No. Anggota</td>		
			<td style="padding-left:50px;">: <?php echo $anggota->nokeanggotaan?></td>		
		</tr>	
	</table>
</div>

<div class="alasan">
	<br/>
		Melalui surat ini mengajukan permintaan berhenti menjadi anggota <?php echo $profil->nama_profil; ?> dengan alasan : 
	<?php echo $berhenti->alasanberhenti; ?>
	<br/>
	<br/>
</div>

<div>
	Demikian surat permintaan ini saya buat dengan penuh kesadaran.
	<table width="100%">
		<tr>
			<td><br/><br/>Mengetahui,<br/><?php echo $profil->nama_profil.",";?><br/><i style="padding-left:30px;"></i>Pengurus</td>
			<td style="text-align:right;"><?php echo $profil->kota_kab_profil.", ".MyFormatter::formatDateTimeId(date('d m Y')); ?><br/>Yang mengundurkan diri,</td>
		</tr>
		<tr>
			<td><br/><br/>( <?php echo $pengurus->NamaLengkap; ?> )</td>		
			<td style="text-align:right;"><br/><br/>( <?php echo $anggota->pegawai->NamaLengkap; ?> )</td>		
		</tr>
	</table>
</div>
<hr/>