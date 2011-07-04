function AlphaNumeric(v)
{
	if (/^\w{4,15}$/.test(v))
    return true;
    else
    return false;
}
/* validation registration */
function checkform(form)
{
	if (form.l2account.value=='')
    {
    	alert("Введите логин");
		form.l2account.focus();return false;
    }
    if (!AlphaNumeric(form.l2account.value))
    {
    	alert('Логин введен не корректно');
        form.l2account.select();return false;
    }
    if (form.l2password1.value=='')
    {
    	alert("Введите пароль");
		form.l2password1.focus();return false;
    }
    if (!AlphaNumeric(form.l2password1.value))
    {
    	alert('Пароль введен не корректно');
        form.l2password1.select();return false;
    }
    if (form.l2password1.value!=form.l2password2.value)
    {
    	alert('Пароли не совпадают');
        form.l2password2.select();return false;
    }
    if (form.l2email.value=='')
    {
		alert("Введите E-Mail!");
		form.l2email.select(); return false;
	}
	if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(form.l2email.value))
    {
		alert("E-Mail введен не корректно");
		return false;
    }
	if (form.l2question.value=='')
    {
    	alert("Введите вопрос");
		form.l2question.focus();return false;
    }
    if (form.l2question.value.length<4 || form.l2question.value.length>64)
    {
    	alert('Вопрос должен состоять не менее 4 символов и не более 64');
        form.l2question.select();return false;
    }
	if (form.l2answer.value=='')
    {
    	alert("Введите ответ");
		form.l2answer.focus();return false;
    }
    if (form.l2answer.value.length<4 || form.l2answer.value.length>64)
    {
    	alert('Ответ должен состоять не менее 4 символов и не более 64');
        form.l2answer.select();return false;
    }
    if (form.l2sec_code.value=='')
    {
		alert("Введите защитный код");
		form.l2sec_code.select(); return false;
	}
return true;
}
/* validation change password */
function checkformCP(chpass)
{
   	if (chpass.l2oldpass.value=='')
    {
    	alert("Введите старый пароль!");
		chpass.l2oldpass.focus();
        return false;
    }
    if (!AlphaNumeric(chpass.l2oldpass.value))
    {
    	alert("Старый пароль введен не корректно!");
        chpass.l2oldpass.select();
        return false;
    }
    if (chpass.l2newpass1.value=='')
    {
    	alert("Введите новый пароль!");
		chpass.l2newpass1.focus();
        return false;
    }
    if (!AlphaNumeric(chpass.l2newpass1.value))
    {
    	alert("Новый пароль введен не корректно!");
        chpass.l2newpass1.select();
        return false;
    }
    if (chpass.l2newpass1.value!=chpass.l2newpass2.value)
    {
    	alert("Пароли не совпадают!");
    	chpass.l2newpass2.select()
        return false;
    }
return true;
}
/* validation add data */
function checkformData(form)
{
	if (form.l2email.value!='' && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(form.l2email.value))
    {
		alert("E-Mail введен не корректно");
		return false;
    }
return true;
}