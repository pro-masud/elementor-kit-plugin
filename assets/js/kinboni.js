/**
 * KINBONI Pro — Storefront JS
 * Version: 2.0.0
 *
 * Modules:
 *  ✅ KinboniPro.Modal     — open / close / keyboard / focus-trap
 *  🔜 KinboniPro.Cart      — (Step 2) WooCommerce AJAX cart
 *  🔜 KinboniPro.QuickView — (Step 3) product data loader
 *  🔜 KinboniPro.Wishlist  — (Step 4) toggle saved items
 */

( function () {
	'use strict';

	/* ── Global namespace ───────────────────────────── */
	var KB = window.KinboniPro = window.KinboniPro || {};


	/* ════════════════════════════════════════════════
	   Modal Module
	   ════════════════════════════════════════════════ */
	KB.Modal = {

		_active: null,
		_trigger: null,

		/** Open a modal by ID string or element. */
		open: function ( target ) {
			var el = typeof target === 'string'
				? document.getElementById( target )
				: target;
			if ( ! el ) return;

			if ( this._active ) this.close();

			// Append to document.body to prevent clipping by transformed/overflow-hidden Elementor parents.
			if ( el.parentNode !== document.body ) {
				document.body.appendChild( el );
			}

			el.classList.add( 'is-open' );
			document.body.classList.add( 'kb-modal-open' );
			this._active = el;
			this._trapFocus( el );

			el.dispatchEvent( new CustomEvent( 'kinboni:modal:open', { bubbles: true } ) );

			// Refresh Lucide icons inside modal if present
			if ( window.lucide && typeof window.lucide.createIcons === 'function' ) {
				try { window.lucide.createIcons(); } catch ( err ) {}
			}
		},

		/** Close the currently open modal. */
		close: function () {
			if ( ! this._active ) return;

			this._active.classList.remove( 'is-open' );
			document.body.classList.remove( 'kb-modal-open' );

			// Clean up focus-trap listener.
			if ( this._active._kbTrap ) {
				this._active.removeEventListener( 'keydown', this._active._kbTrap );
				this._active._kbTrap = null;
			}

			this._active.dispatchEvent( new CustomEvent( 'kinboni:modal:close', { bubbles: true } ) );
			this._active = null;

			// Return focus to the button that opened the modal.
			if ( this._trigger ) {
				this._trigger.focus();
				this._trigger = null;
			}
		},

		/** Focus-trap: keep Tab cycling inside the modal. */
		_trapFocus: function ( modal ) {
			var sel = 'a[href],button:not([disabled]),textarea,input,select,[tabindex]:not([tabindex="-1"])';
			var nodes = modal.querySelectorAll( sel );
			if ( ! nodes.length ) return;

			var first = nodes[0];
			var last  = nodes[ nodes.length - 1 ];

			setTimeout( function () { first.focus(); }, 80 );

			modal._kbTrap = function ( e ) {
				if ( e.key !== 'Tab' ) return;
				if ( e.shiftKey ) {
					if ( document.activeElement === first ) { e.preventDefault(); last.focus(); }
				} else {
					if ( document.activeElement === last ) { e.preventDefault(); first.focus(); }
				}
			};
			modal.addEventListener( 'keydown', modal._kbTrap );
		}
	};


	/* ════════════════════════════════════════════════
	   Event Binding — runs on DOMContentLoaded or immediately if already loaded
	   ════════════════════════════════════════════════ */
	function initListeners() {

		/* Open modal: any element with data-modal="modal-id" */
		document.addEventListener( 'click', function ( e ) {
			var trigger = e.target.closest( '[data-modal]' );
			if ( ! trigger ) return;
			e.preventDefault();
			KB.Modal._trigger = trigger;
			KB.Modal.open( trigger.dataset.modal );
		} );

		/* Close modal: any element with data-close-modal */
		document.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( '[data-close-modal]' ) ) {
				KB.Modal.close();
			}
		} );

		/* Close modal on Escape */
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' ) KB.Modal.close();
		} );

		/* Initial Lucide icons refresh */
		if ( window.lucide && typeof window.lucide.createIcons === 'function' ) {
			try { window.lucide.createIcons(); } catch ( err ) {}
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initListeners );
	} else {
		initListeners();
	}


	/* ════════════════════════════════════════════════
	   Future Modules — will add step by step
	   ════════════════════════════════════════════════

	   KB.Cart = {
	     add:    function ( productId, qty ) { ... },
	     remove: function ( cartKey ) { ... },
	     update: function ( cartKey, qty ) { ... },
	     get:    function () { ... },
	   };

	   KB.QuickView = {
	     load:   function ( productId ) { ... },
	   };

	   KB.Wishlist = {
	     toggle: function ( productId ) { ... },
	     get:    function () { ... },
	   };

	*/

} )();

