<?php 
?>
<tr class="rencanaaskepdet">
	<td><?php echo CHtml::activeHiddenField($modRencanaDet, '[0]rencanaaskepdet_id', array( 'class' => 'inputFormTabel')) ?>
		<?php echo CHtml::activeHiddenField($modRencanaDet, '[0]diagnosakep_id', array( 'class' => 'inputFormTabel')) ?>
		<?php
		if (!empty($modRencanaDet->diagnosakep_id)) {
			echo CHtml::activeTextField($modRencanaDet,'[0]diagnosakep_nama',array('readonly' => true));
		} else {
			$this->widget('MyJuiAutoComplete', array(
				'model' => $modRencanaDet,
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
    </td>
	<td class="tandagejala">
		<?php
		if (!empty($modRencanaDet->diagnosakep_id)) {
			echo Chtml::activeCheckBoxList($modRencanaDet, '[0]tandagejala_id', CHtml::listData(TandagejalaM::model()->findAllByAttributes(array('tandagejala_aktif' => true, 'diagnosakep_id' => $modRencanaDet->diagnosakep_id)), 'tandagejala_id', 'tandagejala_indikator'),array('onclick'=>'cekListTandaGejalaRencana(this);'));
		}
		?>
	</td>
	<td class="tujuan">
		<?php
		if (!empty($modRencanaDet->diagnosakep_id)) {
			echo CHtml::activeTextField($modRencanaDet, '[0]rencanaaskepdet_hari', array( 'class' => 'span1')) . ' x 24 Jam <br>' . $modRencanaDet->tujuan_nama;
			echo CHtml::activeHiddenField($modRencanaDet, '[0]tujuan_id', array('value' => $modRencanaDet->tujuan_id));
		}
		?>
	</td>
	<td class="kriteriahasil">
		<?php
		if (!empty($modRencanaDet->diagnosakep_id)) {
		echo CHtml::activeHiddenField($modRencanaDet, '[0]kriteriahasil_id', array('value' => $modRencanaDet->kriteriahasil_id));
		echo CHtml::activeTextField($modRencanaDet, '[0]kriteriahasil_nama', array('value' => $modRencanaDet->kriteriahasil_nama, 'class' => 'span2', 'readonly' => true));
		$tail = ASKriteriahasildetM::model()->findAllByAttributes(array('kriteriahasil_id' => $modRencanaDet->kriteriahasil_id));
				$data['table_id'] = 'table-kriteria-' . $modRencanaDet->kriteriahasil_id;
				echo '<table class="items table table-striped table-bordered table-condensed kriteria" id="' . $data['table_id'] . '">
            <thead>
                <tr>
					<th></th>
                    <th>Kriteria Hasil</th>
                    <th>IR</th>
					<th>ER</th>
                </tr>
            </thead>
			<tbody>';
				foreach ($tail as $i => $row) {

					echo '<tr class="criteria">
						<td>
							<span name="ASRencanaaskepdetT[0][kriteriahasildet_id]">
							' . CHtml::activeCheckBox($modRencanaDet, '[0]kriteriahasildet_id', array('onclick'=>'cekListKriteriaHasilRencana(this);','onkeyup' => "return $(this).focusNextInputField(event);", 'value' => $row['kriteriahasildet_id']))
							. '</span>
						</td>
						<td>
						' . $row['kriteriahasildet_indikator'] . '
						</td>
						<td>
						' . CHtml::dropDownList(
									'ASRencanaaskepdetT[0][rencanaaskep_ir]', $modRencanaDet->rencanaaskep_ir, array('1' => '1',
								'2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('class' => 'span1', 'empty' => '--Pilih--')) . '
						</td>
						<td>
						' . CHtml::dropDownList(
									'ASRencanaaskepdetT[0][rencanaaskep_er]', $modRencanaDet->rencanaaskep_er, array('1' => '1',
								'2' => '2', '3' => '3', '4' => '4', '5' => '5',), array('class' => 'span1', 'empty' => '--Pilih--')) . '
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
		if (!empty($modRencanaDet->diagnosakep_id)) {
			echo CHtml::activeHiddenField($modRencanaDet, '[0]intervensi_id', array('value' => $modRencanaDet->intervensi_id));
			echo CHtml::activeTextField($modRencanaDet, '[0]intervensi_nama', array('value' => $modRencanaDet->intervensi_nama, 'class' => 'span2', 'readonly' => true));
			echo '<br>';
			echo CHtml::activeCheckBoxList($modRencanaDet, '[0]intervensidet_id', CHtml::listData(IntervensidetM::model()->findAllByAttributes(array('intervensidet_aktif' => true, 'intervensi_id' => $modRencanaDet->intervensi_id)), 'intervensidet_id', 'intervensidet_indikator'), (array('onclick'=>'cekListIntervensiRencana(this);','onkeyup' => "return $(this).focusNextInputField(event);")));
		}
		?>
	</td>
	<td>
		<?php
		if (!empty($modRencanaDet->diagnosakep_id)) {
			echo CHtml::activeCheckBox($modRencanaDet, '[0]iskolaborasi', array('uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));
		}else{
			echo CHtml::activeCheckBox($modRencanaDet, '[0]iskolaborasi', array('uncheckValue' => 0, 'onclick' => 'cekListKolaborasi(this)', 'onkeyup' => "return $(this).focusNextInputField(event);"));	
		}?>
		Ya
		<br>
		<?php
		echo CHtml::activeTextArea($modRencanaDet, '[0]rencanaaskepdet_ketkolaborasi', array( 'onkeyup' => "return $(this).focusNextInputField(event);"));
		?>
	</td>
	<td style="text-align: center;" class="rowbutton">
<?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'addRowRencana(this)')); ?>
<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusRencana(this)')); ?>
	</td>
</tr>
