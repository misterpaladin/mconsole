/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.allowedContent = true;
	config.uiColor = 'FFFFFF';
	config.colorButton_colors = '00923E,FFFFFF,FFFFFF';
	config.removeButtons = 'Image,NewPage,Preview,Print,Find,Replace,SelectAll,Underline,Subscript,Outdent,Indent,Blockquote,CreateDiv,Cut,Copy,Paste,Save,Anchor,Smiley,Flash,PageBreak,Iframe,Language,JustifyLeft,JustifyRight,JustifyCenter,JustifyBlock,SpellChecker,Scayt,Font,ShowBlocks,FontSize';
	config.toolbarGroups = [
	    { name: 'document',    groups: [ 'mode' ] },
	    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align',] },
	    { name: 'links' },
	    { name: 'insert' },
	    { name: 'clipboard',   groups: [ 'PasteText', 'undo' ] },
	    '/',
	    { name: 'styles' },
	    { name: 'tools' },
	];
};

CKEDITOR.on('dialogDefinition', function( ev ) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if ( dialogName == 'table' ) {
        var info = dialogDefinition.getContents( 'info' );
        info.get('txtWidth')['default'] = '100%';
        info.get('txtBorder')['default'] = null;
        info.get('txtCellPad')['default'] = null;
        info.get('txtCellSpace')['default'] = null;
    }
});