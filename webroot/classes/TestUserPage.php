<?php

include_once('TestUserModel.php');

/**
 * Description of TestUserPage
 *
 * @author user
 */
class TestUserPage extends TestUserModel {

    public function __construct($title = null) {
        parent::__construct($title);
    }

    public function addUserInfo() {
        $this->add($this->makeUserInfo());
    }

    public function __toString() {
        return $this->generatePage();
    }

}
