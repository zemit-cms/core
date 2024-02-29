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
     * Compress an image
     *
     * @param null $destination
     * @param null $source
     * @param int $quality
     * @param int $maxWidth
     * @param int $maxHeight
     * @param string $returnMethodName
     *
     * @return string|bool Return a string on success or false
     */
    public function compressImage($destination = null, $source = null, $quality = 60, $maxWidth = 1920, $maxHeight = 1024, $returnMethodName = 'imagepng')
    {
        $source ??= $this->getFilePath();
        $destination ??= $source;

        if (empty($source)) {
            return false;
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

        return false;
    }

}
