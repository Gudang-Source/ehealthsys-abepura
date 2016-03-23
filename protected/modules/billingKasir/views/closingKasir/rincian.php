<style>
    *:not(.btn) {
        font-family: sans-serif !important;
        font-size: 12px !important;
    }
    body {
        color: black;
        width: auto !important;
    }
    thead > tr > th {
        text-align: center;
        background-color: white;
    }
    .unwrap td:not(.wrap), .unwrap th {
        white-space: nowrap;
    }
    .num {
        text-align: right;
    }
    .nom {
        text-align: center;
    }
    .judul {
        text-align: center;
        margin: 5px;
        font-weight: bold;
    }
    .base {
        border: 1px solid black;
    }
    .base th {
        border-bottom: 1px solid black;
        border-right: 1px solid black;
        color: black;
        font-weight: bold;
    }
    .base td {
        vertical-align: top;
        border-right: 1px solid black;
    }
    .base th, .base td {
        padding: 2px;
        padding-left: 5px;
        padding-right: 5px;
    }
    .headee {
        border-bottom: 1px solid black;
    }
    .note {
        margin-bottom: 20px;
        font-style: italic;
    }

</style>

<?php echo $this->renderPartial('application.views.headerReport.headerRincian');  ?>

<table width="100%" class="unwrap headee">
	<tr>
		<td>Tanggal Pembayaran</td>
		<td width="100%" class="wrap">: <?php echo $closing->closingdari; ?></td>
	</tr>
	<tr>
		<td>Sampai Dengan</td>
		<td>: <?php echo $closing->sampaidengan; ?></td>
		<td>Pegawai / Kasir</td>
		<td>: <?php
		$pegawai = PegawaiM::model()->findByPk($closing->pegawai_id);
		echo $pegawai->nama_pegawai;
		?></td>
	</tr>
</table>
<div class="judul">RINCIAN PENUTUPAN</div>
<?php
if (empty($closing->totalpengeluaran)) $closing->totalpengeluaran = 0;
?>
<table width="100%" class="unwrap">
	<tr>
		<td>Tanggal Tutup Kasir </td>
		<td width="100%">: <?php echo $closing->tglclosingkasir; ?></td>
		<td>Jumlah Transaksi</td>
		<td>: <?php echo count($bkm); ?></td>
	</tr>
	<tr>
		<td>Jumlah Saldo Awal</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->closingsaldoawal); ?></td>
		<td>Jumlah Penerimaan Pelayanan</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->terimauangpelayanan); ?></td>
	</tr>
	<tr>
		<td>Terima Uang Muka</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->terimauangmuka); ?></td>
		<td>Total Pengeluaran</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->totalpengeluaran); ?></td>
	</tr>
	<tr>
		<td>Total Tutup Kasir</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->nilaiclosingtrans); ?></td>
		<td>Total Setoran</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->totalsetoran); ?></td>
	</tr>
	<tr>
		<td>Piutang</td>
		<td>: <?php echo 'Rp'.MyFormatter::formatNumberForPrint($closing->piutang); ?></td>
	</tr>
</table>
<br/>
<table width="100%" class="base">
	<thead class="unwrap">
		<tr>
			<th>No. </th>
			<th>Nilai Uang</th>
			<th>Banyak Uang</th>
			<th>Jumlah Uang</th>
		</tr>
	</thead>
	<tbody class="unwrap">
		<?php
		$cnt = 0; $val = 0;
		foreach ($rincian as $item) :
		if ($item->banyakuang == 0) continue;
		$cnt++;
		$val += $item->jumlahuang;
		?>
		<tr>
			<td class="nom"><?php echo $cnt; ?></td>
			<td class="nom wrap" width="100%"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($item->nilaiuang); ?></td>
			<td class="nom"><?php echo MyFormatter::formatNumberForPrint($item->banyakuang); ?></td>
			<td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($item->jumlahuang); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr style="border-top:1px solid">
			<td colspan="3">Total Nilai Uang</td>
			<td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($val); ?></td>
		</tr>
	</tfoot>
</table>

<div class="judul">RINCIAN PEMBAYARAN</div>
<table class="base">
	<thead>
		<tr>
			<th>No.</th>
			<th>Tgl Pembayaran</th>
			<th>No Pembayaran</th>
			<th>Nama Pasien</th>
			<th>Penjamin</th>
			<th>Metode Bayar</th>
			<th>Biaya Administrasi</th>
			<th>Biaya Materai</th>
			<th>Jumlah Invoice</th>
		</tr>
	</thead>
	<tbody class="unwrap">
		<?php
		$cnt = 0;
		$total = 0;
		foreach ($bkm as $item):
			$cnt++;
			$total += $item->jmlpembayaran;
		?>
		<tr>
			<td class="nom"><?php echo $cnt; ?></td>
			<td><?php echo $item->tglbuktibayar; ?></td>
			<td><?php
                        if (!empty($item->pembayaranpelayanan_id)) echo $item->pembayaranpelayanan->nopembayaran;
                        else {
                            $penerimaan = PenerimaanumumT::model()->findByAttributes(array('tandabuktibayar_id'=>$item->tandabuktibayar_id));
                            if (!empty($penerimaan)) echo $penerimaan->nopenerimaan;
                        }
                        ?></td>
			<td class="wrap" width="100%"><?php
			$pasien = $item->pembayaranpelayanan->pasien;
			if (empty($pasien)) $pasien = $item->bayaruangmuka->pasien;
			echo $pasien->namadepan." ".$pasien->nama_pasien;
			?></td>
			<td class="wrap" nowrap><?php echo !empty($item->pembayaranpelayanan->pendaftaran_id)?$item->pembayaranpelayanan->pendaftaran->penjamin->penjamin_nama:"UMUM"; ?></td>
			<td nowrap><?php echo $item->carapembayaran; ?></td>
			<td class="num" nowrap><?php echo 'Rp'.MyFormatter::formatNumberForPrint($item->biayaadministrasi); ?></td>
			<td class="num" nowrap><?php echo 'Rp'.MyFormatter::formatNumberForPrint($item->biayamaterai); ?></td>
			<td class="num" nowrap><?php echo 'Rp'.MyFormatter::formatNumberForPrint($item->jmlpembayaran); // materai dan administrasi sudah termasuk dalam biaya pembayaran ?></td>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr style="border-top:1px solid">
			<td colspan="8">Total</td>
			<td class="num"><?php echo 'Rp'.MyFormatter::formatNumberForPrint($total); ?></td>
		</tr>
	</tfoot>
</table>
<div class="note">* Biaya administrasi dan materai sudah termasuk pada biaya Invoice</div>

<table style="page-break-inside:avoid">
	<tr>
		<td nowrap></td>
		<td width="100%"></td>
		<td nowrap><?php
		$format = new MyFormatter;
		echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeForUser(date('Y-m-d'));
		?></td>
	</tr>
	<tr>
		<td style="text-align:center;" nowrap>
			Yang Menerima
			<br/><br/><br/><br/><br/>
			<?php
			if (isset($_GET['penerima'])) echo $_GET['penerima'];
			else {
			$pegawai = CHtml::listData(PegawaiV::model()->findAllByAttributes(array('pegawai_aktif'=>true), array('order'=>'nama_pegawai asc')), 'namaLengkap', 'namaLengkap');
                            echo CHtml::dropDownList('pegawai', ' Nia Kurniawati, SE.', $pegawai);
			}
			?>
		</td>
		<td></td>
		<td style="text-align:center;" nowrap>
			Yang Menyerahkan
			<br/><br/><br/><br/><br/>
			<?php
      $user = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
			if(isset($user->pegawai))echo $user->pegawai->nama_pegawai;
      else echo "Administrator";
			?>
		</td>
	</tr>
</table>
<?php if (isset($_GET['caraPrint'])) { ?>
<script type="text/javascript">
	window.print();
</script>
<?php  }else{
        echo "<br/>";
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\',$(\'#pegawai\').val());$(this).style(\'display:none\');'))."&nbsp&nbsp";
        $idClosing = $closing->closingkasir_id;
        $urlPrint=$this->createUrl('rincian');
$js = <<< JSCRIPT
function print(caraPrint,nama)
{
    window.open("${urlPrint}&idClosing=${idClosing}&caraPrint="+caraPrint+"&penerima="+nama,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
}?>


<?php /*
<table class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.</th>
        <th><?php echo CHtml::activeLabel($models[0], "nilaiuang"); ?></th>
        <th><?php echo CHtml::activeLabel($models[0], "banyakuang"); ?></th>
        <th><?php echo CHtml::activeLabel($models[0], "jumlahuang"); ?></th>
    </thead>
    <tbody>
        <?php
        if(count($models) > 0){
            $no = 1;
            foreach($models as $i => $model){
                if($model->banyakuang > 0){
                    echo "<tr>";
                    echo "<td>".($no)."</td>";
                    echo "<td> Rp. ".number_format($model->nilaiuang)."</td>";
                    echo "<td>".number_format($model->banyakuang)."</td>";
                    echo "<td> Rp. ".number_format($model->jumlahuang)."</td>";
                    echo "</tr>";
                    $no ++;
                }
            }
        }else{
            echo "<tr><td>Data tidak ditemukan</td></tr>";
        }
        ?>
    </tbody>
</table>

*/ ?>
