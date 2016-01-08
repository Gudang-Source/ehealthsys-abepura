<script type="text/javascript">
var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>';
var confirmMessage = '<?php echo Yii::t('mds','Do You want to remove?') ?>';
function namaLain(nama)
{
	document.getElementById('PPKabupatenM_1_kabupaten_namalainnya').value = nama.value.toUpperCase();
}

function addRow(obj)
{
    var tr = $('#tbl-kabupaten tr:first').html();
    $('#tbl-kabupaten tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kabupaten tr:last td:last').append(''+buttonMinus+'');
    renameInput('PPKabupatenM','kabupaten_nama');
    renameInput('PPKabupatenM','kabupaten_namalainnya');
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kabupaten tr').length;
    var i = 1;
    $('#tbl-kabupaten tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function delRow(obj)
{
    if(!confirm(''+confirmMessage+'')) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('PPKabupatenM','kabupaten_nama');
        renameInput('PPKabupatenM','kabupaten_namalainnya');
    }
}
</script>