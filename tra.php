<?php

class TransactionDemo {

    const DB_HOST = 'localhost';
    const DB_NAME = 'users';
    const DB_USER = 'root';
    const DB_PASSWORD = '';

    /**
     * PDO instance
     * @var PDO 
     */
    private $pdo = null;

    /**
     * Transfer money between two accounts
     * @param int $from
     * @param int $to
     * @param float $amount
     * @return true on success or false on failure.
     */
    public function transfer($from, $to, $amount) {

        try {
            $this->pdo->beginTransaction();

            // get available amount of the transferer account
            $sql = 'SELECT amount FROM accounts WHERE id=:from';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(":from" => $from));
            $availableAmount = (int) $stmt->fetchColumn();
            $stmt->closeCursor();

            if ($availableAmount < $amount) {
                echo 'Insufficient amount to transfer';
                return false;
            }
            // deduct from the transferred account
            $sql_update_from = 'UPDATE accounts
				SET amount = amount - :amount
				WHERE id = :from';
            $stmt = $this->pdo->prepare($sql_update_from);
            $stmt->execute(array(":from" => $from, ":amount" => $amount));
            $stmt->closeCursor();

            // add to the receiving account
            $sql_update_to = 'UPDATE accounts
                                SET amount = amount + :amount
                                WHERE id = :to';
            $stmt = $this->pdo->prepare($sql_update_to);
            $stmt->execute(array(":to" => $to, ":amount" => $amount));

            // commit the transaction
            $this->pdo->commit();

            echo 'The amount has been transferred successfully';

            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    /**
     * Open the database connection
     */
    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;dbname=%s", self::DB_HOST, self::DB_NAME);
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * close the database connection
     */
    public function __destruct() {
        // close the database connection
        $this->pdo = null;
    }

}

// test the transfer method
$obj = new TransactionDemo();

// transfer 30K from from account 1 to 2
$obj->transfer(1, 2, 30000);


// transfer 5K from from account 1 to 2
$obj->transfer(1, 2, 5000);

<div id="main-wrapper"><?php
// connect to database
include 'header.php';
$dbh = mysqli_connect("localhost", "user", "", "test") or die("Cannot connect");

// turn off auto-commit
mysqli_autocommit($dbh, FALSE);

// look for a transfer
if ($_POST['submit'] && is_numeric($_POST['amt'])) {
    // add $$ to target account
    $result = mysqli_query($dbh, "UPDATE accounts SET balance = balance + " . $_POST['amt'] . " WHERE id = " . $_POST['to']);
    if ($result !== TRUE) {
        mysqli_rollback($dbh);  // if error, roll back transaction
    }
   
    // subtract $$ from source account
    $result = mysqli_query($dbh, "UPDATE accounts SET balance = balance - " . $_POST['amt'] . " WHERE id = " . $_POST['from']);
    if ($result !== TRUE) {
        mysqli_rollback($dbh);  // if error, roll back transaction
    }

    // assuming no errors, commit transaction
    mysqli_commit($dbh);
}

// get account balances
// save in array, use to generate form
$result = mysqli_query($dbh, "SELECT * FROM accounts");
while ($row = mysqli_fetch_assoc($result)) {
    $accounts[] = $row;
}

// close connection
mysqli_close($dbh);
?>
<html>
<head></head>
<body>

<h3>SINGLE USER TRANSACTION</h3>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
Transfer $ <input type="text" name="amt" size="5"> from

<select name="from">
<?php
foreach ($accounts as $a) {
    echo "<option value=\"" . $a['id'] . "\">" . $a['label'] . "</option>";   
}
?>
</select>

to

<select name="to">
<?php
foreach ($accounts as $a) {
    echo "<option value=\"" . $a['id'] . "\">" . $a['label'] . "</option>";   
}
?>
</select>

<input type="submit" name="submit" value="Transfer">

</form>

<h3>ACCOUNT BALANCES</h3>
<table border=1>
<?php
foreach ($accounts as $a) {
    echo "<tr><td>" . $a['label'] . "</td><td>" . $a['balance'] . "</td></tr>";   
}
?>
</table>
</body>
</html>
</div>