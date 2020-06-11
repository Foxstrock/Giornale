<?php
    include "header.php";
    $categories = $sql->query("SELECT * FROM categories");
    if($categories->num_rows==0){
        $data = "Non ci sono categorie";
    }else {
        $data = "<table><tr><td>Category ID</td><td>Category Name</td></tr>";
        while ($category = $categories->fetch_assoc()) {
            $data .= "<tr><td>" . $category['categoryID'] . "</td><td>" . $category['name'] . "</td></tr>";
        }
        $data.= "</table>";
    }
    echo $data;
?>
