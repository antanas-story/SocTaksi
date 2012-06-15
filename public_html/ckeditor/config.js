/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
﻿/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.stylesSet.add( 'my_styles',
		[
		    // Block-level styles
		    { name : 'Antraštė h2', element : 'h2' },
		    { name : 'Antraštė h3' , element : 'h3' },
		    { name : 'Antraštė h4' , element : 'h4' },
		    { name : 'Antraštė h5' , element : 'h5' },
		    
		    { name : 'Citata blokas', element : 'blockquote' },
		 
		    // Inline styles
		    { name : 'Citata teskte', element : 'cite' },
		]);
CKEDITOR.editorConfig = function( config )
{
  /*  config.extraPlugins += (config.extraPlugins ? ',imce' : 'imce' );
    CKEDITOR.plugins.addExternal('imce', 'plugins/imce/');    */

    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
	config.stylesSet = 'my_styles';
	config.extraPlugins = 'stylesheetparser';
	config.contentsCss = 'css/ckeditor.css';
    config.toolbar_General = [
    ['Undo','Redo'],
    ['Bold','Italic','Underline','Strike'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor','Image'],
    ['TextColor','BGColor'],
    ['NumberedList','BulletedList','Outdent','Indent'],
    //['Subscript','Superscript'],
    ['FontSize']
];
    config.toolbar_Extended = [
    ['Undo','Redo'],
    ['Bold','Italic','Underline','Strike'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],['Image','HorizontalRule'],
    ['TextColor','BGColor'],
    ['NumberedList','BulletedList','Outdent','Indent'],
    //['Subscript','Superscript'],
    ['FontSize', 'Styles'],
    ['Source']
];

    config.toolbar_Admin = [
    ['Undo','Redo'],
    ['Bold','Italic','Underline','Strike'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],['Image','HorizontalRule'],
    ['TextColor','BGColor'],
    ['NumberedList','BulletedList','Outdent','Indent'],
    ['FontSize', /*'Format', */'Styles'],
    ['Source', 'ShowBlocks', 'RemoveFormat']
];


//'Font'
//'Format'
//'Styles','Blockquote','CreateDiv'
//[,'Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
//['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
   

};