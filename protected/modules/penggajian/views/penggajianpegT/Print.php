<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));  
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
     .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
');
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td width="11%" style="text-align:right;"><b> NIP </b> </td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?>
                    </td>
                    <td width="11%" style="text-align:right;"><b>No. Rekening</b></td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($modelpegawai->no_rekening) ? $modelpegawai->no_rekening : "-"); ?>
                    </td>
                </tr>
                <tr> 
                    <td width="11%" style="text-align:right;"><b>Pegawai</b></td><td width="2%">:</td>
                    <td width="37%">
                        <?php
                            echo CHtml::encode($modelpegawai->nama_pegawai);
                        ?>
                    </td>
                    <td width="11%" style="text-align:right;"><b>Bank</b></td><td width="2%">:</td>
                    <td width="37%">
                        <?php
                            echo CHtml::encode(isset($modelpegawai->banknorekening) ? $modelpegawai->banknorekening : "-");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;"><b>Tempat Lahir</b></td><td width="2%">:</td>
                    <td width="37%">    
                        <?php echo CHtml::encode($modelpegawai->tempatlahir_pegawai); ?>
                    </td>
                    <td width="11%" style="text-align:right;"><b>No. Telepon</b></td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($modelpegawai->notelp_pegawai) ? $modelpegawai->notelp_pegawai : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;"><b>Tanggal Lahir</b></td><td width="2%">:</td>
                    <td width="37%">    
                        <?php
                            echo MyFormatter::formatDateTimeForUser(CHtml::encode($modelpegawai->tgl_lahirpegawai));   
                        ?>
                    </td>
                    <td width="11%" style="text-align:right;"><b>No. Mobile</b></td><td width="2%">:</td>
                    <td width="37%">    
                        <?php
                            echo CHtml::encode(isset($modelpegawai->nomobile_pegawai) ? $modelpegawai->nomobile_pegawai : "-");   
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;"><b>Jenis Kelamin</b> </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($modelpegawai->jeniskelamin); ?>
                    </td>
                    <td width="11%" style="text-align:right;"><b>Agama</b></td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($modelpegawai->agama); ?>
                    </td>
                </tr> 
                <tr>
                    <td width="11%" style="text-align:right;"><b>Tanggal Penggajian</b> </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($model->tglpenggajian)); ?>
                    </td>
                    <td width="11%" style="text-align:right;"><b>Alamat</b> </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode(!empty($modelpegawai->alamat_pegawai) ? $modelpegawai->alamat_pegawai : "-"); ?>
                    </td>
                </tr>    
                <tr>
                    <td width="11%" style="text-align:right;"><b>No. Penggajian</b> </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode($model->nopenggajian); ?>
                    </td>
                </tr>  
                <tr>
                    <td width="11%" style="text-align:right;"><b>Keterangan</b> </td><td width="2%">:</td>
                    <td width="37%">    
                            <?php echo CHtml::encode(!empty($model->keterangan) ? $model->keterangan : "-"); ?>
                    </td>
                </tr>     
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table border'>
    <thead>
        <tr>
            <th>
                Deskripsi
            </th>
            <th>
                Gaji (Rp)
            </th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($modDetail as $i => $detail){
    ?>
        <tr>
            <th><?php echo $detail->komponen->komponengaji_nama; ?></th>
            <th style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($detail->jumlah); ?></th>
        </tr>
    <?php
        }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th style="text-align: right">Total Gaji</th>
            <th style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalterima)); ?>
            </th>
        </tr>
        <tr>
            <th style="text-align: right">Total Pajak</th>
            <th style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalpajak)); ?>
            </th>
        </tr>
        <tr>
            <th style="text-align: right">Penerimaan Bersih</th>
            <th style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->penerimaanbersih)); ?>
            </th>
        </tr>
    </tfoot>
</table>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $model->mengetahui; ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo $model->menyetujui; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>