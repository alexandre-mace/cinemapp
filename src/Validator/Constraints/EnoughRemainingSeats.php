<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/04/19
 * Time: 20:33
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EnoughRemainingSeats extends Constraint
{
    public $message = 'There is not enough remaining seats, only {{ remainingSeats }} seats are left';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}