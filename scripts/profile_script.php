<?php

function check_balance($connect) {
    $balance_query = "SELECT balance FROM users WHERE user_id = '".$_SESSION['user_data']['user_id']."'";
    $result = mysqli_fetch_assoc(mysqli_query($connect, $balance_query));
    return $result['balance'];
}

function goods_list($connect) {
    $goods_query = "SELECT * FROM trade WHERE user_id = '".$_SESSION['user_data']['user_id']."'";
    $result = mysqli_query($connect, $goods_query);
    $result_arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $i = 1;
    foreach($result_arr as $key => $value) {
        echo "<p class=\"goods_list_row\">";
        echo "<b>".$i."</b>&nbsp;";
        $i++;
        goods_cat($result_arr[$key], $connect);
        echo "</p>";
    } 
}

function goods_cat($array, $connect) {
    foreach($array as $k => $v) {
        if($k === 'goods_id') {
            $query = "SELECT * FROM goods WHERE goods_id = '".$v."'";
            $result = mysqli_fetch_assoc(mysqli_query($connect, $query));
            echo "<b>Наименование товара:</b>&nbsp;{$result['name']};&nbsp";
        } elseif($k === 'goods_value') {
            echo "<b>Количество товара:</b>&nbsp;{$v};&nbsp;";
        } elseif($k === 'cost') {
            echo "<b>Стоимость покупки: </b>&nbsp;{$v};&nbsp;";
        } elseif($k === 'date') {
            echo "<b>Дата покупки:</b>&nbsp;".date('d-',strtotime($v)).month_ru(date('F',strtotime($v))).date('-Y в H:i:s',strtotime($v)). ";&nbsp;";
        }
    }
}

?>