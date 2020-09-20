<?php
/**
 * @package    joomlalabs_swiperslider_module
 *
 * @author     Joomla!LABS <info@joomlalabs.com>
 * @copyright  Copyright (C) 2015 - 2020 Joomla!LABS. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://joomlalabs.com
 */

defined('_JEXEC') or die;

$document = $app->getDocument();
$document->addStyleSheet('/media/mod_joomlalabs_swiperslider_module/css/swiper-bundle.min.css', array('version' => 'auto'));
$document->addScript('/media/mod_joomlalabs_swiperslider_module/js/swiper-bundle.min.js', array('version' => 'auto'));

$document->addStyleSheet('/media/mod_joomlalabs_swiperslider_module/css/swiper-style.css', array('version' => 'auto'));

if(($params->get('pagination')) == 'bullet') {
	$document->addStyleSheet('/media/mod_joomlalabs_swiperslider_module/css/swiper-pagination-bullet.css', array('version' => 'auto'));
}

if ($params->get('forceFullWidth')) {
	$document->addStyleDeclaration('
        #swiper-gallery-top-' . $module->id .' .swiper-slide img,
        #swiper-gallery-thumbs-' . $module->id .' .swiper-slide img{
            width: 100% !important;
        }
    ');
}

if ($params->get('slidesPerView') == '\'auto\'') {
	$document->addStyleDeclaration('
        #swiper-gallery-thumbs-' . $module->id .' .swiper-slide{
          width: auto;
          max-width: 100%;
        }
    ');
}

if ($params->get('lazy')) {
	$document->addStyleDeclaration('
	    #swiper-gallery-top-' . $module->id .' .swiper-slide img,
	    #swiper-gallery-thumbs-' . $module->id .' .swiper-slide img{
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
    ');
}

$document->addStyleSheet('/media/mod_joomlalabs_swiperslider_module/css/swiper-thumbs.css', array('version' => 'auto'));

?>

<!-- Swiper -->
<div id="swiper-gallery-top-<?php echo $module->id; ?>" class="swiper-container gallery-top"<?php if( ( ($params->get('dir') == 'global-config') && ($document->getDirection() == 'rtl') ) || ($params->get('dir') == 'rtl') ) { ?> dir="rtl"<?php } ?>>
    <div class="swiper-wrapper">
		<?php foreach($allImagesUrl as $imageUrl): ?>
			<?php if ($params->get('lazy')) { ?>
                <div class="swiper-slide">
                    <img data-src="<?php echo $imageUrl; ?>" class="swiper-lazy">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
			<?php } else { ?>
                <div class="swiper-slide">
					<?php if ($params->get('zoom')): ?><div class="swiper-zoom-container"><?php endif; ?>
                        <img src="<?php echo $imageUrl; ?>">
						<?php if ($params->get('zoom')): ?></div><?php endif; ?>
                </div>
			<?php } ?>
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
<div id='swiper-gallery-thumbs-<?php echo $module->id; ?>' class="swiper-container gallery-thumbs"<?php if( ( ($params->get('dir') == 'global-config') && ($document->getDirection() == 'rtl') ) || ($params->get('dir') == 'rtl') ) { ?> dir="rtl"<?php } ?>>
	<div class="swiper-wrapper">
		<?php foreach($allImagesUrl as $imageUrl): ?>
			<?php if ($params->get('lazy')) { ?>
                <div class="swiper-slide">
                    <img data-src="<?php echo $imageUrl; ?>" class="swiper-lazy">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
			<?php } else { ?>
                <div class="swiper-slide">
					<?php if ($params->get('zoom')): ?><div class="swiper-zoom-container"><?php endif; ?>
                        <img src="<?php echo $imageUrl; ?>">
						<?php if ($params->get('zoom')): ?></div><?php endif; ?>
                </div>
			<?php } ?>
		<?php endforeach; ?>
	</div>
</div>

<!-- Initialize Swiper -->
<script>
    var galleryThumbs = new Swiper('#swiper-gallery-thumbs-<?php echo $module->id; ?>', {
		<?php if ($params->get('loop')): ?>
        loop: true,
		<?php endif; ?>
		<?php if ($params->get('spaceBetween')): ?>
        spaceBetween: <?php echo $params->get('spaceBetween'); ?>,
		<?php endif; ?>
		<?php if (($params->get('slidesPerView')) <> 1): ?>
        slidesPerView: <?php echo $params->get('slidesPerView'); ?>,
		<?php endif; ?>
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var swiper = new Swiper('#swiper-gallery-top-<?php echo $module->id; ?>', {
        // Optional parameters
        direction: '<?php echo $params->get('direction'); ?>',
		<?php if ($params->get('loop')): ?>
        loop: true,
		<?php endif; ?>
		<?php if ($params->get('autoHeight')): ?>
        autoHeight: true,
		<?php endif; ?>
		<?php if ($params->get('spaceBetween')): ?>
        spaceBetween: <?php echo $params->get('spaceBetween'); ?>,
		<?php endif; ?>
		<?php if ($params->get('centeredSlides')): ?>
        centeredSlides: true,
		<?php endif; ?>
		<?php if ($params->get('freeMode')): ?>
        freeMode: true,
		<?php endif; ?>
		<?php if ($params->get('autoplay')): ?>
        autoplay: {
            delay: <?php echo $params->get('autoplayDelay'); ?>,
            disableOnInteraction: <?php echo $params->get('disableOnInteraction'); ?>,
        },
		<?php endif; ?>
		<?php if ($params->get('zoom')): ?>
        zoom: true,
		<?php endif; ?>
		<?php if ($params->get('keyboard')): ?>
        keyboard: {
            enabled: true,
        },
		<?php endif; ?>
		<?php if ($params->get('mousewheel')): ?>
        mousewheel: true,
		<?php endif; ?>
		<?php if ($params->get('lazy')): ?>
        // Enable lazy loading
        lazy: true,
		<?php endif; ?>

		<?php if ($params->get('pagination')): ?>
        // Pagination
        pagination: {
            el: '.swiper-pagination',
			<?php switch ($params->get('pagination')) {
				case "dynamicBullets": echo 'dynamicBullets: true,'; break;
				case "progressbar": echo 'type: \'progressbar\','; break;
				case "fraction": echo 'type: \'fraction\','; break;
				case "bullet": echo 'clickable: true,
                                        renderBullet: function (index, className) {
                                          return \'<span class="\' + className + \'">\' + (index + 1) + \'</span>\';
                                        },'; break;
			} //endswitch ?>
            clickable: true,
        },
		<?php endif; ?>

		<?php if ($params->get('navigation')): ?>
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
		<?php endif; ?>

		<?php if ($params->get('scrollbar')): ?>
        // Scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
		<?php endif; ?>

        thumbs: {
            swiper: galleryThumbs
        },
    });
</script>
