<?php
    Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
                $('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>
<?php
	$criteria = new CDbCriteria;
        $criteria->group = 'rekening3_id,nmrekening3';
        $criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
        $criteria->order = 'rekening3_id,nmrekening3';
	
	if(!empty($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) || $model->periodeposting_id){		
		$periodeposting_id = isset($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) ? $_GET['AKLaporanperubahanmodalV']['periodeposting_id'] : isset($model->periodeposting_id) ? $model->periodeposting_id : null;
		$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
			$modPeriode = AKPeriodepostingM::model()->findByPk($periodeposting_id);
	}
	
	if(!empty($_GET['AKLaporanperubahanmodalV']['ruangan_id']) || $model->ruangan_id){		
		$ruangan_id = isset($_GET['AKLaporanperubahanmodalV']['ruangan_id']) ? $_GET['AKLaporanperubahanmodalV']['ruangan_id'] : isset($model->ruangan_id) ? $model->ruangan_id : null;
		$criteria->addCondition('ruangan_id = '.$ruangan_id);
	}
    $modelLaporan = AKLaporanperubahanmodalV::model()->findAll($criteria);

	$spasi = '&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<div id="tableLaporan" class="grid-view">
<table class="table table-striped table-condensed">
        <thead>
            <tr>
				<th id="tableLaporan_c0" style="text-align:left; height: 30px; vertical-align: middle;">
					Rincian
				</th>				
				<th id="tableLaporan_c0" style="text-align:left; height: 30px; vertical-align: middle;">
					Total Nominal
				</th>
			</tr>
        </thead>
        <tbody>
			<?php
			$spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$nmrekening3_temp = "";
			$jumlah = 0;
			foreach ($modelLaporan as $key => $rekening3) {
				if ($rekening3->nmrekening3) {
					$totSaldo = $rekening3->jumlah;
					$nmrekening3 = $rekening3->nmrekening3;
					$rekening3_id = $rekening3->rekening3_id;
				} else {
					$nmrekening3 = '-';
				}

				if ($nmrekening3_temp != $nmrekening3) {

					echo "
							<tr>
								<td width='200px;'><b>" . $nmrekening3 . "</b></td>
								<td width='150px;' style='text-align:right'><b>" . number_format($rekening3->jumlah) . "</b></td>
							</tr>
						";
					$jumlah += $rekening3->jumlah;
					$criteria2 = new CDbCriteria;
					$term3 = $nmrekening3;
					if (!empty($periodeposting_id)) {
						$criteria2->addCondition('periodeposting_id =' . $periodeposting_id);
					}
					$condition4 = "nmrekening3 ILIKE '%" . $term3 . "%'";
					$criteria2->addCondition($condition4);
					$criteria2->limit = -1;
					$criteria2->group = 'rekening3_id,nmrekening3,rekening4_id,nmrekening4';
					$criteria2->select = $criteria2->group . ', sum(jumlah) as jumlah';
					$criteria2->order = 'rekening3_id,nmrekening3,rekening4_id,nmrekening4 ASC';

					$detail = AKLaporanperubahanmodalV::model()->findAll($criteria2);
					foreach ($detail as $key => $rekening4) {

						if ($rekening4->nmrekening4) {
							$nmrekening4 = $rekening4->nmrekening4;
						} else {
							$nmrekening4 = '-';
						}

						echo "<tr>
								<td width='200px;'>" . $spasi2 . $rekening4->getNamaRekening() . "</td>
								<td width='150px;' style='text-align:right'>" . number_format($rekening4->jumlah) . "</td>
							  </tr>";
					}

					$nmrekening3_temp = $nmrekening3;
				}
			}
			?>
			<tr>
				<td style='text-align:right'><strong>Saldo Per <?php echo $format->formatDateTimeForUser(date('Y-m-d H:i:s')); ?></strong></td>
				<td width='150px;' style='text-align:right'><strong><?php echo number_format($jumlah); ?></strong></td>
			</tr>
		</tbody>
	</table>
</div>