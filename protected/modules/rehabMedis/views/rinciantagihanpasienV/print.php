<style>
    .info{
        font-size: 11px;
        font-family: tahoma;
    }
    
    .grid{
        border-collapse: collapse;
        font-size: 11px;
        font-family: tahoma;
        border:1px solid #000;
    }
    .grid td,th{
        padding: 5px;
    }    

</style>
<?php 
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
}
?>
<table width="100%" style='margin-left:auto; margin-right:auto;font-size:12px; '>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien; ?></td>
        <td width="40%"></td>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->tgl_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Jeni Kelamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->jeniskelamin; ?></td>
        <td></td>
        <td>No. Pendafaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->umur; ?></td>
        <td></td>
        <td>Kelas Pelayanan</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Cara Bayar</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <td></td>
        <td>Diagnosa</td>
        <td>:</td>
        <td><?php 
                if (count($modPendaftaran->diagnosa) > 0 ){ ?>
                    <ul>
                            <?php foreach ($modPendaftaran->diagnosa as $row){
                                echo '<li>'.$row->diagnosa->diagnosa_nama.'</li>';
                            } ?>
                    </ul>
                    <?php } else { echo ' - '; }
            ?>
        </td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->pasien->nama_pasien?></td>
        <td></td>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->tgl_pendaftaran?></td>
    </tr>
    <tr>
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <td></td>
        <td>Jenis Kasus Penyakit</td>
        <td>:</td>
        <td><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>
                Keterangan
            </th>
            <th>
                Kategori (Dokter)<br/>Tindakan
            </th>
            <th>
                Tarif Satuan
            </th>
            <th>
                Jumlah
            </th>
            <th>
                Tarif Cyto
            </th>
            <th>
                Disc
            </th>
            <th>
                Sub Total
            </th> 
            <th>
                Status Bayar
            </th> 
        </tr>
    </thead>
    <tbody>
        <?php 
        $ruangan = array();
        $total = 0;
        $subsidiAsuransi = 0;
        $subsidiPemerintah = 0;
        $subsidiRumahSakit = 0;
        $iurBiaya = 0;
        foreach ($modRincian as $i=>$row){
            $rowspan = count(RMRinciantagihanpasienV::model()->findAll('ruangan_id = '.$row->ruangan_id.' and pendaftaran_id = '.$row->pendaftaran_id));
            if (!in_array($row->ruangan_id, $ruangan)){
                $ruangan[] = $row->ruangan_id;
                $ruanganTd = '<td rowspan="'.$rowspan.'" style="vertical-align:middle;text-align:center;">'.$row->ruangan_nama.'</td>';
            }
            else{
                $ruanganTd = '';
            }
            $subtot = $row->tarifcyto_tindakan + ($row->tarif_satuan * $row->qty_tindakan);
            echo '<tr>
                    '.$ruanganTd.'
                    <td>'.$row->kategoritindakan_nama.' ('.$row->nama_pegawai.')<br/>'.$row->daftartindakan_nama.'
                    </td>
                    <td style="text-align:right;">'.number_format($row->tarif_satuan,0,',','.').'
                    </td>
                    <td>'.$row->qty_tindakan.'
                    </td>
                    <td style="text-align:right;">'.number_format($row->tarifcyto_tindakan,0,',','.').'
                    </td>
                    <td>'.$row->discount_tindakan.'
                    </td>
                    <td style="text-align:right;">'.number_format($subtot,0,',','.').'
                    </td>
                    <td>'.((empty($row->tindakansudahbayar_id)) ? "BELUM LUNAS" : "LUNAS").'
                    </td>
                   </tr>';
            $total += $subtot;
            $subsidiAsuransi +=$row->subsidiasuransi_tindakan;
            $subsidiPemerintah += $row->subsidipemerintah_tindakan;
            $subsidiRumahSakit += $row->subsisidirumahsakit_tindakan;
            $iurBiaya += $row->iurbiaya_tindakan;
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"><div class='pull-right'>Total Tagihan</div></td>
            <td style="text-align:right;"><?php echo number_format($total,0,',','.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"><div class='pull-right'>Subsidi Asuransi</div></td>
            <td style="text-align:right;"><?php echo number_format($subsidiAsuransi,0,',','.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"><div class='pull-right'>Subsidi Pemerintah</div></td>
            <td style="text-align:right;"><?php echo number_format($subsidiPemerintah,0,',','.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"><div class='pull-right'>Subsidi Rumah Sakit</div></td>
            <td style="text-align:right;"><?php echo number_format($subsidiRumahSakit,0,',','.'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"><div class='pull-right'>Iur Biaya</div></td>
            <td style="text-align:right;"><?php echo number_format($iurBiaya,0,',','.'); ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>
    
<?php if (isset($caraPrint)) { ?>
<table width="100%" style='margin-top:100px;margin-left:auto;margin-right:auto;'>
    <tr>
        <td width="50%">
                <label style='float:left;'>Petugas : <?php echo $data['nama_pegawai']; ?></label>

        </td>
        <td width="50%">
            
                <label style='float:right;'>Tanggal Print : <?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?></label>
            
        </td>
    </tr>
</table>
<?php } ?>
