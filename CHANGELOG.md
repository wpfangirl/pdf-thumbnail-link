# Changelog

All notable changes to the **PDF Thumbnail Link Block** plugin will be documented in this file.

## [1.5.0] - 2026-07-04
### Added
- Native automatic update capabilities hosted directly via GitHub.
- `update.json` file to manage remote release distribution.

## [1.4.3] - 2026-06-28
### Changed
- Modified frontend `render.php` markup to wrap the `h3` block title in a direct link to the PDF.
- Added standard WordPress core `.wp-caption-text` utility class to the block caption element for better theme style inheritance.
- Synced `src/edit.js` layout framework to reflect frontend link adjustments in the editor preview.

## [1.4.2] - 2026-06-25
### Fixed
- Replaced strict `isset()` checks with robust type casting using `FILTER_VALIDATE_BOOLEAN` in PHP renderer to guarantee toggle data parses correctly.
- Corrected a critical string translation typo (`grandfather`) in the fallback screen-reader accessibility generator.

## [1.4.0] - 2026-06-23
### Added
- Implemented `aria-label` screen-reader properties to both the image and button markup for grid accessibility compliance.
- Added conditional safety fallbacks (`??`) in React `ToggleControl` elements to prevent state resetting when attributes are unassigned.

## [1.3.0] - 2026-06-20
### Added
- Added an optional "Download PDF" block button utilizing HTML5 forced download attributes.
- Inherited core global style element classes (`.wp-block-button__link`) to match active theme button branding.

## [1.2.0] - 2026-06-18
### Added
- Integrated sidebar Visibility Settings (`ToggleControl`) to toggle the visibility of headings and captions.
- Enhanced editor backend rendering to display media library attachment image thumbnails and document fallbacks seamlessly inside React.

## [1.1.0] - 2026-06-15
### Changed
- Bumped project files to sync baseline version layout hooks inside `block.json` and core dynamic rendering protocols.

## [1.0.0] - 2026-06-10
- Initial release. Native custom WordPress block matching PDF media assets to local presentation layouts.