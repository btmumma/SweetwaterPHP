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
    // Query to Group Comments By What They Contain. UNION handles the duplicates for me.
    // Like I mentioned in queries.txt, SELECT * returns the same amount as my query, so I know I'm getting everything I want back
    $sql = "SELECT * FROM `sweetwater_test`WHERE comments LIKE '%Candy%'
    UNION
    SELECT * FROM `sweetwater_test`WHERE comments LIKE '%Call Me%'
    UNION
    SELECT * FROM `sweetwater_test`WHERE comments LIKE '%Refer%'
    UNION
    SELECT * FROM `sweetwater_test`WHERE comments LIKE '%Signature%'
    UNION
    SELECT * FROM `sweetwater_test`;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    // Ensuring that we got data back from my query
    if($resultCheck > 0)
    {
        // Create table header
        echo "<table><tr><th>Order ID</th><th>Comments</th><th>Expected Ship Date</th></tr>";
        
        // Iterate over all of the rows we got back from the database...
        while($row = mysqli_fetch_assoc($result))
        {
            // Create the table data rows dynamically with the data we got back.
            echo "<tr><td>".$row["orderid"]."</td>  <td>".$row["comments"]."</td> <td>".$row["shipdate_expected"]."</td> </tr>";

            $comment = $row["comments"];
        }
    }
    else
    {
        echo "Ben is an idiot and can't connect";
    }
?>

</body>
</html>