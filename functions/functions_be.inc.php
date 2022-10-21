<?php
/*
	Redaxo-Addon Backend-Tools
	Backend-Funktionen (Global)
	v1.7.5
	by Falko Müller @ 2018-2022
*/

//aktive Session prüfen


//globale Variablen


//Funktionen
function a1510_changeBE($ep)
{	//Variablen deklarieren
	$mypage = "be_tools";
	$cnt = "";
	$search = $replace = array();

	
	//Vorgaben einlesen
	$op = $ep->getSubject();											//Content des ExtPoint (z.B. Seiteninhalt)
	//$artid = $ep->getParams('article_id');							//Umgebungsparameter des Ex.Points (z.B. article_id | clang)
	$config = rex_addon::get($mypage)->getConfig('config');				//Addon-Konfig einladen


	//CSS und JS anfügen
	$cnt .= '';


	//Frontendbutton definieren
	if (@$config['be_hplink'] == 'checked'):
		$search[0] 	= '<ul class="nav navbar-nav navbar-right"><li>';
		$replace[0] = '<ul class="nav navbar-nav navbar-right"><li><a href="../" target="_blank"><i class="rex-icon fa-globe"></i> '.rex_i18n::msg('a1510_frontendlink').'</a></li><li>';
	endif;


	//Sprach-Platzhalter einfügen
	if (@$config['be_minnav'] == 'checked'):
		$l1 = aFM_maskChar(rex_i18n::msg('a1510_minnav_sticky'));
	
		$search[1] 	= '</head>';
		$replace[1] = '<script type="text/javascript">var betlang = {"stickybtn":"'.$l1.'"};</script></head>';
	endif;	


	//Sidebar minimieren
	if (@$config['be_minsidebar'] == 'checked'):
		$search[2] 	= 'section class="rex-main-frame';
		$replace[2] = 'section class="rex-main-frame bet-sidebar';
	endif;

	
	$op = str_replace($search, $replace, $op);
	return $op;
}


function a1510_gotoTop($ep)
{	global $a1510_mypage;

	//Vorgaben einlesen
	$op = $ep->getSubject();												//Content des ExtPoint (z.B. Seiteninhalt)
	
	//Button einfügen vornehmen
	$search = '</body>';
	$replace = '<div class="bet-gototop" title="'.rex_i18n::msg('a1510_gototop_title').'"><i class="fa fa-angle-up"></i><span>'.rex_i18n::msg('a1510_gototop_title').'</span></div>'.$search;
	
	
	$op = str_replace($search, $replace, $op);
	return $op;
}
?>