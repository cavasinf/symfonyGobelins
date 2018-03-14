<?php
/**
 * Created by PhpStorm.
 * User: PC  FLORIAN
 * Date: 13/03/2018
 * Time: 18:17
 */

namespace AppBundle\API;


use Symfony\Component\Validator\ConstraintViolationInterface;

class ValidatorResponseTreatment
{

    public static function validatorToJson(ConstraintViolationInterface $constraintViolation)
    {
        return [
            "value" => $constraintViolation->getInvalidValue(),
            "message" => $constraintViolation->getMessage(),
        ];
    }
}