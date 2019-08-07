

<div class="span4">
        <div class="control-group">
                    <?php echo $form->label($permintaan, 'nokeanggotaan', array('class'=>'control-label col-sm-3')); ?>
                    <div class="controls">
                            <!--div class="input-group">
                            <span class="twitter-typehead"-->
                            <?php
                            $this->widget('MyJuiAutoComplete',array(
                                        'attribute'=>'nokeanggotaan',
                                        'model'=>$permintaan,
                                        'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNo'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 4,
                                           'focus'=> 'js:function( event, ui ) {
                                                //$("#KeanggotaanT_nokeanggotaan").val( ui.item.value );
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                loadAnggotaPegawai(ui.item.attr);
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                                        'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),

                            ));
                            ?>
                            <!--/span>
                            <span class="input-group-addon" onclick="alert('Kick');">
                                    <i class="entypo-search"></i>
                            </span>
                            </div-->
                    </div>
            </div>
            <div class="control-group">
                    <?php echo $form->label($permintaan, 'nama_anggota', array('class'=>'control-label col-sm-3')); ?>
                    <div class="controls">
                            <?php //echo $form->textField($pegawai,'nama_pegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete',array(
                                        'attribute'=>'nama_pegawai',
                                        'model'=>$permintaan,
                                        'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNo', array('nama'=>1)),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 3,
                                           'focus'=> 'js:function( event, ui ) {
                                                //$("#PegawaiM_nama_pegawai").val( ui.item.value2 );
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                    $("#PegawaiM_nama_pegawai").val( ui.item.value2 );
                                                loadAnggotaPegawai(ui.item.attr);
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('placeholder'=>'Nama Anggota','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                                        'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),

                            ));
                            ?>
                    </div>
            </div>             
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'golongan', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'golonganpegawai_nama', array('readonly'=>true, 'class'=>'form-control peg')); ?>			
                </div>
        </div>
</div>
<div class="span4">
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'No Permohonan', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'nopermohonan', array('readonly'=>true, 'class'=>'form-control')); ?>			
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'Tgl Permohonan', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'tglpermohonanpinjaman', array('readonly'=>true, 'class'=>'form-control')); ?>			
                </div>
        </div>
        <!--<div class="control-group" hidden>
                <?php echo CHtml::activeLabel($permintaan, 'Jasa Pinjam', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'jasapinjaman_bln', array('readonly'=>true, 'class'=>'form-control')); ?>			
                </div>
        </div>-->
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'Jenis Pinjaman', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'jenispinjaman_permohonan', array('readonly'=>true, 'class'=>'form-control')); ?>			
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'Jumlah Pinjaman', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'jmlpinjaman', array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align: right')); ?>			
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'Jangka Waktu', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'jangkawaktu_pinj_bln', array('readonly'=>true, 'class'=>'form-control')); ?>			
                </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::activeLabel($permintaan, 'Untuk Keperluan', array('class'=>'control-label col-sm-4')); ?>
                <div class="controls">
                        <?php echo CHtml::activeTextField($permintaan, 'untukkeperluan', array('readonly'=>true, 'class'=>'form-control')); ?>			
                </div>
        </div>
</div>

<div class="span4">    
            <div align="center">
                <?php 
                $url_photopegawai = Params::urlPegawaiDirectory()."no_photo.jpeg";
                ?>
                <img id="photo-preview" src="<?php echo $url_photopegawai?>"width="128px"/> 
            </div>    
</div>