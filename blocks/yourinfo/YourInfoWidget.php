<?php

namespace panix\mod\admin\blocks\yourinfo;

use panix\engine\components\Browser;

class YourInfoWidget extends \panix\engine\data\Widget {


    public function run() {


        $browserClass = new Browser();
        $browser = $browserClass->getBrowser();
        $platform = $browserClass->getPlatform();

        if ($browser == Browser::BROWSER_FIREFOX) {
            $browserIcon = 'firefox';
        } elseif ($browser == Browser::BROWSER_SAFARI) {
            $browserIcon = 'safari';
        } elseif ($browser == Browser::BROWSER_OPERA) {
            $browserIcon = 'opera';
        } elseif ($browser == Browser::BROWSER_CHROME) {
            $browserIcon = 'chrome';
        } elseif ($browser == Browser::BROWSER_IE) {
            $browserIcon = 'ie';
        }

        if ($platform == Browser::PLATFORM_WINDOWS) {
            $platformIcon = 'windows';
        } elseif ($platform == Browser::PLATFORM_WINDOWS_7) { //no tested
            $platformIcon = 'windows';
        } elseif ($platform == Browser::PLATFORM_WINDOWS_8) { //no tested
            $platformIcon = 'windows-7';
        } elseif ($platform == Browser::PLATFORM_WINDOWS_8_1) { //no tested
            $platformIcon = 'windows-7';
        } elseif ($platform == Browser::PLATFORM_WINDOWS_10) { //no tested
            $platformIcon = 'windows-7';
        } elseif ($platform == Browser::PLATFORM_ANDROID) {
            $platformIcon = 'android';
        } elseif ($platform == Browser::PLATFORM_LINUX) {
            $platformIcon = 'linux';
        } elseif ($platform == Browser::PLATFORM_APPLE) {
            $platformIcon = 'apple';
        }


        return $this->render($this->skin, [
            'platformIcon' => $platformIcon,
            'browserIcon' => $browserIcon,
            'browser' => $browserClass,
        ]);
    }

}
