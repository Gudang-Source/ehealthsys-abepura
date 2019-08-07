<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Detail</div>
	</div>
	<div class="panel-body col-sm-12">
    <table class="table table-bordered datatable dataTable">
			<thead>
    	<tr>
    			<th>Tgl Pinjaman</th>
					<th>Tgl Angsuran</th>
					<th>Angsuran Ke</th>
    			<th>Jumlah Angsuran</th>
    			<th>Jasa Angsuran</th>
    			<th>Total Angsuran</th>
    			<th>Terbayar</th>
    			<th>Sisa</th>
    		</tr>
			</thead>
			<tbody>
				<?php
				$total = 0;
				foreach ($angsuran as $item) {
					$total += $item->jmlpokok_angsuran + $item->jmljasa_angsuran;
					$pinjaman = PinjamanT::model()->findByPk($item->pinjaman_id);
				?>
				<tr>
					<td>
						<?php //echo CHtml::hiddenField('angsuran[]', $item->jmlangsuran_id); ?>
						<?php echo CHtml::hiddenField('angsuran['.$item->jmlangsuran_id.'][jmlpokok_angsuran]', $item->jmlpokok_angsuran); ?>
						<?php echo CHtml::hiddenField('angsuran['.$item->jmlangsuran_id.'][jmljasa_angsuran]', $item->jmljasa_angsuran); ?>
						<?php echo CHtml::hiddenField('angsuran['.$item->jmlangsuran_id.'][jmlbayar_pembangsuran]', $item->sisa); ?>
						<?php echo CHtml::hiddenField('angsuran['.$item->jmlangsuran_id.'][byrangsuranke]', $item->angsuran_ke); ?>
						<?php echo date("d/m/Y", strtotime($pinjaman->tglpinjaman)); ?>
					</td>
					<td><?php echo date("d/m/Y", strtotime($item->tglangsuran)); ?></td>
					<td style="text-align: right"><?php echo $item->angsuran_ke; ?></td>
					<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jmlpokok_angsuran); ?></td>
					<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jmljasa_angsuran); ?></td>
					<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jmlpokok_angsuran + $item->jmljasa_angsuran); ?></td>
					<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint(($item->jmlpokok_angsuran + $item->jmljasa_angsuran) - $item->sisa); ?></td>
					<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->sisa); ?></td>
				</tr>
				<?php } ?>
			</body>
			<tfoot>
				<tr>
					<td colspan="7">
						Total Keseluruhan
						<?php echo CHtml::hiddenField('total_pembayaran', $total); ?>
					</td>
					<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
				</tr>
			</tfoot>
    </table>
  </div>
</div>
