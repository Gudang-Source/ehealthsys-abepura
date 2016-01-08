<div class="white-container">
	<legend class="rim2">Transaksi <b>Pembayaran Tarif Kapitasi BPJS</b></legend>
	<fieldset class="box">
		<legend class="rim"> Pencarian </legend>
		<?php 
			$this->renderPartial($this->path_view . '_formPencarian', array('modPendaftaran'=>$modPendaftaran, 'format'=>$format));
		?>
		<?php 
				Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
		});
		$('#pencarianpendaftaran-form').submit(function(){
				return false;
		});
		");
				$this->widget('bootstrap.widgets.BootAlert'); 
		?>
	</fieldset>
<<<<<<< HEAD
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'pembayarankapitasi-t-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	));
	?>
	<fieldset class="box" id="form-perhitungan">
		<legend class="rim"><span class='judul'>Perhitungan Tarif Kapitasi</span></legend>
		<table id="tableList" class="table table-striped table-condensed">
			<thead>
				<tr>
=======
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pembayarankapitasi-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    ));
    ?>
	<div class="block-tabel" id="form-perhitungan">
            <h6><span class='judul'>Perhitungan <b>Tarif Kapitasi</b></span></h6>
	<table id="tableList" class="table table-striped table-condensed">
		<thead>
				<tr>				
>>>>>>> 12f1e5a9c072640a387b6430d541776accbca7b2
					<th>No</th>
					<th>No. Rekam Medik <br/> No. Pendaftaran</th>
					<th>Nama Pasien</th>
					<th>Tarif Kapitasi yang harus dibayar</th>
					<th></th>
					<th>Jenis Tarif Kapitasi</th>
				</tr>
			</thead>
			<?php
				$totalTarif = 0;
			?>
			<tbody>
				<?php 
					if(isset($tr)){
						echo $tr;
					}
				?>
			</tbody>
			<tfoot>
<<<<<<< HEAD
				<tr class="trfooter">
					<td colspan="3">Total</td>
					<td><?php echo CHtml::textField('ARPembayarankapitasiT_pembayarankapitasi_totaltarifkapitasi', $totalTarif, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3','style'=>'width:70px;',)); ?></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</fieldset>
=======
               <tr class="trfooter">
                    <td colspan="3">Total</td>
                    <?php
                                            $totalTarif = 0;
                    ?>
                    <td>
                        <?php echo CHtml::textField("totalTarif", $totalTarif, array('readonly'=>true,'class'=>'inputFormTabel integer lebar3','style'=>'width:70px;',)); ?>
                    </td>
                    <td></td>
                     <td></td>
                </tr>
            </tfoot>
	</table>
	</div>
	
>>>>>>> 12f1e5a9c072640a387b6430d541776accbca7b2
	<fieldset class="box" id="form-perhitungan">
		<legend class="rim"><span class='judul'>Pembayaran Tarif Kapitasi</span></legend>
		<div class="row-fluid">    
			<?php $this->renderPartial($this->path_view . '_formPembayaran', array('form' => $form, 
										'modPembayaranKapitasi'=>$modPembayaranKapitasi,
										'modPembayaranKapitasiDetail'=>$modPembayaranKapitasiDetail,
										'modTandaBukti'=>$modTandaBukti,
										'modPendaftaran'=>$modPendaftaran,
										'format'=>$format,
										//'modTarifKapitasi'=>$modTarifKapitasi
					)); ?>
		</div>
	</fieldset>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(
										'modPembayaranKapitasi'=>$modPembayaranKapitasi,
										'modPembayaranKapitasiDetail'=>$modPembayaranKapitasiDetail,
										'modTandaBukti'=>$modTandaBukti,
										'modPendaftaran'=>$modPendaftaran,
										'format'=>$format,
										//'modTarifKapitasi'=>$modTarifKapitasi
										)); ?>

<?php
 $url =Yii::app()->createUrl($this->route);

	$js = <<< JS



JS;
Yii::app()->clientScript->registerScript('onheadDialog', $js, CClientScript::POS_HEAD);
?>