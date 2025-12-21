<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_joomlalabs_swiperslider_module
 *
 * @author      Joomla!LABS <info@joomlalabs.com>
 * @copyright   (C) 2015 - 2025 Joomla!LABS. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @link        https://joomlalabs.com
 * @since       2.1.0
 */

\defined('_JEXEC') or die;

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

if (!empty($inlineStyles)) {
    $wa = $document->getWebAssetManager();
    $wa->addInlineStyle($inlineStyles, ['name' => 'swiper-creative3-custom-' . $module->id]);
}

// Determine RTL direction
$isRtl = (($params->get('dir') == 'global-config') && ($document->getDirection() == 'rtl')) 
         || ($params->get('dir') == 'rtl');

// Add Creative 3 specific effect configuration
$config = json_decode($swiperConfig, true);
$config['effect'] = 'creative';
$config['grabCursor'] = true;
$config['creativeEffect'] = [
    'prev' => [
        'shadow'    => true,
        'translate' => ['-20%', 0, -1],
    ],
    'next' => [
        'translate' => ['100%', 0, 0],
    ],
];
$swiperConfig = json_encode($config, JSON_UNESCAPED_SLASHES);

?>

<!-- Swiper Creative 3 -->
<div id="swiper-<?php echo $module->id; ?>" 
     class="swiper" 
     data-swiper-config="<?php echo htmlspecialchars($swiperConfig, ENT_QUOTES, 'UTF-8'); ?>"
     <?php if ($isRtl): ?> dir="rtl"<?php endif; ?>>
     
    <div class="swiper-wrapper">
        <?php foreach ($allImagesUrl as $imageUrl): ?>
            <?php if ($params->get('lazy')): ?>
                <div class="swiper-slide">
                    <img data-src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                         class="swiper-lazy"
                         loading="lazy"
                         alt="<?php echo htmlspecialchars(Dispatcher::generateAltText($imageUrl), ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
            <?php else: ?>
                <div class="swiper-slide">
                    <?php if ($params->get('zoom')): ?>
                        <div class="swiper-zoom-container">
                    <?php endif; ?>
                    
                    <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8'); ?>" 
                         loading="lazy"
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

    <?php if ($showAutoplayProgress): ?>
        <!-- Autoplay Progress -->
        <div class="autoplay-progress">
            <svg viewBox="0 0 48 48">
                <circle cx="24" cy="24" r="20"></circle>
            </svg>
            <span></span>
        </div>
    <?php endif; ?>
</div>
