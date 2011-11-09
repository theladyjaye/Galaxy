$(function(){
	$('#channels-table tbody tr').bind("click",function(){
		window.location.href = $(this).data('link');
	})
})
