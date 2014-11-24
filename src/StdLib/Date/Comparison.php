<?php

namespace Martha\StdLib\Date;

/**
 * Class Comparison
 * @package Martha\StdLib\Date
 */
class Comparison
{
    /**
     * @param int $first
     * @param int $second
     * @return string
     */
    public static function difference($first, $second)
    {
        $difference = $second - $first;

        $hours = floor($difference / 3600);
        $minutes = floor(($difference - ($hours * 3600)) / 60);
        $difference = floor($difference - ($minutes * 3600) + ($hours * 3600));

        $time = self::extrapolateDatePiece($hours, 'hour') .
            self::extrapolateDatePiece($minutes, 'minute') .
            self::extrapolateDatePiece($difference, 'second');

        return $time;
    }

    /**
     * @param int $piece
     * @param string $component
     * @return string
     */
    protected static function extrapolateDatePiece($piece, $component)
    {
        if ($piece > 0) {
            return $piece . ' ' . $component . ($piece > 1 ? 's ' : ' ');
        }

        return '';
    }
}
