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

use Zemit\Models\Base\AbstractFile;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Spatie\PdfToText\Pdf;

/**
 * Class File
 *
 * @package Zemit\Models
 */
class File extends AbstractFile
{
    const CATEGORY_ANIMAL = 'animal';
    const CATEGORY_USER = 'user';
    const CATEGORY_INCIDENT = 'incident';
    const CATEGORY_PARKING_SPACE = 'parking_space';
    const CATEGORY_VEHICLE = 'vehicle';
    const CATEGORY_OTHER = 'other';

    protected $category = self::CATEGORY_OTHER;
    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        // File Relation
        $this->hasMany('id', FileRelation::class, 'fileId', ['alias' => 'FileNode']);

        // ParkingSpace relationship
        $this->hasManyToMany('id', FileRelation::class, 'fileId',
            'parkingSpaceId', ParkingSpace::class, ['alias' => 'ParkingSpaceList']);

        // Animal relationship
        $this->hasManyToMany('id', FileRelation::class, 'fileId',
            'animalId', Animal::class, ['alias' => 'AnimalList']);

        // Incident relationship
        $this->hasManyToMany('id', FileRelation::class, 'fileId',
            'incidentId', Incident::class, ['alias' => 'IncidentList']);

        // Incident relationship
        $this->hasManyToMany('id', FileRelation::class, 'fileId',
            'vehicleId', Vehicle::class, ['alias' => 'VehicleList']);

    }

    public function validation()
    {
        $validator = $this->genericValidation();

        // Category
        $validator->add('category', new PresenceOf(['message' => $this->_('categoryRequired')]));
        $validator->add('category', new InclusionIn(['message' => $this->_('categoryNotValid'),
            'domain' => [
                self::CATEGORY_ANIMAL,
                self::CATEGORY_INCIDENT,
                self::CATEGORY_PARKING_SPACE,
                self::CATEGORY_USER,
                self::CATEGORY_VEHICLE,
                self::CATEGORY_OTHER
            ]
        ]));

        return $this->validate($validator);
    }
    
    /**
     * After delete
     * @todo make trash system with cron rotation
     */
    public function afterDelete() {
        
        if ($this->isDeleted()) {
            
            $filePath = $this->getFilePath();
            
            // for new delete the file direclty
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    /**
     * Return null if file not found, or the path
     *
     * @param $fileName
     * @param null $category
     *
     * @return null|string
     */
    public function getFilePath($fileName = null, $category = null)
    {
        $fileName ??= $this->getPath();
        $category ??= $this->getCategory();
        $filePath = null;

        $config = $this->getDI()->get('config');
        $filePath = $config->app->dir->files . $category . (isset($category) ? '/': '') . $fileName;
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
        $imageSize['width'] = $imageWidth;
        $imageSize['height'] = $imageHeight;
        if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
            if ($imageWidth > $imageHeight) {
                $imageSize['height'] = floor(($imageHeight / $imageWidth) * $maxWidth);
                $imageSize['width'] = $maxWidth;
            } else {
                $imageSize['width'] = floor(($imageWidth / $imageHeight) * $maxHeight);
                $imageSize['height'] = $maxHeight;
            }
        }

        switch(mb_strtolower($info['mime'])) {
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
            $newImage = imagecreatetruecolor($imageSize['width'] , $imageSize['height']);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $imageSize['width'], $imageSize['height'], $imageWidth, $imageHeight);

            $exif = @exif_read_data($source);
            if(!empty($exif['Orientation'])) {
                switch($exif['Orientation']) {
                    case 8:
                        $newImage = imagerotate($newImage,90,0);
                        break;
                    case 3:
                        $newImage = imagerotate($newImage,180,0);
                        break;
                    case 6:
                        $newImage = imagerotate($newImage,-90,0);
                        break;
                }
            }
    
            $returnMethodName($newImage, $destination, $returnMethodName === 'imagejpg'? $quality : ceil($quality / 10));
            
            return $destination;
        }

        return false;
    }

    /**
     * Generate a string from an image using an OCR
     *
     * @param null $source
     *
     * @return string|null Return the string from OCR or null otherwise
     */
    public function getFileText(string $source = null) : ?string
    {
        $source ??= $this->getFilePath();
        
        // No source, nothing to return
        if (empty($source)) {
            return null;
        }

        /** @var TesseractOCR $ocr */
        $ocr = $this->getDI()->get('ocr');

        $text = null;
        $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));

        // JPEG / GIF
        if ($ext === 'jpg' || $ext === 'jpeg' || $ext === 'gif') {
            $category = $this->getCategory();
            $destination = $this->getDI()->get('config')->app->dir->files . $category . (isset($category) ? '/': '') . md5(uniqid()) . '.png';
            $path = $this->compressImage($destination);

            if ($path) {
                $text = $ocr->image($path)->run();
                unlink($path);
            }
        }
        
        // PDF
        else if ($ext === 'pdf') {
            
            /** @var Pdf $ocr */
            $pdf = $this->getDI()->get('pdfToText');
            $text = $pdf->setPdf($source)->text();
            
        }
        
        // PNG
        else {
            $text = $ocr->image($source)->run();
        }

        return $text;
    }

}
