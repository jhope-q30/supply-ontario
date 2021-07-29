/**
 * File navigation.js for _bvg theme
 *
 */

 ( function() {

	console.log( "navigation loaded" );

	const menuOpen         = 'menu-open'; // toggle class to open sub-menu
	const menuFade         = 'menu-fade'; // animation class display toggle for items show/hide from the hamburger
	const menuExpander     = 'sub-menu-toggle'; // expander class
	const menuSub          = 'sub-menu';

	const siteNavigation   = document.getElementById( 'site-navigation' );
	const hamburger        = document.getElementById( 'toggler' );
	const menu             = siteNavigation.getElementsByTagName( 'ul' )[ 0 ]; // root level
	const rootItems        = menu.children;
	const menuLinks        = menu.getElementsByTagName( 'a' );
	const expanders        = menu.querySelectorAll( '.' + menuExpander );
	const toggles          = [ 'header-search', 'site-navigation', 'site-secondary-menu' ]; /// items that the hamburger displays for mobile
	const submenus         = menu.querySelectorAll( '.' + menuSub );

	// keys codes to bind actions
	const keys             = {
		tab:   9,
		enter: 13,
		esc:   27,
		space: 32,
		left:  37,
		up:    38,
		right: 39,
		down:  40
	};
	const desktop          = 992; // nav breakpoint for mobile

	// target items within the menu
	var currentFocus       = null;

	// boolean for toggles/actions
	var hamburgerOpen      = false;
	var rootLevelHover     = false; /// set this flag to stop rootlevel hover actions for small screens

	// queue index tied to what the hamburger triggers when opened
	var animateQueueIndex  = 0;

	// Return early if the navigation don't exist.
	if ( ! siteNavigation ) {
		return;
	}

	/// functions
	var bindHandlers = function(){
		/// bind anchor handlers for all menu items
		Array.prototype.forEach.call( menuLinks, function( menuLink, i ){
			menuLink.addEventListener( 'focus', handleFocus, true );
			menuLink.addEventListener( 'blur', handleBlur, true );
			menuLink.addEventListener( 'keydown', keyPressDown, false );
		});
		/// expanders
		Array.prototype.forEach.call( expanders, function( expander, i ){
			expander.addEventListener( 'click', handleExpander, true );
		});
		/// mouse hovers on root level > li
		Array.prototype.forEach.call( rootItems, function( rootItem, i ){
			rootItem.addEventListener( 'mouseenter', handleMouseHover, true );
			rootItem.addEventListener( 'mouseleave', handleMouseHover, false );
		});
		/// hamburger
		hamburger.addEventListener( 'click', handleHamburger, true );
		/// window resize
		window.addEventListener( 'resize', menuResize, false );
	}

	/// MENU / WINDOW RESIZE CONTROLS
	var menuResize = function(e){
		checkMenuResize();
	}
	var checkMenuResize = function(){
		rootLevelHover = true;
		if( window.innerWidth > desktop ){
			rootMenuControl( 'reset', null );
			if( hamburgerOpen ){
				resetHamburger();
			}
			rootLevelHover = false;
		}
	}

	/// KEYBOARD CONTROLS
	/// keypress functions for > a
	var keyPressDown = function(e){
		let self = this;
		// Modifier key pressed: Do not process
		if ( e.altKey || e.ctrlKey ) {
			return true;
		}
		// check for expander
		// go through key codes

		switch( e.keyCode ) {
			case keys.esc :
				// close everything, expanders, toggles, and reset focus, and exit function
				resetMenu();
				e.stopPropagation();
				return true;
			break;
			case keys.left :
				currentFocus = rootMenuControl( 'previous', self );
				currentFocus.focus();
			break;
			case keys.right:
				currentFocus = rootMenuControl( 'next', self );
				currentFocus.focus();
			break;
			case keys.up:
				var a0 = getRootLevelItem( self ).getElementsByTagName( 'a' )[ 0 ];
				if( a0.getAttribute( 'aria-haspopup' ) === 'true' ){
					e.preventDefault();
					currentFocus = subMenuControl( 'up', self );
					currentFocus.focus();
				}
			break;
			case keys.down:
				/// if there is a menu
				var a0 = getRootLevelItem( self ).getElementsByTagName( 'a' )[ 0 ];
				if( a0.getAttribute( 'aria-haspopup' ) === 'true' ){
					e.preventDefault();
					currentFocus = subMenuControl( 'down', self );
					currentFocus.focus();
				}
			break;
		}
		e.stopPropagation();
		return true;
	}
	/// EXPANDER CONTROLS
	/// expanders
	var handleExpander = function(e){
		let self = this;
		const a0 = self.parentNode.getElementsByTagName( 'a' )[ 0 ];
		if ( self.getAttribute( 'aria-expanded' ) === 'false' ) {
			currentFocus = subMenuControl( 'open', a0 );
			return true;
		}
		currentFocus = subMenuControl( 'close', a0 );
		return true;
	}

	/// MENU CONTROLS
	var rootMenuControl = function( action, item ){

		/// check for reset
		/// reset the root level menu items, and close all submenus and exit

		if( action === 'reset' ){
			Array.prototype.forEach.call( rootItems, function( rootItem, i ){
				const a0 = rootItem.getElementsByTagName( 'a' )[ 0 ];
				if( a0.getAttribute( 'aria-haspopup' ) === 'true' ){
					const t0 = rootItem.getElementsByTagName( 'button' )[ 0 ];
					a0.setAttribute( 'aria-expanded', 'false' );
					t0.setAttribute( 'aria-expanded', 'false' );
					rootItem.classList.remove( menuOpen );
				}
			});
			subMenuControl( 'reset', null );
			return false;
		}

		const currentLi   = getObjectType( item ) === 'htmlanchorelement' ? item.parentNode : item;
		var currentRootLi = getRootLevelItem( currentLi );
		var nextLi        = null;

		const menuLength  = rootItems.length;
		const menuIndex   = index( currentRootLi );

		switch( action ){

			case 'next' :

				nextLi = rootItems[0];
				if( menuIndex < menuLength ){
					nextLi = currentRootLi.nextElementSibling;
				}

			break;
			case 'previous' :

				nextLi = rootItems[ menuLength - 1 ];
				if( menuIndex > 1 ){
					nextLi = currentRootLi.previousElementSibling;
				}

			break;

		}

		/// reset root menu items and close submenus
		rootMenuControl( 'reset', null );

		/// set focus to next item
		return nextLi.getElementsByTagName( 'a' )[ 0 ];

	}

	/// controls for submenu actions
	var subMenuControl = function( action, item ){

		// check for reset
		if( action == 'reset' ){
			Array.prototype.forEach.call( submenus, function( submenu, i ){
				submenu.setAttribute( 'aria-hidden', 'true' );
			});
			return false;
		}

		const currentLi = item.parentNode;

		var ul0         = currentLi.parentNode;
		var a0          = item;
		var ul1         = null;
		var subItems    = null;
		var nextA       = null;
		var subIndex    = 0;

		/// check if ul0 is submenu or rootlevel ( should only be for actions open )
		if( ul0.getAttribute( 'role' ) === 'menubar' ){

			ul1 = currentLi.getElementsByTagName( 'ul' )[ 0 ];

		} else { /// this is a submenu item

			a0 = getRootLevelItem( currentLi ).getElementsByTagName( 'a' )[ 0 ];
			ul1 = ul0;

		}

		if( a0.getAttribute( 'aria-haspopup' ) === 'true' ){

			subItems = ul1.children;
			const t0 = currentLi.getElementsByTagName( 'button' )[ 0 ];

			switch( action ){

				case 'open' :

					if( ul1.getAttribute( 'aria-hidden' ) === 'true' ){

						/// open rootMenu

						currentLi.classList.add( menuOpen );
						a0.setAttribute( 'aria-expanded', 'true' );
						t0.setAttribute( 'aria-expanded', 'true' );

						ul1.setAttribute( 'aria-hidden', 'false' );
						nextA = ul1.getElementsByTagName( 'a' )[ 0 ]; // get the top most item

					}					

				break;
				case 'up' :

					subIndex = ( index( currentLi ) - 1 );
					if( subIndex > 0 ){
						subIndex -= 1;
					} else {
						subIndex = subItems.length - 1;
					}
					nextA = subItems[ subIndex ].getElementsByTagName( 'a' )[ 0 ];

				break;
				case 'down' :

					if( ul1.getAttribute( 'aria-hidden' ) === 'true' ){

						return subMenuControl( 'open', item );

					} else {

						subIndex = index( currentLi ); /// increments index
						if( subIndex > ( subItems.length - 1 ) ){
							subIndex = 0;
						}
						nextA = subItems[ subIndex ].getElementsByTagName( 'a' )[ 0 ];

					}

				break;
				case 'close' :

					if( ul1.getAttribute( 'aria-hidden' ) === 'false' ){

						currentLi.classList.remove( menuOpen );
						a0.setAttribute( 'aria-expanded', 'false' );
						t0.setAttribute( 'aria-expanded', 'false' );

						ul1.setAttribute( 'aria-hidden', 'true' );
						nextA = a0; // reset focus to rootlevel link

					}

				break;

			}

		} else {

			return a0;

		}

		return nextA;

	}
	/// MOUSE HOVER CONTROLS
	var handleMouseHover = function(e){
		if( rootLevelHover ) return true; /// block hover actions on small screens
		let self = this;
		const a0 = self.getElementsByTagName( 'a' )[ 0 ];
		switch( e.type ){
			case 'mouseenter' :
				/// check for link level0 for aria
				if( a0.getAttribute( 'aria-expanded' ) === 'false' ){
					currentFocus = subMenuControl( 'open', a0 );
				}
			break;
			case 'mouseleave' :
				currentFocus = subMenuControl( 'close', a0 );
			break;
		}
		e.stopPropagation();
		return true;
	}
	
	/// FOCUS STATES
	/// either menu-item or menu-item > a should get focus states that the menu tracks
	var handleFocus = function(e){
		let self = this;
		if( currentFocus != null ){
			if( self.getAttribute( 'aria-haspopup' ) === 'true' ){
				/// check if there are other menus open
				const a0 = getRootLevelItem( currentFocus ).getElementsByTagName( 'a' )[ 0 ];
				if( a0.getAttribute( 'aria-expanded' ) != self.getAttribute( 'aria-expanded' ) ){
					rootMenuControl( 'reset', null );
				}
			}
		} else {
			currentFocus = self;
		}
		return true;
	}
	var handleBlur = function(e){
		setTimeout(function(){
			/// check if we left the menu, if we do reset the menu
			if( !siteNavigation.contains( document.activeElement ) ){
				rootMenuControl( 'reset', null );
			}
		});
		return true;
	}

	/// HAMBURGER CONTROLS
	var handleHamburger = function(e){
		let self      = this;
		hamburgerOpen = true;
		self.classList.toggle( menuOpen ); /// add menu open to parent to only handle expander actions
		/// open toggles
		for( var q = 0; q < toggles.length; q++ ){
			var t = document.getElementById( toggles[ q ] );
			t.classList.toggle( menuOpen );
		}
		if ( self.getAttribute( 'aria-expanded' ) === 'true' ) {
			self.setAttribute( 'aria-expanded', 'false' );
			hamburgerOpen = false;
			for( var q = 0; q < toggles.length; q++ ){
				var t = document.getElementById( toggles[ q ] );
				t.classList.remove( menuFade );
			}
		} else {
			self.setAttribute( 'aria-expanded', 'true' );
			animateToggles();
		}
		return true;
	}
	var resetHamburger = function(){
		hamburger.classList.remove( menuOpen );
		hamburger.setAttribute( 'aria-expanded', 'false' );
		for( var q = 0; q < toggles.length; q++ ){
			var t = document.getElementById( toggles[ q ] );
			t.classList.remove( menuOpen );
			t.classList.remove( menuFade );
		}
		hamburgerOpen = false;
	}

	/// MENU TOGGLE ANIMATIONS
	var animateToggles = function(){
		if( animateQueueIndex < ( toggles.length ) ){
			var t = document.getElementById( toggles[ animateQueueIndex ] );
			setTimeout(function(){
				t.classList.add( menuFade );
				animateToggles();
			});
			++animateQueueIndex;
			return true;
		}
		/// reset animateQueueIndex
		animateQueueIndex = 0;
	}
	
	/// utils
	var getRootLevelItem = function( item ){
		if( item.parentNode.getAttribute( 'role' ) === 'menubar' ){
			return item;
		} else {
			return getRootLevelItem( item.parentNode );
		}
	}
	/// get index
	var index = function( el ) {
		if( !el ) return -1;
		var i = 0;
		do {
			i++;
		} while ( el = el.previousElementSibling );
		return i;
	}
	/// get object type
	var getObjectType = function( obj ){
		return Object.prototype.toString.call( obj ).replace(/^\[object (.+)\]$/, '$1').toLowerCase();
	}

	/// init
	checkMenuResize();
	bindHandlers();

}() );
