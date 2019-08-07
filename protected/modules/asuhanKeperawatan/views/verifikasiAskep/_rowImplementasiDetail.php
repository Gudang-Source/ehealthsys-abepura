<?php ?>
<tr class="rencanaaskepdet">
	<td class="diagnosa">
		<?php echo CHtml::activeHiddenField($modImplementasiDet, '[0]implementasiaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php echo CHtml::activeHiddenField($modImplementasiDet, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php
		if (!empty($modImplementasiDet->diagnosakep_id)) {
			echo CHtml::activeHiddenField($modImplementasiDet, '[0]isdiagnosa', array('value' => 1, 'onkeyup' => "return $(this).focusNextInputField(event);"));
			echo CHtml::activeTextField($modImplementasiDet, '[0]diagnosakep_nama', array('readonly' => true));
		echo "<br>";
		echo "<br>";
		echo '<strong>Batasan Karakteristik</strong>';
		echo "<br>";
		$bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modImplementasiDet->diagnosakep_id));
		if (count($bk_head)) {
			foreach ($bk_head as $i => $bk) {
				echo "<ul class='spasi1'>";
				echo '<li >' . $bk->bataskarakteristik_nama . '</li>';
				$bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
				if (count($bk_tail)) {
					foreach ($bk_tail as $i => $bkd) {
						echo '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
					}
				} else {
					echo "<ul class='spasi1'>";
					echo '<li> Data tidak ditemukan. </li>';
					echo "</ul>";
				}
				echo "</ul>";
			}
		} else {
			echo "<ul class='spasi1'>";
			echo '<li> Data tidak ditemukan. </li>';
			echo "</ul>";
		}

		echo "<br>";

		echo '<strong>Faktor Risiko</strong>';
		echo "<br>";
		$bk_head = FaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $modImplementasiDet->diagnosakep_id));
		if (count($bk_head)) {
			foreach ($bk_head as $i => $bk) {
				echo "<ul class='spasi1'>";
				echo '<li >' . $bk->faktorrisiko_nama . '</li>';
				$bk_tail = FaktorrisikodetM::model()->findAllByAttributes(array('faktorrisikodet_aktif' => true, 'faktorrisiko_id' => $bk->faktorrisiko_id));
				if (count($bk_tail)) {
					foreach ($bk_tail as $i => $bkd) {
						echo '<li >' . $bkd->faktorrisikodet_indikator . '</li>';
					}
				} else {
					echo "<ul class='spasi1'>";
					echo '<li> Data tidak ditemukan. </li>';
					echo "</ul>";
				}
				echo "</ul>";
			}
		} else {
			echo "<ul class='spasi1'>";
			echo '<li> Data tidak ditemukan. </li>';
			echo "</ul>";
		}

		echo "<br>";

		echo '<strong>Faktor Yang Berhubungan</strong>';
		echo "<br>";
		$bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $modImplementasiDet->diagnosakep_id));
		if (count($bk_head)) {
			foreach ($bk_head as $i => $bk) {
				echo "<ul class='spasi1'>";
				echo '<li >' . $bk->faktorhub_nama . '</li>';
				$bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
				if (count($bk_tail)) {
					foreach ($bk_tail as $i => $bkd) {
						echo '<li >' . $bkd->faktorhubdet_indikator . '</li>';
					}
				} else {
					echo "<ul class='spasi1'>";
					echo '<li> Data tidak ditemukan. </li>';
					echo "</ul>";
				}
				echo "</ul>";
			}
		} else {
			echo "<ul class='spasi1'>";
			echo '<li> Data tidak ditemukan. </li>';
			echo "</ul>";
		}

		echo "<br>";

		echo '<strong>Diagnosa Alternatif</strong>';
		echo "<br>";
		$bk_head = AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $modImplementasiDet->diagnosakep_id));
		if (count($bk_head)) {
			foreach ($bk_head as $i => $bk) {
				echo "<ul class='spasi1'>";
				echo '<li >' . $bk->alternatifdx_nama . '</li>';
				echo "</ul>";
			}
		} else {
			echo "<ul class='spasi1'>";
			echo '<li> Data tidak ditemukan. </li>';
			echo "</ul>";
		}
		}else{
			echo CHtml::activeHiddenField($modImplementasiDet, '[0]isdiagnosa', array('value' => 1, 'onkeyup' => "return $(this).focusNextInputField(event);"));
			echo CHtml::activeTextField($modImplementasiDet, '[0]diagnosakep_nama', array('readonly' => true));
		}
		?>
    </td>
	<td class="intervensi">
		<?php
		if (!empty($modImplementasiDet->diagnosakep_id)) {
			$tail = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,intervensidet.*
									FROM pilihrencanaaskep_t
									JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
									WHERE rencanaaskepdet_id =' . $modImplementasiDet->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
			$modInv = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $modImplementasiDet->diagnosakep_id));
			$data['table_id'] = 'table-intervensi-' . $modImplementasiDet->intervensi_id;
			echo '<table class="items table table-striped table-bordered table-condensed intervensi" id="' . $data['table_id'] . '">
            <thead>
                    <th>Intervensi</th>
                    <th>Indikator Intervensi</th>
            </thead>
			<tbody>';
			echo '<tr>';
			echo '<td>' . (!empty($modImplementasiDet->intervensi_nama) ? $modImplementasiDet->intervensi_nama : $modInv->intervensi_nama) . '</td>';
			echo '<td>';
			foreach ($tail as $i => $itv) {
				echo '<ul>';
				echo '<li>' . $itv['intervensidet_indikator'] . '</li>';
				echo '</ul>';
			}
			'</td>';
			echo '</tr>';
			echo '</tbody></table>';
		}
		?>
	</td>
	<td class="implementasi">
		<?php
		if (!empty($modImplementasiDet->diagnosakep_id)) {
			$impl = ImplementasikepM::model()->findByAttributes(array('diagnosakep_id' => $modImplementasiDet->diagnosakep_id));
			echo CHtml::activeHiddenField($modImplementasiDet, '[0]implementasikep_id', array('value' => $impl->implementasikep_id));
			echo CHtml::activeCheckBoxList($modImplementasiDet, '[0]indikatorimplkepdet_id', CHtml::listData(IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => $impl->implementasikep_id)), 'indikatorimplkepdet_id', 'indikatorimplkepdet_indikator'), (array('onclick'=>'cekListImplementasiDetail(this);','onkeyup' => "return $(this).focusNextInputField(event);")));
		}
		?>
	</td>
	<td>
		<?php
		if (!empty($modImplementasiDet->diagnosakep_id)) {
			if (!empty($modImplementasiDet->implementasiaskepdet_id)) {
				echo CHtml::activeCheckBox($modImplementasiDet, '[0]implementasiaskepdet_iskolaborasi', array('uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
			} else {
				echo CHtml::activeCheckBox($modImplementasiDet, '[0]iskolaborasi', array('readonly' => true, 'uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
			}
		} else {
			echo CHtml::activeCheckBox($modImplementasiDet, '[0]iskolaborasi', array('uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
		}
		?>
		Ya
		<br>
		<?php
		if (!empty($modImplementasiDet->implementasiaskep_id)) {
			echo CHtml::activeTextArea($modImplementasiDet, '[0]implementasiaskepdet_ketkolaborasi', array('onkeyup' => "return $(this).focusNextInputField(event);"));
		} else {
			echo CHtml::activeTextArea($modImplementasiDet, '[0]rencanaaskepdet_ketkolaborasi', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
		}
		?>
	</td>
</tr>
