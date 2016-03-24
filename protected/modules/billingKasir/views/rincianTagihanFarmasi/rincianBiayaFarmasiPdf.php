<style>
    .info{
        font-size: 11px;
        font-family: tahoma;
    }
    
    .grid{
        border-collapse: collapse;
        font-size: 11px;
        font-family: tahoma;
    }
    .grid td, .grid th{
        padding: 5px;
    }    
    .grid tbody td, .grid th {
        border: 1px solid black;
    }
    .grid td {
        vertical-align: top;
    }
</style>
<?php

if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulPrint'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');  
    }else if($caraPrint == 'PRINT'){
        echo CHtml::css('.control-label{
                float:left; 
                text-align: right; 
                width:50%;
                color:black;
                padding-right:10px;
                font-size:11pt;
            }
            td, th{
                font-size:11pt;
            }
            
        ');
    }   
}
?>

<?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan)); ?>
<?php
    $a = 0;
    $subsidiasuransi =0;
    $subsidirs = 0;
    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $nama_pasien        = $dataPendaftar->namapasienpendaftar;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $DokterPemeriksa    = $dataPendaftar->DokterPemeriksa;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $alamat             = $dataPendaftar->AlamatPasienPendaftar;
        $ruanganasal_nama   = $dataPendaftar->ruanganasal_nama;
        $ruangan_nama       = $dataPendaftar->ruangan_nama;
        $umur               = substr($dataPendaftar->umur,0,7);
        $nama_pj            = $dataPendaftar->nama_pj;
        $alamat_pj          = $dataPendaftar->alamat_pj;

        $tglresep[$key]     = $dataPendaftar->tglresep;
        $noresep[$key]      = $dataPendaftar->noresep;

        $jenis_obat[$key]   = $dataPendaftar->jenisobatalkes_nama;
        $obatnama[$key]     = $dataPendaftar->obatalkes_nama;
        $qty_obat[$key]     = $dataPendaftar->qty_oa;
        $hargasatuan_obat[$key]  = $dataPendaftar->hargasatuan_oa;
        $discount_obat[$key]     = $dataPendaftar->discount;
        $harga_obat[$key]        = $dataPendaftar->qty_oa * $dataPendaftar->hargasatuan_oa - $dataPendaftar->discount;
        $biaya_obat[$key]        = $dataPendaftar->biayaservice + $dataPendaftar->biayakemasan + $dataPendaftar->biayaadministrasi;
        $subtotal[$key]     = $harga_obat[$key] + $biaya_obat[$key];
        
        $subsidiasuransi   += $subsidiasuransi[$key];
        $subsidirs         += $subsidirs[$key];

        $a++;
    }
?>
<br>
<div align="center"><b><u>Rincian Biaya Farmasi</u></b></center></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td width="22%">No. RM / No. Pend</td>
        <td width="30%"> :
            <?php if (isset($no_rekam_medik)) {echo CHtml::encode($no_rekam_medik);} ?> / 
            <?php if (isset($no_pendaftaran)) {echo CHtml::encode($no_pendaftaran);} ?>           
        </td>
        <td width="22%">Cara Bayar / Penjamin </td>
        <td>:
            <?php
            if (isset($carabayarPenjamin)){
                echo CHtml::encode($carabayarPenjamin);
            }
            ?>        
        </td>
    </tr>
    <tr>
        <td width="22%">Nama Pasien</td>
        <td width="30%"> :
            <?php if (isset($nama_pasien)) {echo CHtml::encode($nama_pasien);} ?>          
        </td>
        <td width="22%">Alamat Pasien </td>
        <td>:
            <?php
               if (isset($alamat)) { echo CHtml::encode($alamat);}
            ?>        
        </td>
    </tr>
    <tr>
        <td width="22%">Umur / Jenis Kelamin</td>
        <td width="30%"> :
            <?php 
                if (isset($umur) || isset($jeniskelamin)) {
                    echo CHtml::encode($umur).' / '.CHtml::encode($jeniskelamin);
                } 
            ?>         
        </td>
        <td width="22%">Nama PJP </td>
        <td>:
            <?php
                if (isset($nama_pj)){
                    echo CHtml::encode($nama_pj);
                }
            ?>        
        </td>
    </tr>
    <tr>
        <td width="22%">Unit Pelayanan</td>
        <td width="30%"> :
            <?php if (isset($ruangan_nama)){ echo CHtml::encode($ruangan_nama); } ?>         
        </td>
        <td width="22%">Alamat PJP </td>
        <td>:
            <?php
                if (isset($alamat_pj)){ echo CHtml::encode($alamat_pj); }
            ?>        
        </td>
    </tr>
    <tr>
        <td width="22%">Resep Oleh Dokter</td>
        <td width="30%"> :
            <?php if (isset($DokterPemeriksa)){ echo CHtml::encode($DokterPemeriksa); } ?>    
        </td>
        <td width="22%">Asal Unit Layanan </td>
        <td>:
            <?php
               if (isset($ruanganasal_nama)){ echo CHtml::encode($ruanganasal_nama); }
            ?>        
        </td>
    </tr>
</table>

<br>
<div align="center" style="text-align: center;">
    <center><?php echo strtoupper($data['judulPrint']); ?></center>
</div>
    
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid">
    <thead>
        <tr>
            <th width="1%">No.</th>
            <th nowrap>Jenis Obat</th>
            <th>Tanggal</th>
            <th>No. Resep</th>
            <th width="100%">Nama Items</th>
            <th align='center'>Jumlah</th>
            <th align='right'>Satuan</th>
            <th align='right'>Diskon</th>
            <th align='right'>Harga</th>
            <th align='right'>Biaya Servis</th>
            <th align='right'>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (isset($totalAlkes)){
                $totalSeluruh += ($totalObat + $totalAlkes);
            }
            
            $format = new MyFormatter();
            $total_tagihan = 0;
            
            for ($i=0; $i < $a ; $i++) {
                $no = $i+1;
                $tanggal = $format->formatDateTimeId($tglresep[$i]);
                echo "
                <tr>
                    <td>".$no."</td>
                    <td nowrap>".$jenis_obat[$i]."</td>
                    <td nowrap>".$tanggal."</td>
                    <td nowrap>".$noresep[$i]."</td>
                    <td>".$obatnama[$i]."</td>
                    <td align='center'>".$qty_obat[$i]."</td>
                    <td align='right'>".MyFormatter::formatNumberForPrint($hargasatuan_obat[$i])."</td>
                    <td align='right'>".MyFormatter::formatNumberForPrint($discount_obat[$i])."</td>
                    <td align='right'>".MyFormatter::formatNumberForPrint($harga_obat[$i])."</td>
                    <td align='right'>".MyFormatter::formatNumberForPrint($biaya_obat[$i])."</td>
                    <td align='right'>".MyFormatter::formatNumberForPrint($subtotal[$i])."</td>

                </tr>";

                $total_tagihan += $subtotal[$i];
            }
        ?>
    </tbody>
    <tfoot>
    <?php 
        if($caraPrint!='PDF'){
    ?>
        <tr><td colspan="11">&nbsp;</td>
        <tr>            
            <td colspan="6"><?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></td>
            <td colspan="4" align="right"><b>Total Tagihan :</b></td>
            <td align="right"><b><?php echo MyFormatter::formatNumberForPrint($total_tagihan); ?></b></td>
        </tr>
        <tr>
            <td colspan="6">Petugas</td>
            <td colspan="4" align="right"><b>Tanggungan Asuransi :</b></td>
            <td align="right"><b><?php if (isset($subsidiasuransi)) { echo MyFormatter::formatNumberForPrint($subsidiasuransi);} ?></b></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="4" align="right"><b>Tanggungan Rumah Sakit :</b></td>
            <td align="right"><b><?php if (isset($subsidirs)) { echo MyFormatter::formatNumberForPrint($subsidirs);} ?></b></td>
        </tr>
        <tr>
            <td colspan="6"><?php echo $data['nama_pegawai']; ?></td>
            <td colspan="4" align="right"><b>Tangungan Pasien :</b></td>
            <td align="right"><b><?php if (isset($subsidirs)) { echo MyFormatter::formatNumberForPrint($total_tagihan + $subsidiasuransi + $subsidirs); } else { echo MyFormatter::formatNumberForPrint($total_tagihan); } ?></b></td>
        </tr>
    <?php
        }else{
    ?>
        <tr>            
            <td colspan="10" align="right"><b>Total Tagihan :</b></td>
            <td align="right"><b><?php echo MyFormatter::formatNumberForPrint($total_tagihan); ?></b></td>
        </tr>
        <tr>1
            <td colspan="10" align="right"><b>Tanggungan Asuransi :</b></td>
            <td align="right"><b><?php echo MyFormatter::formatNumberForPrint($subsidiasuransi); ?></b></td>
        </tr>
        <tr>1
            <td colspan="10" align="right"><b>Tanggungan Rumah Sakit :</b></td>
            <td align="right"><b><?php echo MyFormatter::formatNumberForPrint($subsidirs); ?></b></td>
        </tr>
        <tr>1
            <td colspan="10" align="right"><b>Tangungan Pasien :</b></td>
            <td align="right"><b><?php echo MyFormatter::formatNumberForPrint($total_tagihan + $subsidiasuransi + $subsidirs); ?></b></td>
        </tr>    
    <?php
        }
    ?>
    </tfoot>
</table>    