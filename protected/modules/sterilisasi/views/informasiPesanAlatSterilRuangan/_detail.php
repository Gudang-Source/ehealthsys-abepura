<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<fieldset>
    <table class="items table table-striped table-bordered table-condensed">
        <tr>
            <td>No. Pemesanan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_no) ? $model->pesanperlinensteril_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemesanan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_tgl) ? MyFormatter::formatDateTimeForUser($model->pesanperlinensteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pemesanan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMemesan->NamaLengkap) ? $model->pegawaiMemesan->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->pesanperlinensteril_ket) ? $model->pesanperlinensteril_ket : "-"; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan dan Linen</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
				$disabled = false;
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->pesan->ruangan_id) ? $detail->pesan->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang->barang_id) ? $detail->barang->barang_id : ""); ?></td>
                <td><?php echo (!empty($detail->pesanperlinensterildet_jml) ? $detail->pesanperlinensterildet_jml : ""); ?></td>
                <td><?php echo (!empty($detail->pesanperlinensterildet_ket) ? $detail->pesanperlinensterildet_ket : ""); ?></td>
            </tr>
            <?php    }
            }else{ $disabled = false;
            ?>
			<tr>
				<td colspan="5">Data tidak ditemukan.</td>
			</tr>
			<?php } ?>
        </tbody>
    </table>
</fieldset>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-success', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
?>
<script type="text/javascript">
function print(caraPrint)
{
    var pesanperlinensteril_id = '<?php echo isset($_GET['pesanperlinensteril_id']) ? $_GET['pesanperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printDetail'); ?>&pesanperlinensteril_id='+pesanperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>