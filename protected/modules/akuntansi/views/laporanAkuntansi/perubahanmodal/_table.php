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
    $criteria->group = 'periodeposting_id, tglperiodeposting_awal, tglperiodeposting_akhir, labarugi, ekuitas, prive, modal';
    $criteria->select = $criteria->group;
	
	if(!empty($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) || $model->periodeposting_id){		
		$periodeposting_id = isset($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) ? $_GET['AKLaporanperubahanmodalV']['periodeposting_id'] : isset($model->periodeposting_id) ? $model->periodeposting_id : null;
		$criteria->addCondition('periodeposting_id = '.$periodeposting_id);
			$modPeriode = AKPeriodepostingM::model()->findByPk($periodeposting_id);
	}
	
	if(!empty($_GET['AKLaporanperubahanmodalV']['ruangan_id']) || $model->ruangan_id){		
		$ruangan_id = isset($_GET['AKLaporanperubahanmodalV']['ruangna_id']) ? $_GET['AKLaporanperubahanmodalV']['ruangan_id'] : isset($model->ruangan_id) ? $model->ruangan_id : null;
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
					
				</th>
				<th id="tableLaporan_c0" style="text-align:left; height: 30px; vertical-align: middle;">
					
				</th>
				<th id="tableLaporan_c0" style="text-align:left; height: 30px; vertical-align: middle;">
					
				</th>
			</tr>
        </thead>
        <tbody>
			<?php
				if(count($modelLaporan) > 0){
					foreach($modelLaporan as $i=>$modal){
			?>
			<tr>
				<td><strong>Modal Awal <?php echo MyFormatter::formatDateTimeId($modal->tglperiodeposting_awal); ?></strong></td>
				<td></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatUang($modal->ekuitas); ?></td>
			</tr>
			<?php
				$criteria_detail = new CDbCriteria;
				if(!empty($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) || $model->periodeposting_id){		
					$periodeposting_id = isset($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) ? $_GET['AKLaporanperubahanmodalV']['periodeposting_id'] : isset($model->periodeposting_id) ? $model->periodeposting_id : null;
					$criteria_detail->addCondition('periodeposting_id = '.$modal->periodeposting_id);
				}

				if(!empty($_GET['AKLaporanperubahanmodalV']['ruangan_id']) || $model->ruangan_id){		
					$ruangan_id = isset($_GET['AKLaporanperubahanmodalV']['ruangna_id']) ? $_GET['AKLaporanperubahanmodalV']['ruangan_id'] : isset($model->ruangan_id) ? $model->ruangan_id : null;
					$criteria_detail->addCondition('ruangan_id = '.$ruangan_id);
				}
				$modDetail = AKLaporanperubahanmodalV::model()->findAll($criteria_detail);
				foreach($modDetail as $ii=>$detail){
			?>
			<tr>
				<td><?php echo $spasi." ".$detail->getNamaRekening(); ?></td>
				<td></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatUang($detail->saldoakhirberjalan); ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td><strong>Laba Bersih</strong></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatUang($modal->labarugi); ?></td>
				<td></td>				
			</tr>
			<tr>
				<td><strong>Prive</strong></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatUang($modal->prive); ?></td>
				<td></td>				
			</tr>
			<tr>
				<td><strong>Modal Akhir <?php echo MyFormatter::formatDateTimeId($modal->tglperiodeposting_akhir); ?></strong></td>
				<td></td>
				<td style="text-align:right;"><?php echo MyFormatter::formatUang($modal->modal); ?></td>
			</tr>
			<?php 
					}
				}else{
			?>
			<tr>
				<td><strong>Modal Awal <?php echo (isset($modPeriode->tglperiodeposting_awal) ? MyFormatter::formatDateTimeId($modPeriode->tglperiodeposting_awal) : NULL); ?></strong></td>
				<td></td>
				<td style="text-align:right;">0</td>
			</tr>
			<tr>
				<td><strong>Laba Bersih</strong></td>
				<td style="text-align:right;">0</td>
				<td></td>				
			</tr>
			<tr>
				<td><strong>Prive</strong></td>
				<td style="text-align:right;">0</td>
				<td></td>				
			</tr>
			<tr>
				<td><strong>Modal Akhir <?php echo (isset($modPeriode->tglperiodeposting_akhir) ? MyFormatter::formatDateTimeId($modPeriode->tglperiodeposting_akhir) : NULL); ?></strong></td>
				<td></td>
				<td style="text-align:right;">0</td>
			</tr>
			<?php } ?>
        </tbody>
</table>
</div>