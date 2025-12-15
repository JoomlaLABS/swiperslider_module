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

/**
 * Initialize Swiper sliders
 */
document.addEventListener('DOMContentLoaded', function() {
    // Store initialized swipers for thumbs gallery linking
    const swipers = {};
    
    // First, initialize thumbs sliders (they need to be initialized first)
    const thumbsContainers = document.querySelectorAll('[data-swiper-thumbs-for]');
    thumbsContainers.forEach(function(container) {
        try {
            let config = JSON.parse(container.dataset.swiperConfig);
            
            // Initialize the thumbs swiper
            const thumbsSwiper = new Swiper('#' + container.id, config);
            
            // Store it with the ID of the main slider it's for
            const mainSliderId = container.dataset.swiperThumbsFor;
            swipers[mainSliderId] = { thumbs: thumbsSwiper };
        } catch (error) {
            console.error('Error initializing Swiper thumbs:', error);
        }
    });
    
    // Then, initialize main swiper containers
    const swiperContainers = document.querySelectorAll('[data-swiper-config]:not([data-swiper-thumbs-for])');
    
    swiperContainers.forEach(function(container) {
        try {
            // Parse the configuration from data attribute
            let config = JSON.parse(container.dataset.swiperConfig);
            
            // Handle autoplay progress indicator
            if (config._autoplayProgress && config._autoplayProgress.enabled) {
                const progressCircle = container.querySelector('.autoplay-progress svg');
                const progressContent = container.querySelector('.autoplay-progress span');
                
                if (progressCircle && progressContent) {
                    config.on = config.on || {};
                    config.on.autoplayTimeLeft = function(s, time, progress) {
                        progressCircle.style.setProperty('--progress', 1 - progress);
                        progressContent.textContent = `${Math.ceil(time / 1000)}s`;
                    };
                }
                
                // Remove internal marker from config
                delete config._autoplayProgress;
            }
            
            // Handle special case for numbered bullet pagination
            if (config.pagination && config.pagination.renderBullet === 'numbered') {
                config.pagination.renderBullet = function (index, className) {
                    return '<span class="' + className + '">' + (index + 1) + '</span>';
                };
            }
            
            // Check if this slider has a thumbs gallery
            if (swipers[container.id] && swipers[container.id].thumbs) {
                config.thumbs = {
                    swiper: swipers[container.id].thumbs
                };
            }
            
            // Initialize Swiper with the configuration
            new Swiper('#' + container.id, config);
        } catch (error) {
            console.error('Error initializing Swiper:', error);
        }
    });
});
