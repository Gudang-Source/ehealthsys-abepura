<script type="text/javascript">
var buttonMinus = '<?php echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>';
var confirmMessage = '<?php echo Yii::t('mds','Do You want to remove?') ?>';
function namaLain(nama)
{
	document.getElementById('PPKecamatanM_1_kecamatan_namalainnya').value = nama.value.toUpperCase();
}

function delRow(obj)
{
	if(!confirm(''+confirmMessage+'')) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('PPKecamatanM','kecamatan_nama');
        renameInput('PPKecamatanM','kecamatan_namalainnya');
    }
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-kecamatan tr').length;
    var i = 1;
    $('#tbl-kecamatan tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        i++;
    });
}

function addRow(obj)
{
    var tr = $('#tbl-kecamatan tr:first').html();
    $('#tbl-kecamatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-kecamatan tr:last td:last').append(''+buttonMinus+'');
    renameInput('PPKecamatanM','kecamatan_nama');
    renameInput('PPKecamatanM','kecamatan_namalainnya');
}
</script>