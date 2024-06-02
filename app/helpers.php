<?php

/******通过id和pid获取树形结构******/
function common_get_tree($array, $pid = 0)
{
    $tree = array();
    foreach ($array as $k => $v) {
        if ($v['pid'] == $pid) {
            $v['children'] = common_get_tree($array, $v['id']);

            $tree[] = $v;
        }
    }

    return $tree;
}
