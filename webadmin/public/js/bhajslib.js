/* This will remove specil character from sting onkeyup */
function checkSpecialChar(id){
	var yourInput = $("#"+id).val();
	re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/;
	var isSplChar = re.test(yourInput);
	if(isSplChar)
	{
		var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/, '');
		$("#"+id).val(no_spl_char);
	}
}