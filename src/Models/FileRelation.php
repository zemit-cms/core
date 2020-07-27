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

use Zemit\Models\Base\AbstractFileRelation;
use phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Date;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength\Max;

/**
 * Class FileRelation
 *
* @package Zemit\Models
*/
class FileRelation extends AbstractFileRelation
{
    const CATEGORY_PICTURE = 'picture';
    const CATEGORY_QUOTE = 'quote';
    const CATEGORY_ANIMAL_CERTIFICATION = 'animal_certification';
    const CATEGORY_VEHICLE_CERTIFICATION = 'vehicle_certification';
    const CATEGORY_INSURANCE_PROOF = 'insurance_proof';
    const CATEGORY_RESIDENCE_PROOF = 'residence_Proof';
    const CATEGORY_OTHER = 'other';

    protected $deleted = self::NO;

    public function initialize()
    {
        parent::initialize();

        // File relation
        $this->belongsTo('fileId', File::class, 'id', ['alias' => 'File']);

        // Animal relation
        $this->belongsTo('animalId', Animal::class, 'id', ['alias' => 'Animal']);

        // User relation
        $this->belongsTo('userId', User::class, 'id', ['alias' => 'User']);

        // Incident relation
        $this->belongsTo('incidentId', Incident::class, 'id', ['alias' => 'Incident']);

        // Parking Space relation
        $this->belongsTo('parkingSpaceId', ParkingSpace::class, 'id', ['alias' => 'ParkingSpace']);

        // Vehicle relation
        $this->belongsTo('vehicleId', Vehicle::class, 'id', ['alias' => 'Vehicle']);

    }
    
    public function validation()
    {
        $validator = $this->genericValidation();

        // File
        $validator->add('fileId', new PresenceOf(['message' => $this->_('fileIdRequired')]));

        if (!$this->animalId && !$this->userId && !$this->incidentId && !$this->parkingSpaceId && !$this->vehicleId) {
            $message = new Message('idRequired', ['animalId', 'userId', 'incidentId', 'parkingSpaceId', 'vehicleId'], 'PresenceOf');
            $this->appendMessage($message);
            return false;
        }


        // @TODO
        
        return $this->validate($validator);
    }
}
