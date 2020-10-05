$(document).ready(function(){
	$('.btn-delete').click(function(e){
		e.preventDefault();

		var row = $(this).parents('tr');
		var id = row.data('id');

		var form = $('#form-delete');
		var url = form.attr('action').replace(':CLIENT_ID', id);
		var data = form.serialize();

		$.post(url, data, function(result){
			if(result.removed == 1){
				row.fadeOut();

				var totalClients = $('#total').text();

				if($.isNumeric(totalClients)){
					$('#total').text(totalClients - 1);
				}
				else{
					$('#total').text(result.countClient);
				}
			}
			else{
				alert('Error al eliminar el usuario');
			}
		});
	});
});