<div class =" row" id="panel-pencarian">		
            <div class="span6">
                    <div class="control-group">
				<?php echo $form->label($permintaanv, 'no_pengajuan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
					'model'=>$permintaanv,
                    'attribute'=>'nopengajuan',
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/loadPengajuanPemotongan'),
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 4,
                       'focus'=> 'js:function( event, ui ) {
                            $("#PengajuanpenerimaanangsuranV_nopengajuan").val( ui.item.attr.nopengajuan);
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                       		ubahTeksBKM(ui.item.attr.nopengajuan, ui.item.attr.tglpengajuanpemb);
                            $("#PengajuanpenerimaanangsuranV_nopengajuan").val( ui.item.attr.nopengajuan);
														$("#PengajuanpenerimaanangsuranV_potongansumber_id").val( ui.item.attr.potongansumber_id);
                            return false;
                        }',

                    ),
                    'htmlOptions'=>array('placeholder'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_permintaan','idTombol'=>'tombolPrepare'),

                ));
			?>
				</div>
			</div>
			<?php /*
			<div class="form-group">
				<?php echo $form->label($permintaanv, 'tglAwal', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php
					$this->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$permintaanv, 'attribute'=>'tglAwal', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					));
					?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($permintaanv, 'tglAkhir', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php
					$this->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$permintaanv, 'attribute'=>'tglAkhir', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					));
					?>
				</div>
			</div> */ ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($permintaanv, 'potongansumber_id', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($permintaanv, 'potongansumber_id', CHtml::listData(PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true', 'order'=>'namapotongan asc')), 'potongansumber_id', 'namapotongan'), array('class'=>'form-control')); ?>
				</div>
			</div>
		</div>
    		
	</div>
		<div class="span12">
			<?php //echo CHtml::button('Cari', array('class'=>'btn btn-blue', 'id'=>'btn-cari')); ?>
                         <div class="form-actions">
                            <?php  echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                        </div>

                </div>
