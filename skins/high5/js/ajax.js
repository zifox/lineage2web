/* Ajax Get Browser */
var resultId;
function getXmlHttp()
{
	var xmlhttp;
	try 
	{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e) 
	{
		try 
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (E) 
		{
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
		xmlhttp = new XMLHttpRequest();

	return xmlhttp;
}
/* Ajax Send Result */
function sendRequest(url, _resultId, method, query)
{	
	resultId = _resultId;
	var httpRequest = getXmlHttp();
	var timeout;
	if(method == null)
		method = 'GET';
	window.document.getElementById(resultId).innerHTML = '<center><img src="inc/module/images/loading.gif"></center>';
	httpRequest.open(method, url, true);
	
	httpRequest.onreadystatechange = function()
	{
		if (httpRequest.readyState != 4)
			return;
		clearTimeout(timeout);
		if (httpRequest.status == 200)	
			window.document.getElementById(resultId).innerHTML = httpRequest.responseText;
		else 
			handleError(httpRequest.statusText);
	}
	
	if(query != null)
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	httpRequest.send(query);


	timeout = setTimeout( function(){ httpRequest.abort(); handleError("Time over");}, 10000);  // таймаут
	return false;
}
/* Ajax Error */
function handleError(message) 
{
	window.document.getElementById(resultId).innerHTML = message;
}
function element(id)
{
	return encodeURIComponent(window.document.getElementById(id).value);
}
/** Polling */
function get_poll(val,poll_id,name)
{
	var id = "poll";
	sendRequest('inc/module/poll_ajax.html', id, 'POST', 'id='+poll_id+'&val='+val+'&name='+name);
}