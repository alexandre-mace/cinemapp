<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 11/04/19
 * Time: 20:35
 */

namespace App\Validator\Constraints;


use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class EnoughRemainingSeatsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EnoughRemainingSeats) {
            throw new UnexpectedTypeException($constraint, EnoughRemainingSeats::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_int($value->getSeats())) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'integer');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        if ($value->getSeats() > $value->getSession()->getRemainingSeats()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('seats')
                ->setParameter('{{ remainingSeats }}', $value->getSession()->getRemainingSeats())
                ->addViolation();
        }
    }
}