<?php
/**
 * @package    joomlalabs_swiperslider_module
 *
 * @author     Joomla!LABS <info@joomlalabs.com>
 * @copyright  Copyright (C) 2015 - 2020 Joomla!LABS. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://joomlalabs.com
 */

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

// The below line is no longer used in Joomla 4
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

// Access to module parameters
$allImagesUrl = Array();
if($params->get('mediaSource') == 'folder') {
	foreach(glob('images/'.$params->get('slidesFolder').'/*.{jpg,JPG,jpeg,JPEG,png,PNG}',GLOB_BRACE) as $file) {
		$allImagesUrl[] = 'images/'.$params->get('slidesFolder').'/'.basename($file);
	}
} elseif ($params->get('mediaSource') == 'imageList') {
	foreach ($params->get('repeatable_fields') as $slide) {
		$allImagesUrl[] = $slide->image;
	}
} elseif ($params->get('mediaSource') == 'csvList') {
	foreach (explode(",",$params->get('csvList')) as $slide) {
		$allImagesUrl[] = $slide;
	}
}

require ModuleHelper::getLayoutPath('mod_joomlalabs_swiperslider_module', $params->get('layout', 'default'));
