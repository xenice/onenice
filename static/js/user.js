/**
 * User
 *
 * @package YYThemes
 */

jQuery(
	function($){
		$( '.arrow' ).on(
			'click',
			function(){
				$( '.user-left' ).animate(
					{
						left:'0px'
					}
				);
				$( '.user-right' ).animate(
					{
						left: '200px'
					}
				);
				$( '.shade' ).fadeIn();
			}
		);
		$( '.shade' ).on(
			'click',
			function(){
				$( '.user-left' ).animate(
					{
						left:'-200px'
					}
				);
				$( '.user-right' ).animate(
					{
						left: '0px'
					}
				);
				$( '.shade' ).fadeOut();
			}
		);

		$( window ).resize(
			function(){
				if ($( window ).width() >= 768) {
					$( '.user-left' ).css( 'left','' );
					$( '.user-right' ).css( 'left','' );
					$( '.shade' ).hide();
				}
			}
		);

		// The tips shows time.
		setTimeout(
			function(){
				$( '.alert' ).slideUp();
			},
			5000
		);
	}
);
