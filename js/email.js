function selectEmailDomain(id,domain)
{
	var edomain = domain;
	var bdom = document.getElementById(id);
	var rdom = document.getElementById('f'+id);

	rdom.value = edomain;
	bdom.innerHTML = '@' + edomain;
}