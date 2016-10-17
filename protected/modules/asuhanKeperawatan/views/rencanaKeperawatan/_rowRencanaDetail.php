<?php ?>
<tr class="rencanaaskepdet">
	<td class="diagnosa"><?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true));
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
			echo CHtml::activeCheckBoxList($modDetail, '[0]alternatifdx_id', CHtml::listData(AlternatifdxM::model()->findAllByAttributes(array('alternatifdx_aktif' => true, 'diagnosakep_id' => $modDetail->diagnosakep_id)), 'alternatifdx_id', 'alternatifdx_nama'), array('readonly' => true));
			echo "</div>";
		} else {
			$this->widget('MyJuiAutoComplete', array(
				'model' => $modDetail,
				'attribute' => '[0]diagnosakep_nama',
				//'name'=>'daftartindakan_nama',
				'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
				'options' => array(
					'showAnim' => 'fold',
					'minLength' => 2,
					'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
					'select' => 'js:function( event, ui ) {
                            setTindakan($(this), ui.item);
                            return false;
                        }',
				),
				'tombolDialog' => array("idDialog" => 'dialogDiagnosa', 'jsFunction' => "setDialog(this);"),
				'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",),
			));
		}
		?>
		<div class="diagdetail">
			
		</div>
    </td>
	<td class="tandagejala">
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo Chtml::activeCheckBoxList($modDetail, '[0]tandagejala_id', CHtml::listData(TandagejalaM::model()->findAllByAttributes(array('tandagejala_aktif' => true, 'diagnosakep_id' => $modDetail->diagnosakep_id)), 'tandagejala_id', 'tandagejala_indikator'), array('readonly' => true));
		}
		?>
	</td>
	<td class="tujuan">
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo CHtml::activeTextField($modDetail, '[0]rencanaaskepdet_hari', array('readonly' => true, 'class' => 'span1')) . ' x 24 Jam <br>' . $modDetail->tujuan_nama;
			echo CHtml::activeHiddenField($modDetail, '[0]tujuan_id', array('value' => $modDetail->tujuan_id));
		}
		?>
	</td>
	<td class="kriteriahasil">
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo CHtml::activeHiddenField($modDetail, '[0]kriteriahasil_id', array('value' => $modDetail->kriteriahasil_id));
			echo CHtml::activeTextField($modDetail, '[0]kriteriahasil_nama', array('value' => $modDetail->kriteriahasil_nama, 'class' => 'span2', 'readonly' => true));
			$tail = ASKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $modDetail->kriteriahasil_id));
			$data['table_id'] = 'table-kriteria-' . $modDetail->kriteriahasil_id;
			echo '<table class="items table table-striped table-bordered table-condensed kriteria" id="' . $data['table_id'] . '">
            <thead>
                <tr>
					<th style = "background: #7FB35D"></th>
                    <th style = "background: #7FB35D">Kriteria Hasil</th>
                    <th style = "background: #7FB35D">IR</th>
					<th style = "background: #7FB35D">ER</th>
                </tr>
            </thead>
			<tbody>';
			foreach ($tail as $i => $row) {

				echo '<tr class="criteria">
						<td>
							<span name="ASRencanaaskepdetT[0][kriteriahasildet_id]">
							' . CHtml::activeCheckBox($modDetail, '[0]kriteriahasildet_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $row['kriteriahasildet_id']))
				. '</span>
						</td>
						<td>
						' . $row['kriteriahasildet_indikator'] . '
						</td>
						<td>
						' . CHtml::activeTextField($modDetail, '[0]rencanaaskep_ir', array('readonly' => true, 'class' => 'span1')) . '
						</td>
						<td>
						' . CHtml::activeTextField($modDetail, '[0]rencanaaskep_er', array('readonly' => true, 'class' => 'span1')) . '
						</td>
						</tr>';
			}
//            <?php 
//                $trTindakan = $this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans,'kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id),true); 
//                echo $trTindakan;
			echo '</tbody></table>';
		}
		?>
	</td>
	<td class="intervensi">
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo CHtml::activeHiddenField($modDetail, '[0]intervensi_id', array('value' => $modDetail->intervensi_id));
			echo CHtml::activeTextField($modDetail, '[0]intervensi_nama', array('value' => $modDetail->intervensi_nama, 'class' => 'span2', 'readonly' => true));
			echo '<br>';
			echo CHtml::activeCheckBoxList($modDetail, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $modDetail->intervensi_id)), 'intervensidet_id', 'intervensidet_indikator'), (array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")));
		}
		?>
	</td>
	<td>
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			echo CHtml::activeCheckBox($modDetail, '[0]iskolaborasi', array('readonly' => true, 'uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
		} else {
			echo CHtml::activeCheckBox($modDetail, '[0]iskolaborasi', array('uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
		}
		?>
		Ya
		<br>
		<?php
		echo CHtml::activeTextArea($modDetail, '[0]rencanaaskepdet_ketkolaborasi', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);"));
		?>
	</td>
	<td style="text-align: center;" class="rowbutton">
		<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'addRowTindakan(this)')); ?>
<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'batalTindakan(this)')); ?>
	</td>
</tr>
