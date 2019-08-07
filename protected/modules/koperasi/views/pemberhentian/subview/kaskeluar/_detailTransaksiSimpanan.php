<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Detail</div>
	</div>
	<div class="panel-body col-sm-12">
    <table class="table table-bordered datatable dataTable">
      <thead>
        <tr>
          <th>Tgl Simpanan</th>
          <th>Jenis Simpanan</th>
          <th>Pokok Simpanan</th>
          <th>Jasa Simpanan</th>
          <th>Total Simpanan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($simpanan as $item) {
					$jasa = 0;

					$s = InformasijasasimpananV::model()->findByAttributes(array('simpanan_id'=>$item->simpanan_id));
          if (!empty($s)) $jasa = $s->jasasimpanan;
          $jenis = JenissimpananM::model()->findByPk($item->jenissimpanan_id);
          $total += $item->jumlahsimpanan + $jasa;
					$bln = $this->getJasaSimpanan($item);
         ?>
        <tr>
          <td>
						<?php echo date('d/m/Y', strtotime($item->tglsimpanan)); ?>
						<?php
						echo CHtml::hiddenField('simpanan['.$item->simpanan_id.'][jml_pokok_pengambilan]', $item->jumlahsimpanan);
						echo CHtml::hiddenField('simpanan['.$item->simpanan_id.'][jml_jasa_pengambilan]', $jasa);
						echo CHtml::hiddenField('simpanan['.$item->simpanan_id.'][jml_pengambilan]', $item->jumlahsimpanan + $jasa);
						echo CHtml::hiddenField('simpanan['.$item->simpanan_id.'][lamasimpanan_bln]', $bln);
						?>
					</td>
          <td><?php echo $jenis->jenissimpanan; ?></td>
          <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jumlahsimpanan); ?></td>
          <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($jasa); ?></td>
          <td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jumlahsimpanan + $jasa); ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Total Simpanan</td>
          <td style="text-align: right">
						<?php echo MyFormatter::formatNumberForPrint($total); ?>
						<?php echo CHtml::hiddenField('total_simpanan', $total); ?>
					</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
