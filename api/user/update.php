<?php

include "/var/www/html/require.php";

$userController = new \obj\controller\UserController();

$user = $userController->getUser();
if ($user == null) {
    echo "not logged in";
    return;
}

if (isset($_POST['userId']) && $_POST['userId'] != "") {
    $userId = $_POST['userId'];
} else {
    echo "userId missing";
    return;
}

if ($user->getId() != $userId) {
    echo "auth error";
    return;
}
$oldUsername = $_SESSION['secretUsername'];
if (isset($_POST['username']) && $_POST['username'] != "") {
    $user->setUsername($_POST['username']);
    if (strlen($_POST['username']) < 4) {
        echo "username to short";
        return;
    }
    $_SESSION['secretUsername'] = $_POST['username'];
}

if (isset($_POST['email']) && $_POST['email'] != "") {
    $user->setEmail($_POST['email']);
}

if (isset($_POST['password']) && $_POST['password'] != "") {
    $uppercase = preg_match('@[A-Z]@', $_POST['password']);
    $lowercase = preg_match('@[a-z]@', $_POST['password']);
    $number    = preg_match('@[0-9]@', $_POST['password']);

    if(!$uppercase || !$lowercase || !$number || strlen($_POST['password']) < 8) {
        echo "weak password";
        $_SESSION['secretUsername'] = $oldUsername;
        return;
    }
    if (isset($_POST['password2'])) {
        if ($_POST['password'] == $_POST['password2']) {
            $_SESSION['secretPassword'] = $_POST['password'];
            $user->setPassword($_POST['password']);
        } else {
            echo "password does not match";
            $_SESSION['secretUsername'] = $oldUsername;
            return;
        }
    } else {
        echo "confirm password not set";
        $_SESSION['secretUsername'] = $oldUsername;
        return;
    }

}

if (isset($_POST['birthday']) && $_POST['birthday'] != "") {
    $birthday = $_POST['birthday'] . " 00:00:00";
    $user->setBirthday($birthday);
}

if (isset($_POST['description']) && $_POST['description'] != "") {
    $user->setDescription($_POST['description']);
}

if (isset($_POST['sex']) && $_POST['sex'] != "") {
    $user->setSex($_POST['sex']);
}

if (isset($_POST['height']) && $_POST['height'] != "") {
    $user->setHeight($_POST['height']);
}

if (isset($_POST['weight']) && $_POST['weight'] != "") {
    $user->setWeight($_POST['weight']);
}

if (isset($_POST['skinColor']) && $_POST['skinColor'] != "") {
    $user->setSkinColor($_POST['skinColor']);
}

if (isset($_POST['hairColor']) && $_POST['hairColor'] != "") {
    $user->setHairColor($_POST['hairColor']);
}

if (isset($_POST['country']) && $_POST['country'] != "") {
    $user->setCountry($_POST['country']);
}

if (isset($_POST['language']) && $_POST['language'] != "") {
    $user->setLanguage($_POST['language']);
}

if (isset($_POST['anonym'])) {
    $user->setAnonym(1);
} else {
    $user->setAnonym(0);
}

if (isset($_POST['instagramName']) && $_POST['instagramName'] != "") {
    $user->setInstagramName($_POST['instagramName']);
}

if (isset($_FILES['thumbnail']["name"]) && $_FILES['thumbnail']["name"] != "") {
    $target_dir = "/var/www/html/assets/image/thumbnail/";
    $ending = explode('.', basename($_FILES["thumbnails"]["name"]));
    $filename = md5(time() . $user->getUsername()) . "." . $ending[sizeof($ending) - 1];
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if($check == false) {
        echo "error";
        return;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "error file type";
        return;
    }

    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        echo "ok";
        $pb = $user->getThumbnail();
        if ($pb != null) {
            unlink($target_dir . $pb);
        }
        $user->setThumbnail($filename);
    }
}

if (isset($_FILES['profilePicture']["name"]) && $_FILES['profilePicture']["name"] != "") {
    if ($_FILES['profilePicture']["name"] != 'default-profile-picture.jpg') {
        $target_dir = "/var/www/html/assets/image/profilepicture/";
        $ending = explode('.', basename($_FILES["profilePicture"]["name"]));
        $filename = md5(time() . $user->getUsername()) . "." . $ending[sizeof($ending) - 1];
        $target_file = $target_dir . $filename;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if($check == false) {
            return;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "error file type";
            return;
        }

        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            echo "ok";
            $pb = $user->getProfilePicture();
            if ($pb != null && $pb != "default-profile-picture.jpg") {
                unlink($target_dir . $pb);
            }
            $user->setProfilePicture($filename);
        }
    }
}

if (isset($_FILES['upload']['name'])) {
    $documentController = new \obj\controller\DocumentController();
    $files = array_filter($_FILES['upload']['name']);

    $total_count = count($_FILES['upload']['name']);

    for ($i = 0; $i < $total_count; $i++) {

        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
        if ($tmpFilePath != "") {

            $target_dir = "/var/www/html/assets/documents/";
            $ending = explode('.', basename( $_FILES['upload']['name'][$i]));
            $filename = md5(time() . $_FILES['upload']['name'][$i]) . "." . $ending[sizeof($ending) - 1];
            $newFilePath = $target_dir . $filename;

            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $documentController->addDocumentToUser(new \obj\elm\Document(null, $user->getId(), $filename, $_FILES['upload']['name'][$i]));
                echo "ok<br>";
            } else {
                echo "errorDoc<br>";
            }
        }
    }
}
$userController->updateUser($user);

return;