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
    $sql = "SELECT * FROM sweetwater_test;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0)
    {
        // Create table header
        echo "<table><tr><th>Order ID</th><th>Comments</th><th>Expected Ship Date</th></tr>";
        
        // Iterate over all of the rows we got back from the database...
        while($row = mysqli_fetch_assoc($result))
        {
            // Create the table data objects dynamically with the data we got back.
            echo "<tr><td>".$row["orderid"]."</td>  <td>".$row["comments"]."</td> <td>".$row["shipdate_expected"]."</td> </tr>";


            // Test to see if I can access column headers:
            //echo $row['orderid'] . "<br>";
            //echo $row['comments'] . "<br>";; 
            //echo $row['shipdate_expected'] . "<br>";; 
        }
    }
    else
    {
        echo "Ben is an idiot and can't connect";
    }
?>

</body>
</html>