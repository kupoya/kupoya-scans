var req;

function getXHR()
{
	if(window.XMLHttpRequest) {
		req = new XMLHttpRequest();
		return true;
	}
	else try {
		req = new ActiveXObject('Msxml2.XMLHTTP');
		return true;
	} catch(e) {
		try {
			req = new ActiveXObject("Microsoft.XMLHTTP");
			return true;
		} catch(e) {
			req = false;
			return false;
		}
	}
}

function updateElm(url, id)
{
	if(getXHR())
	{
		req.open('GET', url, true);
		req.onreadystatechange = function()
		{
			if(req.readyState == 4)
			 {
				if(req.status==200)
				{
					document.getElementById(id).innerHTML = req.responseText;
					window.location.href='#'+id;
				}
				else
				{
					document.getElementById(id).innerHTML = 'Could not retrieve data<br/><em>'+req.statusText+'</em>';
				}
			} 
			else 
			{
				document.getElementById(id).innerHTML = '<div style="text-align:center"><img src="images/ajax-loader.gif" /><br/><span style="color:#528335">Loading...</span></div>';

			}
		}
		req.send('');
	}
	else return true;
	return false;
}


