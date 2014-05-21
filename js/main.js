function validateForm(form, field)
{
	var x=document.forms[form][field].value;
	if (x==null || x=="")
	{
		alert("Empty submit!");
		return false;
	}
}