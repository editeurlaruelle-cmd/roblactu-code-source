<?php
/**
 * @version     1.5.1
 * @package     mod_jm_kick_cass
 * @copyright   Copyright (C) 2024. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @author      Maarten Blokdijk / www.kickstartcassiopeia.com
 */
//No Direct Access
defined('_JEXEC') or die;
use \Joomla\CMS\Factory;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Uri\Uri;

// current URI
$uri = Uri::getInstance();
$base=$uri->base();

$cc_textdecoration      = $params->get('textdedoration', '0');
$cc_cookienotice        = $params->get('CookieNotice');
$cc_popup               = $params->get('Popup');
$cc_showshare           = $params->get('ShowShare');
$cc_hidelogo            = $params->get('HideLogo');
$cc_centerlogo          = $params->get('CenterLogo');
$cc_containerfw         = $params->get('containerfw');
$cc_topbar              = $params->get('enable_topnav');
$cc_customhead          = $params->get('customhead');
$navbarshadow           = $params->get('navbarshadow');
$useupper               = $params->get('useupper');
$sitewidth              = $params->get('sitewidth');
$setfavicon             = $params->get('setfavicon');
$ipblock                = $params->get('setipblock');
$enable_stats           = $params->get('enable_stats');
$menunext               = $params->get('menunext');
$mobilebottombar        = $params->get('mobilebottombar');

$document = Factory::getDocument();
if (isset($cc_customhead)){
    $document->addCustomTag($cc_customhead);
    }


    $document->addCustomTag('<link rel="preconnect" href="https://fonts.gstatic.com/">');
    $document->addCustomTag('<link href="https://fonts.googleapis.com/css?family='.$params->get('googleFontNameBody').':'.$params->get('googleFontWeightBody').'" rel="stylesheet">');
    $document->addCustomTag('<link href="https://fonts.googleapis.com/css?family='.$params->get('googleFontNameHeadings').':'.$params->get('googleFontWeightHeadings').'" rel="stylesheet">');

    if ($params->get('disablerightclick')=='1'){
    //************************************************//
    //************************************************//?>
    <script>
   var isNS="Netscape"==navigator.appName?1:0;function mischandler(){return!1}function mousehandler(e){var n=isNS?e:event,t=isNS?n.which:n.button;if(2==t||3==t)return!1}"Netscape"==navigator.appName&&document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP),document.oncontextmenu=mischandler,document.onmousedown=mousehandler,document.onmouseup=mousehandler;
    </script>
<?php }?>

<style>

    <?php if($cc_hidelogo=='1'){?> .navbar-brand {display:none !important;}<?php } ?>
    <?php if($cc_textdecoration=='0'){?> a {text-decoration:none !important;}<?php } ?>
    <?php if($cc_hidelogo=='1'){?> .navbar-brand {display:none !important;}<?php } ?>
    <?php if($cc_centerlogo=='1'){?> .navbar-brand {margin-left:auto;}<?php } ?>
    <?php if($cc_containerfw=='1'){?> .site-grid>.full-width {grid-column: 2/6;}<?php } ?>
    <?php if($navbarshadow=='1'){?> .header {box-shadow: 0px 1px 2px 0px rgb(60 64 67 / 30%), 0px 2px 6px 2px rgb(60 64 67 / 15%);} <?php } ?>
    <?php if($useupper=='1'){?> .mod-menu, .mod-menu__heading{text-transform:uppercase} <?php } ?>

    <?php 
    
    if ($sitewidth=='1') {?>
        .site-grid{grid-template-columns: [full-start] minmax(0,1fr) [main-start] repeat(4,minmax(0,16.875rem)) [main-end] minmax(0,1fr) [full-end];}
        .header .grid-child {max-width: 70em;}
        .footer .grid-child {max-width: 70em;}
        .topbar .grid-child {max-width: 70em;}
    <?php }
     if ($sitewidth=='2') {?>
        .site-grid{grid-template-columns: [full-start] minmax(0,1fr) [main-start] repeat(4,minmax(0,18.875rem)) [main-end] minmax(0,1fr) [full-end];}
        .header .grid-child {max-width: 78em;}
        .footer .grid-child {max-width: 78em;}
        .topbar .grid-child {max-width: 78em;}
    <?php } 
    if ($sitewidth=='3') {?>
        .site-grid{grid-template-columns: [full-start] minmax(0,1fr) [main-start] repeat(4,minmax(0,21.875rem)) [main-end] minmax(0,1fr) [full-end];}
        .header .grid-child {max-width: 90em;}
        .footer .grid-child {max-width: 90em;}
        .topbar .grid-child {max-width: 90em;}
    <?php } 
    if ($menunext=='1'){
        // set logo next to menu
        //************************************ ?>
    @media (min-width:768px) {
        .container-nav {position:fixed; top:20px;}
        .navbar {margin-left: auto; order: 2; margin-right: 20px !important;}
        .container-header nav {margin-top: 0px}
        .navbar-brand {z-index:10;  top: 20px}
        .header .grid-child {max-width: 100%; padding-bottom: 40px !important; padding-left: <?php echo $params->get('menubarpadding')?>vw; padding-right: <?php echo $params->get('menubarpadding')?>vw; padding-top:0 !important}
        .container-header .container-search {order: 3;}
        
    }
    <?php } ?>
    :root{  
        --cassiopeia-color-primary:<?php echo $params->get('primarycolor')?>;
        --cassiopeia-color-link:<?php echo $params->get('linkcolor')?> ;
        --cassiopeia-color-hover:<?php echo $params->get('hovercolor')?> ;
        --cassiopeia-font-family-body: "<?php echo $params->get('googleFontNameBody')?>" ;
        --cassiopeia-font-family-headings: "<?php echo $params->get('googleFontNameHeadings')?>" ;
        --cassiopeia-font-weight-headings: <?php echo $params->get('googleFontWeightHeadings')?> ;
        --cassiopeia-font-weight-normal: <?php echo $params->get('googleFontWeightBody')?> ;
    }
    html {background: url("<?php echo $base?><?php echo $params->get('BackgroundImage')?>");background-repeat: no-repeat; background-position: center center; background-size: cover;  background-attachment: fixed; }
    p,li,ul,td,table {font-size: <?php echo $params->get('BodyFontSize')?>rem !important}
    .atss {top: <?php echo $params->get('socialtop')?>%}
    body {background-color: <?php echo $params->get('backgroundcolor')?>; }
    .brand-logo {font-family: "<?php echo $params->get('googleFontNameHeadings')?>"}   
    .btn-primary{color: <?php echo $params->get('btn-primary-color')?> ; background-color: <?php echo $params->get('btn-primary-background-color')?>; border-color: <?php echo $params->get('btn-primary-border-color')?>}
    .btn-secondary{color: <?php echo $params->get('btn-secondary-color')?> ; background-color: <?php echo $params->get('btn-secondary-background-color')?>; border-color: <?php echo $params->get('btn-secondary-border-color')?>}
    .btn-info{color: <?php echo $params->get('btn-info-color')?> ; background-color: <?php echo $params->get('btn-info-background-color')?>; border-color: <?php echo $params->get('btn-info-border-color')?>}
    .btn-success{color: <?php echo $params->get('btn-success-color')?> ; background-color: <?php echo $params->get('btn-success-background-color')?>; border-color: <?php echo $params->get('btn-success-border-color')?>}
    .btn-warning{color: <?php echo $params->get('btn-warning-color')?> ; background-color: <?php echo $params->get('btn-warning-background-color')?>; border-color: <?php echo $params->get('btn-warning-border-color')?>}
    .btn-danger{color: <?php echo $params->get('btn-danger-color')?> ; background-color: <?php echo $params->get('btn-danger-background-color')?>; border-color: <?php echo $params->get('')?>}
    .blog-item {background-color: <?php echo $params->get('ContentBackgroundColor')?>}
    .btn, .badge {border-radius: <?php echo $params->get('ButtonRadius')?>rem}
    .card-header{background-color: <?php echo $params->get('BackgroundColorCardHeader')?> }
    .card, .mm-collapse, .breadcrumb, .item-content, .blog-item, .item-image, .item-page, .card-header, .left.item-image img, .category-list, .reset, .remind, .pagination,.page-link, .login, .list-group-item, .finder, .no-card .newsflash-horiz li {border-radius: <?php echo $params->get('ContentRadius')?>em !Important}
    .close_button {float:right; bottom: 5px; border-radius: <?php echo $params->get('ButtonRadius')?>rem; padding: 5px;}
    .container-header .metismenu>li.active>a:after, .container-header .metismenu>li.active>button:before, .container-header .metismenu>li>a:hover:after, .container-header .metismenu>li>button:hover:before {background: <?php echo $params->get('primarycolor')?>; opacity: 1}
    .container-banner .banner-overlay .overlay {background-color: <?php echo $params->get('BannerOverlay')?>;}
    .container-bottom-a>*, .container-bottom-b>*, .container-top-a>*, .container-top-b>* {margin: 0em;}
    .container-top-a {background-color:<?php echo $params->get('TopABackground')?> }
    .container-top-b {background-color:<?php echo $params->get('TopBBackground')?>}
    .container-bottom-a {background-color:<?php echo $params->get('BottomABackground')?> }
    .container-bottom-b {background-color:<?php echo $params->get('BottomBBackground')?>  }
    .container-banner .banner-overlay {height:<?php echo $params->get('BannerHeight')?>vh }
    .container-header .metismenu>li.level-1>ul {min-width: <?php echo $params->get('subwidth')?>rem;}
    .container-header .mod-menu, .container-header .navbar-toggler {color: <?php echo $params->get('MenuTextColor')?>}
    .card-header {color: <?php echo $params->get('CardheaderTextColor')?>;}
    .container-header {background: url(<?php echo $base?><?php echo $params->get('MenuBackgroundImage')?>) ; box-shadow: inset 0 0 0 5000px  <?php echo $params->get('MenubarBackgroundColor')?>; background-size: cover; background-repeat: no-repeat; background-attachment:fixed; background-position:top,50%; }
    .footer {background: url(<?php echo $base?><?php echo $params->get('FooterBackgroundImage')?>) ; box-shadow: inset 0 0 0 5000px  <?php echo $params->get('FooterBackgroundColor')?>;background-size: 100% auto; background-repeat: no-repeat; }
    .footer .grid-child {align-items:flex-start}
    .h1, h1 {font-size:<?php echo $params->get('H1FontSize')?>rem }
    .h2, h2 {font-size:<?php echo $params->get('H2FontSize')?>rem }
    .h3, h3 {font-size:<?php echo $params->get('H3FontSize')?>rem }
    .h4, h4 {font-size:<?php echo $params->get('H4FontSize')?>rem }
    .h5, h5 {font-size:<?php echo $params->get('H5FontSize')?>rem }
    .item-page, .com-users, .com-users-reset, .com-users-remind, .com-users-profile, .com-content-category, .card, .mod-articlesnews-horizontal li, .breadcrumb, .finder, .login {background-color: <?php echo $params->get('ContentBackgroundColor')?> !important; padding: 15px;}
    .item-content {padding: 15px; }
    .metismenu.mod-menu .metismenu-item {flex-wrap: wrap !Important; padding: <?php echo $params->get('menupadding')?>px;}
    .navbar-brand {font-family: <?php echo $params->get('googleFontNameHeadings')?>;padding-top: 0rem; padding-bottom: 0rem;}
    .result__title-text {font-size: 1.286rem; font-size: 1.5rem; color: <?php echo $params->get('primarycolor')?>}
    .result__item>*+* {margin-left: 1em; margin-bottom: 1em;  }
    <?php echo $params->get('customcss')?>
        @media (min-width:200px) and (max-width:768px){.footer .grid-child {display:flex; flex: 1 1 300px; flex-direction: column} <?php echo $params->get('customcssmobile')?>}
        @media (min-width:768px) {.bottombar{display:none;} <?php echo $params->get('customcssdesktop')?>}


</style>

<?php if ($cc_topbar){
    //************************************************//
    //************************************************//?>
    <style>
        .container-header {padding-top: <?php echo $params->get('topnavheight')?>px;} 
        .topbar{ margin-right:auto; z-index: 99; padding: <?php echo $params->get('topnavpadding')?>px; position:fixed; top:0; background-color: <?php echo $params->get('topnavbg')?>; width: 100%; color:<?php echo $params->get('topnavcolor')?>;}
        .topbar a {color: <?php echo $params->get('topnavlinkcolor')?> }
        .topbar p {margin-bottom:0}
        <?php if ($params->get('topnavfloatright')){?>
            .topbar .grid-child {justify-content: flex-end}
        <?php }?>
        <?php if ($menunext=='1'){?>
            @media (min-width:768px) {
                .container-header nav, .container-header .container-search { margin-top: <?php echo $params->get('topnavheight')?>px; } 
                .topbar {padding-left: <?php echo $params->get('menubarpadding')?>vw; padding-right: <?php echo $params->get('menubarpadding')?>vw;} 
            }
        <?php } ?>
    </style>

    <?php if ($menunext=='1'){?>
        <div  class="topbar">
        <?php echo $params->get('topnavcontent')?>
        </div>
    <?php } ?>
    <?php if ($menunext!=='1'){?>
        <div class="topbar">
        <div class="grid-child">
            <?php echo $params->get('topnavcontent')?>
        </div>
        </div>
    <?php } ?>

<?php }?>



