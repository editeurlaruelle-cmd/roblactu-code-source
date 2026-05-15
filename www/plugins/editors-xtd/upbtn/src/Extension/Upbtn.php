<?php

// no direct access

namespace Lomart\Plugin\EditorsXtd\Upbtn\Extension;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Version;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Editor\Button\Button;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Event\Editor\EditorButtonsSetupEvent;

final class Upbtn extends CMSPlugin implements SubscriberInterface
{
    //protected $_name = 'upbtn';
    //protected $_type = 'editors-xtd';
    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return array
     *
     * @since   5.2.0
     */
    public static function getSubscribedEvents(): array
    {
        return ['onEditorButtonsSetup' => 'onEditorButtonsSetup'];
    }

    /**
     * @param  $event
     * @return void
     *
     * @since   5.2.0
     */
    public function onEditorButtonsSetup(EditorButtonsSetupEvent $event): void
    {
        $subject  = $event->getButtonsRegistry();
        $disabled = $event->getDisabledButtons();

        if (\in_array($this->_name, $disabled)) {
            return;
        }

        $button = $this->onDisplay($event->getEditorId());

        if ($button) {
            $subject->add($button);
        }
    }

    public function onDisplay($editorname)
    {
        $this->loadLanguage();
        $app = Factory::getApplication();
        // Version Joomla en cours
        $objVersion = new Version();
        $versionJ4 = ((int)$objVersion->getShortVersion() >= 4);

        // --- Chemin et nom du plugin
        // par défaut, on récupère le nom du script PHP
        $name = $this->_name;
        $path = '/plugins/editors-xtd/'.$name.'/';
        $title = 'Universal plugin';

        if ($app->isClient('administrator')) {
            $path_popup = '../plugins/content/up/upbtn/';
        } else {
            $path_popup = 'plugins/content/up/upbtn/';
        }
        $popup_title = 'Universal plugin';

        // --- code CSS pour l'image du bouton editeur. inutile si utilisation fontAwesome
        $css = '.icon-'.$name.':before {content:url("'.$path.$name.'-16.svg")}';
        if ($versionJ4) {
            // J4 adaptation de la largeur selon device pour TOUS les plugins XTD
            $css .= '@media(max-width:768px){.modal-dialog {width:85vw !important}}';
            $css .= '@media(max-width:480px){.modal-dialog {width:95vw !important}}';
        }
        // force la visualisation
        // $css .= ':not(pre) > code[class*="language-"], pre[class*="language-"] {outline:red 1px solid}';
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $wa->addInlineStyle($css);


        // --- Contrôle langage disponible
        // dans l'ordre : utilisateur, anglais, français
        // tous les fichiers sont créés par UP. Donc si le principal existe, les autres aussi
        while (true) {
            // 1er choix : langue et pays utilisateur
            $lang = Factory::getApplication()->getLanguage()->getTag();
            if (file_exists($path_popup . $lang . '.actions-list.html')) {
                break;
            }
            // 2e choix : langue utilisateur
            $file = glob($path_popup . substr($lang, 0, 2) . '-*' . '.actions-list.html');
            if (isset($file[0])) {
                $lang = substr(basename($file[0]), 0, 5);
                break;
            }
            // 3e choix : en-GB
            $lang = 'en-GB';
            if (file_exists($path_popup . $lang . '.actions-list.html')) {
                break;
            }
            // 4e choix : fr-FR
            $lang = 'fr-FR';
            if (!file_exists($path_popup . $lang . '.actions-list.html')) {
                $app = Factory::getApplication();
                $app->enqueueMessage('UP-button : language not found ' . $path_popup, 'error');
                return;
            }
        }

        // --- ajout fenêtre modal et bouton
        $link = $path_popup . $lang . '.actions-list.html?editor=' . urlencode($editorname);
        // $button->name = $name; // classe image bouton sans 'icon-'
        // icon pour J4-JCE
        $iconSVG  = '<svg  width="32" height="32" viewBox="0 0 32 32">
    <path
       style="fill:#131414;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.168011"
       d="m 11.078202,0.11130167 h 5.254647 V 14.175376 c 0,1.391921 -0.160009,2.708264 -0.473622,3.949025 -0.307214,1.240762 -0.800037,2.324069 -1.472069,3.249916 -0.672032,0.932147 -1.369665,1.580871 -2.105699,1.958768 -1.024048,0.522758 -2.252906,0.787286 -3.6801732,0.787286 -0.8320397,0 -1.7344817,-0.08188 -2.713728,-0.24563 C 4.9083124,23.71728 4.0890732,23.396068 3.4298416,22.917398 2.7770112,22.445027 2.1689825,21.764811 1.6313574,20.889349 1.0809315,20.007589 0.70971427,19.100636 0.50490431,18.168489 0.17848898,16.6632 0.01848153,15.334261 0.01848153,14.175376 V 0.11130167 H 5.273129 V 14.509185 c 0,1.284851 0.2624118,2.292577 0.7680358,3.010582 0.5184242,0.7306 1.2288578,1.089602 2.1441011,1.089602 0.8960423,0 1.6064754,-0.352704 2.1249001,-1.070707 0.512024,-0.705408 0.768036,-1.719433 0.768036,-3.029477 z"
       id="path947" />
    <path
       style="fill:#131414;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.168011"
       d="m 17.561707,-0.00836584 h 8.749213 c 1.907289,0 3.334557,0.62982862 4.288201,1.88318774 0.947246,1.2596579 1.420867,3.0546691 1.420867,5.3787374 0,2.3870506 -0.518425,4.2513437 -1.555273,5.5928777 -1.030449,1.347834 -2.611323,2.021751 -4.736223,2.021751 h -2.886536 v 8.735723 H 17.561707 Z M 22.841956,10.08149 h 1.292862 c 1.024048,0 1.740881,-0.2456299 2.156901,-0.7369004 0.409619,-0.4849679 0.614428,-1.1147964 0.614428,-1.8768891 0,-0.7431979 -0.179206,-1.3667276 -0.537623,-1.8831869 -0.358418,-0.5164604 -1.030451,-0.77469 -2.022497,-0.77469 h -1.504071 z"
       id="path949" />
    <path
       style="fill:#0054ee;fill-opacity:1;fill-rule:evenodd;stroke:none;stroke-width:0.168011px;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
       d="M 0.01848153,31.344505 H 32.019988 V 26.677476 H 0.01848153 Z"
       id="path951" />
</svg>';
        // $button->options = "{handler: 'iframe', size: {x: 700, y: 600}}";

        $button = new Button(
            $this->_name,
            [
                 'action'  => 'modal',
                 'link'    => $link,
                 'text'    => 'Universal Plugin',
                 'icon'    => $this->_name,
                 'iconSVG' => '<svg  width="32" height="32" viewBox="0 0 32 32">
    <path
       style="fill:#131414;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.168011"
       d="m 11.078202,0.11130167 h 5.254647 V 14.175376 c 0,1.391921 -0.160009,2.708264 -0.473622,3.949025 -0.307214,1.240762 -0.800037,2.324069 -1.472069,3.249916 -0.672032,0.932147 -1.369665,1.580871 -2.105699,1.958768 -1.024048,0.522758 -2.252906,0.787286 -3.6801732,0.787286 -0.8320397,0 -1.7344817,-0.08188 -2.713728,-0.24563 C 4.9083124,23.71728 4.0890732,23.396068 3.4298416,22.917398 2.7770112,22.445027 2.1689825,21.764811 1.6313574,20.889349 1.0809315,20.007589 0.70971427,19.100636 0.50490431,18.168489 0.17848898,16.6632 0.01848153,15.334261 0.01848153,14.175376 V 0.11130167 H 5.273129 V 14.509185 c 0,1.284851 0.2624118,2.292577 0.7680358,3.010582 0.5184242,0.7306 1.2288578,1.089602 2.1441011,1.089602 0.8960423,0 1.6064754,-0.352704 2.1249001,-1.070707 0.512024,-0.705408 0.768036,-1.719433 0.768036,-3.029477 z"
       id="path947" />
    <path
       style="fill:#131414;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.168011"
       d="m 17.561707,-0.00836584 h 8.749213 c 1.907289,0 3.334557,0.62982862 4.288201,1.88318774 0.947246,1.2596579 1.420867,3.0546691 1.420867,5.3787374 0,2.3870506 -0.518425,4.2513437 -1.555273,5.5928777 -1.030449,1.347834 -2.611323,2.021751 -4.736223,2.021751 h -2.886536 v 8.735723 H 17.561707 Z M 22.841956,10.08149 h 1.292862 c 1.024048,0 1.740881,-0.2456299 2.156901,-0.7369004 0.409619,-0.4849679 0.614428,-1.1147964 0.614428,-1.8768891 0,-0.7431979 -0.179206,-1.3667276 -0.537623,-1.8831869 -0.358418,-0.5164604 -1.030451,-0.77469 -2.022497,-0.77469 h -1.504071 z"
       id="path949" />
    <path
       style="fill:#0054ee;fill-opacity:1;fill-rule:evenodd;stroke:none;stroke-width:0.168011px;stroke-linecap:butt;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
       d="M 0.01848153,31.344505 H 32.019988 V 26.677476 H 0.01848153 Z"
       id="path951" />
</svg>',
                 // This is whole Plugin name, it is needed for keeping backward compatibility
                 'name' => $this->_type . '_' . $this->_name,
             ]
        );
        return $button;
    }

}
