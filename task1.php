<!DOCTYPE html>
<html>
<head>
    <title>Task 1</title>
<style>
table {
    font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
    border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Task 1</h2>

<?php

include "Ecommerce.php";

$ecommerce = new Ecommerce();
$list = $ecommerce->getTaskOne();

?>

<table>
    <tr>
        <th>Category Name</th>
        <th>Total Count</th>
    </tr>
    <?php foreach ($list as $l) {?>
  <tr>
    <td><?php echo $l['Name']; ?></td>
    <td><?php echo $l['count']; ?></td>
  </tr>

    <?php }?>

</table>

</body>
</html>