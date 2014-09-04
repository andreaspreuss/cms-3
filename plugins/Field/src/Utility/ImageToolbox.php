<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since	 2.0.0
 * @author	 Christopher Castro <chris@quickapps.es>
 * @link	 http://www.quickappscms.org
 * @license	 http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Field\Utility;

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Field\Utility\FileToolbox;
use QuickApps\Core\Plugin;

/**
 * Utility functions for Image Field Handler.
 *
 * Thumbnails files are always stored in `.tmb` directory.
 */
class ImageToolbox extends FileToolbox {

/**
 * List of preview modes. More modes can be defined using "addPreview()" method.
 * 
 * @var array
 */
	protected static $_previews = [];

/**
 * Renders the given field instance.
 *
 * @param \Cake\View\View $view Instance of view class
 * @param \Field\Model\Entity\Field $field Field instance to render
 * @return string HTML
 */
	public static function formatter($view, $field) {
		$out = '';
		$viewModeSettings = $field->view_mode_settings;

		foreach ((array)$field->extra as $image) {
			if (!empty($image['file_name'])) {
				$img = '';
				$originalURL = normalizePath("/files/{$field->metadata->settings['upload_folder']}/{$image['file_name']}", '/');
				$imageOptions = [];

				foreach (['title', 'alt'] as $attr) {
					if (!empty($field->metadata->settings["{$attr}_attr"]) && !empty($image[$attr])) {
						$imageOptions[$attr] = h($image[$attr]);
					}
				}

				if ($viewModeSettings['size']) {
					$thumbnail = static::thumbnail(normalizePath(WWW_ROOT . "/files/{$field->metadata->settings['upload_folder']}/{$image['file_name']}"), $viewModeSettings['size']);

					if ($thumbnail) {
						$thumbnail = basename($thumbnail);
						$img = $view->Html->image(normalizePath("/files/{$field->metadata->settings['upload_folder']}/.tmb/{$thumbnail}", '/'), $imageOptions);
					}
				} else {
					$img = $view->Html->image($originalURL, $imageOptions);
				}

				if ($img) {
					switch ($viewModeSettings['link_type']) {
						case 'content':
							$entityURL = $field->metadata->entity->get('url');
							if ($entityURL) {
								$out .= $view->Html->link($img, $entityURL, ['escape' => false]);
							} else {
								$out .= $img;
							}
						break;

						case 'file':
							$out .= $view->Html->link($img, $originalURL, ['escape' => false, 'target' => '_blank']);
						break;

						default:
							$out .= $img;
						break;
					}
				}
			}
		}
		return $out;
	}

/**
 * Creates a thumbnail for the given image.
 * 
 * @param string $filePath Full path to original image file
 * @param string $previewSize A valid preview preset
 * @return string|bool Full path to thumbnail file on success, false otherwise
 */
	public static function thumbnail($filePath, $previewSize) {
		$filePath = normalizePath($filePath);

		if (!file_exists($filePath)) {
			return false;
		}

		$srcFileName = basename($filePath);
		$srcPath = dirname($filePath) . DS;
		$dstPath = normalizePath("{$srcPath}/.tmb/");
		$previewInfo = static::getPreviews($previewSize);
		$tnPath = false;

		require_once Plugin::classPath('Field') . 'Lib/class.upload.php';
		$handle = new \upload($srcPath . $srcFileName);
		if (empty($previewInfo)) {
			$previewInfo = reset(static::getPreviews());
		}

		$dstFileNameBody = static::removeExt("{$previewInfo['width']}x{$previewInfo['height']}_{$srcFileName}");
		$dstFilePath = normalizePath("{$dstPath}/{$dstFileNameBody}.jpg");

		if (file_exists($dstFilePath)) {
			$tnPath = $dstFilePath;
		} else {
			$handle->image_x = $previewInfo['width'];
			$handle->image_y = $previewInfo['height'];
			$handle->image_resize = true;
			$handle->image_ratio = false;
			$handle->image_ratio_crop = true;
			$handle->image_convert = 'jpg';
			$handle->file_new_name_body = $dstFileNameBody;
			$result = $handle->process($dstPath);

			if (empty($handle->error)) {
				$tnPath = $handle->file_dst_pathname;
			}
		}

		return $tnPath;
	}

/**
 * Returns an array list of available previews modes suitable for select boxes.
 *
 * @return array
 */
	public static function previewsOptions() {
		static::_initPreviews();

		$options = [];
		foreach (static::$_previews as $value => $info) {
			$options[$value] = $info['label'];
		}
		return $options;
	}

/**
 * Gets all defined previews, or information for an specific preview.
 *
 * @param string $slug Slug of the preview for which get its info, set to null
 *  will retrieve info for all registered previews
 * @return array
 */
	public static function getPreviews($slug = null) {
		static::_initPreviews();

		if ($slug !== null) {
			if (isset(static::$_previews[$slug])) {
				return static::$_previews[$slug];
			}
			return [];
		}

		return static::$_previews;
	}

/**
 * Defines a new preview configuration or overwrite if exists.
 *
 * @param string $slug Unique machine-name. e.g.: `my-preview-mode`
 * @param string $label Human-readable name. e.g.: `My preview mode`
 * @param integer $width Width for images that would use this preview mode
 * @param integer $height Height for images that would use this preview mode
 * @return void
 */
	public static function addPreview($slug, $label, $width, $height) {
		static::_initPreviews();
		static::$_previews[$slug] = ['label' => $label, 'width' => $width, 'height' => $height];
	}

/**
 * Deletes the given image and all its thumbnails.
 * 
 * @param string $imagePath Full path to image file
 * @return void
 */
	public static function delete($imagePath) {
		$imagePath = normalizePath($imagePath);
		if (file_exists($imagePath)) {
			$original = new File($imagePath);
			$fileName = basename($imagePath);
			$tmbPath = dirname($imagePath) . '/.tmb/';
			static::deleteThumbnails($fileName, $tmbPath);
			$original->delete();
		}
	}

/**
 * Delete image's thumbnails if exists.
 * 
 * @param string $fileName Original (full-sized) image's file name
 * @param string $tmbPath Full path to the folder containing the thumbnails
 * @return void
 */
	public static function deleteThumbnails($fileName, $tmbPath) {
		$tmbPath = normalizePath("{$tmbPath}/");
		$folder = new Folder($tmbPath);
		$pattern = preg_quote(static::removeExt($fileName));

		foreach ($folder->find(".*{$pattern}.*") as $tn) {
			$tn = new File($tmbPath . $tn);
			$tn->delete();
		}
	}

/**
 * Initializes defaults built-in preview modes.
 *
 * @return void
 */
	protected static function _initPreviews() {
		if (empty(static::$_previews)) {
			static::$_previews = [
				'thumbnail' => ['label' => __d('field', 'Thumbnail'), 'width' => 100, 'height' => 100],
				'medium' => ['label' => __d('field', 'Medium'), 'width' => 220, 'height' => 220],
				'large' => ['label' => __d('field', 'Large'), 'width' => 480, 'height' => 480],
			];
		}
	}

}
