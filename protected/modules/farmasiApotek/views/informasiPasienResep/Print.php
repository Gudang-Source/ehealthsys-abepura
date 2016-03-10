<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<style>       
    table.a  tr td 
    {
      vertical-align: top;
    }
    
    table.a  tr td label
    {
      font-size:8pt;
    }
    
    table.a  tr td 
    {
      font-size:8pt;
    }
    
    table  tr td label
    {
      font-size:8pt;
    }
    
    table  tr td 
    {
      font-size:8pt;
    }
    
   @media (min-width:0px) and (max-width: 1000px) {
    table
    {
        width:100%;
        padding:10px;
    }
    
}
</style>
<table width="50%" >
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


<table width="50%" class = "a">
    <tr>
        <td width='15%'>
            <label class='control-label'>NIP / No. Pendaftaran</label>
        </td>
        <td>:</td>
        <td width='35%'> <?php echo !empty($modPendaftaran->pasien->pegawai_id)?$modPendaftaran->pasien->pegawai->nomorindukpegawai:'-'; ?> / <?php echo $modPendaftaran->no_pendaftaran; ?></td>
        <td width='15%'>
			<label class='control-label'>No. Resep</label>
        </td>
        <td>:</td>
        <td width='35%'> <?php echo $modReseptur->noresep; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Nama Pasien</label>
        </td>
        <td>:</td>
		<td width='35%'> <?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td width='15%'>
			<label class='control-label'>Dokter Penulis Resep</label>
        </td>
        <td>:</td>
        <td width='35%'> <?php echo $modReseptur->GetNamaLengkapPegawai($modReseptur->pegawai_id); ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Umur</label>
        </td>
        <td>:</td>
        <td width='35%'> <?php echo $modPendaftaran->umur; ?></td>
        <td width='15%'>
            <label class='control-label'>Tanggal Resep</label>
        </td>
        <td>:</td>
        <td width='35%'> <?php echo $modReseptur->tglreseptur; ?></td>
    </tr>
    <tr>
        <td width='15%'>
            <label class='control-label'>Alamat</label>
        </td>
        <td>:</td>
		<td width='35%'> <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
        <td width='15%'>
			<label class='control-label'>Ruangan</label>
        </td>
        <td>:</td>
        <td width='35%'> <?php echo $modReseptur->ruanganreseptur->ruangan_nama; ?></td>
    </tr>
       
    </table>
<br/><br/>

<style>
	.iter {
		border-top: 2px solid #000000;
		padding: 5px;
		width: 50%;
	} 
	.iter legend{
		padding: 3px;
		background: #ffffff;
		color: #000000;
		text-align: center;
		width:  15%;
		margin-left: 85%;
                font-size: 8pt;
	} 
        
        @media (min-width:0px) and (max-width: 1000px) {
    .iter
    {
        width:100%;
    }
</style>
<?php foreach($kerangkaLooping as $i => $detail){ ?>
	<?php
		$criteriitem=new CDbCriteria;
		$criteriitem->addCondition("reseptur_id = ". $detail->reseptur_id);
		$criteriitem->addCondition("racikan_id = ". $detail->racikan_id);
		$criteriitem->addCondition("rke = ". $detail->rke);
		$items = ResepturdetailT::model()->findAll($criteriitem);
	?>
	<?php foreach($items as $ii => $item){ ?>
		<?php if($item->racikan_id == Params::RACIKAN_ID_NONRACIKAN){ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td >R <?php echo $detail->rke; ?></td>
						<td  style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td >No </td>
						<td ><?php echo CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
					<tr>
						<td colspan="4"><?php echo $item->signa_reseptur; ?></td>
					</tr>
				</tbody>
			</table>
		<?php }else{ ?>
			<table width="50%">
				<tbody>
					<tr>
						<td >R <?php echo $detail->rke; ?></td>
						<td  style="border-left: 0px; border-right: 0px;"><?php echo $item->obatalkes->obatalkes_nama; ?></td>
						<td > </td>
						<td ></td>
					</tr>
					<tr>
						<td></td>
						<td><?php echo $item->signa_reseptur; ?></td>
						<td><?php echo $item->satuansediaan; ?></td>
						<td><?php echo CustomFunction::Romawi($item->qty_reseptur); ?></td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
	<?php } ?>
	
	
 <fieldset class='iter'>
	 <legend>Iter <?php echo $detail->iter; ?></legend>
 </fieldset>
<br/>
<?php } ?>

<?php
if(isset($_GET['frame'])){
echo CHtml::Link("<i class='icon-print icon-white'></i> Print Resep Dokter",'#',array('class'=>'btn btn-info',"rel"=>"tooltip","title"=>"Klik untuk print resep dari dokter",'onclick'=>'printRecordTerakhir(\'PRINT\')'));
$urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printResepDokter&id='.$modReseptur->reseptur_id);
$js = <<< JSCRIPT
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
}
?>