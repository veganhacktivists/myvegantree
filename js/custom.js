jQuery(function($){

$('#send-details').livequery('submit', function(){
	var id = $('[name=parent]').val();
	var rl = $('[rel=item-'+id+']');
	var ul = rl.parent();

	var formData = new FormData($(this)[0]);

	$.ajax({
		url: 'ajaximg.php',
		type: 'POST',
		data: formData,
		success: function (data) {
			$('#myModal').modal('hide');
		},
		complete: function() {
			location.reload();
		},
		cache: false,
		contentType: false,
		processData: false
	});
	return false;
});

$('#send-vpass').livequery('submit', function(){
	$this = $(this);
	$.post("ajax.php?pg=vpass-send", $(this).serialize(), function(puerto){
		$this.find('hr').before($(puerto.msg).hide().fadeIn());
		setTimeout(function(){ $this.find('.alert').fadeOut(function(){ $(this).remove(); }); }, 4000);
		if(puerto.type == 'success') {
			setTimeout(function(){ location.reload(); }, 4000);
		}
	}, 'json');

	return false;
});



$("#add_poll").submit(function(){
	$('.button').prop('disabled', true);
	$this = $(this);
	$btn  = $this.find('button[type=submit]');
	$btxt = $btn.html();
	$btn.prop('disabled', true).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> loading...');

	var formData = new FormData($(this)[0]);

	$.ajax({
			url: 'ajaximg.php',
			type: 'POST',
			//dataType: 'json',
			data: formData,
			async: false,
			success: function (data) {
					console.log(data);
					$(data.alert).hide().insertBefore('.puerto-footer').fadeIn();
					setTimeout(function(){ $('.alert').fadeOut(function(){ $(this).remove() }); }, 3000);
					if( data.type == 'success' ){
						setTimeout( function(){ $(location).attr('href', ( data.url ?  data.url : ( prthref ? prthref : '' ) )); }, 2000);
					} else {
						//$('.button').prop('disabled', false);
						setTimeout(function(){ $btn.html($btxt).prop('disabled', false); }, 3000);
					}
					console.log(data);
			},
			cache: false,
			contentType: false,
			processData: false
	});
	return false;
});


$('.tree-edit').livequery('click', function(){
	var id = $(this).attr('rel');

	$('#send-details [name=id]').val(id);
	$.get("ajax.php?pg=tree-edit&id="+id, function(data){

		$('[name=name]').val(data.name);
		$('[name=status]').val(data.status);
		$('[name=type]').val(data.type);
		$('[name=photo]').val(data.photo);
		$('[name=attached]').val(data.attached);
		$('[name=date]').val(data.date);
		$('[name=bio]').val(data.bio);

		$('#myModalLabel').text('Edit Member');
		$('#myModal').modal('show');
		// console.log(data.death);
	}, 'json');

	return false;
})


$('.tree-add').livequery('click', function(){
	var id = $(this).attr('rel');

	$('#send-details').trigger('reset');
	$('#send-details [name=id]').val('');
	$('#send-details input[type=text], #send-details textarea').val('');
	$('#send-details [name=parent]').val(id);
	$('#myModalLabel').text('Add New Member');
	$('#myModal').modal('show');

	return false;
});


$('.tree-delete').livequery('click', function(){
	var id = $(this).attr('rel');

	$.get("ajax.php?pg=tree-delete&id="+id, function(){
		location.reload();
	});

	return false;
});

$('.logout').livequery('click', function(){

	$.get("ajax.php?pg=logout", function(){
		$(location).attr('href', 'index.php');
	});

	return false;
});


$('#send-user').livequery('submit', function(){
	$this = $(this);
	$.post("ajax.php?pg=user-send", $(this).serialize(), function(puerto){
		// console.log(data);
		$this.find('hr').before($(puerto.msg).hide().fadeIn());
		setTimeout(function(){ $this.find('.alert').fadeOut(function(){ $(this).remove(); }); }, 4000);
		if(puerto.type == 'success') {
			setTimeout(function(){ $(location).attr('href', 'index.php'); }, 4000);
		}
	}, 'json');

	return false;
});

$('#send-detail').livequery('submit', function(){
	$this = $(this);
	$.post("ajax.php?pg=detail-send", $(this).serialize(), function(puerto){
		console.log(puerto);
		$this.find('hr').before($(puerto.msg).hide().fadeIn());
		setTimeout(function(){ $this.find('.alert').fadeOut(function(){ $(this).remove(); }); }, 4000);
		if(puerto.type == 'success') {
			setTimeout(function(){ location.reload(); }, 4000);
		}
	}, 'json');

	return false;
});


$('#send-login').livequery('submit', function(){
	$this = $(this);
	$.post("ajax.php?pg=login-send", $(this).serialize(), function(puerto){
		// console.log(data);
		$this.find('hr').before($(puerto.msg).hide().fadeIn());
		setTimeout(function(){ $this.find('.alert').fadeOut(function(){ $(this).remove(); }); }, 3000);
		if(puerto.type == 'success') {
			setTimeout(function(){ $(location).attr('href', 'tree.php?id='+puerto.id); }, 3000);
		}
	}, 'json');

	return false;
});


$('.inputfile').livequery('change', function(){
	console.log('gg');
	console.log(event.target.files[0].name);
	$(this).parent().find('label').html('<i class="fa fa-upload"></i> '+event.target.files[0].name);
	return false;
});

});

$('.trash-alert')
  .popup({
	on: 'click',
	inline: true,
	position: 'top left',
});