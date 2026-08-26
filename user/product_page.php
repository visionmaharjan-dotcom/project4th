<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../css/productpage.css">

</head>
<body bgcolor ="#D7E5CA">

<div class="banner" style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;"></div>
<div class="rectangle">
    <div class="search-bar">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" name="search_submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="dropdowns">
        <form action="" method="GET">
            <div class="dropdown">
                <label for="price">Price</label>
                <select name="price">
                    <option value="">Select</option>
                    <option value="high_to_low">High to Low</option>
                    <option value="low_to_high">Low to High</option>
                </select>
                <button type="submit" name="price_sort">Sort</button>
            </div>
        </form>
        <form action="" method="GET">
            <div class="dropdown">
                <label for="sort">Sort by</label>
                <select name="sort">
                    <option value="">Select</option>
                    <option value="name_asc">Name A-Z</option>
                    <option value="name_desc">Name Z-A</option>
                </select>
                <button type="submit" name="name_sort">Sort</button>
            </div>
        </form>
    </div>
</div>

<div class='product-container mb-8'>
<?php
$sql = "SELECT * FROM PRODUCT WHERE 1=1"; 
$qry = mysqli_query($conn, $sql) or die(mysqli_error($conn));

if (isset($_GET['search_submit'])) {
    $searchTerm = htmlspecialchars($_GET['search']);
    if (!empty($searchTerm)) {
        $sql .= " AND UPPER(name) LIKE UPPER('%$searchTerm%')";
    }
}

if (isset($_GET['price_sort'])) {
    $priceOrder = $_GET['price'];
    if ($priceOrder == 'high_to_low') {
        $sql .= " ORDER BY price DESC";
    } elseif ($priceOrder == 'low_to_high') {
        $sql .= " ORDER BY price ASC";
    }
}

if (isset($_GET['name_sort'])) {
    $sortBy = $_GET['sort'];
    if ($sortBy == 'name_asc') {
        $sql .= " ORDER BY name ASC";
    } elseif ($sortBy == 'name_desc') {
        $sql .= " ORDER BY name DESC";
    }
}

$qry = mysqli_query($conn, $sql) or die(mysqli_error($conn)); 

while ($row = mysqli_fetch_assoc($qry)) 
{
    echo "<div class='product' style='background-color: #EEEDEB'>";

    echo "<a href='product_details.php?product_id=" . $row['id'] . "'>";
    $image = htmlspecialchars($row['image']);
    echo "<img src='$image' alt='Product'>";
    echo "<div class='details'>";
    echo "<p class='name'>" . htmlspecialchars($row['name']) . "</p>";
    echo "<p class='price'>NRs." . htmlspecialchars($row['price']) . "</p>";
    echo "<form method='post' action='add_to_cart.php'>";
    echo "<div class='buttons'>";
    echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
    echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($row['name']) . "'>";
    echo "<input type='hidden' name='product_price' value='" . htmlspecialchars($row['price']) . "'>";
    echo "<input type='hidden' name='product_image' value='" . htmlspecialchars($row['image']) . "'>";
    echo "<button type='submit' name='add_to_cart' class='add-to-cart-button'>Add to Cart</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
}
?>
</div>

</body>
</html>
