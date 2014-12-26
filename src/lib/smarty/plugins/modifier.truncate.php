<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate<br>
 * Purpose:  Truncate a string to a certain length if necessary,
 *           optionally splitting in the middle of a word, and
 *           appending the $etc string or inserting $etc into the middle.
 * @link http://smarty.php.net/manual/en/language.modifier.truncate.php
 *          truncate (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param integer
 * @param string
 * @param boolean
 * @param boolean
 * @return string
 */
function smarty_modifier_truncate($string, $sublen = 80, $etc = '...',
    $break_words = false, $middle = false, $code = 'UTF-8')
{
    $start=0;
    if($code == 'UTF-8')
    {
        preg_match_all(STANDERD_LETTERS, $string, $t_string);

        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen)) . $etc;
        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else
    {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';

        for($i=0; $i<$strlen; $i++)
        {
            if($i>=$start && $i<($start+$sublen))
            {
                if(ord(substr($string, $i, 1))>129)
                {
                    $tmpstr.= substr($string, $i, 2);
                }
                else
                {
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        if(strlen($tmpstr)<$strlen ) $tmpstr.= $etc;
        return $tmpstr;
    }
}

/* vim: set expandtab: */

?>
