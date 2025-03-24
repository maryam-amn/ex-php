<?php

namespace Jobtrek\ExPhp;

class Basics
{
    /**
     * Php is a bit particular from other languages, important things :
     * - PHP files always start with `<?php`
     * - All php variables are prefixed with `$`, there is no `var` ou `let` keyword
     * - Methods on objects are accessed with `->` not `.` like in other languages
     * - If types are specified, they goes before the variable name, without `:` unlike TypeScript or Rust types
     *
     * Modern PHP (version 8+) are very similar to Java, you have a type system, class, interfaces.
     * But php is still a dynamically typed language, so if you don't provide types, you have no guarantees
     * to get what you want, like in JavaScript.
     *
     * Complete the function to add the two provided int numbers
     */
    public static function add(int $number1, int $number2): int
    {
        return $number1 += $number2;
    }

    /**
     * Return the length of a string
     */
    public static function length(string $str): int
    {
        return mb_strlen($str);
    }

    /**
     * Return true if the string have more than 10 characters
     */
    public static function condition(string $str): bool
    {
        if (strlen($str) > 10) {
            return true;
        }
        return false;
    }

    /**
     * Concatenate two strings
     */
    public static function concatenate(string $str1, string $str2): string
    {
        return $str1.$str2;
    }

    /**
     * Analyse the string, and cut to the number of words requested. If the number of
     * words requested is bigger than the string word count, duplicate the last word.
     */
    public static function getWordsToCount(string $str, int $wordsCountToRemain): string
    {
        $word = array_filter(explode(' ', $str));

        if (count($word) > $wordsCountToRemain) {
            $finalStr = implode(' ', array_slice($word, 0, $wordsCountToRemain));
            return $finalStr;
        } else {
            $lastWord = end($word);
            while (count($word) < $wordsCountToRemain) {
                $word[] = $lastWord;
            }
            return implode(' ', $word);
        }
    }

}
