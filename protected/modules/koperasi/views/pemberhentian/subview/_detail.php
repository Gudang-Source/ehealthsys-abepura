<style>
	.mark-line td , .mark-line th {
		border-bottom: 1px solid black;
	}
</style>
<div class="panel panel-primary col-sm-12">
    <div class="block-tabel">
	<h6><b>Simpanan</b></h6>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>Tgl Simpanan</th>
						<th>Jenis Simpanan</th>
						<th>Pokok Simpanan</th>
						<th>Jasa Simpanan</th>
						<th>Total Simpanan</th>
					</tr>
				</thead>
				<tbody id="content-simpanan"></tbody>
				<tfoot>
					<tr>
						<td colspan="4" style='color:#373e4a;'><b>Total Keseluruhan Simpanan</b></td>
						<td style="text-align:right;" id="total-content-simpanan"></td>
					</tr>
				</tfoot>
			</table>
    </div>
</div>
	<br/>
   <div class="panel panel-primary col-sm-12">  
       <div class="block-tabel">
	<h6><b>Pinjaman</b></h6>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>Tgl Pinjaman</th>
						<th>Jumlah Angsuran</th>
						<th>Jasa Angsuran</th>
						<th>Total Angsuran</th>
						<th>Terbayar</th>
						<th>Sisa</th>
					</tr>
				</thead>
				<tbody id="content-angsuran"></tbody>
				<tfoot>
					<tr>
						<td colspan="5" style='color:#373e4a;'><b>Total Sisa Angsuran</b></td>
						<td style="text-align:right;" id="total-content-angsuran"></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="panel-body col-sm-12">
		 <div class="block-tabel">
                    <h6><b>Total Keseluruhan</b></h6>
			<?php
			echo $form->hiddenField($berhenti, 'jmlsimpanan_berhenti');
			echo $form->hiddenField($berhenti, 'jmltunggakan_berhenti');
			echo $form->hiddenField($berhenti, 'jmlkasmasuk_keluar');
			?>
		
	
			<table class="table table-bordered table-condensed">
				<tbody>
					<tr>
						<th style='color:#373e4a;'>Total Simpanan Keseluruhan</th>
						<td width="200" style="text-align:right" id="total-simpanan">0</td>
					</tr>
					<tr class="mark-line">
						<th style='color:#373e4a;'>Total Sisa Angsuran Keseluruhan</th>
						<td style="text-align:right" id="total-angsuran">0</td>
					</tr>
					<tr>
						<th style='color:#373e4a;'>Total Penarikan</th>
						<td style="text-align:right" id="penarikan">0</td>
					</tr>
				</tbody>
			</table>
		
                    </div>
	</div>
	<div class="panel-body col-sm-12" style="text-align:center" id="area-print-detail">

	</div>
</div>
