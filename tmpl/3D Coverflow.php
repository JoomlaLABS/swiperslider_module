<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_joomlalabs_swiperslider_module
 *
 * @author      Joomla!LABS <info@joomlalabs.com>
 * @copyright   (C) 2015 - 2025 Joomla!LABS. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @link        https://joomlalabs.com
 * @since       1.0.0
 */

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Module\JoomlalabsSwiperslider\Site\Dispatcher\Dispatcher;

/**
 * @var array  $allImagesUrl   Array of image URLs
 * @var object $module          Module object
 * @var object $params          Module parameters
 * @var string $swiperConfig    JSON configuration for Swiper
 */

$app = Factory::getApplication();
$document = $app->getDocument();

// Inline styles for specific configurations
$inlineStyles = '';

if ($params->get('forceFullWidth')) {
    $inlineStyles .= '
        #swiper-' . $module->id . ' .swiper-slide img {
            width: 100% !important;
        }
    ';
}

if ($params->get('slidesPerView') == "'auto'") {
    $inlineStyles .= '
        #swiper-' . $module->id . ' .swiper-slide {
            width: auto;
            max-width: 100%;
        }
    ';
}

if (($params->get('slidesPerColumn')) > 1) {
    $inlineStyles .= '
        #swiper-' . $module->id . ' .swiper-slide {
            height: calc((100% - ' . $params->get('spaceBetween') . 'px) / ' . $params->get('slidesPerColumn') . ');
        }
    ';
}

if ($params->get('lazy')) {
    $inlineStyles .= '
        #swiper-' . $module->id . ' .swiper-slide img {
            width: auto;
            max-height: 100%;
            -ms-transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            position: absolute;
            left: 50%;
            top: 50%;
        }
    ';
}

if (!empty($inlineStyles)) {
    $wa = $document->getWebAssetManager();
    $wa->addInlineStyle($inlineStyles, ['name' => 'swiper-custom-' . $module->id]);
}

// Determine RTL direction
$isRtl = (($params->get('dir') == 'global-config') && ($document->getDirection() == 'rtl')) 
         || ($params->get('dir') == 'rtl');

// Add 3D Coverflow specific effect configuration
$config = json_decode($swiperConfig, true);
$config['effect'] = 'coverflow';
$config['coverflowEffect'] = [
    'rotate'       => 50,
    'stretch'      => 0,
    'depth'        => 100,
    'modifier'     => 1,
    'slideShadows' => true,
];
$swiperConfig = json_encode($config, JSON_UNESCAPED_SLASHES);

?>

<!-- Swiper -->
<div id="swiper-<?php echo $module->id; ?>" 
     class="swiper-container" 
     data-swiper-config="<?php echo htmlspecialchars($swiperConfig, ENT_QUOTES, 'UTF-8'); ?>"
     <?php if ($isRtl): ?> dir="rtl"<?php endif; ?>>
     
    <div class="swiper-wrapper">
        <?php foreach ($allImagesUrl as $imageUrl): ?>
            <?php if ($params->get('lazy')): ?>
                <div class="swiper-slide">
                    <img data-src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                         class="swiper-lazy"
                         alt="<?php echo htmlspecialchars(Dispatcher::generateAltText($imageUrl), ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
            <?php else: ?>
                <div class="swiper-slide">
                    <?php if ($params->get('zoom')): ?>
                        <div class="swiper-zoom-container">
                    <?php endif; ?>
                    
                    <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                         alt="<?php echo htmlspecialchars(Dispatcher::generateAltText($imageUrl), ENT_QUOTES, 'UTF-8'); ?>">
                    
                    <?php if ($params->get('zoom')): ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php if ($params->get('pagination')): ?>
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    <?php endif; ?>

    <?php if ($params->get('navigation')): ?>
        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    <?php endif; ?>

    <?php if ($params->get('scrollbar')): ?>
        <!-- Scrollbar -->
        <div class="swiper-scrollbar"></div>
    <?php endif; ?>
</div>
