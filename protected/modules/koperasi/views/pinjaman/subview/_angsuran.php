
	
	<div class="span12">
		<table class="table table-striped table-bordered table-condensed" id="tab-angsuran">
			<thead>
				<tr>
					<th >Angsuran Ke</th>
					<th>Tgl Angsuran</th>
					<th>Tgl Jatuh Tempo</th>
					<th>Pokok Angsuran</th>
					<th >Jasa Angsuran</th>
					<th>Total Angsuran</th>
				</tr>
			</thead>
			<tbody id="tab-content-angsuran">
				<?php 
					if (!empty($pinjaman->pinjaman_id)) {
						$angsuran = JmlangsuranT::model()->findAllByAttributes(array('pinjaman_id'=>$pinjaman->pinjaman_id), array('order'=>'angsuran_ke asc'));
						foreach ($angsuran as $item) : 
				?>
				<tr>
					<td><?php echo $item->angsuran_ke; ?></td>
					<td><?php echo date('d/m/Y', strtotime($item->tglangsuran)); ?></td>
					<td><?php echo date('d/m/Y', strtotime($item->tgljatuhtempoangs)); ?></td>
					<td class="num"><?php echo number_format($item->jmlpokok_angsuran, 0, ',', '.'); ?></td>
					<td class="num"><?php echo number_format($item->jmljasa_angsuran, 0, ',', '.'); ?></td>
					<td class="num"><?php echo number_format(($item->jmlpokok_angsuran + $item->jmljasa_angsuran), 0, ',', '.'); ?></td>
				</tr>
				<?php
						endforeach;
					} else {
				?>
				<tr>
					<td colspan="6"></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
            <div>