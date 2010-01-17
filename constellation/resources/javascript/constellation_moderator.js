$(function()
{
	$('.btn_moderate').each(function(){
		$(this).bind('click', {id:$(this).attr('name')}, showModeratorControls);
	})
});

function showModeratorControls(event)
{
	var topic_id = event.data.id;
	$('#btn_moderator-panel_close').bind('click', hideModeratorControls);
	$('#moderator-panel').show();
	
	$('#btn_edit_topic').attr('href', '/moderator/topic_edit.php?id='+topic_id);
	$('#btn_delete_topic').attr('href', '/moderator/topic_delete.php?id='+topic_id);
	
	return false;
}

function hideModeratorControls(event)
{
	$('#btn_moderator-panel_close').unbind('click', hideModeratorControls);
	$('#btn_delete_topic').attr('href', '');
	$('#moderator-panel').hide();
	return false;
}