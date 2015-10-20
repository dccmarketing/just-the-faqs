(function( $ ) {

	'use strict';

	var question = $( '.question' );

	question.each( function() {

		var link = $(this).children( '.question-list-link' );
		var answer = $(this).children( '.question-list-answer' );

		link.on( 'click', function(e){

			e.preventDefault();

			answer.slideToggle(250);

		});

	});

})( jQuery );
