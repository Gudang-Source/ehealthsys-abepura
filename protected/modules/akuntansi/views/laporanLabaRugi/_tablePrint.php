<style>
	.main-tab td {
		vertical-align: top;
	}
	
	.table td, .table th {
		background-color: white !important;
		border: 1px solid black;
	}
	.table {
		border-collapse: collapse;
		border: 1px solid black;
		box-shadow: none;
		
	}
</style>
<table width="100%" class="main-tab">
	<tr>
		<td width="50%">
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>Rincian</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2" style="font-weight: bold; font-style:italic;">PENDAPATAN</td>
					</tr>
					<?php echo $this->renderPartial('_subTabel', array(
						'detail'=>$detail['pendapatan']['rek2'],
					), true); ?>
					<tr>
						<td style="font-weight: bold; font-style:italic; text-align: center;">TOTAL PENDAPATAN</td>
						<td style="font-weight: bold; font-style:italic; text-align: right;">
							<?php echo MyFormatter::formatNumberForPrint($detail['pendapatan']['total']); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
		<td>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>Rincian</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2" style="font-weight: bold; font-style:italic;">BIAYA</td>
					</tr>
					<?php echo $this->renderPartial('_subTabel', array(
						'detail'=>$detail['beban']['rek2'],
					), true); ?>
					<tr>
						<td style="font-weight: bold; font-style:italic; text-align: center;">TOTAL BIAYA</td>
						<td style="font-weight: bold; font-style:italic; text-align: right;">
							<?php echo MyFormatter::formatNumberForPrint($detail['beban']['total']); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<style>
				.tots td {
					font-weight: bold;
				}
				.tot {
					text-align: right !important;
					font-weight: bold;
					font-style: italic;
				}
				.totlr {
					text-align: right !important;
					font-weight: bold;
					font-style: italic;
					text-decoration: underline;
				}
			</style>


			<?php 

			$labarugi = $detail['pendapatan']['total'] - $detail['beban']['total'];
			if ($labarugi < 0) {
				$labarugi = "(".MyFormatter::formatNumberForPrint($labarugi).")";
			} else {
				$labarugi = MyFormatter::formatNumberForPrint($labarugi);
			}

			?>
			<div class="col-sm-12">
				<table class="table table-striped table-bordered table-condensed tots">
					<tbody>
						<tr>
							<td>TOTAL PENDAPATAN</td>
							<td class="tot"><?php echo MyFormatter::formatNumberForPrint($detail['pendapatan']['total']); ?></td>
						</tr>
						<tr>
							<td>TOTAL BIAYA</td>
							<td class="tot"><?php echo MyFormatter::formatNumberForPrint($detail['beban']['total']); ?></td>
						</tr>
						<tr>
							<td>LABA/RUGI</td>
							<td class="totlr"><?php echo $labarugi; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</td>
	</tr>
</table>