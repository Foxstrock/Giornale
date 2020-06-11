<?php
    $categories = $sql->query("SELECT * FROM categories");
    while($category = $categories->fetch_assoc()){
        $data .= "<tr><td>".$category['categoryID']."</td><td>".$category['name']."</td></tr>";
    }
?>
<table>
    <tr>
        <td>Category ID</td>
        <td>Category Name</td>
    </tr>
    <?php echo $data; ?>
</table>