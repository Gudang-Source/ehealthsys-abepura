<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Periode Penilaian','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
				$this->widget('MyDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'periodepenilaian',
					'mode'=>'date',
					'options'=> array(
						'showOn' => false,
						// 'maxDate' => 'd',
						'yearRange'=> "-150:+0",
					),
					'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
					),
				)); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
				$this->widget('MyDateTimePicker',array(
					'model'=>$model,
					'attribute'=>'sampaidengan',
					'mode'=>'date',
					'options'=> array(
						'showOn' => false,
						// 'maxDate' => 'd',
						'yearRange'=> "-150:+0",
					),
					'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker3 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
					),
				)); ?>
			</div>
		</div>
	</div>
	<div class="span4" >
		<div class="control-group" >
			<label style=" float: right">Waktu Pengisian : &nbsp; <span id="time" style="font-size: 15px; color: #800000;"></span></label>
		</div>
	</div>
</div>
<style>
	.tablepenilaian tr th{
		text-align: center;
		vertical-align: middle;
	}
</style>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-bordered table-condensed tablepenilaian" width="100%">
			<thead>
				<tr>
					<th colspan="4" rowspan="2">BERILAH TANDA (.) PADA KOLOM RATING SESUAI PENDAPAT ANDA</th>
				</tr>
				<tr></tr>
				<tr>
					<th width="20%">Jenis Penilaian</th>
					<th width="20%">Kompetensi</th>
					<th width="20%">Indikator Perilaku</th>
					<th width="40%">Uraian <span class="required">*</span></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$modIndikatorPerilakus = KPIndikatorperilakuM::model()->findAllByAttributes(array('indikatorperilaku_aktif'=>true),array('order'=>'jenispenilaian_id asc,kompetensi_id asc'));
				if(count($modIndikatorPerilakus)>0){
					foreach($modIndikatorPerilakus as $ii =>$modIndikatorPerilaku){
						echo "<tr id=tr$modIndikatorPerilaku->indikatorperilaku_id>";
							echo "<td>".$modIndikatorPerilaku->jenispenilaian->jenispenilaian_nama.
										$form->hiddenField($modPenilaianPegawaiDet,'['.$ii.']jenispenilaian_id',array('class'=>'span1','readonly'=>TRUE,'value'=>$modIndikatorPerilaku->jenispenilaian_id))
								."</td>";
							echo "<td>".$modIndikatorPerilaku->kompetensi->kompetensi_nama.
										$form->hiddenField($modPenilaianPegawaiDet,'['.$ii.']kompetensi_id',array('class'=>'span1','readonly'=>TRUE,'value'=>$modIndikatorPerilaku->kompetensi_id))
								."</td>";
							echo "<td>".$modIndikatorPerilaku->indikatorperilaku_nama.
										$form->hiddenField($modPenilaianPegawaiDet,'['.$ii.']indikatorperilaku_id',array('class'=>'span1','readonly'=>TRUE,'value'=>$modIndikatorPerilaku->indikatorperilaku_id)).
										$form->hiddenField($modPenilaianPegawaiDet,'['.$ii.']penilaianpegdet_socre',array('onkeypress'=>'$(this).focusNextInputField(event)')).
										$form->hiddenField($modPenilaianPegawaiDet,'['.$ii.']kolomrating_id',array('class'=>'span1'))
								."</td>";
							echo "<td>".
									$form->textField($modPenilaianPegawaiDet,'['.$ii.']penilaianpegdet_socre',array('class'=>'numbers-only','style'=>'width:60px','onkeypress'=>'$(this).focusNextInputField(event)','placeholder'=>'','onblur'=>'cekScore(this)','readonly'=>FALSE)).
									CHtml::activeHiddenField($modPenilaianPegawaiDet,'['.$ii.']kolomrating_id',array('class'=>'span1','readonly'=>TRUE))
									."</td>";
// ada perbedaan isi tabel kolomrating_m pada db_innovaehospital_dev_20151216 dengan db_innovaehospital_dev
//							echo "<td>";
//									$modKolomRatings = KPKolomratingM::model()->findAllByAttributes(array('indikatorperilaku_id'=>$modIndikatorPerilaku->indikatorperilaku_id),array('order'=>'indikatorperilaku_id asc'));?>
<!--									<table>
										<?php // foreach($modKolomRatings as $iv => $modKolomRating){ ?>
											<tr>
												<td><?php // echo "<input type='radio' id='radiorating[$ii][$iv]' name='radiorating[$ii]' value='$modKolomRating->kolomrating_id' onclick='setKolomRating(this,$ii);'>"; ?>
													<?php // echo CHtml::activeHiddenField($modKolomRating,'['.$ii.']['.$iv.']kolomrating_point',array('class'=>'span1','readonly'=>TRUE)); ?>
												</td>
												<td><?php // echo $modKolomRating->kolomrating_uraian; ?></td>
											</tr>
										<?php // } ?>
									</table>-->
									<?php
//							echo "</td>";
						echo "</tr>";
					}
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='4'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" style='text-align: right; font-weight: bold'>Total Score Level</td>
					<td><?php echo $form->textField($model,'jumlahpenilaian',array('class'=>'numbers-only','style'=>'width:130px','onkeypress'=>'$(this).focusNextInputField(event)','readonly'=>true)) ?></td>
				</tr>
				<tr>
					<td colspan="3" style='text-align: right; font-weight: bold'>Rata-rata Level</td>
					<td><?php echo $form->textField($model,'nilairatapenilaian',array('class'=>'numbers-only','style'=>'width:130px','onkeypress'=>'$(this).focusNextInputField(event)','readonly'=>true)) ?></td>
				</tr>
				<tr>
					<td colspan="3" style='text-align: right; font-weight: bold'>Level KKJ</td>
					<td><?php echo $form->textField($model,'performanceindex',array('class'=>'numbers-only','style'=>'width:130px','onkeypress'=>'$(this).focusNextInputField(event)','readonly'=>false)) ?></td>
				</tr>
				<tr>
					<td colspan="3" style='text-align: right; font-weight: bold'>Saran</td>
					<td><?php echo $form->textarea($model,'keterangan_score',array('style'=>'width:130px','onkeypress'=>'$(this).focusNextInputField(event)','readonly'=>false)) ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>