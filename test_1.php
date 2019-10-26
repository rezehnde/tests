<?php
$items = [2, 177];
$rules = array(
    '[(13 OR 3 OR 2)]',
    '[(54 OR 77) AND 17 AND 59 AND 36] OR [(2 AND 36)]',
    '[(2 OR 3 OR 13) AND 30]',
    '[(2)] OR [(13 OR 4) AND (17)]',
    '[(2)] OR [(13 OR 3) AND 17]',
    '[(2 AND 30) OR (3 AND 30)]'
);
$return = array();
foreach ($items as $item) {
    foreach ($rules as $rule) {
        $return[] = array(
            'item'      => $item,
            'rule'      => $rule,
            'result'    => compare($item, $rule)
        );
    }
}
function compare($item, $rule)
{
    $rule = str_replace('[', '(', $rule);
    $rule = str_replace(']', ')', $rule);
    $rule = str_replace('AND', '&&', $rule);
    $rule = str_replace('OR', '||', $rule);
    $comparision = preg_replace("/\d+/", "$item == $0", $rule);
    $condition =  "if ($comparision) { return true; } else { return false; }";
    return eval($condition);
}
var_dump($return);
