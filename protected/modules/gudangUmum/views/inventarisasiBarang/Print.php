<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
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
//if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
//}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align:center;"colspan="6">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
    <tr>
        <td><b>No. Inventarisasi Barang</b></td>
        <td>:</td>
        <td><?php echo $model->invbarang_no; ?></td>

        <td><b>Total Harga</b></td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->invbarang_totalharga); ?></td>
    </tr>
    <tr>
        <td><b>Tanggal Inventarisasi Barang</b></td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->invbarang_tgl); ?></td>

        <td><b>Total HPP</b></td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->invbarang_totalnetto); ?></td>
    </tr>
    <?php if(isset($model->formuliropname_id)){ ?>
    <tr>
        <td><b>No. Formulir Inventarisasi</b></td>
        <td>:</td>
        <td><?php echo $model->formulirinvbarang->forminvbarang_no; ?></td>

        <td><b>Total Volume</b></td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->formulirinvbarang->forminvbarang_totalvolume); ?></td>
    </tr>
    <tr>
        <td><b>Tanggal Formulir Opname</b></td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->formulirinvbarang->forminvbarang_tgl); ?></td>

        <td><b>Total Harga</b></td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->formulirinvbarang->forminvbarang_totalharga); ?></td>
    </tr>
    <?php } ?>
    </table><br/>
<table class="table border" style = "box-shadow:none;" border="1">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>No. Seri</th>
            <th>HPP (Rp)</th>
            <th>Harga Jual (Rp)</th>
            <th>Fisik</th>
            <th>Tgl Cek Fisik</th>
            <th>Kondisi Barang</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($modDetails as $i=>$barang){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $barang->barang->barang_kode; ?></td>
            <td><?php echo $barang->barang->barang_nama; ?></td>
            <td><?php echo $barang->barang->barang_merk; ?></td>
            <td><?php echo $barang->barang->barang_noseri; ?></td>
            <td style="text-align:right;"><?php echo $format->formatNumberForPrint($barang->harga_netto); ?></td>
            <td style="text-align:right;"><?php echo $format->formatNumberForPrint($barang->harga_satuan); ?></td>
            <td style="text-align:center;"><?php echo $format->formatNumberForPrint($barang->volume_fisik); ?></td>
            <td style="text-align:center;"></td>
            <td><?php echo $barang->kondisi_barang ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<table width="100%" style="margin-top:20px;">
<tr>
    <td width="100%" align="left" align="top">
        <table width="100%">
            <tr>
                <td width="35%" style="text-align:center;" colspan="3"> </td>
                <td width="35%" style="text-align:center;" colspan="3"></td>
                <td width="35%" style="text-align:center;" colspan="3"><div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div></td>
            </tr>
            <tr>
                <td style="text-align:center;" colspan="3">
                    <div>Petugas 2</div>                    
                </td>
                <td width="35%" style="text-align:center;" colspan="3">
                    <div>Petugas 1</div>                    
                </td>
                <td width="35%" style="text-align:center;" colspan="3">                    
                    <div>Mengetahui</div>                    
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center;"><div><?php echo ($model->petugas2_id)?PegawaiM::model()->findByPk($model->petugas2_id)->NamaLengkap:""; ?></div></td>
                <td colspan="3" style="text-align:center;"><div><?php echo ($model->petugas1_id)?PegawaiM::model()->findByPk($model->petugas1_id)->NamaLengkap:""; ?></div></td>
                <td colspan="3" style="text-align:center;"><div><?php echo ($model->mengetahui_id)?PegawaiM::model()->findByPk($model->mengetahui_id)->NamaLengkap:""; ?></div></td>
            </tr>
        </table>
    </td>
</tr>
</table>

    <?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"))."&nbsp;&nbsp;";
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        invbarang_id = '<?php echo isset($model->invbarang_id) ? $model->invbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&invbarang_id='+invbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
    }
    </script>
<?php
} ?>
<?php //} 
    ?>