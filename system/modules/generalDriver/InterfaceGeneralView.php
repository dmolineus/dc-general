<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  MEN AT WORK 2012
 * @package    generalDriver
 * @license    GNU/LGPL
 * @filesource
 */
interface InterfaceGeneralView
{

    /**
     * Set the DC
     * 
     * @param DC_General $objDC
     */
    public function setDC($objDC);

    /**
     * Get the DC
     * 
     * @return DC_General 
     */
    public function getDC();

    public function copy();

    public function copyAll();

    public function create();

    public function cut();

    public function cutAll();

    public function delete();

    public function edit();

    public function move();

    public function show();

    public function showAll();

    public function undo();

    public function generateAjaxPalette($strMethod, $strSelector);
}

?>
