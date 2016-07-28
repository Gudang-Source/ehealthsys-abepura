<div class="white-container">
    <legend class="rim2">Transaksi <b>Pemeliharaan Aset</b></legend>
	<?php 
        Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#sterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('sterilisasi-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash("success","Data Pemeliharaan Aset berhasil disimpan!");
		}
    ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
	<fieldset class="box" id="form-penerimaan">
        <legend class="rim"><span class='judul'>Pencarian Data Aset </span></legend>
        <div>
            <?php $this->renderPartial($this->path_view.'_pencarian', 
					array(
						'modPemeliharaan' => $modPemeliharaan, 
						'modPemeliharaanDetail'=>$modPemeliharaanDetail,
						'asalaset'=>$asalaset,
						'kategoriaset'=>$kategoriaset
					)); 
			?>
        </div>
    </fieldset>
    
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penyimpanansteril-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);','onSubmit'=>'return requiredCheck(this);'),
    )); ?>

    <div class="block-tabel" id="form-sterilisasi">
        <h6>Tabel <b>Pemeliharaan Aset</b></h6>
		<table id="tabel-sterilisasi" class="items table table-striped table-condensed">
			<thead>
				<tr>
					<th>Pilih
						<?php echo CHtml::checkBox('check_semua',true, array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked')) ?>
					</th>					
					<th>Kode Inventarisasi</th>
					<th>Kategori Aset</th>
					<th>Kode Aset</th>
					<th>Nama Aset</th>
					<th>Waktu Pengecekan <font style = "color:red;">*</font></th>
                                        <th>Kondisi Aset <font style = "color:red;">*</font></th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php
                                        $no=0;
					if(count($modPenyimpananPemeliharaanDetail) > 0){
						foreach($modPenyimpananPemeliharaanDetail as $i=>$detail){
							$detail->invgedung_id = $detail->invgedung_id;
							$detail->invasetlain_id = $detail->invasetlain_id;
							$detail->inventarisasi_id = $detail->inventarisasi_id;
							$detail->invperalatan_id = $detail->invperalatan_id;
							$detail->barang_id = $detail->barang_id;
							$detail->asalaset_id = $detail->asalaset_id;
							$detail->pemeliharaanaset_id = $detail->pemeliharaanaset_id;
							$detail->waktuCek = $detail->pemeliharaanasetdet_tgl;
							$detail->kondisiaset = $detail->kondisiaset;
							$detail->keteranganaset = $detail->keteranganaset;
							echo $this->renderPartial($this->path_view.'_rowBarang',array(
									'detail'=>$detail, 'no'=>$no
							));
                                                        $no++;
						}
					}
				?>
			</tbody>
		</table>
    </div>
	
	<fieldset class="box" id="form-penyimpanansteril">
		<legend class="rim">Data Pemeliharaan</legend>
		<?php echo $this->renderPartial($this->path_view.'_form', array(
					'form'=>$form,
					'modPemeliharaanAset'=>$modPemeliharaanAset, 
				));
		?>
	</fieldset>
	
    <div class="row-fluid">
        <div class="form-actions">
			<?php 
			if(isset($_GET['pemeliharaanaset_id'])){
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))."&nbsp;"; 
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT');return false",'disabled'=>FALSE  ));
			}else{
				echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'validasiCek();', 'onclick'=>'validasiCek();'))."&nbsp"; 
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE,'style'=>'cursor:not-allowed;'));
			}
			?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
			<?php 
			$content = $this->renderPartial($this->path_view.'tips/tipsPenyimpananSteril',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPemeliharaan'=>$modPemeliharaan,'modPemeliharaanAset'=>$modPemeliharaanAset,'modPenyimpananPemeliharaanDetail'=>$modPenyimpananPemeliharaanDetail)); ?>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogDetailsTarif',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Komponen Tarif',
                'autoOpen'=>false,
                'width'=>350,
                'height'=>350,
                'resizable'=>false,
                'scroll'=>false    
                 ),
        ));
        echo "tes";
        $this->endWidget('zii.widgets.jui.CJuiDialog');

?>