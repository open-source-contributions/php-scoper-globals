<?php

/**
 *    __  _____   ___   __          __
 *   / / / /   | <  /  / /   ____ _/ /_  _____
 *  / / / / /| | / /  / /   / __ `/ __ `/ ___/
 * / /_/ / ___ |/ /  / /___/ /_/ / /_/ (__  )
 * `____/_/  |_/_/  /_____/`__,_/_.___/____/
 *
 * @author UA1 Labs Developers https://ua1.us
 * @copyright Copyright (c) UA1 Labs
 */

/*
 * This function is responsible for returning a callback to work with the humbug/php-scoper patcher
 * configuration. The function enables users to identify global functions/classes/constants the app they are bundling
 * may be requiring as a dependency and will exclude appending the scope to those function calls.
 *
 * @param array $globalIncludes An array of strings that identify global classes/functions/constants that your app may be using
 * @return type
 */
function globalIncludes($globalIncludes)
{
    return function ($filePath, $prefix, $content) use ($globalIncludes): string {
        // don't prefix native wp functions
        foreach($globalIncludes as $include) {
            $content = str_replace('\\' . $prefix . '\\' . $include . '(', '\\' . $include . '(', $content);
        }
        return $content;
    };
}