function trimspace(fieldid)
{
	var fieldName = $('#'+fieldid).val();
	var fieldValue = $.trim(fieldName);
	$('#'+fieldid).val(fieldValue);

}