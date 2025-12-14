# Swiper Slider Module for Joomla!

![swiper-slider](https://user-images.githubusercontent.com/906604/91635509-5b882900-e9f9-11ea-869d-73ac6f2822bc.png)

![GitHub all releases](https://img.shields.io/github/downloads/JoomlaLABS/swiperslider_module/total?style=for-the-badge&color=blue) ![GitHub release (latest by SemVer)](https://img.shields.io/github/downloads/JoomlaLABS/swiperslider_module/latest/total?style=for-the-badge&color=blue)

[![License](https://img.shields.io/badge/license-GPL%202.0%2B-blue.svg)](LICENSE)
[![Joomla](https://img.shields.io/badge/Joomla-6.0%2B-blue.svg)](https://www.joomla.org)

## Description

**Joomla!LABS Swiper Slider Module** is a powerful and modern slider module for Joomla! 6, built on the popular [Swiper.js](https://swiperjs.com) framework. It provides a feature-rich, mobile-friendly, and hardware-accelerated slider solution with extensive configuration options and multiple layout templates.

Perfect for creating image galleries, carousels, content sliders, and advanced presentation layouts with smooth touch gestures and responsive behavior.

## Key Features

### 🎨 Multiple Layout Templates
- **Default** - Classic horizontal/vertical slider
- **3D Coverflow** - Apple's Cover Flow style effect
- **3D Cube** - 3D cube rotation transition
- **3D Flip** - Card flip animation
- **Fade** - Smooth fade transitions
- **Responsive Breakpoints** - Adaptive layout based on screen size
- **Thumbs Gallery** - Main slider with thumbnail navigation

### 📸 Flexible Media Sources
- **Folder** - Load images from a directory
- **Image List** - Repeatable field for manual image selection
- **CSV List** - Comma-separated list of image paths

### ⚙️ Rich Configuration Options

**Navigation & Controls:**
- Pagination (Default, Dynamic Bullets, Progress bar, Fraction, Numbered bullets)
- Navigation arrows (Next/Previous)
- Scrollbar
- Keyboard control
- Mousewheel control

**Behavior:**
- Autoplay with configurable delay
- Loop mode
- Free mode (no fixed positions)
- Centered slides
- RTL (Right-to-Left) support
- Direction (Horizontal/Vertical)

**Display:**
- Configurable slides per view
- Space between slides
- Auto height
- Force full width
- Zoom functionality
- Lazy loading

### 🚀 Modern Architecture (v2.0.0)
- Full **Joomla 6.0+** compatibility
- PSR-4 namespacing
- Service Provider pattern
- Dispatcher architecture
- Web Asset Manager integration
- Secure output escaping
- Optimized performance

## Requirements

- **Joomla**: 6.0 or later
- **PHP**: 8.1 or later
- **Browser**: Modern browsers with JavaScript enabled

## Installation

1. Download the latest release from [GitHub Releases](https://github.com/JoomlaLABS/swiperslider_module/releases)
2. In Joomla Administrator, go to **System → Extensions → Install**
3. Upload the downloaded package file
4. The module will be installed and ready to use

### Update from v1.x

⚠️ **Important**: Version 2.0.0 includes breaking changes for Joomla 6 compatibility.

When upgrading from v1.x:
1. **Backup your site** before upgrading
2. Your module settings will be preserved
3. Verify all layouts work correctly after upgrade
4. Review the [Changelog](#changelog) for details

## Configuration

After installation, create or edit a module instance:

1. Go to **System → Site Modules → New**
2. Select **Joomla!LABS Swiper Slider Module**
3. Configure basic settings:
   - **Title**: Module title
   - **Position**: Module position in your template
   - **Status**: Published/Unpublished

4. **Media Source Tab**: Choose how to load images
   - **Folder**: Select a directory from `/images/`
   - **Image List**: Add images one by one with the repeatable field
   - **CSV List**: Enter comma-separated image paths

5. **Layout Tab**: Select a layout template
   - Choose from 7 available templates
   - Each layout has specific visual effects

6. **Options Tab**: Configure slider behavior
   - Navigation, pagination, and control settings
   - Autoplay, loop, and animation options
   - Display and responsive settings

7. **Advanced Tab**: Fine-tune additional options
   - Module class suffix
   - Caching settings
   - Custom CSS

## Usage Examples

### Basic Image Slider

```
Media Source: Folder
Folder: /images/slideshow/
Layout: Default
Slides Per View: 1
Navigation: Yes
Pagination: Default
```

### Thumbnail Gallery

```
Media Source: Image List
Layout: Thumbs Gallery
Slides Per View: 5
Space Between: 10
Navigation: Yes
```

### 3D Coverflow Gallery

```
Media Source: Folder
Layout: 3D Coverflow
Centered Slides: Yes
Slides Per View: 3
Loop: Yes
```

### Responsive Carousel

```
Media Source: CSV List
Layout: Responsive Breakpoints
Autoplay: Yes
Loop: Yes
```

## Template Override

To customize the module output, you can create template overrides:

1. Copy the desired template from:
   ```
   /modules/mod_joomlalabs_swiperslider_module/tmpl/
   ```

2. Paste it to:
   ```
   /templates/YOUR_TEMPLATE/html/mod_joomlalabs_swiperslider_module/
   ```

3. Edit the copied file to customize the output

## Screenshots

### Site Preview

| Default Layout | 3D Coverflow |
| ------------- | ------------- |
| ![screenshot](https://user-images.githubusercontent.com/906604/91639537-9600be80-ea17-11ea-81b9-782c99038594.png) | ![screenshot](https://user-images.githubusercontent.com/906604/91639552-b466ba00-ea17-11ea-9e71-01332efcf37c.png) |

| 3D Cube | Fade Effect |
| ------------- | ------------- |
| ![screenshot](https://user-images.githubusercontent.com/906604/91639556-c183a900-ea17-11ea-840d-78a28b7941bf.png) | ![screenshot](https://user-images.githubusercontent.com/906604/91639688-9cdc0100-ea18-11ea-843d-9f2c63563bba.png) |

### Administrator Preview

![Configuration - Media Source](https://user-images.githubusercontent.com/906604/93741506-d6a1c100-fbec-11ea-946a-fd694f354986.png)
![Configuration - Layout](https://user-images.githubusercontent.com/906604/93740911-b3c2dd00-fbeb-11ea-9faa-d7f86aebfcae.png)
![Configuration - Options](https://user-images.githubusercontent.com/906604/93741208-42375e80-fbec-11ea-8299-7611fe9907b3.png)
![Configuration - Navigation](https://user-images.githubusercontent.com/906604/93740992-e1a82180-fbeb-11ea-9089-6e667e8e2280.png)
![Configuration - Advanced](https://user-images.githubusercontent.com/906604/93741313-7ca0fb80-fbec-11ea-8774-2e4e4f9da3eb.png)

## Changelog

### [2.0.0] - 2025-12-14

#### Added
- Full Joomla 6.0 compatibility
- Modern architecture with Service Provider and Dispatcher
- PSR-4 namespacing (`Joomla\Module\JoomlalabsSwiperslider`)
- Web Asset Manager integration
- External JavaScript for better performance and caching
- Improved security with proper output escaping
- Layout-specific asset management
- Enhanced configuration override in templates

#### Changed
- **BREAKING**: Minimum Joomla version is now 6.0.0
- **BREAKING**: Minimum PHP version is now 8.1
- **BREAKING**: Module structure completely rewritten
- JavaScript moved from inline to external files (`swiper-init.js`)
- Assets loading via Web Asset Manager (deprecating old methods)
- Language files renamed (removed `en-GB.` prefix)
- Template architecture: effects configuration moved to template files
- Improved Thumbs Gallery layout with better slider linking

#### Removed
- Legacy entry point file (`mod_joomlalabs_swiperslider_module.php`)
- Inline JavaScript in templates
- Deprecated API calls (`$document->addStyleSheet()`, `addScript()`)
- `watchSlidesVisibility` (deprecated in Swiper 6+)

#### Fixed
- Thumbs Gallery main slider configuration (removed incorrect `slidesPerView`)
- Responsive Breakpoints values aligned with original implementation
- Layout prefix handling (`_:` prefix stripped correctly)
- Security improvements with `htmlspecialchars()` for all output
- Better error handling for missing folders
- Improved asset loading performance

### [1.1.0] - 2020-09-21

#### Added
- CSV List media source: You can now pass a comma-separated list of image paths for generating galleries
- Support for direct image path input without folder navigation

### [1.0.0] - 2020-08-27

- Initial Joomla 4 release

## Credits

This module is built using:
<a href="https://swiperjs.com" target="_blank"><img src="https://swiperjs.com/images/swiper-logo.svg" width="12px" alt="Swiper - The Most Modern Mobile Touch Slider" /> Swiper</a>

- **Swiper.js** v6.2.0 - The most modern mobile touch slider
- Icons and graphics from various open-source projects

## Support

- **Documentation**: [Full documentation](https://github.com/JoomlaLABS/swiperslider_module/wiki) (Wiki)
- **Issues**: [Report bugs or request features](https://github.com/JoomlaLABS/swiperslider_module/issues)
- **Discussions**: [Community discussions](https://github.com/JoomlaLABS/swiperslider_module/discussions)

## Contributing

Contributions are welcome! If you'd like to contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please ensure your code follows Joomla coding standards and includes appropriate documentation.

## License

This project is licensed under the **GNU General Public License v2.0 or later** - see the [LICENSE](LICENSE) file for details.

## Authors

- **Joomla!LABS** - [https://joomlalabs.com](https://joomlalabs.com)
- **Email**: info@joomlalabs.com

## Donate

If you find this module useful, consider supporting its development:

[![Sponsor on GitHub](https://img.shields.io/badge/Sponsor-GitHub-ea4aaa?style=for-the-badge&logo=github)](https://github.com/sponsors/JoomlaLABS)
[![Buy me a beer](https://img.shields.io/badge/🍺%20Buy%20me%20a-beer-FFDD00?style=for-the-badge&labelColor=FFDD00&color=FFDD00)](https://buymeacoffee.com/razzo)

Your support helps maintain and improve this project!

---

**Made with ❤️ for the Joomla! Community**
