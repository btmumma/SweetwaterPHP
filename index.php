<?php
    include_once 'includes/dbh.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<head>
<body>

<?php
    // Base Call - Check To Ensure We Have Access to Sweetwater Test
    $sql = "SELECT * FROM `sweetwater_test`;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
    {
        // Grab all Candy Records
        $sqlCandy = "SELECT * FROM `sweetwater_test`GROUP BY comments HAVING comments LIKE '%Candy%';";
        $resultCandy = mysqli_query($conn, $sqlCandy);

        // Create table header
        echo "<table><tr><th>Order ID</th><th>Comments</th><th>Expected Ship Date</th></tr>";
        
        // Iterate over all of the rows we got back from the database with Candy in the message...
        while($candyRows = mysqli_fetch_assoc($resultCandy))
        {
            // Create the table data objects dynamically with the data we got back.
            echo "<tr><td>".$candyRows["orderid"]."</td>  <td>".$candyRows["comments"]."</td> <td>".$candyRows["shipdate_expected"]."</td> </tr>";
        }

        //-----------------------------------------------------------------------------------------------------------------------------------------
        
        // Grab all Call Me / Don't Call Me Records
        $sqlCallMe = "SELECT * FROM `sweetwater_test`GROUP BY comments HAVING comments LIKE '%Call Me%';";
        $resultCallMe = mysqli_query($conn, $sqlCallMe);
        
        // Iterate over all of the rows we got back from the database with Candy in the message...
        while($callMeRows = mysqli_fetch_assoc($resultCallMe))
        {
            // Create the table data objects dynamically with the data we got back.
            echo "<tr><td>".$callMeRows["orderid"]."</td>  <td>".$callMeRows["comments"]."</td> <td>".$callMeRows["shipdate_expected"]."</td> </tr>";
        }
        
        //-----------------------------------------------------------------------------------------------------------------------------------------
        
        
    }
    else
    {
        echo "Ben is an idiot and can't connect";
    }
?>

</body>
</html>