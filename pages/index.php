<?php
/*
	Redaxo-Addon Backend-Tools
	Verwaltung: index
	v1.7.1
	by Falko Müller @ 2018-2020 (based on 1.0@rex4)
	package: redaxo5
*/

//Fehlerhinweise (E_NOTICE) abschalten
//error_reporting(E_ALL ^  E_NOTICE);

//Variablen deklarieren
$mypage = $this->getProperty('package');

$page = rex_request('page', 'string');
$subpage = rex_be_controller::getCurrentPagePart(2);						//Subpages werden aus page-Pfad ausgelesen (getrennt mit einem Slash, z.B. page=demo_addon/subpage -> 2 = zweiter Teil)
	$tmp = rex_request('subpage', 'string');
	$subpage = (!empty($tmp)) ? $tmp : $subpage;
$subpage2 = rex_be_controller::getCurrentPagePart(3);						//2. Unterebene = dritter Teil des page-Parameters
	$subpage2 = preg_replace("/.*-([0-9])$/i", "$1", $subpage2);			//Auslesen der ClangID
$func = rex_request('func', 'string');

$config = $this->getConfig('config');


//Userrechte prüfen
//$isAdmin = ( is_object(rex::getUser()) AND (rex::getUser()->hasPerm($mypage.'[admin]') OR rex::getUser()->isAdmin()) ) ? true : false;


//Seitentitel ausgeben
echo ($subpage != 'cropper') ? rex_view::title($this->i18n('a1510_title').'<span class="addonversion">'.$this->getProperty('version').'</span>') : '';


//globales Inline-CSS + Javascript
?>
<style type="text/css">
input.rex-form-submit { margin-left: 190px !important; }	/* Rex-Button auf neue (Labelbreite +10) verschieben */
td.name { position: relative; padding-right: 20px !important; }
.nowidth { width: auto !important; }
.togglebox { display: none; margin-top: 8px; font-size: 90%; color: #666; line-height: 130%; }
.toggler { width: 15px; height: 12px; position: absolute; top: 10px; right: 3px; }
.toggler a { display: block; height: 11px; background-image: url(../assets/addons/<?php echo $mypage; ?>/arrows.png); background-repeat: no-repeat; background-position: center -6px; cursor: pointer; }
.required { font-weight: bold; }
.inlinelabel { display: inline !important; width: auto !important; float: none !important; clear: none !important; padding: 0px  !important; margin: 0px !important; font-weight: normal !important; }
.inlineform { display: inline-block !important; }
.form_auto { width: auto !important; }
.form_plz { width: 25%px !important; margin-right: 6px; }
.form_ort { width: 73%px !important; }
.form_25perc { width: 25% !important; min-width: 120px; }
.form_50perc { width: 50% !important; min-width: 120px; }
.form_75perc { width: 75% !important; }
.form_content { display: block; padding-top: 5px; }
.form_readonly { background-color: #EEE; color: #999; }
.form_isoffline { color: #A00; }
.addonversion { margin-left: 7px; }
.radio label, .checkbox label { margin-right: 20px; }

.form_column, .datepicker-widget { display: inline-block; vertical-align: middle; }
	.form_column-spacer, .datepicker-widget-spacer { padding: 0px 5px; }
.daterangepicker { box-shadow: 3px 3px 10px 0px rgb(0,0,0, 0.2); }
.daterangepicker .calendar-table th, .daterangepicker .calendar-table td { padding: 2px; }

.addon_failed, .addonfailed { color: #F00; font-weight: bold; margin-bottom: 15px; }
.addon_search { width: 100%; background-color: #EEE; }
.addon_search .searchholder { position: relative; }
	.addon_search .searchholder a { position: absolute; top: -1px; right: 7px; cursor: pointer; }
	@-moz-document url-prefix('') { .addon_search .searchholder a { top: -3px; } /* FF-only */ }
.addon_search .border-top { border-top: 1px solid #DFE9E9; }
.addon_search td { width: 46%; padding: 9px !important; font-size: 90%; color: #333; border: none !important; vertical-align: top !important; }
	.addon_search td.td2 { width: 8%; text-align: center; }
	.addon_search td.td3 { text-align: right;	}
.addon_search input { width: 84px; margin: 0px !important; padding: 2px !important; height: 20px !important; }
	.addon_search input.sbeg { width: 84px; padding: 2px 18px 2px 2px !important; }
.addon_search select { margin: 0px !important; padding: 0px 10px 0px 0px !important; height: 20px !important; min-width: 230px; max-width: 230px; }
	.addon_search select option { margin-right: -10px; padding-right: 10px; }
	.addon_search select.multiple { height: 60px !important; }
	.addon_search select.form_auto { width: auto !important; max-width: 634px; }
.addon_search input.checkbox { display: inline-block; width: auto; margin: 0px 6px !important; padding: 0px !important; height: auto !important; }
.addon_search input.button { font-weight: bold; margin: 0px !important; margin-left: 5px !important; width: auto; padding: 0px 2px 0px 2px !important; height: 21px !important; }
.addon_search label { display: inline-block; width: 90px !important; font-weight: normal; }
	.addon_search label.multiple { vertical-align: top !important; }
	.addon_search label.form_auto { width: auto !important; }
.addon_search a.moreoptions { display: inline-block; vertical-align: sub; }
.addon_search .rightmargin { margin-right: 7px !important; }

.db-order { display: inline; /*width: 20px; height: 10px;*/ padding: 0px 5px; margin-left: 0px; cursor: pointer; }
.db-order-desc { background-position: center bottom; }
.block { display: block; }
.info { font-size: 0.825em; }
.info-labels { display: inline-block; padding: 3px 6px; background: #EAEAEA; margin-right: 5px; font-size: 0.80em; }
	.info-green { background: #360; color: #FFF; }
	.info-red { background: #900; color: #FFF; }
.infoblock { display: block; font-size: 0.825em; margin-top: 7px; }

span.ajaxNav { display: inline-block; padding: 2px 4px; margin: 3px 2px 1px; cursor: pointer; }
span.ajaxNav:hover { background-color: #666; color: #FFF; }
span.ajaxNavSel { background-color: #CCC; }

.checkbox.toggle label input, .radio.toggle label input { -webkit-appearance: none; -moz-appearance: none; appearance: none; width: 3em; height: 1.5em; background: #ddd; vertical-align: middle; border-radius: 1.6em; position: relative; outline: 0; margin-top: -3px; margin-right: 10px; cursor: pointer; transition: background 0.1s ease-in-out; }
	.checkbox.toggle label input::after, .radio.toggle label input::after, .radio.switch label input::before { content: ''; width: 1.5em; height: 1.5em; background: white; position: absolute; border-radius: 1.2em; transform: scale(0.7); left: 0; box-shadow: 0 1px rgba(0, 0, 0, 0.5); transition: left 0.1s ease-in-out; }
.checkbox.toggle label input:checked, .radio.toggle label input:checked { background: #5791CE; }
	.checkbox.toggle label input:checked::after { left: 1.5em; }

.radio.switch label { margin-right: 1.5em; }
.radio.switch label input { width: 1.5em; margin-right: 5px; }
	.radio.switch label input:checked::after { transform: scale(0.5); }
.radio.switch label input::before { background: #5791CE; opacity: 0; box-shadow: none; }
	.radio.switch label input:checked::before { animation: radioswitcheffect 0.65s; }
@keyframes radioswitcheffect { 0% { opacity: 0.75; } 100% { opacity: 0; transform: scale(2.5); } }
</style>


<script type="text/javascript">
setTimeout(function() { jQuery('.alert-info').fadeOut(); }, 5000);			//Rückmeldung ausblenden
</script>


<?php
//Unterseite einbinden
switch($subpage):
	case "help":	//Hilfe
					require_once("help.inc.php");
					break;				

/*
	case "cropper":	//ImageCropper
	
					$fragment = new rex_fragment();
					$fragment->setVar('title', rex_i18n::msg('pool_file_caption', "Peter"), false);
					//$fragment->setVar('options', $toolbar, false);
					$fragment->setVar('content', "HALLO", false);
					$content = $fragment->parse('core/page/section.php');
					echo $content;
	
					//require_once("cropper.inc.php");
					break;					
*/

	default:		//Index = Standardwerte
					require_once("default.inc.php");
					break;
endswitch;
?>


<!-- PLEASE DO NOT REMOVE THIS COPYRIGHT -->
<p><?php echo $this->getProperty('author'); ?></p>
<!-- THANK YOU! -->