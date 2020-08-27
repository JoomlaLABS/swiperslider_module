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

require ModuleHelper::getLayoutPath('mod_joomlalabs_swiperslider_module', $params->get('layout', 'default'));
