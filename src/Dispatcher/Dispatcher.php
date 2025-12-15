<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_joomlalabs_swiperslider_module
 *
 * @author      Joomla!LABS <info@joomlalabs.com>
 * @copyright   (C) 2015 - 2025 Joomla!LABS. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @link        https://joomlalabs.com
 * @since       2.0.0
 */

namespace Joomla\Module\JoomlalabsSwiperslider\Site\Dispatcher;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Factory;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Dispatcher class for mod_joomlalabs_swiperslider_module.
 *
 * @since  2.0.0
 */
class Dispatcher extends AbstractModuleDispatcher
{
    /**
     * Generate accessible alt text from image filename.
     *
     * Removes file extension, replaces underscores/hyphens with spaces,
     * and capitalizes each word for better accessibility.
     *
     * @param string $imageUrl The image URL or path
     *
     * @return string Formatted alt text
     *
     * @since   2.0.0
     */
    public static function generateAltText(string $imageUrl): string
    {
        // Get filename without path
        $filename = basename($imageUrl);
        
        // Remove extension
        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        
        // Replace underscores and hyphens with spaces
        $readable = str_replace(['_', '-'], ' ', $nameWithoutExt);
        
        // Capitalize each word
        return ucwords(trim($readable));
    }

    /**
     * Returns the layout data.
     *
     * @return array
     *
     * @since   2.0.0
     */
    protected function getLayoutData(): array
    {
        $data = parent::getLayoutData();

        // Get Web Asset Manager
        /** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

        // Register and load Swiper assets
        $this->registerAssets($wa);

        // Load base assets
        $wa->useStyle('swiper.bundle')
           ->useStyle('swiper.style')
           ->useScript('swiper.bundle')
           ->useScript('swiper.init');

        // Load specific CSS for bullet pagination if needed
        if ($data['params']->get('pagination') == 'bullet') {
            $wa->useStyle('swiper.pagination-bullet');
        }

        // Load autoplay progress CSS if needed
        if ($data['params']->get('autoplay') && $data['params']->get('autoplayShowProgress')) {
            $wa->useStyle('swiper.autoplay-progress');
            $data['showAutoplayProgress'] = true;
        } else {
            $data['showAutoplayProgress'] = false;
        }

        // Prepare Swiper configuration as JSON
        $swiperConfig         = $this->prepareSwiperConfig($data['params']);
        $data['swiperConfig'] = json_encode($swiperConfig, JSON_UNESCAPED_SLASHES);

        // Generate images array based on selected source
        $params       = $data['params'];
        $allImagesUrl = [];

        if ($params->get('mediaSource') == 'folder') {
            // Load images from folder
            $slidesFolder = JPATH_ROOT . '/images/' . $params->get('slidesFolder');

            if (is_dir($slidesFolder)) {
                $extensions = ['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'];

                foreach ($extensions as $ext) {
                    $files = glob($slidesFolder . '/*.' . $ext);

                    if ($files) {
                        foreach ($files as $file) {
                            $allImagesUrl[] = 'images/' . $params->get('slidesFolder') . '/' . basename($file);
                        }
                    }
                }
            } else {
                Factory::getApplication()->enqueueMessage(
                    'Swiper Slider: The specified folder does not exist',
                    'warning'
                );
            }
        } elseif ($params->get('mediaSource') == 'imageList') {
            // Load images from repeatable list
            $repeatableFields = $params->get('repeatable_fields');

            // Check type and content
            if ($repeatableFields) {
                // If it's a JSON string, decode it
                if (\is_string($repeatableFields)) {
                    $repeatableFields = json_decode($repeatableFields);
                }

                // If it's an object, convert to array
                if (\is_object($repeatableFields)) {
                    $repeatableFields = (array) $repeatableFields;
                }

                if (\is_array($repeatableFields)) {
                    foreach ($repeatableFields as $slide) {
                        // Convert to object if needed
                        if (\is_array($slide)) {
                            $slide = (object) $slide;
                        }

                        if (isset($slide->image) && !empty($slide->image)) {
                            $allImagesUrl[] = $slide->image;
                        }
                    }
                }
            }
        } elseif ($params->get('mediaSource') == 'csvList') {
            // Load images from CSV
            $csvList = $params->get('csvList', '');

            if (!empty($csvList)) {
                $allImagesUrl = array_map('trim', explode(',', $csvList));
            }
        }

        $data['allImagesUrl'] = $allImagesUrl;

        return $data;
    }

    /**
     * Prepare Swiper configuration array from module parameters.
     *
     * @param \Joomla\Registry\Registry $params Module parameters
     *
     * @return array Swiper configuration
     *
     * @since   2.0.0
     */
    private function prepareSwiperConfig($params): array
    {
        $config = [
            'direction' => $params->get('direction', 'horizontal'),
        ];

        // Get current layout
        $layout = $params->get('layout', 'default');

        // Remove module prefix if present (e.g., "_:3D Coverflow" becomes "3D Coverflow")
        if (str_starts_with($layout, '_:')) {
            $layout = substr($layout, 2);
        }

        // Loop
        if ($params->get('loop')) {
            $config['loop'] = true;
        }

        // Rewind
        if ($params->get('rewind')) {
            $config['rewind'] = true;
        }

        // Slides per view
        $slidesPerView = $params->get('slidesPerView', 1);
        if ($slidesPerView != 1) {
            // If it's 'auto', keep it as string
            if ($slidesPerView == "'auto'") {
                $config['slidesPerView'] = 'auto';
            } else {
                $config['slidesPerView'] = (int) $slidesPerView;
            }
        }

        // Grid (replaces slidesPerColumn in Swiper 7+)
        $slidesPerColumn = $params->get('slidesPerColumn', 1);
        if ($slidesPerColumn > 1) {
            $config['grid'] = [
                'rows' => (int) $slidesPerColumn,
            ];
        }

        // Auto height
        if ($params->get('autoHeight')) {
            $config['autoHeight'] = true;
        }

        // Space between
        if ($params->get('spaceBetween')) {
            $config['spaceBetween'] = (int) $params->get('spaceBetween');
        }

        // Centered slides
        if ($params->get('centeredSlides')) {
            $config['centeredSlides'] = true;
        }

        // Free mode
        if ($params->get('freeMode')) {
            $config['freeMode'] = true;
        }

        // Autoplay
        if ($params->get('autoplay')) {
            $config['autoplay'] = [
                'delay'                => (int) $params->get('autoplayDelay', 2500),
                'disableOnInteraction' => $params->get('disableOnInteraction', 'false') === 'true',
            ];

            // Autoplay progress circle
            if ($params->get('autoplayShowProgress')) {
                $config['_autoplayProgress'] = [
                    'enabled' => true,
                ];
            }
        }

        // Zoom
        if ($params->get('zoom')) {
            $config['zoom'] = true;
        }

        // Keyboard
        if ($params->get('keyboard')) {
            $config['keyboard'] = [
                'enabled' => true,
            ];
        }

        // Mousewheel
        if ($params->get('mousewheel')) {
            $config['mousewheel'] = true;
        }

        // Pagination
        if ($params->get('pagination')) {
            $paginationConfig = [
                'el'        => '.swiper-pagination',
                'clickable' => true,
            ];

            switch ($params->get('pagination')) {
                case 'dynamicBullets':
                    $paginationConfig['dynamicBullets'] = true;
                    break;
                case 'progressbar':
                    $paginationConfig['type'] = 'progressbar';
                    break;
                case 'fraction':
                    $paginationConfig['type'] = 'fraction';
                    break;
                case 'bullet':
                    // For numbered bullets, we should use a JavaScript function
                    // But since we can't pass functions in JSON,
                    // we'll handle this case in the swiper-init.js file
                    $paginationConfig['renderBullet'] = 'numbered';
                    break;
            }

            $config['pagination'] = $paginationConfig;
        }

        // Navigation
        if ($params->get('navigation')) {
            $config['navigation'] = [
                'nextEl' => '.swiper-button-next',
                'prevEl' => '.swiper-button-prev',
            ];
        }

        // Scrollbar
        if ($params->get('scrollbar')) {
            $config['scrollbar'] = [
                'el' => '.swiper-scrollbar',
            ];
        }

        return $config;
    }

    /**
     * Register Swiper assets in the Web Asset Manager.
     *
     * @param \Joomla\CMS\WebAsset\WebAssetManager $wa Web Asset Manager instance
     *
     * @return void
     *
     * @since   2.0.0
     */
    private function registerAssets($wa): void
    {
        $registry = $wa->getRegistry();

        // Register CSS Swiper Bundle
        if (!$registry->exists('style', 'swiper.bundle')) {
            $wa->registerStyle('swiper.bundle', 'media/mod_joomlalabs_swiperslider_module/css/swiper-bundle.min.css');
        }

        // Register custom CSS Style
        if (!$registry->exists('style', 'swiper.style')) {
            $wa->registerStyle('swiper.style', 'media/mod_joomlalabs_swiperslider_module/css/swiper-style.css', [], [], ['swiper.bundle']);
        }

        // Register CSS Pagination Bullet
        if (!$registry->exists('style', 'swiper.pagination-bullet')) {
            $wa->registerStyle('swiper.pagination-bullet', 'media/mod_joomlalabs_swiperslider_module/css/swiper-pagination-bullet.css', [], [], ['swiper.bundle']);
        }

        // Register CSS Autoplay Progress
        if (!$registry->exists('style', 'swiper.autoplay-progress')) {
            $wa->registerStyle('swiper.autoplay-progress', 'media/mod_joomlalabs_swiperslider_module/css/swiper-autoplay-progress.css', [], [], ['swiper.bundle']);
        }

        // Register JS Swiper Bundle
        if (!$registry->exists('script', 'swiper.bundle')) {
            $wa->registerScript('swiper.bundle', 'media/mod_joomlalabs_swiperslider_module/js/swiper-bundle.min.js', [], ['defer' => true]);
        }

        // Register JS Init
        if (!$registry->exists('script', 'swiper.init')) {
            $wa->registerScript('swiper.init', 'media/mod_joomlalabs_swiperslider_module/js/swiper-init.js', [], ['defer' => true], ['swiper.bundle']);
        }
    }
}
