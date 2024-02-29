<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Zemit\Models;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Zemit\Models\Abstracts\AbstractFile;
use Zemit\Models\Interfaces\FileInterface;

/**
 * @property EmailFile $EmailFileEntity
 * @property User $UserEntity
 *
 * @method EmailFile getEmailFileEntity(?array $params = null)
 * @method User getUserEntity(?array $params = null)
 */
class File extends AbstractFile implements FileInterface
{
    protected $deleted = self::NO;

    public function initialize(): void
    {
        parent::initialize();

        $this->hasOne('id', EmailFile::class, 'fileId', ['alias' => 'EmailFileEntity']);
        $this->belongsTo('userId', User::class, 'id', ['alias' => 'UserEntity']);
    }

    public function validation(): bool
    {
        $validator = $this->genericValidation();

        $validator->add('key', new Max(['max' => 50, 'message' => $this->_('length-exceeded')]));
        $validator->add('path', new Max(['max' => 120, 'message' => $this->_('length-exceeded')]));
        $validator->add('type', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));
        $validator->add('typeReal', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));
        $validator->add('extension', new Max(['max' => 6, 'message' => $this->_('length-exceeded')]));
        $validator->add('name', new Max(['max' => 100, 'message' => $this->_('length-exceeded')]));
        $validator->add('nameTemp', new Max(['max' => 120, 'message' => $this->_('length-exceeded')]));
        $validator->add('size', new Max(['max' => 45, 'message' => $this->_('length-exceeded')]));
        $validator->add('createdBy', new PresenceOf(['message' => $this->_('required')]));

        return $this->validate($validator);
    }

    /**
     * Return null if file not found, or the path
     */
    public function getFilePath(?string $fileName = null): ?string
    {
        $fileName ??= $this->getPath();

        $config = $this->getDI()->get('config');
        $filePath = $config->app->dir->files . $fileName;
        if (!file_exists($filePath)) {
            $filePath = null;
        }

        return $filePath;
    }
    
    /**
     * Compresses an image and saves it to a destination file.
     *
     * @param string|null $destination The path to save the compressed image. If null, the source file will be overwritten.
     * @param string|null $source The path to the source image file. If null, $this->getFilePath() will be used.
     * @param int $quality The quality of the compressed image (range: 0-100, default: 60).
     * @param int $maxWidth The maximum width of the compressed image (default: 1920).
     * @param int $maxHeight The maximum height of the compressed image (default: 1024).
     * @param string $returnMethodName The name of the method used to save the compressed image.
     *      Possible values: 'imagepng' (default), 'imagejpeg', 'imagegif'.
     *      Note: Make sure the GD extension is enabled in PHP for the respective format.
     *
     * @return string|null The path of the compressed image on success, null if the image cannot be compressed.
     */
    public function compressImage(string $destination = null, string $source = null, int $quality = 60, int $maxWidth = 1920, int $maxHeight = 1024, string $returnMethodName = 'imagepng'): ?string
    {
        $source ??= $this->getFilePath();
        $destination ??= $source;

        if (empty($source)) {
            return null;
        }

        $info = getimagesize($source);

        $imageWidth = $info[0];
        $imageHeight = $info[1];
        $imageSize = [];
        $imageSize['width'] = $imageWidth;
        $imageSize['height'] = $imageHeight;
        if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
            if ($imageWidth > $imageHeight) {
                $imageSize['height'] = floor(($imageHeight / $imageWidth) * $maxWidth);
                $imageSize['width'] = $maxWidth;
            }
            else {
                $imageSize['width'] = floor(($imageWidth / $imageHeight) * $maxHeight);
                $imageSize['height'] = $maxHeight;
            }
        }

        switch (mb_strtolower($info['mime'])) {
            case 'image/jpg':
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            default:
                $image = false;
                break;
        }

        if ($image) {
            $newImage = imagecreatetruecolor($imageSize['width'], $imageSize['height']);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $imageSize['width'], $imageSize['height'], $imageWidth, $imageHeight);

            $exif = @exif_read_data($source);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 8:
                        $newImage = imagerotate($newImage, 90, 0);
                        break;
                    case 3:
                        $newImage = imagerotate($newImage, 180, 0);
                        break;
                    case 6:
                        $newImage = imagerotate($newImage, -90, 0);
                        break;
                }
            }

            $returnMethodName($newImage, $destination, $returnMethodName === 'imagejpg' ? $quality : ceil($quality / 10));

            return $destination;
        }

        return null;
    }

}
