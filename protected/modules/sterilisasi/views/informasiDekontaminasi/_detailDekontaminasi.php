<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<fieldset>
    <table class="items table table-striped table-condensed">
        <tr>
            <td>No. Dekontaminasi</td>
            <td>:</td>
            <td><?php echo isset($model->dekontaminasi_no) ? $model->dekontaminasi_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Dekontaminasi</td>
            <td>:</td>
            <td><?php echo isset($model->dekontaminasi_tgl) ? MyFormatter::formatDateTimeForUser($model->dekontaminasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Dekontaminasi</td>
            <td>:</td>
            <td><?php echo (isset($model->pegpetugas->NamaLengkap) ? $model->pegpetugas->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->dekontaminasi_ket) ? $model->dekontaminasi_ket : ""; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Penerimaan Sterilisasi</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Lama Dekontaminasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
				$disabled = false;
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->penerimaansterilisasi_id) ? $detail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang_id) ? $detail->barang->barang_nama : ""); ?></td>
                <td><?php echo (!empty($detail->dekontaminasidetail_jml) ? $detail->dekontaminasidetail_jml : ""); ?></td>
                <td><?php echo (!empty($detail->dekontaminasidetail_lama) ? $detail->dekontaminasidetail_lama : ""); ?></td>
            </tr>
            <?php    }
            }else{ $disabled = true; 
            ?>
			<tr>
				<td colspan="6">Data tidak ditemukan</td>
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
    var dekontaminasi_id = '<?php echo isset($_GET['dekontaminasi_id']) ? $_GET['dekontaminasi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printDetail'); ?>&dekontaminasi_id='+dekontaminasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>