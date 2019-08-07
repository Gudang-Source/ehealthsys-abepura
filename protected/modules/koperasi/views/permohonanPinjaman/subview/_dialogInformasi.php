<?php 
	$approval = new ApprovalT;
	$permintaan = new InformasipermohonanpinjamanV;
?>
<!-- Dialog Persetujuan -->
<div class="modal fade custom-width" id="dialog_persetujuan">
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Persetujuan Permohonan Pinjaman</h4>
			</div>
			<div class="modal-body">
				<form id="form-penyetujuan" class="form-horizontal">
					<div class="panel panel-body">
						<div class="panel panel-primary col-sm-12">
							<div class="panel-heading panel-heading2">
								<div class="panel-title">Data Permohonan</div>
							</div>
							<div class="panel-body col-sm-12">
								<div class="panel-body col-sm-6">
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'no anggota', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'nokeanggotaan', array('readonly'=>true, 'class'=>'form-control peg')); ?>			
											<?php echo CHtml::activeHiddenField($permintaan, 'permohonanpinjaman_id'); ?>			
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'nama anggota', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'nama_pegawai', array('readonly'=>true, 'class'=>'form-control peg')); ?>			
										</div>
									</div>
                                                                    <?php /*
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'unit', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'namaunit', array('readonly'=>true, 'class'=>'form-control peg')); ?>			
										</div>
									</div> */ ?>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'golongan', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'golonganpegawai_nama', array('readonly'=>true, 'class'=>'form-control peg')); ?>			
										</div>
									</div>
								</div>
								<div class="panel-body col-sm-6">
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'No Permohonan', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'nopermohonan', array('readonly'=>true, 'class'=>'form-control')); ?>			
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'Tgl Permohonan', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'tglpermohonanpinjaman', array('readonly'=>true, 'class'=>'form-control')); ?>			
										</div>
									</div>
									<div class="form-group" hidden>
										<?php echo CHtml::activeLabel($permintaan, 'Jasa Pinjam', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'jasapinjaman_bln', array('readonly'=>true, 'class'=>'form-control')); ?>			
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'Jenis Pinjaman', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'jenispinjaman_permohonan', array('readonly'=>true, 'class'=>'form-control')); ?>			
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'Jumlah Pinjaman', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'jmlpinjaman', array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align: right')); ?>			
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'Jangka Waktu', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'jangkawaktu_pinj_bln', array('readonly'=>true, 'class'=>'form-control')); ?>			
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($permintaan, 'Untuk Keperluan', array('class'=>'control-label col-sm-4')); ?>
										<div class="col-sm-8">
											<?php echo CHtml::activeTextField($permintaan, 'untukkeperluan', array('readonly'=>true, 'class'=>'form-control')); ?>			
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-primary col-sm-12">
							<div class="panel-heading panel-heading2">
								<div class="panel-title">Persetujuan</div>
							</div>
							<div class="panel-body col-sm-12">
								<div class="panel-body col-sm-12">
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'tgl disetujui', array('class'=>'control-label col-sm-2')); ?>
										<div class="col-sm-5">
											<?php
											//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
												//'model'=>$approval, 'attribute'=>'tglapproval', 'htmlOptions'=>array('class'=>'form-control tanggal'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
											//));
											?>
                                                                                    
                                                                                        <?php   
                                                                                            
                                                                                            $this->widget('MyDateTimePicker',array(
                                                                                            'model'=>$approval,
                                                                                            'attribute'=>'tglapproval',
                                                                                            'mode'=>'date',
                                                                                            'options'=> array(
                                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                                'maxDate' => 'd',
                                                                                            ),
                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                                                                        ));?>	
										</div>
										<div class="col-sm-5">
											<?php echo CHtml::activeDropDownList($approval, 'status_disetujui', array(true=>'Diterima', false=>'Ditolak'), array('class'=>'form-control')); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'cara_bayar', array('class'=>'control-label col-sm-2')); ?>
										<div class="col-sm-5">
											<?php echo CHtml::activeDropDownList($approval, 'cara_bayar', Params::caraBayarPinjaman(), array('class'=>'form-control')); ?>
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'keterangan approval', array('class'=>'control-label col-sm-2')); ?>
										<div class="col-sm-10">
											<?php echo CHtml::activeTextArea($approval,'keteranganapproval',array('rows'=>3, 'cols'=>50, 'class'=>'form-control','style'=>'resize:none;')); ?>
										</div>
									</div>
								</div>
								<hr style="border: 1px solid #eee;">
								<div class="panel-body col-sm-6">
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'diperiksa', array('class'=>'control-label col-sm-3')); ?>
										<div class="col-sm-9">
											<?php 
											$this->widget('MyJuiAutoComplete',array(
								                                    'attribute'=>'appr_diperiksaoleh_id',
								                                    'model'=>$approval,
								                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
								                                    'options'=>array(
								                                       'showAnim'=>'fold',
								                                       'minLength' => 4,
								                                       'focus'=> 'js:function( event, ui ) {
								                                            $("#ApprovalT_appr_diperiksaoleh_id").val( ui.item.value );
								                                            return false;
								                                        }', 
								                                       'select'=>'js:function( event, ui ) {
								                                            loadAnggotaPegawai(ui.item.attr);
								                                        }',
								
								                                    ),
								                                    'htmlOptions'=>array('readonly'=>true, 'placeholder'=>'Pemeriksa','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
								                                    'tombolModal'=>array('idModal'=>'dialog_pengurus','idTombol'=>'tombolAnggota', 'jsFunction'=>"$('#pengurus-switcher').val('diperiksaoleh'); $('#dialog_pengurus').modal('show');"),
								                                
								                        ));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'tanggal', array('class'=>'control-label col-sm-3')); ?>
										<div class="col-sm-9">
											<?php
											//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
												//'model'=>$approval, 'attribute'=>'appr_tgldiperiksa', 'htmlOptions'=>array('class'=>'form-control tanggal'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
											//));
											?>
                                                                                         <?php   
                                                                                            
                                                                                            $this->widget('MyDateTimePicker',array(
                                                                                            'model'=>$approval,
                                                                                            'attribute'=>'appr_tgldiperiksa',
                                                                                            'mode'=>'date',
                                                                                            'options'=> array(
                                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                                'maxDate' => 'd',
                                                                                            ),
                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                                                                        ));?>	
										</div>
									</div>
								</div>
								<div class="panel-body col-sm-6">
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'disetujui', array('class'=>'control-label col-sm-3')); ?>
										<div class="col-sm-9">
											<?php 
											$this->widget('MyJuiAutoComplete',array(
								                                    'attribute'=>'appr_disetujuioleh_id',
								                                    'model'=>$approval,
								                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
								                                    'options'=>array(
								                                       'showAnim'=>'fold',
								                                       'minLength' => 4,
								                                       'focus'=> 'js:function( event, ui ) {
								                                            $("#ApprovalT_appr_disetujuioleh_id").val( ui.item.value );
								                                            return false;
								                                        }', 
								                                       'select'=>'js:function( event, ui ) {
								                                            loadAnggotaPegawai(ui.item.attr);
								                                        }',
								
								                                    ),
								                                    'htmlOptions'=>array('readonly'=>true, 'placeholder'=>'Penyetujui','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
								                                    'tombolModal'=>array('idModal'=>'dialog_pengurus','idTombol'=>'tombolAnggota', 'jsFunction'=>"$('#pengurus-switcher').val('disetujuioleh'); $('#dialog_pengurus').modal('show');"),
								                                
								                        ));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php echo CHtml::activeLabel($approval, 'tanggal', array('class'=>'control-label col-sm-3')); ?>
										<div class="col-sm-9">
											<?php
											//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
											//	'model'=>$approval, 'attribute'=>'appr_tgldisetujui', 'htmlOptions'=>array('class'=>'form-control tanggal'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
											//));
											?>
                                                                                         <?php   
                                                                                            
                                                                                            $this->widget('MyDateTimePicker',array(
                                                                                            'model'=>$approval,
                                                                                            'attribute'=>'appr_tgldisetujui',
                                                                                            'mode'=>'date',
                                                                                            'options'=> array(
                                                                                                'dateFormat'=>Params::DATE_FORMAT,
                                                                                                'maxDate' => 'd',
                                                                                            ),
                                                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                                                                        ));?>	
										</div>
									</div>
									<?php echo CHtml::hiddenField('pengurus-switcher'); ?>
									<?php echo CHtml::activeHiddenField($approval, 'appr_diperiksaoleh_id', array('id'=>'diperiksaoleh_id')); ?>
									<?php echo CHtml::activeHiddenField($approval, 'appr_disetujuioleh_id', array('id'=>'disetujuioleh_id')); ?>
								</div>
							</div>
						</div>
						<div class="panel-body col-sm-12" style="text-align: center">
							<?php  echo Chtml::button('OK', array('class' => 'btn btn-success btn-setuju', 'onclick'=>'kirimPersetujuan()')); ?>
							<?php  echo Chtml::button('Batal', array('class' => 'btn btn-danger btn-setuju', 'onclick'=>'$("#dialog_persetujuan").modal("hide")')); ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade custom-width" id="dialog_pengurus">
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Pengurus Koperasi</h4>
			</div>
			<div class="modal-body">
				<div class="modal-body">
				<?php 
					echo CHtml::hiddenField('target_attr', null);
					$pegawai = new PegawaiM;
					if (isset($_GET['PegawaiM'])) $pegawai->attributes = $_GET['PegawaiM'];
					$this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'pegawai-pengurus-m-grid',
					'dataProvider'=>$pegawai->searchPengurus(),
					'filter'=>$pegawai,
					'itemsCssClass' => 'table table-striped table-condensed',
					'columns'=>array(
						array(
							'type'=>'raw',
							'value'=>function($data) {
								return CHtml::link('<i class="entypo-check"></i>', '#', array('onclick'=>'loadPengurusDariDialog("'.$data->pegawai_id.'", "'.$data->nama_pegawai.'"); $("#dialog_pengurus").modal("hide"); return false;'));
							},
						),
						'nomorindukpegawai',
						'no_kartupegawainegerisipil',
						//'pegawai_id',
						'noidentitas',
						array(
							'header'=>'Nama Pegawai',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
						)
						),
					)); 
				
				?>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade custom-width" id="dialog_sumberPotongan">
	<div class="modal-dialog" style="width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close"></button>
				<h4 class="modal-title">Ubah Sumber Potongan</h4>
			</div>
			<div class="modal-body">
				<div class="panel-body">
					<form id="form-ubahSumber" class="form-horizontal">
					
						<div class="form-group">
						<?php 
							echo CHtml::hiddenField('id_potongan');
							$potongan = PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true')); 
							foreach ($potongan as $data){
								/*echo CHtml::checkbox('potongan['.$data->potongansumber_id.'][check]',false, array("uncheckValue"=>null, 'class'=>'checkPotongan', 'onchange'=>'checkDisableInput()'))." ";
								echo $data->namapotongan; 
								echo CHtml::textField('potongan['.$data->potongansumber_id.'][text]', 0, array('class'=>'form-control num potongan', 'disabled'=>false));
								echo "<br/>";*/?>
								<div class="form-group">
									<label class="col-sm-4 control-label">
										<?php echo CHtml::checkbox('potongan['.$data->potongansumber_id.'][check]', false, array("uncheckValue"=>null, 'class'=>'checkPotongan', 'onchange'=>'checkDisableInput()'))." "; ?>
										<?php echo $data->namapotongan; ?>
									</label>
									<div class="col-sm-6">
										<?php echo CHtml::textField('potongan['.$data->potongansumber_id.'][text]', 0, array('class'=>'form-control num potongan', 'disabled'=>true)); ?>
									</div>
									<label class="control-label col-sm-2">Rupiah</label>
								</div>
						<?php
							}
						?>
						</div>
							<?php  echo Chtml::button('OK', array('class' => 'btn btn-success btn-ubah', 'onclick'=>'ubahSumber()')); ?>
							<?php  echo Chtml::button('Batal', array('class' => 'btn btn-danger btn-batal', 'onclick'=>'$("#dialog_sumberPotongan").modal("hide")')); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>