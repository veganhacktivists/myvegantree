jQuery(function($){

$('#send-details').livequery('submit', function(){
	var id = $('[name=parent]').val();
	var rl = $('[rel=item-'+id+']');
	var ul = rl.parent();

	var formData = new FormData($(this)[0]);

	console.log(formData);
	console.log($(this).serialize());

	$.ajax({
			url: 'ajaximg.php',
			type: 'POST',
			//dataType: 'json',
			data: formData,
			async: false,
			success: function (data) {
					console.log(data);
					$('#myModal').modal('hide');
						location.reload();
					// $(data.alert).hide().insertBefore('.puerto-footer').fadeIn();
					// setTimeout(function(){ $('.alert').fadeOut(function(){ $(this).remove() }); }, 3000);
					// if( data.type == 'success' ){
					// 	setTimeout( function(){ $(location).attr('href', ( data.url ?  data.url : ( prthref ? prthref : '' ) )); }, 2000);
					// } else {
					// 	//$('.button').prop('disabled', false);
					// 	setTimeout(function(){ $btn.html($btxt).prop('disabled', false); }, 3000);
					// }
					// console.log(data);
			},
			cache: false,
			contentType: false,
			processData: false
	});

	// $.post("ajax.php?pg=tree-send", $(this).serialize(), function(data){
	// 	// console.log(data);
	// 	$('#myModal').modal('hide');
	// 	location.reload();
	// });



	return false;
});

$('#send-vpass').livequery('submit', function(){
	$this = $(this);
	$.post("ajax.php?pg=vpass-send", $(this).serialize(), function(puerto){
		// console.log(data);
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
		console.log(data);
		$('[name=name]').val(data.name);
		$('[name=lastname]').val(data.lastname);
		$('[name=birthday]').val(data.birthday);
		$('[name=birthmonth]').val(data.birthmonth);
		$('[name=birthyear]').val(data.birthyear);
		$('[name=deathday]').val(data.deathday);
		$('[name=deathmonth]').val(data.deathmonth);
		$('[name=deathyear]').val(data.deathyear);
		$('[name=photo]').val(data.photo);
		$('[name=email]').val(data.email);
		$('[name=site]').val(data.site);
		$('[name=tel]').val(data.tel);
		$('[name=mobile]').val(data.mobile);
		$('[name=birthplace]').val(data.birthplace);
		$('[name=deathplace]').val(data.deathplace);
		$('[name=city]').val(data.city);
		$('[name=profession]').val(data.profession);
		$('[name=company]').val(data.company);
		$('[name=interests]').val(data.interests);
		$('[name=bio]').val(data.bio);

		$('[name=status][value="'+data.status+'"]').prop('checked',true);
		$('[name=death]').prop('checked',(data.death==1?true:false));
		$('#myModal').modal('show');
		// console.log(data.death);
	}, 'json');

	return false;
})


$('.tree-add').livequery('click', function(){
	var id = $(this).attr('rel');

	$('#send-details input[type=text], #send-details textarea').val('');
	$('#send-details [name=parent]').val(id);
	$('#myModal').modal('show');


	return false;
});


$('.tree-delete').livequery('click', function(){
	var id = $(this).attr('rel');

	$.get("ajax.php?pg=tree-delete&id="+id, function(){
		location.reload();
	});

	// $('#send-details input[type=text], #send-details textarea').val('');
	// $('#send-details [name=parent]').val(id);
	// $('#myModal').modal('show');


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
		setTimeout(function(){ $this.find('.alert').fadeOut(function(){ $(this).remove(); }); }, 4000);
		if(puerto.type == 'success') {
			setTimeout(function(){ $(location).attr('href', 'tree.php?id='+puerto.id); }, 4000);
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


$('[rel^=item-]').livequery('click', function(){
	var id = $(this).attr('rel').replace('item-', '');
	$.get("ajax.php?pg=tree-edit&id="+id, function(data){
		console.log(data);
		var html = '<div class="media">'
			+'<div class="media-left"><div class="thumb"><img src="'+data.photo+'"></div></div>'
			+'<div class="media-body">'
				+'<a>'+data.name+' '+data.lastname+' <i class="icons icon-symbol-'+(data.status == 1?'female" title="Female':'male" title="Male')+'"></i></a>'
				+'<p>Born at '+data.birthday+'/'+data.birthmonth+'/'+data.birthyear+' in <b>'+data.birthplace+'</b></p>'
				+(data.death == 0?'<p>Dead at '+data.deathday+'/'+data.deathmonth+'/'+data.deathyear+' in <b>'+data.deathplace+'</b></p>':'')
				+'<p>'
					+'<a href="'+data.site+'" target="_blank" title="'+data.site+'"><i class="icons icon-globe"></i></a>'
					+'<a href="mailto:'+data.email+'" title="'+data.email+'"><i class="icons icon-envelope"></i></a>'
					+'<a title="'+data.tel+'"><i class="icons icon-phone"></i></a>'
					+'<a title="'+data.mobile+'"><i class="icons icon-screen-smartphone"></i></a>'
				+'</p>'
			+'</div>'
		+'</div>'
		+'<p><b>Profession:</b> '+data.profession+'</p>'
		+'<p><b>Company:</b> '+data.company+'</p>'
		+'<p><b>Interests:</b> '+data.interests+'</p>'
		+'<p><b>Bio Notes:</b> '+data.bio+'</p>';
		$('#myTree .modal-body').html(html);
		console.log(html);
		// $('[name=name]').val(data.name);
		// $('[name=lastname]').val(data.lastname);
		// $('[name=birthday]').val(data.birthday);
		// $('[name=birthmonth]').val(data.birthmonth);
		// $('[name=birthyear]').val(data.birthyear);
		// $('[name=photo]').val(data.photo);
		// $('[name=email]').val(data.email);
		// $('[name=site]').val(data.site);
		// $('[name=tel]').val(data.tel);
		// $('[name=mobile]').val(data.mobile);
		// $('[name=birthplace]').val(data.birthplace);
		// $('[name=deathplace]').val(data.deathplace);
		// $('[name=profession]').val(data.profession);
		// $('[name=company]').val(data.company);
		// $('[name=interests]').val(data.interests);
		// $('[name=bio]').val(data.bio);
		//
		// $('[name=status][value='+data.status+']').prop('checked',true);
		// $('[name=death]').prop('checked',(data.death==1?true:false));
		$('#myTree').modal('show');
		// console.log(data.death);
	}, 'json');

	return false;
	console.log(id);
});


// $("#ZoomIn").click(ZoomIn());
//
// $("#ZoomOut").click(ZoomOut());
//
// function ZoomIn (event) {
//
//     $("#div").width(
//         $("#div").width() * 1.2
//     );
//
//     $("#div").height(
//         $("#div").height() * 1.2
//     );
// }
//
// function  ZoomOut (event) {
//
//     $("#div").width(
//         $("#div").width() * 0.5
//     );
//
//     $("#div").height(
//         $("#div").height() * 0.5
//     );
// }





});
