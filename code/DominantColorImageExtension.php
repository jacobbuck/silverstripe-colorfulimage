<?php

namespace JacobBuck\SilverStripeDominantColor;

use ColorThief\ColorThief;
use SilverStripe\Assets\Folder;
use SilverStripe\Core\Extension;

class DominantColorImageExtension extends Extension
{

    /**
     * @var array
     */
    private static $db = [
        'DominantColor' => 'Varchar(255)'
    ];

    /**
     * Calculation accuracy of the dominant color
     * @var Int
     */
    static public $quality = 10;


    /**
     * Get the primary dominant color of this Image
     * @return String color as hex i.e. #ff0000
     */
    protected function setDominantColor()
    {
        $sourceImage = $this->getPath();

        $color = ColorThief::getColor(
            $sourceImage,
            $quality = '10'
        );

        $hexColor = self::colorToHex($color);

        return $hexColor;
    }

    /**
     * Getting the path (! the only way I found...)
     * @return string
     */
    protected function getPath()
    {
        $hash = substr($this->owner->getHash(), 0, 10);
        $parent = $this->owner->getParent();
        $folder = '';
        if ($parent instanceof Folder) {
            $folder = $parent->Name . '/';
        }
        return ASSETS_PATH . "/.protected/" . $folder . $hash . "/" . $this->owner->Name;
    }

    /**
     * Converts a color array into a hex string
     * @param Array $color [red, green, blue]
     * @return String color as hex i.e. #ff0000
     */
    protected static function colorToHex($color)
    {
        if (empty($color)) return false;
        $hex = dechex(($color[0] << 16) | ($color[1] << 8) | $color[2]);
        return '#' . str_pad($hex, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Set the DominantColor
     */
    public function onBeforeWrite()
    {
        if ($this->owner->ID == 0) {
            $color = $this->setDominantColor();
            $this->owner->DominantColor = $color;
            $this->owner->DominantColorHex = $this->owner->getHash();
        }
    }
}
