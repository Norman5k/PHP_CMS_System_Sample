<?php

function goods_data($connect) {
    $query = "SELECT * FROM goods";
    $result = mysqli_fetch_all(mysqli_query($connect, $query), MYSQLI_NUM);
    return $result;
}

function goods_print($connect) {
    $goods_list = goods_data($connect);
    for ($i=0; $i < count($goods_list); $i++) { 
        echo 
        "<form action=\"\" method=\"post\" class=\"goods_item_wrapper\">
			<div id=\"goods_img\">
				<p class=\"goods_img_name\">Фото&nbsp;".$goods_list[$i][2]."</p>
			</div>
			<h3 class=\"goods_name\">".$goods_list[$i][2]."</h3>
			<p class=\"goods_cost\"><b>Цена:</b>&nbsp;".$goods_list[$i][3]."&nbsp;RUB</p>
			<p class=\"goods_value\"><b>Осталось:</b>&nbsp;".$goods_list[$i][4]."</p>
			<input type=\"hidden\" name=\"goods_id\" value=\"".$goods_list[$i][0]."\">
			<div class=\"value_of_goods\">
				<p>Укажите количество товаров</p>
				<input type=\"number\" name=\"value_of_goods\">
			</div>
			<button type=\"submit\" name=\"buy_goods\" value=\"buy_goods\">Купить</button>
		</form>";
    }
}

function buy_goods($connect) {
    if((isset($_POST['buy_goods'])) && (isset($_POST['goods_id'])) && (isset($_POST['value_of_goods']))) {
        $balance_query = "SELECT * FROM users WHERE user_id = '".$_SESSION['user_data']['user_id']."'";
		$result = mysqli_query($connect, $balance_query);
		$result = mysqli_fetch_assoc($result);
		$balance = $result['balance'];

		$item_query = "SELECT * FROM goods WHERE goods_id = '".$_POST['goods_id']."'";
		$result = mysqli_query($connect, $item_query);
		$result = mysqli_fetch_assoc($result);
        $log = print_r($result, true);
        file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);

		$item_cost = $result['cost'];
		$item_value = $result['value'];
		$trade_date = date('Y-m-d H:i:s');
		if(isset($_POST['value_of_goods'])) {
			$goods_volume = (double)$_POST['value_of_goods'];
		} else {
			$goods_volume = 0;
		}
		$trade_costs = $item_cost * $goods_volume;

		if(($goods_volume <= $item_value) && ($balance >= $trade_costs) && ($goods_volume > 0)) {
			$trade_query = "INSERT INTO trade VALUES (NULL, '".$_SESSION['user_data']['user_id']."', '".$_POST['goods_id']."', '".$goods_volume."', '".$trade_costs."', '".$trade_date."')";
			$trade_result = mysqli_query($connect, $trade_query) or die(mysqli_error($connect));

			$new_user_balance = $balance - $trade_costs;
			$balance_query = "UPDATE users SET balance = '".$new_user_balance."' WHERE users.user_id = '".$_SESSION['user_data']['user_id']."'";
			$balance_result = mysqli_query($connect, $balance_query) or die(mysqli_error($connect));

			$new_goods_value = $item_value - $goods_volume;
			$goods_query = "UPDATE goods SET value = '".$new_goods_value."' WHERE goods.goods_id = '".$_POST['goods_id']."'";
			$goods_result = mysqli_query($connect, $goods_query) or die(mysqli_error($connect));

			unset($_POST['buy_goods']);
			unset($_POST['goods_id']);
			unset($_POST['value_of_goods']);
		}
	}
}

?>