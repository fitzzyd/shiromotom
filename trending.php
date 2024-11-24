<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};


$trending_products = [];
$getTrendingProduct = $conn->prepare(
    "
                                            WITH RankedProducts AS (
    SELECT
        st.product_id,
        st.type,
        COUNT(*) AS count_per_type,
        p.name,
        p.details,
        p.price,
        p.image_01,
        ROW_NUMBER() OVER (PARTITION BY type ORDER BY COUNT(st.id) DESC) AS row_num
    FROM statistics_tbl AS st
    LEFT JOIN products AS p ON st.product_id = p.id
    WHERE st.created_timestamp BETWEEN CURDATE() - INTERVAL 1 MONTH AND CURDATE() + INTERVAL 1 DAY - INTERVAL 1 SECOND
    GROUP BY st.product_id, st.type
),
DistinctProducts AS (
    SELECT *
    FROM RankedProducts
    WHERE row_num = 1
)
SELECT dp1.product_id, dp1.type, dp1.count_per_type, dp1.name, dp1.details, dp1.price, dp1.image_01
FROM DistinctProducts dp1
WHERE NOT EXISTS (
    SELECT 1
    FROM DistinctProducts dp2
    WHERE dp2.product_id = dp1.product_id
    AND dp2.type < dp1.type
)
LIMIT 10; 
"
);
$getTrendingProduct->execute();

while ($row = $getTrendingProduct->fetch(PDO::FETCH_ASSOC)) {
    $trending_products[] = $row;
}


include 'components/wishlist_cart.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trending</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php include 'components/user_header.php'; ?>
    <div class="trending-bg">
    <section class="products">

    <h1 class="heading" style="margin-bottom: 1em; margin-top: 1em; color: white;">Trending Products</h1>

        <div class="box-container">

            <?php
            foreach ($trending_products as $value) {
            ?>

                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $value['product_id']; ?>">
                    <input type="hidden" name="name" value="<?= $value['name']; ?>">
                    <input type="hidden" name="price" value="<?= $value['price']; ?>">
                    <input type="hidden" name="image" value="<?= $value['image_01']; ?>">
                    <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                    <a href="quick_view.php?pid=<?= $value['product_id']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $value['image_01']; ?>" alt="">
                    <div class="name"><?= $value['name']; ?></div>
                    <div class="flex">
                    <div class="price"><span>₱</span><?= number_format($value['price'], 2); ?></div>                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                    </div>
                    <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                </form>




            <?php
            }
            ?>


        </div>
    </section>
        </div>

    <script src="js/script.js"></script>
</body>

</html>