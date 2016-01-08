<?php // $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10)); ?>
<!--<div style="height: 3cm;"></div>-->
<style>
    th, td, div{
        font-family: Arial;
        font-size: 11pt;
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
        width: 50%;
    }
</style>
<?php $format = new MyFormatter;?>
<?php if(!empty($caraPrint)){
    echo "<br><br><br><br>";
} ?>
<table width="75%"><tr><td>
<table width="100%">
    <tr>
        <td width="10%">No. Faktur</td>
        <td>: <?php echo (empty($modPenjualan->NoFaktur)) ? "- Belum Lunas -" : $modPenjualan->NoFaktur; ?></td>
        <td colspan="2">Kepada Yth.,</td>
    </tr>
    <tr>
        <td>Tanggal. Faktur</td>
        <td>: <?php echo date('d M Y H:i:s');?></td>
        <td width="10%">Nama </td>
        <td>: 
            <?php 
            if(!empty($modPenjualan->pasienpegawai_id))
                echo $modPegawaiDokter->nomorindukpegawai." - ".$modPegawaiDokter->gelardepan." ".$modPegawaiDokter->nama_pegawai.", ".$modPegawaiDokter->gelarbelakang_nama;
            else if (!empty($modPenjualan->pasieninstalasiunit_id))
                echo $modInstalasi->instalasi_nama;
            else
                echo $pasien->nama_pasien;
            ;?>
        </td>
    </tr>
    <tr>
        <td>No. Resep</td>
        <td>: <?php echo $modPenjualan->noresep;?>
        <td>Alamat </td>
        <td rowspan="2" style="vertical-align: top;">: 
            <?php
            if(!empty($modPenjualan->pasienpegawai_id)){
                echo ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->nama_rumahsakit;
                if(!empty($modPegawaiDokter->alamat_pegawai))
                    echo "/".$modPegawaiDokter->alamat_pegawai;
            }else if(!empty($modPenjualan->pasieninstalasiunit_id)){
                // if($modInstalasi->instalasi_lokasi == "GRT")
                    echo ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->nama_rumahsakit;
                // else{
                //     echo "Holding PT. KAH";
                // }
            }
            else    
                echo $pasien->alamat_pasien;
            ?>
            <?php // echo ", ".$modPenjualan->pendaftaran->pasien->kelurahan->kelurahan_nama;?>
            <?php // echo ", ".$pasien->kecamatan->kecamatan_nama;?>
            <?php // echo ", ".$modPenjualan->pendaftaran->pasien->kabupaten->kabupaten_nama;?>
        </td>
<!--        <td>Umur</td>
        <td>: <?php // echo $modPenjualan->pendaftaran->umur;?> -->
    </tr>
    <tr>
        <td>Tanggal Resep</td>
        <td>: <?php echo $modPenjualan->tglresep;?></td>
    </tr>
</table><br/>
<table width="100%">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Kode</th>
        <th style='text-align: center;'>Nama</th>
        <th style='text-align: center;'>Jumlah</th>
        <th style='text-align: center;'>Harga</th>
        <th style='text-align: center;'>Subtotal</th>
    </thead>
    <?php
    $no=1;
    $total = 0;
    $totalAdmin = 0;
    if (count($obatAlkes) > 0){
        foreach($obatAlkes AS $tampilData):
        echo "<tr style='border:1px solid;''>
            <td style='text-align:center;'>".$no."</td>
            <td>".$tampilData->obatalkes->obatalkes_kode."</td>
            <td>".$tampilData->obatalkes->obatalkes_nama."</td>
            <td style='text-align: center;'>".number_format($tampilData->qty_oa,0,"",".")."</td>
            <td style='text-align: right;'>".number_format($tampilData->hargasatuan_oa,0,"",".")."</td>
            <td style='text-align: right;'>".number_format(($tampilData->qty_oa * $tampilData->hargasatuan_oa),0,"",".")."</td>
         </tr>";  
        $no++;
        $total += ($tampilData->qty_oa * $tampilData->hargasatuan_oa);
        $totalAdmin +=  ($tampilData->biayaservice + $tampilData->biayakonseling + $tampilData->biayaadministrasi);//$tampilData->jasadokterresep + << TIDAK DICANTUMKAN KARENA SUDAH TERMASUK KE DALAM OBAT
        endforeach;
    }
    ?>
</table>
<table width="100%">
    <tr>
        <td width ="50%" rowspan="6"></td>
        <td width ="50%" colspan="2"></td>
    </tr>
    <tr><td width ="25%">Total</td><td style="text-align:right;" width ="25%">Rp. <?php echo number_format($total,0,"",".") ?></td></tr>
    <tr><td>Biaya Racik, dll.</td><td style="text-align:right;">Rp. <?php echo number_format($totalAdmin,0,"","."); ?></td></tr>
    <?php if(empty($modPenjualan->NoFaktur)){?>
        <tr><td>Total Transaksi</td><td style="text-align:right;">Rp. <?php echo number_format(($total + $totalAdmin),0,"","."); ?></td></tr>
    <?php }else{?>
        <tr><td>Total Transaksi</td><td style="text-align:right;">Rp. <?php echo number_format($tandabukti->jmlpembayaran,0,"","."); ?></td></tr>
        <tr><td>Bayar</td><td style="text-align:right;">Rp. <?php echo number_format($tandabukti->uangditerima,0,"","."); ?></td></tr>
        <tr><td>Kembalian</td><td style="text-align:right;">Rp. <?php echo number_format($tandabukti->uangkembalian,0,"","."); ?></td></tr>
    <?php } ?>
</table><br>
<?php if(empty($caraPrint)){ 
    
}else{
?>
<table width="100%">
    <tr><td class="tandatangan">Penerima</td>
        <td class="tandatangan">Hormat Kami,</td>
    </tr>
    <tr>
        <td class="tandatangan" style="height: 50px;">.........................</td>
        <td class="tandatangan" ><?php echo Yii::app()->user->getState('nama_pegawai'); ?>
    </td></tr>
</table>
<div style="font-size: 9pt;">Print Date: <?php echo RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama.','; // echo Yii::app()->user->getState('nama_pegawai'); ?>
    <?php echo date('d M Y H:i:s'); ?></div>
<?php } ?>
</td></tr></table>
