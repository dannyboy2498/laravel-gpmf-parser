<?php

namespace Dan\GPMF\Common;

/** Converts values from unsigned to signed.
 * This is because PHP pack/unpack does not
 * have a format code for signed 32-bit int
 * that is also always big-endian.
 * @param uint_32
 * @return int_32 
 */
function convert_unsigned32_to_signed($unsigned, $size = 32)
{
    // cutoff is 10000000 for size 8
    $cutoff = pow(2, $size - 1);
    $condition = ($cutoff & $unsigned) > 0;
    if ($condition == false) return $unsigned;

    // maximum is 11111111 for size 8
    $maximum = pow(2, $size) - 1;
    $complement = $maximum ^ $unsigned;
    return (-1) * ($complement + 1); 
}