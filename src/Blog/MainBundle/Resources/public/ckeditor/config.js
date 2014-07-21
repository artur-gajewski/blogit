/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
                { name: 'pbckcode' } ,
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

    // Don't convert to entities
    config.htmlEncodeOutput = false;
    config.entities = false;

    // Extra plugins:
    config.extraPlugins = 'youtube,pbckcode';

    //config.allowedContent= 'pre[*]{*}(*); img';

    // PBCKCODE CUSTOMIZATION
    config.pbckcode = {
         // An optional class to your pre tag.
         cls : '',

         // The syntax highlighter you will use in the output view
         highlighter : 'PRETTIFY',

         // An array of the available modes for you plugin.
         // The key corresponds to the string shown in the select tag.
         // The value correspond to the loaded file for ACE Editor.
         modes :  [ ['HTML', 'html'], ['CSS', 'css'], ['PHP', 'php'], ['JS', 'javascript'] ],

         // The theme of the ACE Editor of the plugin.
         theme : 'textmate',

         // Tab indentation (in spaces)
         tab_size : '4'
    };
};
