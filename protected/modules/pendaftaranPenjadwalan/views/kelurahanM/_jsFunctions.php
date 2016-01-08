<script type="text/javascript">
var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>';
function namaLain(nama)
{
	document.getElementById('PPKelurahanM_1_kelurahan_namalainnya').value = nama.value.toUpperCase();
}

function delRow(obj)
{
	var confirmMessage = '<?php echo Yii::t('mds','Do You want to remove?') ?>';
    if(!confirm(""+confirmMessage+"")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('PPKelurahanM','kelurahan_nama');
        renameInput('PPKelurahanM','kelurahan_namalainnya');
        renameInput('PPKelurahanM','kode_pos');
    }
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kelurahan tr').length;
    var i = 1;
    $('#tbl-kelurahan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function addRow(obj)
{
    var tr = $('#tbl-kelurahan tr:first').html();
    $('#tbl-kelurahan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kelurahan tr:last td:last').append(''+buttonMinus+'');
    renameInput('PPKelurahanM','kelurahan_nama');
    renameInput('PPKelurahanM','kelurahan_namalainnya');
    renameInput('PPKelurahanM','kode_pos');
}
</script>