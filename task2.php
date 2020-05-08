<!DOCTYPE html>
<html>
<head>
    <title>Task 2</title>
</head>
<body>

<h2>Task 2</h2>

<?php

include "Ecommerce.php";

$ecommerce = new Ecommerce();
$list = $ecommerce->getTaskTwo();

?>

<ul>
    <?php foreach ($list as $l) { ?>
        <li><?php echo $l['Name']; ?></li>
            <?php printList($l, 0) ?>
    <?php } ?>
</ul>


</body>
</html>

<?php
function printList($data, $level)
{

    $level++;

    $dlist = isset($data['child']) ? $data['child'] : $data;

        foreach ($dlist as $d)
        {
            $space = "&nbsp;";
            for($i = 0; $i<$level*2; $i++){
                $space .= $space;
            }
            $itemCount = $d['items'] > 0 ? ' ('.$d['items'].')' : '';
            echo '<ul>' . $space . '-' . $d['Name'] . $itemCount . '</ul>';
            if (is_array($d['child'.$level]))
            {
                printList($d['child'.$level], $level);
            }

        }


}
?>