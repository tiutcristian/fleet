<?php
include_once '../includes/config-session.php';
include_once '../includes/page-button.php';

function display_page_content($pdo)
{
    try 
    {
        if(isset($_SESSION["user_id"]))
        {
            ?>
                <div class="dashboard-tool-buttons">
                    <?php button_link("Add a car", "../add-car/", ""); ?>
                    <button id="filters-toggle-button" onclick="toggle_filters();" style="width: auto;">Show filters</button>
                </div>
            <?php
            display_cars_table($pdo, $_SESSION["user_username"], $_SESSION["user_role"]);
        }
        else
        {
            ?>
                <div class="form-container">
                    <p class="error">You are not logged in. <br> Login first.</p>
                    <?php button_link("Login", "../login/", ""); ?>
                </div>
            <?php
        }
    } 
    catch (PDOException $e) 
    {
        die("Query failed: " . $e->getMessage());
    }
    display_delete_pop_up(); 
}

function display_cars_table (object $pdo, string $username, string $role)
{
    $page_size = 10;
    $page = $_GET["page"] ?? 1;
    $offset = ($page - 1) * $page_size;
    $no_of_cars = 0;

    if($role == "admin")
    {
        $result = get_all_cars_filtered($pdo, $page_size, $offset);
        $no_of_cars = get_total_number_of_cars_admin($pdo);
    }
    else if ($role == "user")
    {
        $result = get_user_cars_filtered($pdo, $username, $page_size, $offset);
        $no_of_cars = get_total_number_of_cars_user($pdo, $username);
    }
    else 
    {
        die("Invalid role");
    }

    ?>
        <table role="grid">
            <?php display_table_data($role, $result); ?>
        </table>
    <?php  

    ?>
        <div class="pagination-container">
            <?=$offset + 1?> - <?=min($offset + $page_size, $no_of_cars)?> out of <?=$no_of_cars?> cars
        </div>
    <?php

    display_pagination_buttons($page, ceil($no_of_cars / $page_size));
}

function display_pagination_buttons($page, $no_of_pages)
{
    ?> 
        <div class="pagination-container">
            <?php
                page_button("outline", $page-1, $page == 1, "<i class='fa fa-arrow-left'></i>");
                switch ($no_of_pages) {
                    case 1:
                        page_button("outline", 1, true, 1);
                        break;

                    case 2:
                        page_button(1 == $page ? "outline" : "secondary outline", 1, false, 1);
                        page_button(2 == $page ? "outline" : "secondary outline", 2, false, 2);
                        break;
                    
                    default:
                        switch ($page) {
                            case 1:
                                page_button("outline", 1, false, 1);
                                echo "<div>...</div>";
                                page_button("secondary outline", $no_of_pages, false, $no_of_pages);
                                break;

                            case $no_of_pages:
                                page_button("secondary outline", 1, false, 1);
                                echo "<div>...</div>";
                                page_button("outline", $no_of_pages, false, $no_of_pages);
                                break;
                            
                            default:
                                page_button("secondary outline", 1, false, 1);
                                if($page > 2) echo "<div>...</div>";
                                page_button("outline", $page, false, $page);
                                if($page < $no_of_pages - 1) echo "<div>...</div>";
                                page_button("secondary outline", $no_of_pages, false, $no_of_pages);
                                break;
                        }
                        break;
                }
                page_button("outline", $page+1, $page == $no_of_pages, "<i class='fa fa-arrow-right'></i>");
            ?>
        </div>
    <?php
}

function display_table_data($role, $result)
{
    display_table_header($role);
        
    ?> <tbody> <?php
    foreach ($result as $car) 
    {
        display_car_row($car, $role);
    }
    ?> </tbody> <?php
}

function display_filters_row($role)
{
    ?>
        <form action="." method="get" id="apply-filters-form">
            <tr class="hidden-row" id="filters-row">
                <th><div >Filters</div></th>
                <?php 
                    if($role == "admin") 
                    { 
                        ?> <th><input 
                                type="text" 
                                name="owner_username" 
                                id="owner_username" 
                                class="filter-input"
                                value="<?= $_GET["owner_username"] ?? "" ?>"
                                ></th> <?php 
                    } 
                ?>
                <th><input type="text" name="make" id="make" class="filter-input" value="<?= $_GET["make"] ?? "" ?>"></th>
                <th><input type="text" name="model" id="model" class="filter-input" value="<?= $_GET["model"] ?? "" ?>"></th>
                <th><input type="text" name="vin" id="vin" class="filter-input" value="<?= $_GET["vin"] ?? "" ?>"></th>
                <th><input type="text" name="plate_number" id="plate_number" class="filter-input" value="<?= $_GET["plate_number"] ?? "" ?>"></th>
                <th><input type="button" value="Apply" class="filter-input" onclick="apply_filters();"></th>
            </tr>
        </form>
    <?php
}

function display_table_header($role)
{
    ?>
        <thead>
            <?php display_filters_row($role); ?>
            <tr>
                <th>Car image</th>
                <?php if($role == "admin") { ?> <th>Owner</th> <?php } ?>
                <th>Make</th>
                <th>Model</th>
                <th>VIN Number</th>
                <th>License plate</th>
                <th></th>
            </tr>
        </thead>
    <?php
}

function display_car_row($car, $role)
{
    ?>
        <tr>
            <td class="car-img-cell"><img src="../<?=$car["path_to_image"]?>" alt="car"></td>
            <?php if($role == "admin") { ?> <td><?= $car["username"] ?></td> <?php } ?>
            <td><?= $car["make"] ?></td>
            <td><?= $car["model"] ?></td>
            <td><?= $car["vin"] ?></td>
            <td><?= $car["plate_number"] ?></td>
            <td>
                <div class="table-buttons">
                    <button class="btn-small" onclick="redirectToCarDocuments(<?= $car["id"] ?>)">
                        <i class="fa fa-eye"></i>
                    </button>  
                    <button class="btn-small" onclick="onDelete('<?= $car["plate_number"] ?>', <?= $car["id"] ?>)">
                        <i class="fa fa-trash"></i>
                    </button>           
                </div>
            </td>
        </tr>
    <?php
}

function display_delete_pop_up()
{
    ?>
        <div id="pop-up-container">
            <div class="pop-up">
                <div>Are you sure you want to delete <span id="plate-number-container"></span></div>
                <br>
                <div class="flex-center-container">
                    <button id="yes-button">Yes</button>
                    <form action="delete-handler.php" method="post" id="delete-car-form" style="display:none;">
                        <input type="text" name="car-id" id="car-id">
                    </form>
                    <button onclick="hidePopUp()">No</button>
                </div>
            </div>
        </div> 
    <?php
}