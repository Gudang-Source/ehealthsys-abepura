<?php ?>
<tr class="rencanaaskepdet">
	<td>
		<?php echo CHtml::activeHiddenField($modDetail, '[0]rencanaaskepdet_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo CHtml::activeCheckBox($modDetail, '[0]isdiagnosa', array('uncheckValue' => 0, 'onclick' => 'cekListDiagnosa(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
			echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true));
		}
		echo "<div class='diagdetail'>";
		echo "<br>";
		echo "<br>";
		echo '<strong>Batasan Karakteristik</strong>';
		echo "<br>";
		$bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
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
		$bk_head = FaktorrisikoM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
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
		$bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
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
		echo CHtml::activeCheckBoxList($modDetail, '[0]alternatifdx_id', CHtml::listData(AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $modDetail->diagnosakep_id)), 'alternatifdx_id', 'alternatifdx_nama'));
		echo "</div>";
		?>
    </td>
	<td class="intervensi">
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			$tail = ASPilihrencanaaskepT::model()->findAllBySql('
									SELECT pilihrencanaaskep_t.*,intervensidet.*
									FROM pilihrencanaaskep_t
									JOIN intervensidet_m AS intervensidet ON intervensidet.intervensidet_id = pilihrencanaaskep_t.intervensidet_id
									WHERE rencanaaskepdet_id =' . $modDetail->rencanaaskepdet_id . ' AND pilihrencanaaskep_t.intervensidet_id IS NOT NULL');
			$modInv = IntervensiM::model()->findByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
			$data['table_id'] = 'table-intervensi-' . $modDetail->intervensi_id;
			echo '<table class="items table table-striped table-bordered table-condensed intervensi" id="' . $data['table_id'] . '">
            <thead>
                    <th style="color:#333">Intervensi</th>
                    <th style="color:#333">Indikator Intervensi</th>
            </thead>
			<tbody>';
			echo '<tr>';
			echo '<td>' . (!empty($modDetail->intervensi_nama) ? $modDetail->intervensi_nama : $modInv->intervensi_nama) . '</td>';
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
		if (!empty($modDetail->diagnosakep_id)) {
                    
			$impl = ImplementasikepM::model()->findByAttributes(array('diagnosakep_id' => $modDetail->diagnosakep_id));
			echo CHtml::activeHiddenField($modDetail, '[0]implementasikep_id', array('value' => !empty($impl->implementasikep_id)?$impl->implementasikep_id:null));
			echo CHtml::activeCheckBoxList($modDetail, '[0]indikatorimplkepdet_id', CHtml::listData(IndikatorimplkepdetM::model()->findAllByAttributes(array('indikatorimplkepdet_aktif' => true, 'implementasikep_id' => !empty($impl->implementasikep_id)?$impl->implementasikep_id:null)), 'indikatorimplkepdet_id', 'indikatorimplkepdet_indikator'), (array('onkeyup' => "return $(this).focusNextInputField(event);")));
		}
		?>
	</td>
	<td>
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			if (!empty($modDetail->implementasiaskepdet_id)) {
				echo CHtml::activeCheckBox($modDetail, '[0]implementasiaskepdet_iskolaborasi', array('readonly' => true, 'uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
			} else {
				echo CHtml::activeCheckBox($modDetail, '[0]iskolaborasi', array('readonly' => true, 'uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
			}
		} else {
			echo CHtml::activeCheckBox($modDetail, '[0]iskolaborasi', array('uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
		}
		?>
		Ya
		<br>
		<?php
		if (!empty($modDetail->implementasiaskep_id)) {
			echo CHtml::activeTextArea($modDetail, '[0]implementasiaskepdet_ketkolaborasi', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
		} else {
			echo CHtml::activeTextArea($modDetail, '[0]rencanaaskepdet_ketkolaborasi', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
		}
		?>
	</td>
</tr>
