<?php
include_once('assets/check.php');

$menu_data = new menuData;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion of all type form</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box
        }

        .margin-20 {
            margin: 20px;
        }
    </style>
</head>

<body>

    <div class="margin-20">
        <form action="assets/check.php" method="post" enctype="multipart/form-data">
            <input type="text" name="main_course" placeholder="Main Course Category" required>
            <input type="submit" name="main_course_insert" value="Insert">
        </form>
    </div>

    <?php
    if (isset($_GET['edit_cat'])) {
        $edit_cat = filter_var($_GET['edit_cat'], FILTER_SANITIZE_NUMBER_INT);
        $menu_data->setMain_course_id($edit_cat);
        $edit_cat_data = $menu_data->mainCourseFetchById();
    ?>

        <div class="margin-20">
            <form action="assets/check.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="edit_cateogry_id" value="<?php echo $edit_cat; ?>">
                <input type="text" name="main_course" value="<?php echo $edit_cat_data[0][0]['main_menu_name']; ?>" placeholder="Main Course Category" required>
                <input type="submit" name="main_course_update" onClick="javascript: return confirm('Please confirm updation');" value="Update">
            </form>
        </div>

    <?php }

    $main_course_details = $menu_data->mainCourseFetch();
    echo "<pre>";
    print_r($main_course_details[0]);
    echo "</pre>";
    echo "<br>";
    foreach ($main_course_details[0] as $key) {
        echo "<a href='?edit_cat=" . $key['main_course_id'] . "'>" . $key['main_menu_name'] . "</a> <br><br>";
    }

    ?>

    <hr />

    <div class="margin-20">
        <?php

        if ($main_course_details[1] == 0) {
            echo "No Main Course Category";
        } else { ?>
            <form action="assets/check.php" method="post" enctype="multipart/form-data">
                <select name="main_course_category" required>
                    <option selected disabled hidden value="">Select Main Course Category</option>
                    <?php
                    foreach ($main_course_details[0] as $key) {
                        echo '<option value="' . $key['main_course_id'] . '">' . $key['main_menu_name'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" name="main_course" placeholder="Main Category" required>
                <input type="submit" name="main_insert" value="Insert">
            </form>
        <?php }

        if (isset($_GET['edit_menu'])) {
            $edit_menu = filter_var($_GET['edit_menu'], FILTER_SANITIZE_NUMBER_INT);
            $menu_data->setMenu_id($edit_menu);
            $edit_cat_data = $menu_data->mainMenuFetchById();
        ?>
            <div class="margin-20" style="margin-inline: 0;">
                <form action="assets/check.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="menu_id" value="<?php echo $edit_menu; ?>">
                    <select name="edit_cateogry_id">
                        <?php
                        foreach ($edit_cat_data[2] as $key) {
                            if ($edit_cat_data[0][0]['main_course_id'] == $key['main_course_id']) {
                                echo '<option value="' . $key['main_course_id'] . '" selected>' . $key['main_menu_name'] . '</option>';
                            } else {
                                echo '<option value="' . $key['main_course_id'] . '">' . $key['main_menu_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" name="menu_name" value="<?php echo $edit_cat_data[0][0]['menu_name']; ?>" placeholder="Main Course Category" required>
                    <input type="submit" name="menu_update" onClick="javascript: return confirm('Please confirm updation');" value="Update">
                </form>
            </div>
        <?php }

        $main_menu_details = $menu_data->mainMenuFetch();
        echo "<br><pre>";
        print_r($main_menu_details[0]);
        echo "</pre>";

        foreach ($main_menu_details[0] as $key) {
            echo "<a href='?edit_menu=" . $key['menu_id'] . "'>" . $key['menu_name'] . "</a> <br><br>";
        }

        ?>
    </div>

    <hr />

    <div class="margin-20">
        <?php

        if ($main_menu_details[1] == 0) {
            echo "No Main Course Category";
        } else { ?>
            <form action="assets/check.php" method="post" enctype="multipart/form-data">
                <select name="menu_category" required>
                    <option selected disabled hidden value="">Select Main Course Category</option>
                    <?php
                    foreach ($main_menu_details[0] as $key) {
                        echo '<option value="' . $key['menu_id'] . '">' . $key['menu_name'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" name="sub_menu_name" placeholder="Sub Menu Category" required>
                <input type="number" name="sub_menu_price" min="0" placeholder="Price" required>
                <input type="submit" name="sub_menu_insert" value="Insert">
            </form>
        <?php
        }

        if(isset($_GET['edit_sub_id'])) {
            $edit_sub_id = filter_var($_GET['edit_sub_id'], FILTER_SANITIZE_NUMBER_INT);
            $menu_data->setSubmenu_id($edit_sub_id);
            $submenu_data_by_id = $menu_data->subMenuByIdFetch();
            $submenu_data = $menu_data->mainMenuFetch();
        ?>
        <div class="margin-20" style="margin-inline:0">
         <form action="assets/check.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="sub_menu_edit_id" value="<?php echo $edit_sub_id ;?>">
                <select name="submenu_category" required>
                    <?php
                    foreach ($submenu_data[0] as $key) {
                        if ($submenu_data_by_id[0][0]['menu_id'] == $key['menu_id']) {
                            echo '<option value="' . $key['menu_id'] . '" selected>' . $key['menu_name'] . '</option>';
                        } else {
                            echo '<option value="' . $key['menu_id'] . '">' . $key['menu_name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <input type="text" name="sub_menu_name" placeholder="Enter Name" value="<?php echo $submenu_data_by_id[0][0]['submenu_name']; ?>" required>
                <input type="number" name="sub_menu_price" min="0" placeholder="Price" value="<?php echo $submenu_data_by_id[0][0]['submenu_price']; ?>" required>
                <input type="submit" name="sub_menu_update" onClick="javascript: return confirm('Please confirm updation');" value="Update">
            </form>
        </div>
        <?php
        }
        
        $sub_menu_data = $menu_data->subMenuFetch();
        echo "<pre>";
        print_r($sub_menu_data[0]);
        echo "</pre>";
        ?>
    </div>
    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Main Menu</th>
                <th>Sub Menu Name</th>
                <th>Sub Menu Price</th>
                <th>Changes</th>
            </tr>
        </thead>
        <tbody>

<?php
$sub_menu_cat_data = $menu_data->subMenuCatFetch();
$count = 1;
foreach ($sub_menu_cat_data[0] as $key) {
    echo "<tr>";
        echo "<td>".$count++."</td>";
        echo "<td>".$key['menu_name']."</td>";
        echo "<td>".$key['submenu_name']."</td>";
        echo "<td>".$key['submenu_price']."</td>";
        echo "<td><a href='?edit_sub_id=".$key['submenu_id']."'>Edit</a></td>";
    echo "</tr>";

}
?>  
        </tbody>
    </table>

    <hr />
</body>

</html>