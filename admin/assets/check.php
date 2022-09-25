<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) && !isset($_SERVER['HTTP_REFERER'])) {
    /*
    Up to you which header to send, some prefer 404 even if
    the files does exist for security
    */
    header('HTTP/1.0 403 Forbidden', TRUE, 403);

    /* choose the appropriate page to redirect users */
    die(header('location: /new_blog/error403.php'));
}

class dbConnect
{
    private $host = 'localhost';
    private $user = 'root';
    private $dbname = 'meraki';
    private $password = '';

    function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbname . ';', $this->user, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    }
}

class menuData
{
    private $main_course_id;
    private $main_menu_name;

    private $menu_id;
    private $menu_name;

    private $submenu_id;
    private $submenu_name;
    private $submenu_price;


    private $dbconn;

    function getMain_course_id()
    {
        return $this->main_course_id;
    }

    function setMain_course_id($main_course_id)
    {
        $this->main_course_id = $main_course_id;
    }

    function getMain_menu_name()
    {
        return $this->main_menu_name;
    }

    function setMain_menu_name($main_menu_name)
    {
        $this->main_menu_name = $main_menu_name;
    }

    function getMenu_id()
    {
        return $this->menu_id;
    }

    function setMenu_id($menu_id)
    {
        $this->menu_id = $menu_id;
    }

    function getMenu_name()
    {
        return $this->menu_name;
    }

    function setMenu_name($menu_name)
    {
        $this->menu_name = $menu_name;
    }

    function getSubmenu_id()
    {
        return $this->submenu_id;
    }

    function setSubmenu_id($submenu_id)
    {
        $this->submenu_id = $submenu_id;
    }

    function getSubmenu_name()
    {
        return $this->submenu_name;
    }

    function setSubmenu_name($submenu_name)
    {
        $this->submenu_name = $submenu_name;
    }

    function getSubmenu_price()
    {
        return $this->submenu_price;
    }

    function setSubmenu_price($submenu_price)
    {
        $this->submenu_price = $submenu_price;
    }


    function __construct()
    {
        $db = new dbConnect;
        $this->dbconn = $db->connect();
    }

    function mainCourseInsert()
    {

        $query_check = "SELECT * FROM main_course WHERE main_menu_name LIKE ?";
        $stmt_check = $this->dbconn->prepare($query_check);
        $params = array("%$this->main_menu_name%");
        //$stmt_check->bindParam(':main_menu_name', $this->main_menu_name);
        $stmt_check->execute($params);

        if ($stmt_check->errorCode()) {
            $stmt_check_count = $stmt_check->rowCount();
        } else {
            die();
        }

        if ($stmt_check_count > 0) {
            return 2;
        } else {
            $query = "INSERT INTO main_course (main_menu_name) ";
            $query .= "VALUES(:main_menu_name)";

            $stmt = $this->dbconn->prepare($query);
            $stmt->bindParam(':main_menu_name', $this->main_menu_name);
            $stmt->execute();
            if ($stmt->errorCode()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function mainCourseFetch()
    {
        $query = "SELECT * FROM main_course";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function mainCourseFetchById()
    {
        $query = "SELECT * FROM main_course WHERE main_course_id = :main_course_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(":main_course_id",$this->main_course_id);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function mainCourseUpdate()
    {
        $query = "UPDATE main_course SET main_menu_name = :main_menu_name WHERE main_course_id = :main_course_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(":main_course_id",$this->main_course_id);
        $stmt->bindParam(":main_menu_name",$this->main_menu_name);
        $stmt->execute();
        if($stmt->errorCode()) {
            return 1;
        } else {
            return 0;
        }
    }

    function mainMenuInsert()
    {

        $query_check = "SELECT * FROM menu WHERE main_course_id = ? AND menu_name LIKE ?";
        $stmt_check = $this->dbconn->prepare($query_check);
        $params = array($this->main_course_id, "%$this->menu_name%");
        $stmt_check->execute($params);

        if ($stmt_check->errorCode()) {
            $stmt_check_count = $stmt_check->rowCount();
        } else {
            die();
        }

        if ($stmt_check_count > 0) {
            return 2;
        } else {
            $query = "INSERT INTO menu (main_course_id,menu_name) ";
            $query .= "VALUES(:main_course_id,:menu_name)";

            $stmt = $this->dbconn->prepare($query);
            $stmt->bindParam(':main_course_id', $this->main_course_id);
            $stmt->bindParam(':menu_name', $this->menu_name);
            $stmt->execute();
            if ($stmt->errorCode()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function mainMenuFetch()
    {
        $query = "SELECT * FROM menu";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function mainMenuFetchById()
    {
        $query = "SELECT * FROM menu WHERE menu_id = :menu_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(":menu_id",$this->menu_id);
        $stmt->execute();

        $query_cat = "SELECT * FROM main_course";
        $stmt_cat = $this->dbconn->prepare($query_cat);
        $stmt_cat->execute();

        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        $arr[2] = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
        $arr[3] = $stmt_cat->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function mainMenuUpdate()
    {
        $query = "UPDATE menu SET menu_name = :menu_name, main_course_id = :main_course_id WHERE menu_id = :menu_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(":menu_id",$this->menu_id);
        $stmt->bindParam(":main_course_id",$this->main_course_id);
        $stmt->bindParam(":menu_name",$this->menu_name);
        $stmt->execute();
        if($stmt->errorCode()) {
            return 1;
        } else {
            return 0;
        }
    }

    function subMenuInsert()
    {

        $query_check = "SELECT * FROM submenu WHERE menu_id = ? AND submenu_name LIKE ?";
        $stmt_check = $this->dbconn->prepare($query_check);
        $params = array($this->menu_id, "%$this->submenu_name%");
        $stmt_check->execute($params);

        if ($stmt_check->errorCode()) {
            $stmt_check_count = $stmt_check->rowCount();
        } else {
            die();
        }

        if ($stmt_check_count > 0) {
            return 2;
        } else {
            $query = "INSERT INTO submenu (menu_id,submenu_name,submenu_price) ";
            $query .= "VALUES(:menu_id,:submenu_name,:submenu_price)";

            $stmt = $this->dbconn->prepare($query);
            $stmt->bindParam(':menu_id', $this->menu_id);
            $stmt->bindParam(':submenu_name', $this->submenu_name);
            $stmt->bindParam(':submenu_price', $this->submenu_price);
            $stmt->execute();
            if ($stmt->errorCode()) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function subMenuFetch()
    {
        $query = "SELECT * FROM submenu";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function subMenuByIdFetch()
    {
        $query = "SELECT * FROM submenu WHERE submenu_id = :submenu_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindValue(':submenu_id', $this->submenu_id);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function subMenuCatFetch()
    {
        $query = "SELECT * FROM submenu INNER JOIN menu ON submenu.menu_id = menu.menu_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute();
        $arr[0] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $arr[1] = $stmt->rowCount();
        if ($stmt->errorCode()) {
            return $arr;
        }
    }

    function subMenuUpdate()
    {
        $query = "UPDATE submenu SET submenu_name = :submenu_name, submenu_price = :submenu_price, menu_id = :menu_id WHERE submenu_id = :submenu_id";
        $stmt = $this->dbconn->prepare($query);
        $stmt->bindParam(":menu_id",$this->menu_id);
        $stmt->bindParam(":submenu_id",$this->submenu_id);
        $stmt->bindParam(":submenu_name",$this->submenu_name);
        $stmt->bindParam(":submenu_price",$this->submenu_price);
        $stmt->execute();
        if($stmt->errorCode()) {
            return 1;
        } else {
            return 0;
        }
    }
    
}

if (isset($_POST['main_course_insert'])) {
    $main_menu_name = $_POST['main_course'];

    $main_course_data = new menuData;
    $main_course_data->setMain_menu_name($main_menu_name);
    $return_value = $main_course_data->mainCourseInsert();
    if ($return_value == 1) {
        echo "Main Course inserted successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "Main Course not inserted successfully.";
    }
}

if (isset($_POST['main_course_update'])) {
    $main_course_id  = filter_var($_POST['edit_cateogry_id'], FILTER_SANITIZE_NUMBER_INT);
    $main_menu_name = $_POST['main_course'];

    $main_course_data = new menuData;
    $main_course_data->setMain_course_id($main_course_id);
    $main_course_data->setMain_menu_name($main_menu_name);
    $return_value = $main_course_data->mainCourseUpdate();
    if ($return_value == 1) {
        echo "Main Course updated successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "Main Course failed to update.";
    }
}

if (isset($_POST['main_insert'])) {
    $main_course_category = $_POST['main_course_category'];
    $main_course = $_POST['main_course'];

    $main_course_data = new menuData;
    $main_course_data->setMain_course_id($main_course_category);
    $main_course_data->setMenu_name($main_course);
    $return_value = $main_course_data->mainMenuInsert();
    if ($return_value == 1) {
        echo "Main Menu inserted successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "Main Menu not inserted successfully.";
    }
}

if (isset($_POST['menu_update'])) {
    $menu_id = filter_var($_POST['menu_id'], FILTER_SANITIZE_NUMBER_INT);
    $main_course_id  = filter_var($_POST['edit_cateogry_id'], FILTER_SANITIZE_NUMBER_INT);
    $menu_name = $_POST['menu_name'];

    $main_course_data = new menuData;
    $main_course_data->setMenu_id($menu_id);
    $main_course_data->setMain_course_id($main_course_id);
    $main_course_data->setMenu_name($menu_name);
    $return_value = $main_course_data->mainMenuUpdate();
    if ($return_value == 1) {
        echo "Menu updated successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "Menu failed to update.";
    }
}

if (isset($_POST['sub_menu_insert'])) {
    $menu_id = $_POST['menu_category'];
    $sub_menu_name = $_POST['sub_menu_name'];
    $sub_menu_price = $_POST['sub_menu_price'];

    $menu_data = new menuData;
    $menu_data->setMenu_id($menu_id);
    $menu_data->setSubmenu_name($sub_menu_name);
    $menu_data->setSubmenu_price($sub_menu_price);
    $return_value = $menu_data->subMenuInsert();
    if ($return_value == 1) {
        echo "Sub Menu inserted successfully.";
    } else if ($return_value == 2) {
        echo "Sub Menu starting or ending with this name already exits";
    } else {
        echo "Sub Menu not inserted successfully.";
    }
}

if (isset($_POST['sub_menu_update'])) {
    $sub_menu_id  = filter_var($_POST['sub_menu_edit_id'], FILTER_SANITIZE_NUMBER_INT);
    $menu_id  = filter_var($_POST['submenu_category'], FILTER_SANITIZE_NUMBER_INT);
    $sub_menu_name = filter_var($_POST['sub_menu_name'],FILTER_SANITIZE_STRING);
    $sub_menu_price = filter_var($_POST['sub_menu_price'],FILTER_SANITIZE_NUMBER_INT);

    $subMenu_data = new menuData;
    $subMenu_data->setMenu_id($menu_id);
    $subMenu_data->setSubmenu_id($sub_menu_id);
    $subMenu_data->setSubmenu_name($sub_menu_name);
    $subMenu_data->setSubmenu_price($sub_menu_price);
    $return_value = $subMenu_data->subMenuUpdate();
    if ($return_value == 1) {
        echo "SubMenu updated successfully.";
    } else if ($return_value == 2) {
        echo "Category starting or ending with this name already exits";
    } else {
        echo "SubMenu failed to update.";
    }
}


/* $insertFile = new productData;
$insertFile->setProductCategoryId(2);
$insertFile->setProductName("123");
$insertFile->setProductDesc('Kuch bhi keh raha');
$insertFile->setProductImage('kuch_bhi.jpg');
$insertFile->setProductImageAlt('Jhooth bolta hai saala, jalta hai maderjaat');

$insertFile->productInsert(); */
