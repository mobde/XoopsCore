<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

namespace Xoops\Form;

/**
 * ColorPicker - colorpicker form element
 *
 * @category  Xoops\Form\ColorPicker
 * @package   Xoops\Form
 * @author    Zoullou <webmaster@zoullou.org>
 * @author    John Neill <catzwolf@xoops.org>
 * @copyright 2003-2015 XOOPS Project (http://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @version   Release: 1.0
 * @link      http://xoops.org
 */
class ColorPicker extends Text
{
    /**
     * __construct
     *
     * @param string|array $caption field caption or array of all attributes
     * @param string       $name    field name
     * @param string       $value   field value
     */
    public function __construct($caption, $name = null, $value = '#FFFFFF')
    {
        parent::__construct($caption, $name, 10, 16, $value);
        if (is_array($caption)) {
            parent::__construct($caption);
            $this->setIfNotSet('size', 10);
            $this->setIfNotSet('maxlength', 16);
        } else {
            parent::__construct([]);
            $this->set('caption', $caption);
            $this->setWithDefaults('name', $name, 'name_error');
            $this->set('size', 10);
            $this->set('maxlength', 16);
            $this->set('value', $value);
        }
        $this->setIfNotSet('type', 'text');
    }

    /**
     * render
     *
     * @return string
     */
    public function render()
    {
        $xoops = \Xoops::getInstance();
        if ($xoops->theme()) {
            $xoops->theme()->addScript('include/color-picker.js');
        } else {
            echo '<script type="text/javascript" src="' . $xoops->url('/include/color-picker.js') . '"></script>';
        }
        $temp = $this->get('value', '');
        if (!empty($temp)) {
            $this->set('style', 'background-color:' . $temp . ';');
        }
        return parent::render() . "<button class='btn' type='button' onclick=\"return TCP.popup('"
            . $xoops->url('/include/') . "',document.getElementById('" . $this->getName() . "'));\"> ... </button>";

    }

    /**
     * Returns custom validation Javascript
     *
     * @return string Element validation Javascript
     */
    public function renderValidationJS()
    {
        $eltname = $this->getName();
        $eltcaption = $this->getCaption();
        $eltmsg = empty($eltcaption)
            ? sprintf(\XoopsLocale::F_ENTER, $eltname)
            : sprintf(\XoopsLocale::F_ENTER, $eltcaption);

        return "if ( !(new RegExp(\"^#[0-9a-fA-F]{6}\",\"i\").test(myform.{$eltname}.value)) )"
            . " { window.alert(\"{$eltmsg}\"); myform.{$eltname}.focus(); return false; }";
    }
}
