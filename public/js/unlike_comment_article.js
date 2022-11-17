function unlikeCommentArticle(comment_id){
    event.preventDefault();
    $.ajax({
        url: '/ya-no-me-gusta-comentario-articulo',
        type: 'delete',
        data: $('#unlike_comment'+comment_id).serialize(), 
        success: function( response ){
            $('#unlike_comment'+comment_id).addClass('hidden');
            $('#like_comment'+comment_id).removeClass('hidden');
            $('#like_comment'+comment_id).show('slow');
            $('.nlikes'+comment_id).text(response['n_likes']);
        },
        error: function( response ){    
            alert('Error al enviar el formulario. Intenta más tarde.');
        }
    });
};