<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<!--KUITANSI -->
<style>
    body {
        letter-spacing: 2px;
    }
    table, td, div{
        font-size: 8pt;
        font-family: Arial;
    }
    .catatan{
        font-size: 8pt;
        text-align: left;
    }
    .uang{
        font-size: 12pt;
        font-weight: bold;
    }
    .terbilang{
        font-style: italic;
    }
    .tandatangan{
        text-align: center;
        vertical-align: top;
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
}
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'pembayaran-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#TandabuktibayarT_darinama_bkm'
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<!-- <table class="table table-condensed">
    <tr>
        <td>
            <div class="control-group">
                <label class="control-label">Ubah <?php echo $form->labelEx($modTandaBukti,'darinama_bkm'); ?></label>
                <div class="controls">
                    <?php echo $form->textField($modTandaBukti,'darinama_bkm',array('class'=>'span3', 'title'=>'Tekan tombol Enter untuk melakukan perubahan data')); ?>
                </div>
            </div>
        </td>
    </tr>
</table> -->
<?php $this->endWidget(); ?>

<table width="100%">
    <?php 
    $slippage = "No Kuitansi : ".$modTandaBukti->nobuktibayar;
    $ru = "";
    if (!empty($modPendaftaran->pasienadmisi_id)) $ru = " RAWAT INAP";
    else $ru = " ".strtoupper($modPendaftaran->instalasi->instalasi_nama);
    
    if (isset($caraPrint)){ ?>
        <tr>
            <td colspan="3">
                <?php echo $this->renderPartial('application.views.headerReport.headerDefaultKwitansi', array('noKwitansi'=>$slippage)); ?>
            </td>
        </tr>
    <?php } $format = new MyFormatter(); ?>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <table align="center" cellspacing=0 width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" align="center">
                            <div align="center" style="font-size:15pt;text-decoration: underline;"><b>KUITANSI<?php echo $ru; ?></b></div>
                        </td>
                    </tr>                    
                    <!--tr>
                        <td width="20%">No. Kuitansi</td>
                        <td width="2%">:</td>
                        <td align="left"><?php echo $modTandaBukti->nobuktibayar;?></td>
                    </tr-->
                    <tr>
                        <td>Sudah Terima Dari</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->darinama_bkm;?></td>
                    </tr>
                    <tr>
                        <td>Uang Sejumlah</td>
                        <td>:</td>
                        <td class="terbilang">
                            <?php
                                if($modTandaBukti->jmlpembayaran == 0)
                                {
                                    echo '-';
                                }else{
                                    echo strtoupper($format->formatNumberTerbilang($modTandaBukti->jmlpembayaran)) . ' RUPIAH';
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Untuk Pembayaran</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->sebagaipembayaran_bkm;?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                    </tr>
                    <?php /*
                    <tr>
                        <td>Nama Pasien</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->nama_pasien; ?> - No. RM : <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->pasien->no_rekam_medik ?></td>
                    </tr>
                    <tr>
                        <td>Cara Bayar</td>
                        <td>:</td>
                        <td><?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->carabayar->carabayar_nama; ?> - Penjamin : <?php echo $modTandaBukti->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama ?></td>
                    </tr> */ ?>
                </tbody>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="60%" align="center">
                            <div align="center">
                                <br>
                                <div align="center" style="border:1px solid #000000;width:200px;padding:5px;" class="uang">
                                    Rp. <?php echo number_format($modTandaBukti->jmlpembayaran,0,'','.');?>,-
                                </div>
                                <br>
                                <div colspan="2" class="catatan">
                                    LEMBAR I : Pasien<br/>
                                    LEMBAR II : Ruangan<br/>
                                    LEMBAR III : Arsip Keuangan<br/>
                                    <!--
                                    Catatan : untuk pembayaran melalui Cheque / Bilyet Giro (BG)<br>
                                    Belum dianggap lunas apabila Cheque/Bilyet Giro (BG) Belum Diuangkan<br>
                                    <i>*Kuitansi ini sah bila ada tandatangan petugas dan cap <?php echo $data->nama_rumahsakit; ?>*</i>
                                    -->
                                </div>
                            </div>
                        </td>
                        <td class="tandatangan">

                            <?php echo Yii::app()->user->getState('kecamatan_nama') ?>, 
                            <?php 
                                $format = new MyFormatter();
                                $tgl = $modTandaBukti->tglbuktibayar;
                                $tglBayar = explode(" ",$tgl);
                                $tanggal = date('Y-m-d H:i:s'); //$tglBayar[0];
								$tgls = Myformatter::formatDateTimeId($tanggal);
								echo $tgls;
                            ?>
                           
                            <br>
                            Petugas Kasir,<br><br><br><br>                           
                            <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                            <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b><br/>
                            <b style="border-top: 1px solid black;">NIP. <?php echo empty($pegawai)?"-":$pegawai->nomorindukpegawai; ?></b>
                                
                            
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <?php if (!isset($caraPrint)){ ?>
        <tr>
            <td colspan="3" style="border-bottom:1px solid #000000;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">Printed at <?php echo date("d/m/y h:m:s");?></td>
        </tr>   
    <?php } ?>
</table>
<?php if (isset($caraPrint)) { ?>
<?php  }else{
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
//      echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//      echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
      
//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKuitansi');
        $urlUpdateDN=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/updateDN');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idTandaBuktiBayar = $modBayar->tandabuktibayar_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    var dariNamaBKM = $('#TandabuktibayarT_darinama_bkm').val();
    var urlUpdateDN = '${urlUpdateDN}&tandabuktibayar_id='+${idTandaBuktiBayar}+'&darinama_bkm='+dariNamaBKM;
    $.post(urlUpdateDN, {tandabuktibayar_id: ${idTandaBuktiBayar}, darinama_bkm:dariNamaBKM}, "json");

    window.open("${urlPrint}&idPembayaranPelayanan=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>