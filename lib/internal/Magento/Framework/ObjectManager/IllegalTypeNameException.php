<?php

/*
 * This file is part Magento
 */

namespace Magento\Framework\ObjectManager;

use RuntimeException;
use UnexpectedValueException;

/**
 * Class IllegalTypeException
 * @package Magento\Framework\ObjectManager
 */
class IllegalTypeNameException extends RuntimeException
{
    /**
     * FIXME(tk): In the XSD and then the PHP test looks like we have a gap in the encoding
     *            between PHP and UTF8 when it comes to the XSD pattern.
     *
     * choosing single-byte pattern, no u modifier
     */
    const TYPE_PATTERN = '~^(?:[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)'
                         . '(?:\\\\[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)*$~';

    /**
     * Assert that not an illegal type name
     *
     * @param string $type
     * @throws IllegalTypeNameException
     * @return string
     */
    public static function assert($type)
    {
        $result = preg_match(self::TYPE_PATTERN, $type);
        if (false === $result) {
            throw new UnexpectedValueException('Regex error');
        }
        if (0 === $result) {
            throw new self(sprintf("Illegal type name '%s'", $type));
        }

        return $type;
    }
}
