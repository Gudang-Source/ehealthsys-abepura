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
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td>Tanggal Pengeluaran</td><td>:</td>
                    <td width="100%">
                        <?php echo CHtml::encode($model->tglpengeluaran); ?>
                    </td>
                    <td>Harga Satuan</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->hargasatuan) ? MyFormatter::formatNumberForPrint($model->hargasatuan) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>No. Pengeluaran</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->nopengeluaran) ? $model->nopengeluaran : "-"); ?>
                    </td>
                    <td>Total Harga</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalharga)); ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap>Kelompok Transaksi</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->kelompoktransaksi); ?>
                    </td>
                    <td nowrap>Keterangan Pengeluaran</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->keterangankeluar) ? $model->keterangankeluar : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Pengeluaran </td><td>:</td>
                    <td>
                        <?php 
						$p = JenispengeluaranM::model()->findByPk($model->jenispengeluaran_id);
						echo CHtml::encode($p->jenispengeluaran_nama); ?>
                    </td>
					<?php /*
                    <td>Nama Penandatangan </td><td>:</td>
                    <td nowrap>
                        <?php echo CHtml::encode(isset($model->namapenandatangan) ? $model->namapenandatangan : "-"); ?>
                    </td>
					 * 
					 */ ?>
                </tr>
                <tr>
                    <td>Volume  </td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->volume).' '.CHtml::encode($model->satuanvol); ?>
                    </td>
                </tr>
                   
            </table>            
        </td>
    </tr>
</table><br>

<?php if (count($modUraian) != 0): ?>

<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>Uraian</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modUraian as $i => $uraian) { ?>
        <tr>
            <td>
                <?php echo isset($uraian->uraiantransaksi)?$uraian->uraiantransaksi:'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->volume)?$uraian->volume:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->satuanvol)?$uraian->satuanvol:'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->hargasatuan)?  MyFormatter::formatNumberForPrint($uraian->hargasatuan):'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->totalharga)?MyFormatter::formatNumberForPrint($uraian->totalharga):'-'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php endif; ?>