<?php

namespace Premise\Laralang;

use Premise\Laralang\Builder\ApertiumTrans;
use Premise\Laralang\Builder\Exception;
use Premise\Laralang\Builder\MymemoryTrans;

class Builder
{
    /**
     * Get the trnaslation.
     *
     * @param string $string
     *
     * @return object
     */
    public static function trans($string)
    {
        $translator = config('laralang.default.translator');
        if (!in_array(config('laralang.default.translator'), ['apertium', 'mymemory'])) {
            return new Exception("<font style='color:red;'>Laralang doesn't support $translator translator. Check config</font>");
        } else {
            if (config('laralang.default.translator') == 'mymemory') {
                return new MymemoryTrans($string);
            } elseif (config('laralang.default.translator') == 'apertium') {
                return new ApertiumTrans($string);
            }
        }
    }
}
