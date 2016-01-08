<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPemeliharaanAset->getAttributeLabel('pemeliharaanaset_no')); ?>:</b>
            <?php echo CHtml::encode($modPemeliharaanAset->pemeliharaanaset_no); ?>
            <br />
            <b><?php echo CHtml::encode($modPemeliharaanAset->getAttributeLabel('pemeliharaanaset_tgl')); ?>:</b>
            <?php echo CHtml::encode($modPemeliharaanAset->pemeliharaanaset_tgl); ?>
             <br/>
        </td>
        <td>
            <b><?php echo CHtml::encode($modPemeliharaanAset->getAttributeLabel('pemeliharaanaset_ket')); ?>:</b>
            <?php echo CHtml::encode($modPemeliharaanAset->pemeliharaanaset_ket); ?>
            <br />
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No. Urut</th>
        <th>Barang</th>
        <th>Kodisi Aset</th>
        <th>Keterangan Aset</th>
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDetailPemeliharaan AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $detail->barang->barang_nama; ?></td>
                <td><?php echo $detail->kondisiaset; ?></td>
                <td><?php echo $detail->keteranganaset; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
</table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
?>
<script type="text/javascript">
function print(caraPrint)
{
var id = <?php echo $_GET['id']; ?>;
var url = '<?php echo $this->createUrl("Print"); ?>';
    window.open(url+"&pemeliharaanaset_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>