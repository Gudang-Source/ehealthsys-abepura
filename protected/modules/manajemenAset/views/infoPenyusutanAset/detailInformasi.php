<!--
Data dibawah masih belum valid dikarenakan data di tabel penyusutanaset_v belum ada dan belum ada format yang ditentukan
-->
<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPenyusutanAset->getAttributeLabel('no_penyusutan')); ?>:</b>
            <?php echo CHtml::encode($modPenyusutanAset->no_penyusutan); ?>
            <br />
            <b><?php echo CHtml::encode($modPenyusutanAset->getAttributeLabel('tgl_penyusutan')); ?>:</b>
            <?php echo MyFormatter::formatDateTimeForUser(CHtml::encode($modPenyusutanAset->tgl_penyusutan)); ?>
             <br/>
        </td>
        <td>
            <b><?php //echo CHtml::encode($modPenyusutanAset->getAttributeLabel('ruangan_id')); ?></b>
            <?php //echo CHtml::encode($modPenyusutanAset->ruangan->ruangan_nama); ?>
            <br />
            <b><?php //echo CHtml::encode($modPenyusutanAset->getAttributeLabel('untukkeperluan')); ?></b>
            <?php //echo CHtml::encode($modPenyusutanAset->untukkeperluan); ?>
            <br />
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No. Urut</th>
        <th>Periode</th>
        <th>Saldo</th>
        <th>Persentase</th>
      <!--  <th>Catatan</th>-->
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDetailPenyusutan AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo MyFormatter::formatDateTimeForUser($detail->penyusutanaset_periode); ?></td>
                <td style = "text-align:right;"><?php echo $detail->penyusutanaset_saldo; ?></td>
                <td style = "text-align:right;"><?php echo $detail->penyusutanaset_persentase; ?></td>                
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
    window.open(url+"&penyusutanaset_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>