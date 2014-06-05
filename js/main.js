$(document).ready(function(){
  $('.slider').bxSlider({
    slideWidth: 175,
    minSlides: 5,
    maxSlides: 5,
    moveSlides: 5,
    slideMargin: 10,
    ticker: false
  });
}).startAuto();

function validateForm(form, field)
{
	var x=document.forms[form][field].value;
	if (x==null || x=="")
	{
		alert("Empty submit!");
		return false;
	}
}