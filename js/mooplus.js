/*

Script: asset/style.js

License:
        MIT license.

        Copyright (c) 2009 Thomas McGrew

        Permission is hereby granted, free of charge, to any person
        obtaining a copy of this software and associated documentation
        files (the "Software"), to deal in the Software without
        restriction, including without limitation the rights to use,
        copy, modify, merge, publish, distribute, sublicense, and/or sell
        copies of the Software, and to permit persons to whom the
        Software is furnished to do so, subject to the following
        conditions:

        The above copyright notice and this permission notice shall be
        included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
        OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
        NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
        HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
        FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.

Copyright: Thomas McGrew, (c)2009, http://ecolihub.org

*/

/*

Class: Asset.Style

Syntax:
	(start code)
	new Asset.Style( options );
	(end)

Options:
	priority - Setting this property to 0 or a number less than the total loaded stylesheets will allow loaded stylesheets or other rulesets to override the rules in this set. By default it is set to 'highest'.

Example:
	(start code)
	var rules = new Asset.Style( );
	rules.addRule( "body", "background-color: yellow" );
	rules.addRules({
		body: {
			padding:"5px",
			"font-size":"12px"
		}
		".large": "font-size:3em"
		"#small": {
			"font-size":"0.8em",
			color:"#999"
			}
	});
	(end)
Attributes and selectors which contain non-alphanumeric characters must be enclosed in quotes.
Quotes are optional on all other attributes.
*/
Asset.Style = new Class({
	Implements: Options,
	options: {
		priority: 'highest'
	},
	initialize: function( options ) {
		this.setOptions( options )

		// create the style node for all browsers
		this.styleNode = new Element("style",{
			'type':'text/css',
			'media':'screen'
		});

		var styles = $$('head link,head style');
		if ( this.options.priority == 'highest' )
			this.options.priority =  styles.length;
		var nextSibling = ( styles[ this.options.priority ] ) ? styles[ this.options.priority ] : null;
		document.head.insertBefore( this.styleNode, nextSibling );

		if ( Browser.Engine.trident ) // IE
		{
			if ( document.styleSheets && document.styleSheets.length > 0 )
			{
					this.styleNode = document.styleSheets[ this.options.priority ];
			}
			else
			{
				this.styleNode = null;
				alert( "Unable to add style rules!" );
			}
		}

	},

	addRule: function( selector, declaration )
	{
		// append a rule for good browsers
		if (!Browser.Engine.trident)
			this.styleNode.appendChild(document.createTextNode(selector + " {" + declaration + "}"));
		// use alternative methods for IE
		else
			try { this.styleNode.addRule( selector, declaration ); }
			catch( e ) { /* alert( "Unable to apply rule " + selector + " {" + declaration + "}" );*/ }
	},
	addRules: function( rules )
	{
		for ( var i in rules )
		{
			if ( typeof( rules[ i ] ) == "string" )
				this.addRule( i, rules[ i ] ); // for example addRules({ '.floater':'float:right' })
			else
				for( var j in rules[ i ] )
				this.addRule( i, j+':'+rules[ i ][ j ] ); // for example addRules({ '.floater':{ 'float':'right', 'width':'25%' })
		}
	}
});

/*
function: Hash.fromArrays
		accepts 2 arrays and converts them into a hash using the first array as the keys, second array as the values. If the keyArray contains duplicate keys, only the last value will be used.
*/
Hash.fromArrays = function( keyArray, valueArray )
{
		var h = new Hash({ });
		for( var i=0; i < keyArray.length && i < valueArray.length; i++ )
				h.set( keyArray[ i ], valueArray[ i ] );
		return h;
}

/*

Script: core/core.js

License:
        MIT license.

        Copyright (c) 2009 Thomas McGrew

        Permission is hereby granted, free of charge, to any person
        obtaining a copy of this software and associated documentation
        files (the "Software"), to deal in the Software without
        restriction, including without limitation the rights to use,
        copy, modify, merge, publish, distribute, sublicense, and/or sell
        copies of the Software, and to permit persons to whom the
        Software is furnished to do so, subject to the following
        conditions:

        The above copyright notice and this permission notice shall be
        included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
        OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
        NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
        HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
        FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.

Copyright: Thomas McGrew, (c)2009, http://ecolihub.org

*/

var mooplus = {
	version: '0.2-pre'
}

/*

Function: $get
Returns the query string parameter requested. Also known as a GET variable,
these parameters are passed from one page to another after the '?' in the
url.

Arguments:
		varName - the name of the variable to request
		defaultValue - The value to be returned if the passed in variable is not present in the query string. This paramater is optional, and the function will return null in it's stead.
		bubble - If true, this function will bubble up through the parent frames looking for get values if they are not set on the current frame. Defaults to true.

Returns:
		A string containing the value of the GET variable.

*/
var $get = function( varName, defaultValue, bubble )
{
	if ( arguments.length < 1 )
		return;
	if (!$defined( bubble )) bubble = true;
	var getValue = function( win )
	{
		var queryString = win.location.toString( ).split( '?' )[ 1 ];
		var value = new RegExp( "(^|&)" + varName + "=([^&]*)(&|$)" ).exec( queryString );
		if ( !value && bubble && win != win.parent ) return getValue( win.parent );
		return value;
	}
	var value = getValue( window );
	if ( value )
		return value[ 2 ]
	if ( arguments.length >= 2 )
		return defaultValue;
	return null;
}

/*

Function: $benchmark
	Logs the time taken to execute a function and returns its return value.

Arguments:
	func - The function to be executed.
	args - An array containing the arguments to be passed to the function. Alternatively a single value may be passed.
	label - A label to be prepended to the log entry. Defaults to 'runtime'.

Returns:
	The return value of the passed in function.

 */
var $benchmark = function( func, args, label )
{
	if ( !label ) label = 'runtime';
	if ( !args ) args = [ ];
	var t = - ( new Date( ).getTime( ) )
	var returnvalue = func.run( args );
	$log( label + ': ' + (t + new Date( ).getTime( )) + 'ms' )
	return returnvalue;
				    
}

/*

Function: $log
	Prints a message to console.log if it is available.

Arguments:
	String[s] to be printed to the logger

Returns:
	True if console.log is available, false otherwise

 */
var $log = function( )
{
	if ( window.console && console.log )
	{
		for ( var i = 0; i < arguments.length; i++ )
		{
			console.log( arguments[ i ] );
		}
		return true;
	}
	return false;
}

/*

Script: element/element.js
	Adds functions to the Element class for determining the border size and inner size of an element.

License:
        MIT license.

        Copyright (c) 2009 Thomas McGrew

        Permission is hereby granted, free of charge, to any person
        obtaining a copy of this software and associated documentation
        files (the "Software"), to deal in the Software without
        restriction, including without limitation the rights to use,
        copy, modify, merge, publish, distribute, sublicense, and/or sell
        copies of the Software, and to permit persons to whom the
        Software is furnished to do so, subject to the following
        conditions:

        The above copyright notice and this permission notice shall be
        included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
        OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
        NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
        HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
        FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.


Copyright: Thomas McGrew, (c)2009, http://ecolihub.org

*/

Element.implement({
		/*
		Function: getBorderHeight
				This will give the difference between the css height and the true height of the element.

		 Arguments:
				None

		 Returns:
				An integer containing the height of the element in pixels in the case of success, -1 in case of failure.
		 */
		getBorderHeight: function ( )
		{
				var oldHeight = this.style.height;
				var borderHeight = -1;
				this.style.height = '0px';
				try { // makes sure the height gets reset at the end no matter what happens.
						borderHeight = this.getHeight( );
				} catch( e ) { }
				this.style.height = oldHeight;
				return borderHeight;
		},

		/*
		Function: getBorderWidth
				This will give the difference between the css width and the true width of the element.

		 Arguments:
				None

		 Returns:
				An integer containing the width of the element in pixels in the case of success, -1 in case of failure.
		 */
		getBorderWidth: function ( )
		{
				var oldWidth = this.style.width;
				var borderWidth = -1;
				this.style.width = '0px';
				try { // makes sure the width gets reset at the end no matter what happens.
						borderWidth = this.getWidth( );
				} catch( e ) { }
				this.style.width = oldWidth;
				return borderWidth;
		},
		/*
		Function: getInnerHeight
				This function will give you the element's height not including any borders which may be present. This is good for calculating what to set the element's CSS height to.

		 Arguments:
				None

		 Returns:
				An integer containing the inner height of the element in pixels in the case of success, -1 in case of failure.
		 */
		getInnerHeight: function ( )
		{
						return this.getHeight( ) - this.getBorderHeight( );
		},
		/*
		Function: getInnerWidth
				This function will give you the element's width not including any borders which may be present. This is good for calculating what to set the element's CSS width to.

		 Arguments:
				None

		 Returns:
				An integer containing the inner width of the element in pixels in the case of success, -1 in case of failure.
		 */
		getInnerWidth: function ( element )
		{
						return this.getWidth( ) - this.getBorderWidth( );
		},

		/*
		Function: Element.getOption
				Gets the value of the option for a special element. This value should be set in the element's class name in the form class="option:value".

		 Arguments:
				option - The option to retrieve the setting for.
				defaultValue - The value to return if the option is not set. This parameter is optional and will return null if not given.

		 Returns:
				The option value as a string if present, defaultValue if not.
		 */
		getOption: function( option,  defaultValue )
		{
				var optValue = new RegExp( option + ":([a-zA-Z0-9]*)" ).exec( this.className )
			if ( optValue )
					return optValue[ 1 ]
			if ( arguments.length >= 2 )
							return defaultValue;
			return null;
		},

		fixIEHover: function( )
		{
			if ( Browser.Engine.trident4 )
			{
				this.addEvent( 'mouseover', function( ){ this.addClass( 'hover' )});
				this.addEvent( 'mouseout', function( ){ this.removeClass( 'hover' )});
			}
		}


});

/*
Function: Fx.adjustHeight
		Adjusts the height of a child element to match it's parent. All elements marked with the 'fullHeight' class will be resized to the size of their parent element. This will effectively do what one would think style="height:100%" would do.

License:
        MIT license.

        Copyright (c) 2009 Thomas McGrew

        Permission is hereby granted, free of charge, to any person
        obtaining a copy of this software and associated documentation
        files (the "Software"), to deal in the Software without
        restriction, including without limitation the rights to use,
        copy, modify, merge, publish, distribute, sublicense, and/or sell
        copies of the Software, and to permit persons to whom the
        Software is furnished to do so, subject to the following
        conditions:

        The above copyright notice and this permission notice shall be
        included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
        OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
        NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
        HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
        FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.

Copyright: Thomas McGrew, (c)2009, http://ecolihub.org

 */
Fx.adjustHeight = function ( event )
{
		var elements = $$( '.fullHeight' );
		// first, reset the height of all columns
		elements.each( function( element ){ element.style.height =  ""; });
		elements.each( function( element ){
				// IE6 is doing something strange here, so we will catch any errors and check the sanity.
				try{
						parentHeight = $(element.getParent( )).getInnerHeight( )
						if ( parentHeight )
								element.setStyle( 'height',  parentHeight - element.getBorderHeight( ) );
				} catch(e){}
		});
};
window.addEvent( 'load', function( ){ Fx.adjustHeight.delay( 1000 ); });
window.addEvent( 'resize', Fx.adjustHeight );


/*

Script: fx/tabSet.js

License:
        MIT license.

        Copyright (c) 2009 Thomas McGrew

        Permission is hereby granted, free of charge, to any person
        obtaining a copy of this software and associated documentation
        files (the "Software"), to deal in the Software without
        restriction, including without limitation the rights to use,
        copy, modify, merge, publish, distribute, sublicense, and/or sell
        copies of the Software, and to permit persons to whom the
        Software is furnished to do so, subject to the following
        conditions:

        The above copyright notice and this permission notice shall be
        included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
        OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
        NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
        HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
        FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.

Copyright: Thomas McGrew, (c)2009, http://ecolihub.org

*/


/*

Class: Fx.TabSet
		A class for creating a tabbed interface on a web page. This will create a new container element which can be added to the page by calling something like:
		(code start)
		var tabs = new TabSet( )
		document.body.appendChild( tabs.container );
		(end)

Options:
		container - The html <div> element you wish to use for the tab container. This argument is optional and a new <div> element will be created if omitted. Remember to insert the new element into the page somewhere if so.
		tabHeight - the desired height of the tabs in pixels.
		contentHeight - What to set the tab container height to. Valid values are:
				'auto' - automatically resize content containers so that they are of equal height. (default)
				'default' - let the browser determine the size of each container.
				number - the desired height in pixels.

*/

Fx.TabSet = new Class({
		Implements: Options,
		options: {
				container: null,
				tabHeight: false,
				contentHeight:'auto'
		},
		initialize: function( options )
		{
				this.setOptions( options );
				if ( !Fx.TabSet.instances ) Fx.TabSet.instances = new Hash( );
				if ( !Fx.TabSet.CSS ) Fx.TabSet.addCSS( );
				if ( !this.options.container || $(this.options.container).tagName.toLowerCase( ) != 'div' )
						this.container = new Element( 'div', { 'class':'tabContainer' } );
				else
				{
						this.container = $(this.options.container);
						// make sure this is not already a tab set.
						var instances = Fx.TabSet.instances.getValues( );
						for ( var i=0; i < instances.length; i++ )
								if ( instances[ i ].container == this.container )
										return instances[ i ];
						this.container.addClass( 'tabContainer' );
				}

				this.tabHolder = this.container.insertBefore(
						new Element( 'ul', { 'class':'tabHolder' } ),
						this.container.firstChild
				);
				this.tabHolderBottom = this.container.appendChild( new Element( 'ul', { 'class':'tabHolder' } ))

				this.container.getChildren( 'div' ).each( function( div ){
						opts = {
								tabPosition: div.getOption( 'tabPosition' ),
								contentElement: div
						}
						if ( div.title ) opts.title = div.title;
						this.append( new Fx.Tab( opts ));
				}.bind( this ));
				if ( !this.container.id || !this.container.id.length ) this.container.id = 'tabSet' + Fx.TabSet.instances.getLength( );
				Fx.TabSet.instances.set( this.container.id, this );
				window.addEvent( 'resize', this.resize.bind( this ) );
		},
		/*
		Function: append

		Arguments:
				Tab - a Tab created with <i>new Fx.TabSet.Tab( )</i>
		*/
		append: function( Tab )
		{
				Tab.parent = this;
				if ( Tab.options.tabPosition == 'bottom' )
				{
						Tab.tab.addClass( 'bottomTab' );
						this.tabHolderBottom.appendChild( Tab.tab );
				}
				else
						this.tabHolder.appendChild( Tab.tab );
				if ( this.options.tabHeight )
						Tab.tab.style.height = this.options.tabHeight + 'px';

				this.container.insertBefore( Tab.content, this.tabHolderBottom );
				if ( !this.tabs )
				{
						this.tabs = [ ];
						Tab.tab.addClass( 'active' );
						Tab.content.style.display = '';
				}
				else
						Tab.content.style.display = 'none';
				this.tabs.push( Tab );
				this.resize( )
				return Tab;
		},
		/*
		Function: resize
				Resizes the tab holders and makes all tab content containers the same height.

		Arguments:
				None
		*/
		resizeLastCalled: 0, // limit how quickly this can be called again (IE fix).
		resize: function( )
		{
				if ( !( this.resizeLastCalled - new Date( ).getSeconds( ) ) )
						return;
				this.resizeLastCalled = new Date( ).getSeconds( );

				this.resizeTabHolder.delay( 100, this, this.tabHolder );
				this.resizeTabHolder.delay( 100, this, this.tabHolderBottom );

				if ( $type( this.options.contentHeight )  == 'number' )
				{
						this.container.getChildren( 'div' ).each( function( panel ){
								panel.style.height = this.options.contentHeight + "px";
						});
				}
				else if ( this.options.contentHeight == 'auto' )
				{
						var maxHeight = 0;
						this.container.getChildren( 'div' ).each( function( panel ){
								// reset the tab height
								panel.style.height = "";
								// reset the display
								var oldDisplay = panel.style.display;
								panel.style.display = "";
								if ( panel.getInnerHeight( ) > maxHeight )
										maxHeight = panel.getInnerHeight( );
								panel.style.display = oldDisplay;
						});
						this.container.getChildren( 'div' ).each( function( panel ){
								panel.style.height = maxHeight + "px";
						});
				}
				return this;
		},
		resizeTabHolder: function( tabHolder )
		{
				var tabs = tabHolder.getChildren( 'li' );
				tabs.each( function( tab ){
						if ( tabHolder.getInnerHeight( ) <= tab.getHeight( ) )
								tabHolder.style.height = tab.getHeight( ) + "px";
				});
				if ( tabs.length && !tabHolder.getInnerHeight( ) && !Browser.Engine.trident4 )
				{
						this.resizeTabHolder.delay( 200, this, tabHolder );
				}
		},
		destroy: function( )
		{
				Fx.TabSet.instances.erase( this.container.id );
				[ this.tabHolder, this.tabHolderBottom, this.container ].each( function( el ){
						if ( el.getParent( ) )
								el.getParent( ).removeChild( el );
				});
		},
		getActiveTab: function( )
		{
				for( var i=0; i < this.tabs.length; i++ )
						if ( this.tabs[ i ].isActive( ) ) return this.tabs[ i ];
				return null;
		},
		toElement: function( ) { return this.container }
});

/*
Class: Fx.Tab
*/
Fx.Tab = new Class({
		Implements: Options,
		options: {
				title:'No Title',
				tabPosition:'top',
				tabElement:null,
				contentElement:null,
				contentHTML:null
		},

		initialize: function( options )
		{
				this.setOptions( options );
				if ( !window.tabIDCounter ) window.tabIDCounter = 0;
				if ( this.tabElement && $(this.tabElement).tagName == 'li' )
				{

				}
				else
				{
						this.tab = new Element( 'li', {
								'id':'tab'+tabIDCounter,
								'html':this.options.title
						});
				}
				this.tab.addEvent( 'click', this.activate.bind( this ) );
				if ( this.options.contentElement )
				{
						this.content = $(this.options.contentElement);
						this.content.id = 'tabContent'+tabIDCounter++;
						$(this.content).addClass('tabContent');
						if ( this.options.contentHTML )
								this.content.set( 'html', this.options.contentHTML );
				}
				else
				{
						this.content = new Element( 'div', {
								'id':'tabContent'+tabIDCounter++,
								'class':'tabContent',
								'html':this.options.contentHTML
						});
				}
		},

		activate: function( )
		{
				if ( this.parent )
						this.parent.tabs.each( function( tab ){
								tab.deactivate( );
						});
				this.tab.addClass( 'active' );
				this.content.setStyle( 'display', '' );
		},
		deactivate: function( )
		{
				this.tab.removeClass( 'active' );
				this.content.setStyle( 'display', 'none' );
		},
		isActive: function( )
		{
				return this.tab.hasClass( 'active' );
		},
		getId: function( )
		{
				return this.tab.id;
		}
});

		/*
		Function: Fx.TabSet.addCSS( )
				Adds the CSS necessary to make the tabs display properly. This can be overridden by including a custom CSS file or style tag.

		Arguments:
				None
		*/
Fx.TabSet.addCSS = function( )
{
		// add CSS
		if ( Fx.TabSet.CSS ) return Fx.TabSet.CSS;
		Fx.TabSet.CSS = new Asset.Style({
				priority: 0
		})
		Fx.TabSet.CSS.addRules({
				/* The container for the tabs */
				'ul.tabHolder': {
						padding: 0,
						margin: 0,
						display: 'block'
				},

				/* The tabs themselves */
				'ul.tabHolder li': {
						'float': 'left',
						'display': 'block',
						'border-color': '#ccc',
						'border-style': 'solid',
						'border-width': '1px 1px 0 1px',
						'list-style-type': 'none',
						'cursor': 'pointer',
						'padding': '2px 10px 1px 10px',
						'margin': '0 5px 0 0',
						'font-weight': 'bold',
						'color': '#aaa'
				},

				/* Tabs underneath the content containers */
				'ul.tabHolder li.bottomTab': {
						'border-width': '0 1px 1px 1px'
				},

				/* Highlighted tab (when you have the mouse over it */
				'ul.tabHolder li:hover': {
						'color': '#666'
				},

				/* The activated tab */
				'ul.tabHolder li.active': {
						'background-color': '#fff',
						'color': '#000'
				},

				/* The tab content holders */
				'div.tabContainer div.tabContent': {
						'border': '1px solid #ccc'
				}
		});
		return Fx.TabSet.CSS;
};

/*
Function: Fx.Tabs.init( )
		Initializes tabs from HTML. The tabs should be in the following format:

		(start code)
		<div class="tabContainer">
				<div title="Tab 1 Label">
						Tab 1 content
				</div>
				<div title="Tab 2 Label">
						Tab 2 content
				</div>
				...
		</div>
		(end)

		The function will automatically convert these into tabs.  Also bear in mind that tab content elements DO NOT retain their id attribute. This is replaced in the init function with an id which allows the tab to work. Unlike class names, elements cannot have more than one id attribute. If a unique attribute is necessary for css styling purposes, I recommend you use a unique class instead.

		Tabs options:
		Options are placed in the class name of the elements in the format class="option:value". Valid options are as follows:

		tabLocation
				bottom - places the tab for this content at the bottom of the tabContainer instead of the top.

		Unrecognized options are ignored.
*/
Fx.TabSet.init = function( )
{
		$$('.tabContainer').each( function( div ){
				new Fx.TabSet({
						container:div
				});
		});
};

window.addEvent( 'domready', Fx.TabSet.init );


/*
Script: storage/hash.storage.js
		A class to store data using localStorage from the HTML5 API if available. Falls back to using Hash.Cookie if not.

License:
        MIT license.

        Copyright (c) 2009 Thomas McGrew

        Permission is hereby granted, free of charge, to any person
        obtaining a copy of this software and associated documentation
        files (the "Software"), to deal in the Software without
        restriction, including without limitation the rights to use,
        copy, modify, merge, publish, distribute, sublicense, and/or sell
        copies of the Software, and to permit persons to whom the
        Software is furnished to do so, subject to the following
        conditions:

        The above copyright notice and this permission notice shall be
        included in all copies or substantial portions of the Software.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
        OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
        NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
        HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
        FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.

Copyright: Thomas McGrew, (c)2009, http://ecolihub.org

*/

/*

Class: Hash.Storage

Extends: Hash.Cookie

Usage: Usage is identical to Hash.Cookie, except that DOM Storage is used in place of cookies when available.

*/


if ( !window.localStorage && window.globalStorage ) // Firefox
		localStorage = globalStorage[ location.hostname ]

Hash.Storage = new Class({
		Extends: Hash.Cookie,
		initialize: function( name, options )
		{
				if ( window.localStorage )
						this.storage = "domStorage";
				else
						this.storage = "cookie";
				this[ this.storage ] = true;
				this.parent( name, { domain: location.hostname, path: '/', duration: 365 } )
		},
		/*

		Function: maxSize
				returns an ESTIMATE of the available storage space for data in bytes. THIS MAY NOT BE EXACT!

		*/
		maxSize: function( )
		{
				if ( this.domStorage )
						if ( Browser.Engine.trident )
								return 10485760;
						return 5242880;
				if ( this.cookie )
						return 4096;
				if ( this.userData )
						return 65536;
		},
		/*

		Function: size
				returns the size of data storage used, in bytes.

		*/
		size: function( ) { return this.read( ).length; },

		/*

		Function: free
				returns an ESTIMATE of the amount of space free for storage in byes. THIS MAY NOT BE EXACT!
		*/
		free: function( ) { return this.maxSize( ) - this.size( ); }
});

if ( window.localStorage )
Hash.Storage.implement({
		write: function( value )
		{
				localStorage[ this.key ] = value;
				return this;
		},

		read: function( )
		{
				if ( !localStorage[ this.key ] ) return null;
				var value = ( localStorage[ this.key ].value ) ? localStorage[ this.key ].value : localStorage[ this.key ];
				return value;
		},

		dispose: function( )
		{
				if ( localStorage[ this.key ] )
						delete localStorage[ this.key ];
				this.load( );
				return this;
		}
});
/*
else if ( Browser.Engine.trident ) // For  IE 6/7 - userData behavior
Hash.Storage.implement({
		initialize: function( name, options )
		{
				this.storage = "userData";
				this.storage[ this.storage ] = true;
//			  if ( !( this.storage = $(name) ) )
//			  {
						this.storageEl = document.createElement( 'span' );
						this.storageEl.id = name;
						this.storageEl.addBehavior("#default#userData");
						this.storageEl.style.display = "none";
//			  }
				document.body.appendChild( this.storage );
				this.parent( name, { domain: location.hostname, path: '/', duration: 365 } )
		},
		write: function( value )
		{
				this.storageEl.setAttribute("sPersist",value);
				this.storageEl.save(this.key);
		},
		read: function( )
		{
				this.storageEl.load(this.key);
				return this.storage.getAttribute("sPersist");
		},
		dispose: function( )
		{
				this.storageEl.setAttribute("sPersist","");
				this.storageEl.save(this.key);
		}

});
*/ /*
else
{

		// Attempt to Initialize Gears
		if (!window.google || !google.gears)
		{

				var factory = null;

				// Firefox
				if (typeof GearsFactory != 'undefined') {
						factory = new GearsFactory();
				}
				else
				{
				// IE
						try {
								factory = new ActiveXObject('Gears.Factory');
								// privateSetGlobalObject is only required and supported on IE Mobile on
								// WinCE.
								if (factory.getBuildInfo().indexOf('ie_mobile') != -1)
										factory.privateSetGlobalObject(this);
						}
						catch (e)
						{
								// Safari
								if ((typeof navigator.mimeTypes != 'undefined')
										&& navigator.mimeTypes["application/x-googlegears"])
								{
										factory = document.createElement("object");
										factory.style.display = "none";
										factory.width = 0;
										factory.height = 0;
										factory.type = "application/x-googlegears";
										document.documentElement.appendChild(factory);
								}
						}
				}

				// *Do not* define any objects if Gears is not installed. This mimics the
				// behavior of Gears defining the objects in the future.
				if (factory) {

						// Now set up the objects, being careful not to overwrite anything.

						// Note: In Internet Explorer for Windows Mobile, you can't add properties to
						// the window object. However, global objects are automatically added as
						// properties of the window object in all browsers.
						if (!window.google) {
								google = {};
						}

						if (!google.gears) {
								google.gears = {factory: factory};
						}
				}
		}
}
*/

