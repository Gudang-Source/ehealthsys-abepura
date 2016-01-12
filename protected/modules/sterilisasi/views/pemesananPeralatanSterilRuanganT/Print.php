<center>
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
if(!$modPemesananDetail){
    echo "Data tidak ditemukan"; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
?>
<body class="kertas">
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Pengajuan Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->pesanperlinensteril_tgl) ? $format->formatDateTimeId($modPemesanan->pesanperlinensteril_tgl) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Pengajuan Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->pesanperlinensteril_no) ? $modPemesanan->pesanperlinensteril_no : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->ruangan->ruangan_nama) ? $modPemesanan->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($modPemesanan->pesanperlinensteril_ket) ? $modPemesanan->pesanperlinensteril_ket : "-"; ?></td>
        </tr>
    </table><br/><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>Nama Peralatan dan Linen</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </thead>
		<tbody>
        <?php 
			$total = 0;
			foreach ($modPemesananDetail as $i=>$modLinen){ 
			$total = $total+$modLinen->pesanperlinensterildet_jml; 
        ?>
            <tr>
                <td><?php echo $modLinen->barang->barang_nama; ?></td>
                <td><?php echo $modLinen->pesanperlinensterildet_jml; ?></td>
                <td><?php echo $modLinen->pesanperlinensterildet_ket; ?></td>
            </tr>
        <?php } ?>
		</tbody>
    </table>
	<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Memesan<br></div>
                        <div style="margin-top:60px;"><?php echo $modPemesanan->pegawaiMemesan->nama_pegawai; ?></div>
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $modPemesanan->pegawaiMengetahui->nama_pegawai; ?></div>
                        <div></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
