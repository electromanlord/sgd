// JavaScript Document
tinyMCE.init({
	language : 'es',
	mode : "exact",
	elements : "rpt_borrador",
	theme : "advanced",
	skin : "o2k7",
	
		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",

	// Theme options
	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,cut,copy,paste,pastetext,pasteword,|,undo,redo,|,fontselect,fontsizeselect,|,forecolor,backcolor,|,sub,sup,charmap,|,print,|,fullscreen",
	theme_advanced_buttons2 :"replace,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,tablecontrols,|,hr,|,template,pagebreak,|,spellchecker",
	theme_advanced_buttons3 : "visualchars,template,blockquote",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	spellchecker_languages : "+Espanol=es"
});