<?php


include "../header/header.php";
include "../header/bodyHeader.php";

if (!$isLoggedIn) {
    echo "not logged in";
    return;
}

$user = $userController->getUser();
if (!$user) {
    echo "error";
}

//$logController->log($_SERVER['REMOTE_ADDR'], "page view", "/settings", "", $userController->getUser());

?>
    <h1>Edit User</h1>
    <form action="/api/user/update.php" method="post" enctype="multipart/form-data">
        <input name="userId" type="hidden" value="<?php echo $user->getId(); ?>">

        <div>
            <label for="profilePicture"><img class="profilepictureedit" src="/assets/image/profilepicture/<?php echo $user->getProfilePicture(); ?>"></label>
            <input type="file" accept="image/png, image/jpeg" name="profilePicture" id="profilePicture">
        </div>
        <div>
            <label>Username:</label>
            <input name="username" type="text" value="<?php echo $user->getUsername(); ?>">
        </div>
        <div>
            <label>Email:</label>
            <input name="email" type="text" value="<?php echo $user->getEmail(); ?>">
        </div>
        <div>
            <label>new Password:</label>
            <input name="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        </div>
        <div>
            <label>Confirm Password:</label>
            <input name="password2" type="password">
        </div>
        <div>
            <label>Birthday:</label>
            <input name="birthday" type="date" value="<?php echo substr($user->getBirthday(), 0, 10); ?>">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description" type="text">
                <?php echo $user->getDescription(); ?>
            </textarea>
        </div>
        <div>
            <label>Sex:</label>
            <select name="sex">
                <option value="" disabled <?php echo ($user->getSex() == null) ? "selected" : ""; ?>>Select your option</option>
                <?php
                foreach ($db->getAllSex() as $id => $name) {
                    ?>
                    <option value="<?php echo $id; ?>" <?php echo ($user->getSex() == $id) ? "selected" : ""; ?>><?php echo $name; ?></option>

                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Height: (in cm)</label>
            <input name="height" type="number" value="<?php echo $user->getHeight(); ?>">
        </div>
        <div>
            <label>Weight: in (Kg)</label>
            <input name="weight" type="number" value="<?php echo $user->getWeight(); ?>">
        </div>
        <div>
            <label>SkinColor:</label>
            <select name="skinColor">
                <option value="" disabled <?php echo ($user->getSkinColor() == null) ? "selected" : ""; ?>>Select your option</option>
                <?php
                foreach ($db->getSkinColor() as $id => $name) {
                    ?>
                    <option value="<?php echo $id; ?>" <?php echo ($user->getSkinColor() == $id) ? "selected" : ""; ?>><?php echo $id; ?></option>

                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>HairColor:</label>
            <select name="hairColor">
                <option value="" disabled <?php echo ($user->getHairColor() == null) ? "selected" : ""; ?>>Select your option</option>
                <?php
                foreach ($db->getHairColor() as $id => $name) {
                    ?>
                    <option value="<?php echo $id; ?>" <?php echo ($user->getHairColor() == $id) ? "selected" : ""; ?>><?php echo $id; ?></option>

                    <?php
                }
                ?>
             </select>
        </div>
        <div>
            <label>Country:</label>
            <select name="country">
                <option value="" disabled <?php echo ($user->getCountry() == null) ? "selected" : ""; ?>>Select your option</option>
                <?php
                foreach ($db->getCountries() as $id => $name) {
                    ?>
                    <option value="<?php echo $id; ?>" <?php echo ($user->getCountry() == $name) ? "selected" : ""; ?>><?php echo $name; ?></option>

                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Language:</label>
            <select name="language">
                <option value="" disabled <?php echo ($user->getLanguage() == null) ? "selected" : ""; ?>>Select your option</option>
                <?php
                foreach ($db->getLanguages() as $id => $name) {
                    ?>
                    <option value="<?php echo $id; ?>" <?php echo ($user->getLanguage() == $name) ? "selected" : ""; ?>><?php echo $name; ?></option>

                    <?php
                }
                ?>
            </select>
        </div>
        <div>
            <label>Anonym: (hide username in chat)</label>
            <input name="anonym" type="checkbox" <?php echo ($user->isAnonym()) ? "checked" : ""; ?>>
        </div>
        <div>
            <label>Instagram:</label>
            <input name="instagramName" type="text" value="<?php echo $user->getInstagramName(); ?>">
        </div>
        <div>
            <label>Documents:</label>
            <input name="upload[]" type="file" multiple="multiple" />
            <?php
                $documentController = new \obj\controller\DocumentController();
                $documents = $documentController->getDocumentByUser($user->getId());
                foreach ($documents as $document) {
                    echo '<br><a href="/assets/documents/' . $document->getPath() .'">' . $document->getName() . '</a><br> ';
                }
            ?>
        </div>
        <div>
            <input type="submit">
        </div>
    </form>
    <div class="editActions">
        <?php
        foreach ($user->getActions() as $action) {
            echo "<label>" . $action->getName() . " " . $action->getCoins() . "</label><a href='/api/user/removeAction.php?actionName=" . $action->getName() . "'>Remove</a>";
        }
        ?>
    </div>
    <form method="post" action="/api/user/addAction.php">

        <input name="userId" type="hidden" value="<?php echo $user->getId(); ?>">
        <label>
            Name
        </label>
        <input name="actionName" type="text">
        <label>
            Coins to Buy
        </label>
        <input name="coins" type="number">
        <div>
            <input type="submit">
        </div>
    </form>
    <div class="editTags">
        <?php
        $myTags = $user->getTags();
        foreach ($db->getTags() as $tag) {
            if (in_array($tag, $myTags)) {
                echo $tag->getName() . "<a href='/api/user/removeTag.php?tagName=" . $tag->getName() . "'>Remove</a>";
            } else {
                echo $tag->getName() . "<a href='/api/user/addTag.php?tagName=" . $tag->getName() . "'>Add</a>";
            }
        }
        ?>
    </div>
    <div class="streamerRequest">
        <a href="/api/user/streamerRequest.php">Request to be a streamer</a>
    </div>
<?php

include "../footer/bodyFooter.php";
include "../footer/footer.php";