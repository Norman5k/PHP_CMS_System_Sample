<?php

include_once "content/page_header.php";
include_once "content/nav_bar.php";

?>

<section>
    <h1>Список товаров для покупок</h1>
    <div id="goods_wrapper">
        <?php goods_print($connect) ?>
    </div>
</section>

<?php

include_once "content/page_footer.php";

?>