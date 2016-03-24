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
    .tab-det thead th, .tab-det tbody td {
        background-color: white !important;
        border: 1px solid black !important;
        color: black !important;
    }
    .border{
        border:1px solid;
    }
    .num {
        text-align: right;
    }
');
?>
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
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
//    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan'=>$data['judulLaporan']));      
    
}
?>
<?php
    $a = 0;
        $no_rekam_medik = null;
    $no_pendaftaran = null;
    $carabayarPenjamin = null;
    $nama_pasien = null;
    $alamat = null;
    $umur = null;
    $jeniskelamin = null;
    $nama_pj = null;
    $ruangan_nama = null;
    $alamat_pj = null;
    $DokterPemeriksa = null;
    $ruanganasal_nama = null; 
    $subsidiasuransi = 0;
    $subsidirs = 0;
    $pendaftaran_id = null;
    $pendaftaran_id = null;
    foreach ($modRincian as $key => $dataPendaftar) {
        $no_rekam_medik     = $dataPendaftar->no_rekam_medik;
        $no_pendaftaran     = $dataPendaftar->no_pendaftaran;
        $nama_pasien        = $dataPendaftar->namapasienpendaftar;
        $jeniskelamin       = $dataPendaftar->jeniskelamin;
        $DokterPemeriksa    = $dataPendaftar->DokterPemeriksa;
        $carabayarPenjamin  = $dataPendaftar->CarabayarPenjamin;
        $alamat             = $dataPendaftar->alamat_pasien; //AlamatPasienPendaftar;
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
<br><br><br><br>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr><td><center><b><u>RINCIAN BIAYA FARMASI</u></b></center></td></tr>
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%">
                        <label class='control-label'>
                            No. RM / No. Pend :
                        </label>
                            <?php echo CHtml::encode($no_rekam_medik); ?> / 
                            <?php echo CHtml::encode($no_pendaftaran); ?>
                    </td>
                    <Td width="5%"></td>
                    <td>
                        <label class='control-label'>
                            Cara Bayar / Penjamin :
                        </label>
                        <?php
                            echo CHtml::encode($carabayarPenjamin);
                        ?>
                    </td>
                </tr>
                <tr>

                <tr>
                    <td>
                        <label class='control-label'>
                            Nama Pasien :
                        </label>
                        <?php echo CHtml::encode($nama_pasien); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat Pasien :
                        </label>
                        <?php
                            echo CHtml::encode($alamat);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Umur / Jenis Kelamin :
                        </label>
                            <?php echo CHtml::encode($umur).' / '.CHtml::encode($jeniskelamin); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Nama PJP :
                        </label>
                        <?php
                            echo CHtml::encode($nama_pj);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>
                            Unit Pelayanan :
                        </label>
                            <?php echo CHtml::encode($ruangan_nama); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Alamat PJP :
                        </label>
                        <?php
                            echo CHtml::encode($alamat_pj);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class='control-label'>Resep Oleh Dokter :</label>
                            <?php echo CHtml::encode($DokterPemeriksa); ?>
                    </td>
                    <Td></td>
                    <td>   
                        <label class='control-label'>
                            Asal Unit Layanan :
                        </label>
                        <?php
                            echo CHtml::encode($ruanganasal_nama);
                        ?>
                    </td>
                </tr>                
            </table>            
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" style='margin-left:auto; margin-right:auto;' class="tab-det"> <!--  class='table table-striped table-bordered table-condensed' -->
                <thead class="border">
                    <tr>
                        <th>No.</th>
                        <th>Jenis Obat</th>
                        <th>Tanggal</th>
                        <th>No. Resep</th>
                        <th>Nama Items</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Diskon</th>
                        <th>Harga</th>
                        <th>Biaya Servis</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
    <?php
        $totalSeluruh = 0;
        $totalObat = 0;
        $totalAlkes = 0;
        $totalAdmin = 0;
        $kelompokObat = 0;
        $kelompokAlkes = 0;
        
        $data_obat = array();
        $data_alkes = array();
        
        $totalSeluruh += ($totalObat + $totalAlkes);
        $format = new MyFormatter();
        $total_tagihan = 0;
        
        for ($i=0; $i < $a ; $i++) {
            $no = $i+1;
            $tanggal = $format->formatDateTimeId($tglresep[$i]);
            echo "
            <tr>
                <td>".$no."</td>
                <td>".$jenis_obat[$i]."</td>
                <td>".$tanggal."</td>
                <td>".$noresep[$i]."</td>
                <td>".$obatnama[$i]."</td>
                <td class='num'>".$qty_obat[$i]."</td>
                <td class='num'>".number_format($hargasatuan_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($discount_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($harga_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($biaya_obat[$i],0,',','.')."</td>
                <td class='num'>".number_format($subtotal[$i],0,',','.')."</td>

            </tr>";

            $total_tagihan += $subtotal[$i];
        }

        
    ?>
   
        <tfoot>
            <tr>
                <td colspan="10" class="uang"><b>Total Tagihan :</b></td>
                <td class="uang"><b><?php echo number_format($total_tagihan,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Asuransi :</b></td>
                <td class="uang"><b><?php echo number_format($subsidiasuransi,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tanggungan Rumah Sakit :</b></td>
                <td class="uang"><b><?php echo number_format($subsidirs,0,',','.'); ?></b></td>
            </tr>
            <tr>
                <td colspan="10" class="uang"><b>Tangungan Pasien :</b></td>
                <td class="uang"><b><?php echo number_format(($total_tagihan + $subsidiasuransi + $subsidirs),0,',','.'); ?></b></td>
            </tr>
        </tfoot>
            </table>
        </td>
    </tr>
</table>
<?php if ($caraPrint == 'PRINT') { ?>


<?php }
else { 

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";  
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//        $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/rincianTagihanFarmasi/rincianBiayaFarmasi');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&id=${pendaftaran_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
 } ?>
