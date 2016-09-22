<style>
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
    
    .table{
        box-shadow:none;
    }
        

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerRincian'); ?>
<table class='table' >
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('nopemakaianbrg')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPemakaianbarang->nopemakaianbrg); ?>
        </td>
        <td>&nbsp;</td>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('ruangan_id')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPemakaianbarang->ruangan->ruangan_nama); ?>
        </td>
    </tr>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('tglpemakaianbrg')); ?></b>
        </td>
        <td>
            : <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($modPemakaianbarang->tglpemakaianbrg)); ?>
        </td>
        <td>&nbsp;</td>
        <td>            
            <b><?php echo CHtml::encode($modPemakaianbarang->getAttributeLabel('untukkeperluan')); ?></b>
        </td>
        <td>
            : <?php echo CHtml::encode($modPemakaianbarang->untukkeperluan); ?>            
        </td>
    </tr>    
             
</table>

<table id="tableObatAlkes" class="table border">
    <thead>
        <th>No. Urut</th>
        <th>Barang</th>
        <th>Jml Pakai</th>
        <!--<th>Satuan</th>-->
        <th>Catatan</th>
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDetailPemakaian AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $detail->barang->barang_nama; ?></td>
                <td><?php echo $detail->jmlpakai.' '.$detail->satuanpakai; ?></td>
               <!-- <td><?php //echo $detail->satuanpakai; ?></td>-->
                <td><?php echo $detail->catatanbrg; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
</table>
<table class = "table" width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                        
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" style="text-align:center;">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Mengetahui<br></div>
                        <div style="margin-top:60px;"><?php echo $modPemakaianbarang->pegawai->namaLengkap ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
?>
<script type="text/javascript">
function print(caraPrint)
{
var id = <?php echo $_GET['id']; ?>;
var url = '<?php echo $this->createUrl("Print"); ?>';
    window.open(url+"&pemakaianbarang_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>