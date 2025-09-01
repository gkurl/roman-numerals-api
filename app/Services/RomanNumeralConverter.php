<?php

namespace App\Services;

use App\EnumsRomanNumerals;
use InvalidArgumentException;

class RomanNumeralConverter implements IntegerConverterInterface
{

    public function convertInteger(int $integer): string
    {

        // ORIGINAL basic V1 implementation that passed unit tests but wasn't optimised or slick for API use
//        $map = ['M' => 1000,
//            'CM' => 900,
//            'D' => 500,
//            'CD' => 400,
//            'C' => 100,
//            'XC' => 90,
//            'L' => 50,
//            'XL' => 40,
//            'X' => 10,
//            'IX' => 9,
//            'V' => 5,
//            'IV' => 4,
//            'I' => 1];
//
//        $returnValue = '';
//
//        while ($integer > 0) {
//            foreach ($map as $roman => $int) {
//                if ($integer >= $int) {
//                    $integer -= $int;
//                    $returnValue .= $roman;
//                    break;
//                }
//            }
//        }
//        return $returnValue;

        //V2 implementation - improved with error handling/basic input validation, much more maintainable, read-able and performance friendly for API use
        // We will validate at the API request level as well - but a value limit here for sanity
        if ($integer < 1 || $integer > 3999) {
            throw new InvalidArgumentException("Integer must be between 1 and 3999");
        }

        $result = '';

        foreach (EnumsRomanNumerals::cases() as $case) {
            //dd($case)

            $romanValue = $case->value;
            $romanSymbol = $case->name;

            $count = intdiv($integer, $romanValue); //Takes input and returns a whole number result of division i.e. if integer = 1992 and the symbol is M (highest) then intdiv(1992,1000) = 1
            if ($count > 0) { // keep going if the count is above 0, skip if not
                $result .= str_repeat($romanSymbol, $count); // append the symbol 'count' many times
                $integer -= $count * $romanValue; //subtract the count * romanValue from the integer total i.e. 1992 becomes 992
            }
        }
        return $result; //return result as string, satisfying the interface requirement as well
    }
}
