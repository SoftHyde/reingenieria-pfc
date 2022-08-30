$('#poll-form').submit(function( event ) {
    event.preventDefault();
    $.ajax({
        url: '/votar',
        type: 'post',
        data: $('#poll-form').serialize(), 
        success: function( response ){
            $('.list-group-item').addClass('hidden');
            $('div[name=footer_vote]').addClass('hidden'); 
            $.each(response, function(i, option) {
			    $('.list-group').append(
			    	"<li class='list-group-item' style='display: none;'>"
			    	 	+"<h4>" + option['name'] + " (" + option['perc'] + "%)</h4>"
                        +"<div><div class='progress'><div class='progress-bar progress-bar-info progress-bar-striped' role='progressbar' style='width:"
                        +option['perc']+"%'"
                        +"></div></div></div>"
			    	+"</li>"
			    );
			    $('.list-group-item').show();
                $('.progress').hide();
                $('.progress').show('slow');
			})
        },
        error: function( response ){    
            alert('Error al enviar el formulario. Intenta más tarde.');
        }
    });
});