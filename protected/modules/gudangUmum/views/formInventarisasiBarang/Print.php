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
<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: right;" valign="middle" colspan="5">
            <b><?php echo $judulLaporan ?></b>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><b>No. Formulir</b> </td>
        <td>:</td>
        <td><?php echo $model->forminvbarang_no; ?></td>

        <td><b>Total Volume</b></td>
        <td>:</td>
        <td><?php echo $format->formatNumberForPrint($model->forminvbarang_totalvolume); ?></td>
    </tr>
    <tr>
        <td><b>Tanggal Formulir</b> </td>
        <td>:</td>
        <td><?php echo $format->formatDateTimeForUser($model->forminvbarang_tgl); ?></td>

        <td><b>Total Harga</b></td>
        <td>:</td>
        <td><?php echo "Rp".$format->formatNumberForPrint($model->forminvbarang_totalharga); ?></td>
    </tr>
    </table><br/>
<table width="100%" border="0" class = "border">
    <thead>
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Kode Barang</th>
            <th style="text-align: center;">Nama Barang</th>
            <th style="text-align: center;">Merk</th>
            <th style="text-align: center;">No. Seri</th>
            <th style="text-align: center;">Satuan Kecil</th>
            <th style="text-align: center;">HPP (Rp.)</th>
            <th style="text-align: center;">Inventarisasi Sistem</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($modDetails as $i=>$barang){
        ?>
        <tr>
            <td style="text-align: center;"><?php echo ($i+1); ?></td>
            <td style="text-align: center;"><?php echo (isset($barang->barang->barang_kode) ? $barang->barang->barang_kode : ""); ?></td>
            <td><?php echo $barang->barang->barang_nama; ?></td>
            <td><?php echo $barang->barang->barang_merk; ?></td>
            <td><?php echo $barang->barang->barang_noseri; ?></td>
            <td><?php echo $barang->barang->barang_satuan; ?></td>
            <td style="text-align:right;"><?php 
            $data = BarangM::model()->findByPk($barang->barang_id);
            echo $format->formatNumberForPrint(
            (isset($data->barang_hpp) && !empty($data->barang_hpp) && $data->barang_hpp != 0) ? $data->barang_hpp : $data->barang_harganetto
            ); 
            ?></td>
            <td style="text-align:right;"><?php echo $format->formatNumberForPrint($barang->volume_inventaris); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
  
<table width="100%" style="margin-top:20px;">
<tr>
    <td width="100%" align="left" align="top">
        <table width="100%">
            <tr>
                <td width="35%" style="text-align:center;">
                </td>
                <td width="35%" style="text-align:center;">
                </td>
                <td width="35%" style="text-align:center;">
                    <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                    <div>Petugas</div>                    
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align:center;"><div><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div></td>
            </tr>
        </table>
    </td>
</tr>
</table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"))."&nbsp;"."&nbsp;";
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        formulirinvbarang_id = '<?php echo isset($model->formulirinvbarang_id) ? $model->formulirinvbarang_id : ''; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&formulirinvbarang_id='+formulirinvbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
    }
    </script>
    
<?php
} //else{ ?>

<?php //} 
