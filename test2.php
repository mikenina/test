<?php
/**
 * Написать функцию которая из этого массива
 */
$data1 = [
    'parent.child.field' => 1,
    'parent.child.field2' => 2,
    'parent2.child.name' => 'test',
    'parent2.child2.name' => 'test',
    'parent2.child2.position' => 10,
    'parent3.child3.position' => 10,
];

//сделает такой и наоборот
$data = [
    'parent' => [
        'child' => [
            'field' => 1,
            'field2' => 2,
        ]
    ],
    'parent2' => [
        'child' => [
            'name' => 'test'
        ],
        'child2' => [
            'name' => 'test',
            'position' => 10
        ]
    ],
    'parent3' => [
        'child3' => [
            'position' => 10
        ]
    ],
];

/**
 * @param $data
 * @return array
 */
function func_data1_to_data($data)
{
    $return = [];
    foreach ($data as $key => $val) {

        _parse_row($key, $val, $return);

    }
    return $return;
}

/**
 * @param $key
 * @param $val
 * @param $tmp
 */
function _parse_row($key, $val, &$tmp)
{
    if (($pos = strpos($key, '.')) !== false) {

        $key_part = substr($key, 0, $pos);
        $key_rest = preg_replace('/([0-9a-z]+\.)/', '', $key, 1);

        if (!isset($tmp[$key_part])) {
            $tmp[$key_part] = [];
        }
        _parse_row($key_rest , $val, $tmp[$key_part]);

    } else {
        $tmp[$key] = $val;
        return;
    }
}

print_r(func_data1_to_data($data1));

/**
 * @param $data
 * @return mixed
 */
function func_data_to_data1($data)
{
    static $return = [];
    static $keys = [];
    static $level = 0;

    $level++;

    foreach ($data as $key => $val) {

        $keys[$level] = $key;
        if (is_array($val)) {

            func_data_to_data1($val);

        } else {
            $return[implode('.', $keys)] = $val;
        }

        unset($keys[$level]);
    }

    $level--;

    return $return;
}

print_r(func_data_to_data1($data));
