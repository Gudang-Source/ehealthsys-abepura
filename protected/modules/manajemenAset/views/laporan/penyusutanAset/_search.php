<div class="search-form" style="">
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                ));
        ?>
        <style>
            table{
                margin-bottom: 0px;
            }
            .form-actions{
                padding:4px;
                margin-top:5px;
            }
            .nav-tabs>li>a{display:block; cursor:pointer;}
            .nav-tabs > .active a:hover{cursor:pointer;}
        </style>
        <div class="box">
			<div class="row-fluid block-tabel">
				<div class="span4">
					<fieldset class="box2">
						<legend class="rim">Berdasarkan Tanggal Penyusutan Aset</legend>
						<?php echo CHtml::hiddenField('type', ''); ?>
						<?php //echo CHtml::hiddenField('src', ''); ?>
						<div class = 'control-label'>Tanggal Penyusutan Aset</div>
						<div class="controls">  
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_awal',
								'mode' => 'date',
	//                                          'maxDate'=>'d',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)"),
							));
							?>
						</div> 
						<?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
						<div class="controls">  
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgl_akhir',
								'mode' => 'date',
	//                                         'maxdate'=>'d',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)"),
							));
							?>
						</div> 
					</fieldset>
				</div>
			</div>
			
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
                         'type' => 'GET', 
                         'url' => array("/".$this->route), 
                         'update' => '#tableLaporan',
                         'beforeSend' => 'function(){
                                              $("#tableLaporan").addClass("animation-loading");
                                          }',
                         'complete' => 'function(){
                                              $("#tableLaporan").removeClass("animation-loading");
                                          }',
                     ))); 
                ?>
				<?php 
//					echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
//					array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
				?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/LaporanPenyusutanAset'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));  ?>
            </div>
        </div>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
