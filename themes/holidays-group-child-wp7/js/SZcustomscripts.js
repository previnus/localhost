jQuery(document).ready(function($) {
	/*********** GOOGLE TRANSLATE ***********/
	// from gtranslate plugin
	//Change a values of ahref
		$('a.glink[title="French"]').text('Traduire en francais');
		$('a.glink[title="English"]').text('Texte Original');

	// gtranslate buttons after comment-meta
		$('div.comment-meta').each(function(){
			$(this).append('<div class="googleBtn"><a href="#" onclick="doGTranslate(&#39;en|en&#39;);return false;" title="English" class="glink nturl notranslate">Texte original</a><a href="#" onclick="doGTranslate(&#39;en|fr&#39;);return false;" title="French" class="glink nturl notranslate">Traduire en français</a></div>');
		});
	// add class translate on click and remove on mouseout
		$('a.glink[title="French"]').on({
			click:function(){
				$(this).closest('.comment-body').addClass('translate');
			},
			mouseout:function(){
				$(this).closest('.comment-body').removeClass('translate');
			}
		});
	// prevent comment date and modify link being translated
		$('div.comment-author, div.comment-meta').addClass('notranslate');

	/*********** CONTENT READ MORE/LESS BUTTON ***********/
		$('.hg-show-less').hide();
		$('.hg-show-more').click(function() {
				$('#hg-content').css('max-height', 'none');
				$(this).hide();
				$('.hg-show-less').show();
		});
		$('.hg-show-less').click(function() {
				$('#hg-content').css('max-height', '20em');
				$(this).hide();
				$('.hg-show-more').show();
		});
	/*********** COMMENT READ MORE/LESS BUTTON ***********/
		$('.hg-comment-show-less').hide();
		$('.hg-comment-show-more').click(function() {
				$('li.comment:gt(0)').css('display', 'block');
				$(this).hide();
				$('.hg-comment-show-less').show();
		});
		$('.hg-comment-show-less').click(function() {
				$('li.comment:gt(0)').css('display', 'none');
				$(this).hide();
				$('.hg-comment-show-more').show();
		});

	/*********** REPORT BUTTON SHOW/HIDE BUTTON ***********/
		$('.hg-abus-hide').hide();
		$('.hg-abus-show').click(function() {
				$('#rform').css('display', 'block');
				$(this).hide();
				$('.hg-abus-hide').show();
		});
		$('.hg-abus-hide').click(function() {
				$('#rform').css('display', 'none');
				$(this).hide();
				$('.hg-abus-show').show();
		});

	
	});