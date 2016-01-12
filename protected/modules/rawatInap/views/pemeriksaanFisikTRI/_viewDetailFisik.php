<style>
	#imgtag
			{
				position: relative;
				min-width: 300px;
				min-height: 300px;
				float: none;
				border: 3px solid #FFF;
				cursor: crosshair;
				text-align: center;
			}
</style>
<table width="100%" >
    <tr>
        <td >
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->tgl_pendaftaran); ?>
        </td>
    </tr><br/>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br/>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->kelaspelayanan->kelaspelayanan_nama); ?>
        </td>
    </tr><br/>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Cara Bayar / Penjamin ')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
            
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
    </tr> 
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="2" width="30%">Tekanan Darah</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tekanandarah)?$modPemeriksaanFisik->tekanandarah:" - ").' /MmHg'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Mean Arterial Pressure</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->meanarteripressure)?$modPemeriksaanFisik->meanarteripressure:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Detak Nadi</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->detaknadi)?$modPemeriksaanFisik->detaknadi:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Denyut Jantung</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->denyutjantung)?$modPemeriksaanFisik->denyutjantung:" - "); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Pernapasan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->pernapasan)?$modPemeriksaanFisik->pernapasan:" - ").' /Menit'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Suhu Tubuh</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->suhutubuh)?$modPemeriksaanFisik->suhutubuh:" - ").' &deg; Celcius'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Tinggi badan / Berat badan</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->tinggibadan_cm)?$modPemeriksaanFisik->tinggibadan_cm:" - ").' Cm / '.(isset($modPemeriksaanFisik->beratbadan_kg)?$modPemeriksaanFisik->beratbadan_kg:" - ").' Kg'; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Index Masa Tubuh</td>
        <td colspan="2" width="70%"><?php echo (isset($modPemeriksaanFisik->indexmassatubuh)?$modPemeriksaanFisik->indexmassatubuh:" - "); ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Kelainan Pada Bagian Tubuh</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->kelainanpadabagtubuh)?$modPemeriksaanFisik->kelainanpadabagtubuh:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Inspeksi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->inspeksi)?$modPemeriksaanFisik->inspeksi:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Palpasi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->palpasi)?$modPemeriksaanFisik->palpasi:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Perkusi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->perkusi)?$modPemeriksaanFisik->perkusi:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="2" width="30%">Auskultasi</td>
        <td colspan="2" width="70%"><?php echo isset($modPemeriksaanFisik->auskultasi)?$modPemeriksaanFisik->auskultasi:" - "; ?></td>
    </tr>
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
	<tr>
		<td width="70%">
			<div align="center" id="imgtag">
				<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
			<div id="tagbox"></div>
			</div>
		</td>
		<td width="30%" style="vertical-align:top;">
			<table border="1">
				<?php 
				if(count($modPemeriksaanGambar)>0){?>
					<tr>
						<td><center><strong>No.</strong></center></td>
						<td><strong>Bagian Tubuh</strong></td>
						<td><strong>Keterangan</strong></td>
					</tr>
					<?php foreach($modPemeriksaanGambar as $i => $v ){ ?>
					<tr>
						<td><center><?= $i+1; ?></center></td>
						<td><?= $v->bagiantubuh->namabagtubuh; ?></td>
						<td><?= $v->keterangan_periksa_gbr; ?></td>
					</tr>
					<?php } ?>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
	<tr>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><strong>Jalan Nafas</strong></td>
        <td align="center" valign="middle" colspan="2" style="font-weight:bold"><strong>Pernafasan</strong></td>
    </tr>
    <tr>
		<td width="30%">Paten</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_paten)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%">Simetri</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgd_simetri)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Obstruktif Partial</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifpartial)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%">Asimetri</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgd_asimetri)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Obstruktif Total</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_obstruktifnormal)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%">Normal</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_normal)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Stridor</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_stridor)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%">Kussmaul</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_kussmaul)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Gargling</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->jn_gargling)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%">Takipena</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_takipnea)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="20%"></td>
		<td width="30%">Retraktif</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_retraktif)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%"></td>
		<td width="20%"></td>
		<td width="30%">Dangkal</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->pgp_dangkal)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
	<tr>
		<td align="center" valign="middle" colspan="4" style="font-weight:bold"><strong>Sirkulasi</strong></td>
    </tr>
	<tr>
		<td width="30%">Nadi Carotis</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadicarotis)?$modPemeriksaanFisik->sirkulasi_nadicarotis.' x/menit':' - '; ?></td>
		<td width="30%"> Kulit Cyanosis</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_cyanosis)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Nadi Radialis</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->sirkulasi_nadiradialis)?$modPemeriksaanFisik->sirkulasi_nadiradialis.' x/menit':' - '; ?></td>
		<td width="30%"> Kulit Pucat</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_pucat)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">CFR</td>
		<td width="20%">
			<?php echo ($modPemeriksaanFisik->cfr_kecil_2)?'<strong>&#8730</strong>':' - '; ?> <= 2 &nbsp; &nbsp;
			<?php echo ($modPemeriksaanFisik->cfr_besar_2)?'<strong>&#8730</strong>':' - '; ?> >= 2
		</td>
		<td width="30%"> Kulit Berkeringat</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_berkeringat)?'<strong>&#8730</strong>':' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Kulit Normal</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_normal)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%"> Akral</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->akral)?$modPemeriksaanFisik->akral:' - '; ?></td>
	</tr>
	<tr>
		<td width="30%">Kulit Jaundice</td>
		<td width="20%"><?php echo ($modPemeriksaanFisik->kulit_jaundice)?'<strong>&#8730</strong>':' - '; ?></td>
		<td width="30%"></td>
		<td width="20%"></td>
	</tr>
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td colspan="2" width="30%">Hasil</td>
        <td colspan="2" width="70%"><?php echo isset($hasil)?$hasil:" - "; ?></td>
    </tr>
</table>
<table>
<tr>
    <td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printFisik();return false")); ?></td>
</tr>
</table>
<script type="text/javascript">
    function printFisik()
{
    window.open('<?php echo $this->createUrl('printPemeriksaanFisik',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=640,height=480');
}

function titikSesudahSimpan(titikX,titikY,urutan){
	var titikX=titikX-185;
	var titikY=titikY-10;
	var nomor = urutan+1;
	var color = '#000000';
	var size = '5px';
	$("#imgtag").append(
		$('<div><strong>'+nomor+'</strong></div>')
			.css('position', 'absolute')
			.css('top', titikY + 'px')
			.css('left', titikX + 'px')
			.css('width', size)
			.css('height', size)
			.css('background-color', color)
			.css('cursor', 'pointer')
			.css('display', 'block')
			.css('padding', '10px')
			.css('-webkit-border-radius', '50%')
			.css('-moz-border-radius', '50%')
			.css('border-radius', '50%')
			.css('vertical-align','middle')
			.css('color','#FFF')
	);
}

function loadTitikSesudahSimpan(){
	<?php if(!empty($modPemeriksaanGambar)){
		foreach($modPemeriksaanGambar as $i => $v){ ?>
		titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i; ?>);	
	<?php }
	}?>
}
$(document).ready(function(){
//	loadTitikSesudahSimpan();
});

</script>