<legend class='rim'>Metode Apgar</legend>
<div style="float:left;">
	<?php echo $form->labelEx($model, 'menitke'); ?>
	<?php echo $form->textField($model, 'menitke', array('class'=>'span1 numbersOnly required', 'maxlength'=>3,  'onkeypress' => "return $(this).focusNextInputField(event)")); ?> 
</div>
<div id='menitkealert' class="additional-text"></div>
<table width='100%' class="table table-striped table-condensed">
    <thead>
        <tr>
            <th>ID</th>
            <th>Kriteria</th>
            <th>Nilai 2</th>
            <th>Nilai 1</th>
            <th>Nilai 0</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        <?php foreach($appgards as $appgard){ ?>
            <tr>
                <td><?php echo $appgard->metodeapgar_id; ?></td>
                <td><?php echo $appgard->kriteria; ?></td>
                <td><?php echo CHtml::radioButton("appgard[$appgard->metodeapgar_id]",'', array('value'=>'2'.$appgard->nilai_2,'style'=>'margin-right:5px;', 'class'=>'apgar',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?><?php echo $appgard->nilai_2; ?></td>
                <td><?php echo CHtml::radioButton("appgard[$appgard->metodeapgar_id]",'', array('value'=>'1'.$appgard->nilai_1,'style'=>'margin-right:5px;', 'class'=>'apgar',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?><?php echo $appgard->nilai_1; ?></td>
                <td><?php echo CHtml::radioButton("appgard[$appgard->metodeapgar_id]",'', array('value'=>'0'.$appgard->nilai_0,'style'=>'margin-right:5px;', 'class'=>'apgar',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?><?php echo $appgard->nilai_0; ?></td>
                <?php $i++; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php $urlCekMenitKe = $this->createUrl('getMenitKe'); ?>

<?php Yii::app()->clientScript->registerScript('appgard', "
    $(document).ready(function(){
        function cekMenit(inputmenit){
                
                var menitke = $(inputmenit).val();
                var kelahiranbayi_id = $('#kelahiranbayi_id').val();
                
                $.post('${urlCekMenitKe}', { menitke: menitke, kelahiranbayi_id : kelahiranbayi_id },
                function(data){
                    if (data == true){
                        data = 'Menit Ke '+menitke+' sudah terdaftar';
                        $(inputmenit).css('background-color','B94A48');
                       
                    }
                    else
                    {
                        
                    }
                    $('#menitkealert').html(data);
                }, 'json');
           
        }
        $('#PSKelahiranbayiT_menitke').keyup(function(){
              cekMenit($(this));
        });
        
        $('.apgar').change(function(){
            $(this).parent().parent().css('background','#B5C1D7');
        });
    });
", CClientScript::POS_READY); ?>