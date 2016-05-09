/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.allowedContent = true;
	config.uiColor = 'FFFFFF';
	config.colorButton_colors = '00923E,FFFFFF,FFFFFF';
	config.removeButtons = 'Image,NewPage,Preview,Print,Find,Replace,SelectAll,Underline,Subscript,Outdent,Indent,Blockquote,CreateDiv,Cut,Copy,Paste,Save,Anchor,Smiley,Flash,PageBreak,Iframe,Language,JustifyLeft,JustifyRight,JustifyCenter,JustifyBlock,SpellChecker,Scayt,Font';
	config.toolbarGroups = [
	    { name: 'document',    groups: [ 'mode' ] },
	    { name: 'clipboard',   groups: [ 'PasteText', 'undo' ] },
	    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align',] },
	    { name: 'links' },
	    { name: 'insert' },
	    '/',
	    { name: 'styles' },
	    { name: 'colors' },
	    { name: 'tools' },
	    { name: 'others' },
	];
};
