<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_GET['p1']) && isset($_GET['p2'])) {
    $p1 = $_GET['p1'];
    $p2 = $_GET['p2'];
    $product1Details = [];
    $product2Details = [];
    $getProduct1Data = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $getProduct1Data->execute([$p1]);
    $getProduct2Data = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $getProduct2Data->execute([$p2]);


    if ($getProduct1Data->rowCount() > 0) {
        $product1Details = $getProduct1Data->fetch(PDO::FETCH_ASSOC);

        $addCompareCount = $conn->prepare("UPDATE products SET compare_count = ? WHERE id = ?;");
        $addCompareCount->execute([intval($product1Details['compare_count']) + 1, $product1Details['id']]);
    }
    if ($getProduct2Data->rowCount() > 0) {
        $product2Details = $getProduct2Data->fetch(PDO::FETCH_ASSOC);

        $addCompareCount = $conn->prepare("UPDATE products SET compare_count = ? WHERE id = ?;");
        $addCompareCount->execute([intval($product2Details['compare_count']) + 1, $product2Details['id']]);
    }
}



include 'components/wishlist_cart.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare Products</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/compare.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>
    <div id="alertPlaceholder" style="display:flex; justify-content:space-between; align-items:center; position: absolute; top: 10em; right: 0; background-color: #dc3545; padding: 15px 30px; color: white; border-radius: 5px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); z-index: 1000;">
        <p style="margin: 0; flex-grow: 1;">Can't compare same product</p>
        <button type="button" id="close_alert" style="background: none; border: none; color: white; font-size: 1.5em; cursor: pointer;">
            <span aria-hidden="true" style="margin-left: 1em;">&times;</span>
        </button>
    </div>

    <div class="wrapper">
        <!-- HEADER -->

        <div class="header_con">

            <div class="input_con">
                <label class="label_text">Product 1 </label>
                <input type="text" onclick="showAvailableProducts(1)" id="product1" value="<?= htmlspecialchars($_GET['p1'] ?? ''); ?>" />
                <div class="search_con" style="position:relative; width: 100%">
                    <ul id="seach_content_1" style="position:absolute; top:1em;background-color: white;
                    width: 100%; border-radius: 5px;max-height:500px; overflow-y: scroll;">
                    </ul>
                </div>

            </div>
            <div>
                <i class="fa fa-exchange icon" aria-hidden="true"></i>
            </div>
            <div class="input_con">
                <label class="label_text">Product 2</label>
                <input type="text" id="product2" onclick="showAvailableProducts(2)" value="<?= htmlspecialchars($_GET['p2'] ?? ''); ?>" />
                <div style="position:relative; width: 100%; ">
                    <ul id="seach_content_2" style="position:absolute; top:1em;background-color: white;
                    width: 100%; border-radius: 5px;max-height:500px; overflow-y: scroll;">

                    </ul>
                </div>
            </div>


        </div>

        <!-- BODY -->
        <div class="body">
            <!-- PRODUCT IMAGE SECTION -->
            <div class="product_con">
                <?php
                if (isset($_GET['p1']) && isset($_GET['p2'])) {

                    echo ' <img class="img" src="uploaded_img/' . $product1Details['image_01'] . '" />';
                    echo ' <img class="img" src="uploaded_img/' . $product2Details['image_01'] . '" /> ';
                }
                ?>

            </div>
            <div class="compare_counter">
                <?php
                if (isset($_GET['p1']) && isset($_GET['p2'])) {
                    $countP1 = intval($product1Details['compare_count']) > 1 ? 'TIMES' : 'TIME';
                    $countP2 = intval($product2Details['compare_count']) > 1 ? 'TIMES' : 'TIME';

                    echo "<p class='compared_count'> Used to Compared " . $product1Details['compare_count'] . " " . $countP1 . "</p>";
                    echo "<p class='compared_count'>Used to Compared " . $product2Details['compare_count'] . " " . $countP2 . "</p>";
                }
                ?>

            </div>

            <!-- PRODUCT SPECS -->
            <div class="specs_con">
                <table id="search_content">
                    <?php
                    if (!isset($_GET['p1']) && !isset($_GET['p2'])) {

                        echo '<p id="no_msg" style="color:rgb(57, 58, 59); font-size: 2rem; text-align:center; margin-top:5em">Select Products to Compare</p>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function extractNumber(spec) {
            if (spec !== null) {
                const match = spec.match(/\d+/); // Match one or more digits

                return match ? parseInt(match[0], 10) : ""; 
            }
            return ""; 
        }

        function compareSpecs(specs_1, specs_2) {
            const num1 = extractNumber(specs_1);
            const num2 = extractNumber(specs_2);


            const resultElement = document.createElement('div');

            if (typeof num1 !== "number" && typeof num2 !== "number") {

                return resultElement.innerHTML; // Return the HTML string
            }
            if (num1 > num2) {


                resultElement.innerHTML = '<i style="margin-left: 20px; color:#06D001; font-size: 2rem;" class="fa fa-check-circle-o" aria-hidden="true"></i>';


            } else {

                resultElement.innerHTML = '<i style="margin-left: 20px; color:#FF0000; font-size: 2rem;" class="fa fa-times-circle-o" aria-hidden="true"></i>';

            }

            return resultElement.innerHTML; // Return the HTML string
        }

        function fillTable(product1Details, product2Details) {

            let items = '';
            items += '<tbody>';

            const getDetail = (detail) => detail || '---';

            items += '<tr><td>Network</td><td><div class="info_con">';
            items += '<div><p>Technology</p><p>' + getDetail(product1Details.technology) + '</p><p>' + getDetail(product2Details.technology) + '</p> </div>';
            items += '</div></td></tr>';

            items += '<tr><td>Launch</td><td><div class="info_con">';
            items += '<div><p>Announced</p><p>' + getDetail(product1Details.announced) + '</p><p>' + getDetail(product2Details.announced) + '</p></div>';
            items += '<div><p>Status</p><p>' + getDetail(product1Details.status) + '</p><p>' + getDetail(product2Details.status) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Body</td><td><div class="info_con">';
            items += '<div><p>Dimensions</p><p>' + getDetail(product1Details.dimensions) + '</p><p>' + getDetail(product2Details.dimensions) + '</p></div>';
            items += '<div><p>Weight</p><p>' + getDetail(product1Details.weight) + '</p><p>' + getDetail(product2Details.weight) + '</p></div>';
            items += '<div><p>Build</p><p>' + getDetail(product1Details.build) + '</p><p>' + getDetail(product2Details.build) + '</p></div>';
            items += '<div><p>SIM</p><p>' + getDetail(product1Details.sim) + '</p><p>' + getDetail(product2Details.sim) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Display</td><td><div class="info_con">';
            items += '<div><p>Type</p><p>' + getDetail(product1Details.display_type) + '</p><p>' + getDetail(product2Details.display_type) + '</p></div>';
            items += '<div><p>Size</p><p>' + getDetail(product1Details.size) + '</p><p>' + getDetail(product2Details.size) + '</p></div>';
            items += '<div><p>Resolution</p><p>' + getDetail(product1Details.resolution) + '</p><p>' + getDetail(product2Details.resolution) + '</p></div>';
            items += '<div><p>Protection</p><p>' + getDetail(product1Details.protection) + '</p><p>' + getDetail(product2Details.protection) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Platform</td><td><div class="info_con">';
            items += '<div><p>OS</p><p>' + getDetail(product1Details.os) + '</p><p>' + getDetail(product2Details.os) + '</p></div>';
            items += '<div><p>ChipSet</p><p>' + getDetail(product1Details.chipset) + '</p><p>' + getDetail(product2Details.chipset) + '</p></div>';
            items += '<div><p>CPU</p><p>' + getDetail(product1Details.cpu) + '</p><p>' + getDetail(product2Details.cpu) + '</p></div>';
            items += '<div><p>GPU</p><p>' + getDetail(product1Details.gpu) + '</p><p>' + getDetail(product2Details.gpu) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Memory</td><td><div class="info_con">';
            items += '<div><p>Card Slot</p><p>' + getDetail(product1Details.mem_card_slot) + '</p><p>' + getDetail(product2Details.mem_card_slot) + '</p></div>';
            items += '<div><p>Internal</p><p>' + getDetail(product1Details.mem_internal) + compareSpecs(product1Details.mem_internal, product2Details.mem_internal) + '</p><p>' + getDetail(product2Details.mem_internal) + compareSpecs(product2Details.mem_internal, product1Details.mem_internal) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Main Camera</td><td><div class="info_con">';
            items += '<div><p>Modules</p><p>' + getDetail(product1Details.mc_modules) + compareSpecs(product1Details.mc_modules, product2Details.mc_modules) + '</p><p>' + getDetail(product2Details.mc_modules) + compareSpecs(product2Details.mc_modules, product1Details.mc_modules) + '</p></div>';
            items += '<div><p>Features</p><p>' + getDetail(product1Details.mc_features) + '</p><p>' + getDetail(product2Details.mc_features) + '</p></div>';
            items += '<div><p>Video</p><p>' + getDetail(product1Details.mc_video) + '</p><p>' + getDetail(product2Details.mc_video) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Selfie Camera</td><td><div class="info_con">';
            items += '<div><p>Modules</p><p>' + getDetail(product1Details.sc_modules) + compareSpecs(product1Details.sc_modules, product2Details.sc_modules) + '</p><p>' + getDetail(product2Details.sc_modules) + compareSpecs(product2Details.sc_modules, product1Details.sc_modules) + '</p></div>';
            items += '<div><p>Features</p><p>' + getDetail(product1Details.sc_features) + '</p><p>' + getDetail(product2Details.sc_features) + '</p></div>';
            items += '<div><p>Video</p><p>' + getDetail(product1Details.sc_video) + '</p><p>' + getDetail(product2Details.sc_video) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Sound</td><td><div class="info_con">';
            items += '<div><p>Loudspeaker</p><p>' + getDetail(product1Details.loudspeaker) + '</p><p>' + getDetail(product2Details.loudspeaker) + '</p></div>';
            items += '<div><p>3.5mm jack</p><p>' + getDetail(product1Details.sound_jack) + '</p><p>' + getDetail(product2Details.sound_jack) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Comms</td><td><div class="info_con">';
            items += '<div><p>WLAN</p><p>' + getDetail(product1Details.wlan) + '</p><p>' + getDetail(product2Details.wlan) + '</p></div>';
            items += '<div><p>Bluetooth</p><p>' + getDetail(product1Details.bluetooth) + '</p><p>' + getDetail(product2Details.bluetooth) + '</p></div>';
            items += '<div><p>Positioning</p><p>' + getDetail(product1Details.positioning) + '</p><p>' + getDetail(product2Details.positioning) + '</p></div>';
            items += '<div><p>NFC</p><p>' + getDetail(product1Details.nfc) + '</p><p>' + getDetail(product2Details.nfc) + '</p></div>';
            items += '<div><p>Infrared port</p><p>' + getDetail(product1Details.infrared_port) + '</p><p>' + getDetail(product2Details.infrared_port) + '</p></div>';
            items += '<div><p>Radio</p><p>' + getDetail(product1Details.radio) + '</p><p>' + getDetail(product2Details.radio) + '</p></div>';
            items += '<div><p>USB</p><p>' + getDetail(product1Details.usb) + '</p><p>' + getDetail(product2Details.usb) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Features</td><td><div class="info_con">';
            items += '<div><p>Sensors</p><p>' + getDetail(product1Details.sensors) + '</p><p>' + getDetail(product2Details.sensors) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>Battery</td><td><div class="info_con">';
            items += '<div><p>Type</p><p>' + getDetail(product1Details.battery_type) + compareSpecs(product1Details.battery_type, product2Details.battery_type) + '</p><p>' + getDetail(product2Details.battery_type) + compareSpecs(product2Details.battery_type, product1Details.battery_type) + '</p></div>';
            items += '<div><p>Charging</p><p>' + getDetail(product1Details.charging) + '</p><p>' + getDetail(product2Details.charging) + '</p></div>';
            items += '</div></td></tr>';

            items += '<tr><td>MISC</td><td><div class="info_con">';
            items += '<div><p>Colors</p><p>' + getDetail(product1Details.colors) + '</p><p>' + getDetail(product2Details.colors) + '</p></div>';
            items += '<div><p>Models</p><p>' + getDetail(product1Details.models) + '</p><p>' + getDetail(product2Details.models) + '</p></div>';
            items += '<div><p>Price</p><p>₱' + getDetail(product1Details.price) + '</p><p>₱' + getDetail(product2Details.price) + '</p></div>';
            items += '</tbody>';

            $('#search_content').html(items);


        }

        function showAvailableProducts(input) {
            $.ajax({
                url: 'products.php',
                type: 'GET',

                success: function(response) {
                    const f = JSON.parse(response)
                    console.log(f.length)
                    let items = '';
                    if (f.length > 0) {

                        console.log(response)
                        $.each(f, function(index, product) {
                            items += '<div class="card">';
                            items += '<img src="uploaded_img/' + product.image_01 + '" alt="' + product.name + '" class="card-image">';
                            items += '<p class="card-title" style="color: red">' + product.name + '</p>';
                            items += '</div>';
                        });
                    } else {
                        items = '<div style="padding: 12px; text-align: center; color: #666;">No results found</div>';
                    }
                    if (input == 1) {
                        $('#seach_content_1').html(items);
                    } else {
                        $('#seach_content_2').html(items);
                    }


                },

                error: function(xhr) {
                    alert('An error occurred while searching.');
                }
            });
        }

        function chageImgDisplay(img1, img2) {
            let items = '';
            items += '<img class="img" src="uploaded_img/' + img1 + '"/>';

            items += '<img class="img" src="uploaded_img/' + img2 + '"/>';
            $('.product_con').html(items);
        }
        $(document).ready(function() {

            // Get the current URL
            const url = new URL(window.location.href);

            // Use URLSearchParams to parse the query string
            const params = new URLSearchParams(url.search);



            if (params.has('p1') && params.has('p2')) {
                // Get the parameters
                const p1 = params.get('p1');
                const p2 = params.get('p2');
                $.ajax({
                    url: 'searchProduct.php', // Use PHP_SELF
                    type: 'GET',
                    data: {
                        p1: p1,
                        p2: p2
                    },
                    success: function(response) {
                        let items = '';
                        const data = JSON.parse(response)
                        const product1Details = data['prod_1']; // First product
                        const product2Details = data['prod_2']; // Second product
                        if (response.length > 0) {
                            if (product1Details && Object.keys(product1Details).length > 0 &&
                                product2Details && Object.keys(product2Details).length > 0) {
                                fillTable(product1Details, product2Details)
                                chageImgDisplay(product1Details.image_01, product2Details.image_01)
                                $("#no_msg").remove();
                                $('#alertPlaceholder').fadeOut();
                            }
                            $('#seach_content_2').html("");

                        } else {
                            items = '<tbody><tr><td colspan="2" style="padding: 12px; text-align: center; color: #666;">No results found</td></tr></tbody>';
                            $('#search_content').html(items);

                        }

                    },

                    error: function(xhr) {
                        alert('An error occurred while searching.');
                    }
                });
            }

            $('#alertPlaceholder').hide();
            $('#product1').on('input', function() {
                const query = $(this).val();

                $.ajax({
                    url: 'searchProduct.php', // Use PHP_SELF
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        const f = JSON.parse(response)
                        console.log(f.length)
                        let items = '';
                        if (f.length > 0) {

                            console.log(response)
                            $.each(f, function(index, product) {
                                items += '<div class="card">';
                                items += '<img src="uploaded_img/' + product.image_01 + '" alt="' + product.name + '" class="card-image">';
                                items += '<p class="card-title" style="color: red">' + product.name + '</p>';
                                items += '</div>';
                            });
                        } else {
                            items = '<div style="padding: 12px; text-align: center; color: #666;">No results found</div>';
                        }
                        $('#seach_content_1').html(items);
                    },

                    error: function(xhr) {
                        alert('An error occurred while searching.');
                    }
                });
            });
            $('#product2').on('input', function() {
                const query = $(this).val();

                $.ajax({
                    url: 'searchProduct.php', // Use PHP_SELF
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        const f = JSON.parse(response)
                        console.log(f.length)
                        let items = '';
                        if (f.length > 0) {

                            console.log(response)
                            $.each(f, function(index, product) {

                                items += '<li class="item"><div class="card">';
                                items += '<img src="uploaded_img/' + product.image_01 + '" alt="' + product.name + '" class="card-image">';
                                items += '<p class="card-title" style="color: red">' + product.name + '</p>';
                                items += '</div></li>';

                            });
                        } else {
                            items = '<div style="padding: 12px; text-align: center; color: #666;">No results found</div>';
                        }
                        $('#seach_content_2').html(items);
                    },

                    error: function(xhr) {
                        alert('An error occurred while searching.');
                    }
                });
            });

        });
        $(document).on('click', '#seach_content_1 .card', function() {

            const url = new URL(window.location.href);

            const prod_2 = document.getElementById('product2').value;
            const input1 = document.getElementById('product1');

            if (prod_2 === $(this).text()) {
                $('#alertPlaceholder').fadeIn();
                return
            }
            url.searchParams.set('p1', $(this).text());
            url.searchParams.set('p2', prod_2);
            window.history.replaceState({}, '', url);
            input1.value = $(this).text()
            $.ajax({
                url: 'searchProduct.php', // Use PHP_SELF
                type: 'GET',
                data: {
                    p1: $(this).text(),
                    p2: prod_2
                },
                success: function(response) {
                    let items = '';
                    const data = JSON.parse(response)
                    const product1Details = data['prod_1']; // First product
                    const product2Details = data['prod_2']; // Second product

                    if (response.length > 0) {

                        if (product1Details && Object.keys(product1Details).length > 0 &&
                            product2Details && Object.keys(product2Details).length > 0) {

                            fillTable(product1Details, product2Details)
                            chageImgDisplay(product1Details.image_01, product2Details.image_01)
                            $("#no_msg").remove()
                            $('#alertPlaceholder').fadeOut();
                        }

                        $('#seach_content_1').html("");

                    } else {
                        items = '<tbody><tr><td colspan="2" style="padding: 12px; text-align: center; color: #666;">No results found</td></tr></tbody>';
                        $('#search_content').html(items);
                    }


                },

                error: function(xhr) {
                    alert('An error occurred while searching.');
                }
            });
        });

        $(document).on('click', '#seach_content_2 .card', function() {
            const url = new URL(window.location.href);

            const input2 = document.getElementById('product2');
            const input1 = document.getElementById('product1').value;
            if (input1 === $(this).text()) {

                $('#alertPlaceholder').fadeIn();
                return
            }

            url.searchParams.set('p1', input1);
            url.searchParams.set('p2', $(this).text());
            window.history.replaceState({}, '', url);
            input2.value = $(this).text()
            $.ajax({
                url: 'searchProduct.php', // Use PHP_SELF
                type: 'GET',
                data: {
                    p1: input1,
                    p2: $(this).text()
                },
                success: function(response) {
                    let items = '';
                    const data = JSON.parse(response)
                    const product1Details = data['prod_1']; // First product
                    const product2Details = data['prod_2']; // Second product
                    if (response.length > 0) {
                        if (product1Details && Object.keys(product1Details).length > 0 &&
                            product2Details && Object.keys(product2Details).length > 0) {
                            fillTable(product1Details, product2Details)
                            chageImgDisplay(product1Details.image_01, product2Details.image_01)
                            $("#no_msg").remove();
                            $('#alertPlaceholder').fadeOut();
                        }
                        $('#seach_content_2').html("");

                    } else {
                        items = '<tbody><tr><td colspan="2" style="padding: 12px; text-align: center; color: #666;">No results found</td></tr></tbody>';
                        $('#search_content').html(items);

                    }

                },

                error: function(xhr) {
                    alert('An error occurred while searching.');
                }
            });
        });

        $(document).on('click', '#close_alert', function() {
            $('#alertPlaceholder').fadeOut();

        });
    </script>
    <script src="js/script.js"></script>
    <?php include 'components/footer.php'; ?>


</body>

</html>