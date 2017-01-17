function insert_tag(tag)
{
	msgfield = (document.all) ? document.all.tags : document.forms['editinfo']['info[motsclefs]'];
	if (msgfield.value.length > 0)
		msgfield.value += ', ' + tag;
	else
		msgfield.value += tag;
	msgfield.focus();
	return;
}