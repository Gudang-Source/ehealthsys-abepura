<style>
    table{
        font-size: 11px;
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
<table width="100%">
    <tr>
        <td colspan="3">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultLab'); ?>
        </td><br/><br/>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="3">
            <div align="center"><b>KUITANSI</b></div> <br/>
            <table align="center" cellspacing=0 width="100%" border="1">
                <tbody>
                                           
                    <tr style="border:2px;">
                        <td width="15%"> Nama Pasien</td>
                        <td width="2%" align="center">:</td>
                        <td align="left"><?php echo (isset($modTandaBukti->pembayaran->pendaftaran->pasien->nama_pasien) ? $modTandaBukti->pembayaran->pendaftaran->pasien->nama_pasien : $modPendaftaran->pasien->nama_pasien); ?></td>
                    </tr>
                    <tr>
                        <td> Alamat</td>
                        <td  align="center">:</td>
                        <td><?php echo (isset($modTandaBukti->pembayaran->pendaftaran->pasien->alamat_pasien) ? $modTandaBukti->pembayaran->pendaftaran->pasien->alamat_pasien : $modPendaftaran->pasien->alamat_pasien); ?></td>
                        <td> No. Lab</td>
                        <td  align="center">:</td>
                        <td><?php echo (isset($modTandaBukti->pembayaran->pendaftaran->no_pendaftaran) ? $modTandaBukti->pembayaran->pendaftaran->no_pendaftaran : $modPendaftaran->no_pendaftaran); ?></td>
                    </tr>
                    <tr>
                        <td> Umur</td>
                        <td  align="center">:</td>
                        <td><?php echo (isset($modTandaBukti->pembayaran->pendaftaran->umur) ? $modTandaBukti->pembayaran->pendaftaran->umur : $modPendaftaran->umur) ;?></td>
                        <td> Tgl. Pembayaran</td>
                        <td  align="center">:</td>
                        <td><?php echo (isset($modTandaBukti->pembayaran->tglpembayaran) ? $modTandaBukti->pembayaran->tglpembayaran : "") ;?></td>
                    </tr>
                    
                </tbody>
            </table><br/><br/>
            <table align="center" cellspacing=0 width="60%"style="margin-left:30px;">
                <tr>
                    <td width="15%"> Sudah Terima Dari</td>
                    <td width="2%">:</td>
                    <td align="left">
                        <?php echo CHtml::textField('darinama_bkm',(isset($modTandaBukti->darinama_bkm) ? $modTandaBukti->darinama_bkm : ""),array('class'=>'span5', 'title'=>'Tekan tombol Enter untuk melakukan perubahan data')); ?>
                    </td>
                </tr>
                <tr>
                    <td> Banyak Uang</td>
                    <td>:</td>
                    <td><?php echo (isset($modTandaBukti->jmlpembayaran) ? $format->formatNumberTerbilang($modTandaBukti->jmlpembayaran) : 0);?></td>
                </tr>
                <tr>
                    <td> Untuk Pembayaran</td>
                    <td>:</td>
                    <td><?php echo (isset($modTandaBukti->sebagaipembayaran_bkm) ? $modTandaBukti->sebagaipembayaran_bkm : "");?></td>
                </tr>
            </table>
            <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="50%" align="center">
                            <div align="center">
                                <div align="center" style="border:0px solid #000000;width:200px;padding:10px;float:left;margin-left:-35px;">
                                    <b>Jumlah Rp <?php echo (isset($modTandaBukti->jmlpembayaran) ? number_format($modTandaBukti->jmlpembayaran,0,'','.') : 0);?></b>
                                </div>                                
                            </div>
                        </td>
                        <td align="center">
                            <div align="center">
                                <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".(isset($modTandaBukti->tglbuktibayar) ? $modTandaBukti->tglbuktibayar : $format->formatDateTimeForUser(date('Y-m-d')));?></div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>
                                    <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                                    <b>(<?php echo $pegawai->nama_pegawai; ?>)</b>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom:1px solid #000000;border-bottom-style:dotted">&nbsp;</td>
    </tr>        
</table>
<?php $this->endWidget(); ?>
<?php if (isset($caraPrint)) { ?>
<?php  }else{

//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printKwitansi');
$pendaftaran_id = $modPendaftaran->pendaftaran_id;
$idPasienadmisi = ((isset($modBayar->pasienadmisi_id)) ? $modBayar->pasienadmisi_id : null);
$idPembayaranPelayanan = $modBayar->pembayaranpelayanan_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&pendaftaran_id=${pendaftaran_id}&idPasienadmisi=${idPasienadmisi}&idPembayaranPelayanan=${idPembayaranPelayanan}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>
