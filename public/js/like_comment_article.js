function likeCommentArticle(comment_id){
    event.preventDefault();
    $.ajax({
        url: '/me-gusta-comentario-articulo',
        type: 'post',
        data: $('#like_comment'+comment_id).serialize(), 
        success: function( response ){
            $('#like_comment'+comment_id).addClass('hidden');
            $('#unlike_comment'+comment_id).removeClass('hidden');
            $('#unlike_comment'+comment_id).show('slow');
            $('.nlikes'+comment_id).text(response['n_likes']);
        },
        error: function( response ){    
            alert('Error al enviar el formulario. Intenta más tarde.');
        }
    });
};