<?php

//Функция проверки пользователя на предмет авторизации
function verify_user($user_data) {
	if(!isset($user_data)) {
		$fold_path = 'all/';
	} elseif(isset($user_data)) {
		$fold_path = 'auth/';
	}
	return $fold_path;
}

//Функция проверки пути для дальнейшего создания полного относительного пути от текущего каталога
function verify_path() {
	if($_SERVER['REQUEST_URI'] === '/') {
		$path_to_dir = '';
	} else {
		$path_to_dir = '../';
	}
	return $path_to_dir;
}

//Функция подключения контента страницы в зависимости от выбранного пути
function get_path_to_page() {
	$folder = verify_user($_SESSION['user_data']);
	$dir = verify_path();
	$link = $_POST['link'];
	if(($link == '') || (!isset($link))) {
		$path_to_page = $folder.'/home.php';
	} elseif((isset($link)) && ($link !== 'exit')) {
		$path_to_page = $dir.$folder.$link.".php";
	} elseif((isset($link)) && ($link !== 'exit')) {
		$path_to_page = 'all/home.php';
	}
	return $path_to_page;
}

//Функция уничтожения сессии
function ses_destroy() {
	if($_POST['link'] === 'exit') {
		$_SESSION = [];
		$_POST['link'] = null;
		$_POST = null;
		unset($_COOKIE[session_name()]);
		session_destroy();
		header('Location: /');
	}
}

//Функция определения имени страницы в заголовке вкладки
function page_name() {
	$page_name = $_POST['link'];
	if(($page_name == '') || ($page_name == 'home')) {
		$page_name = 'Главная страница CMS';
	} elseif($page_name === 'info') {
		$page_name = 'Информация о CMS';
	} elseif($page_name === 'contacts') {
		$page_name = 'Контакты CMS';
	} elseif($page_name === 'goods') {
		$page_name = 'Товары CMS';
	} elseif($page_name === 'profile') {
		$page_name = 'Профиль пользователя CMS';
	}
	return $page_name;
}

//Функция определения русскоязычного имени месяца
function month_ru($month) {
	if($month === 'January') $month = 'Января';
	elseif($month === 'February') $month = 'Февраля';
	elseif($month === 'March') $month = 'Марта';
	elseif($month === 'April') $month = 'Апреля';
	elseif($month === 'May') $month = 'Мая';
	elseif($month === 'June') $month = 'Июня';
	elseif($month === 'July') $month = 'Июля';
	elseif($month === 'August') $month = 'Августа';
	elseif($month === 'September') $month = 'Сентября';
	elseif($month === 'October') $month = 'Октября';
	elseif($month === 'November') $month = 'Ноября';
	elseif($month === 'December') $month = 'Декабря';
	return $month;
}

?>