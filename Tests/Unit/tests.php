<?php

class IsAdminTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        // Set up global variables and start a session
        global $db;
        $_SESSION['username'] = 'testuser';
        $query = "INSERT INTO users (username, admin) VALUES (:username, :admin)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->bindParam(':admin', 1);
        $stmt->execute();
    }

    protected function _after()
    {
        // Delete test data and end the session
        global $db;
        $query = "DELETE FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        unset($_SESSION['username']);
    }

    public function testIsAdminWithAdminUser()
    {
        // Test that a user with admin privileges returns true
        $result = isAdmin();
        $this->assertTrue($result);
    }

    public function testIsAdminWithNonAdminUser()
    {
        // Test that a user without admin privileges returns false
        global $db;
        $query = "UPDATE users SET admin = 0 WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $result = isAdmin();
        $this->assertFalse($result);
    }

    public function testIsAdminWithNoSession()
    {
        // Test that a user without a session returns false
        unset($_SESSION['username']);
        $result = isAdmin();
        $this->assertFalse($result);
    }
}

class AdminTest extends Unit
{
    protected function _before()
    {
        // start the session
        session_start();
        // set the session values for a user who is not an admin
        $_SESSION['username'] = 'notadminuser';
    }

    public function testIsAdminFunctionForNonAdminUser()
    {
        require_once 'include/functions/adminCheck.php';

        // call the function and check if the result is 0, which means the user is not an admin
        $result = isAdmin();
        $this->assertEquals(0, $result);
    }

    public function testPageContentForNonAdminUser()
    {
        ob_start();
        require_once 'admin.php';
        $content = ob_get_clean();

        // check if the content of the page contains the correct information for a non-admin user
        $this->assertContains('Admin Panel', $content);
        $this->assertNotContains('userPanel.php', $content);
        $this->assertNotContains('userPanel.php', $content);
        $this->assertNotContains('userPanel.php', $content);
        
    }
}

    class CalculatePriceTest extends Unit
{
    public function testCalculateTotalPrice()
    {
        $_POST['standart'] = 10;
        $_POST['pers'] = 20;
        $_POST['vektor'] = 30;
        $_POST['modern'] = 40;
        $_POST['specialinput'] = 50;
        
    
        $this->assertSame(150, $_SESSION['total']);
    }
    
    public function testCalculateTotalPriceWithRabatt()
    {
        $_POST['standart'] = 10;
        $_POST['pers'] = 20;
        $_POST['vektor'] = 30;
        $_POST['modern'] = 40;
        $_POST['specialinput'] = 50;
        $_POST['instant'] = true;
   

        $this->assertSame(135, $_SESSION['totalMwstRabatt']);
    }
    
    public function testCalculateMwst()
    {
        $_POST['standart'] = 10;
        $_POST['pers'] = 20;
        $_POST['vektor'] = 30;
        $_POST['modern'] = 40;
        $_POST['specialinput'] = 50;
        
        
        $this->assertSame(11.35, $_SESSION['mwst']);
    }
    
    public function testCalculateMwstWithRabatt()
    {
        $_POST['standart'] = 10;
        $_POST['pers'] = 20;
        $_POST['vektor'] = 30;
        $_POST['modern'] = 40;
        $_POST['specialinput'] = 50;
        $_POST['instant'] = true;
        
        
        $this->assertSame(10.19, $_SESSION['mwstRabatt']);
    }
}

?>