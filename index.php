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
            
            // Code for INSERT into the DB:
            
            // Create variables were going to need for the Query
            $orderID = $row["orderid"];
            $comment = $row["comments"];

            // Test to make sure my variables work. I will need 'orderID' for my INSERT
            // echo $orderID . " " . $comment ."<br>";
            if (str_contains($comment, 'Expected Ship Date')) 
            {
                // This would work if Expected Ship Date was at the end of every message :(
                // $dateToInsert = substr($comment, strpos($comment,'Expected Ship Date:') + 19);

                // At this point, the string is equal to Expected Ship Date: XX/XX/XXXX
                // Edit: No, past Ben, it is not. We need to remove all non-numbers from the string
                $dateToInsert = substr($comment ,strpos($comment,'Expected Ship Date:'));

                // THIS DID NOT WORK BECAUSE GIFT AND OTHER JUNK WAS INCLUDED IN THE STR
                // Use str_rplace to rid myself of Expected Shp Date
                // str_replace($search, $replace, $subject)
                // $dateToInsert = str_replace("Expected Ship Date:", "",$dateToInsert);
                // $dateToInsert = str_replace("Gift", "",$dateToInsert);
                
                // Use Regex to remove all non-numerical chars. 01/08/2022 Gift! = 01082022
                $dateToInsert = preg_replace('~\D~', '', $dateToInsert);

                // Using substr_replace to re-add the '/' char for the date
                $str_to_insert = "/";
                $dateToInsert = substr_replace($dateToInsert, $str_to_insert, 2, 0);
                $dateToInsert = substr_replace($dateToInsert, $str_to_insert, 5, 0);
                
                // Convert the date so MySQL likes it (If we don't format it, the dates get put in as 2001)
                $dateToInsert = date("Y-m-d", strtotime($dateToInsert));

                // UPDATE query to update the MySQL Database
                // I will leave this in, but it makes the page take a while to load.
                // Verified myself that it is working as expected
                $insertQuery = "UPDATE `sweetwater_test` SET `shipdate_expected`= '$dateToInsert' WHERE orderid = $orderID;";
                mysqli_query($conn, $insertQuery);
            }

        }
    }
    else
    {
        echo "Ben is an idiot and can't code :(";
    }
?>

</body>
</html>