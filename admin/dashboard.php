<?php
session_start();
require 'config/db.php';

include("export_data.php");
// Check if the user is authenticated
if(!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
    // Redirect to the login page if not authenticated
    header("Location: index.php");
    exit();
}

// Example: You might have stored the username in the session
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Existing CSS rules... */

table {
  width: 100%;
  border-collapse: collapse;
}

table th, table td {
  padding: 1rem;
  text-align: left;
  border: 1px solid #ddd;
  word-wrap: break-word; /* Allows long words to break onto the next line */
  text-align: center;
}

table th {
  background-color: #000;
  color: #fff;
  text-align: center;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

table tr:hover {
  background-color: #ddd;
}

table td {
  vertical-align: top; /* Aligns text to the top of the cell */
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }
  table thead {
    display: none;
  }
  table, tbody, tr, td {
    display: block;
    width: 100%;
  }
  table tr {
    margin-bottom: 1rem;
    border-bottom: 1px solid #ddd;
  }
  table td {
    text-align: right;
    position: relative;
    padding-left: 50%;
    white-space: normal; /* Allows text to wrap */
  }
  table td::before {
    content: attr(data-label);
    position: absolute;
    left: 0;
    width: 45%;
    padding-left: 0.5rem;
    font-weight: bold;
    white-space: nowrap;
  }
}

    </style>
</head>
<body>
    <div class="sidebar close">
        <div class="logo-details">
        <i class="fa-solid fa-j" style="color: #FFD43B;"></i>
            <span class="logo_name">Joshiana | 13.0</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#">
                    <i class='bx bx-home-alt' ></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#home">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <a href="#one">
                    <i class='bx bx-grid-alt' ></i>
                    <span class="link_name">View</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">View</a></li>
                </ul>
            </li>
            <li>
                <a href="#three">
                    <i class='bx bx-building-house' ></i>
                    <span class="link_name">Transaction Details</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Transaction Details</a></li>
                </ul>
            </li>
            <li>
                <a href="logout.php">
                    <i class='bx bx-log-out' ></i>
                    <span class="link_name">LOGOUT</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="logout.php">LOGOUT</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text">Welcome Back !!</span>
        </div>
    </section>
    <div class="two" id="two">
        <div class="row">
            <div class="column">
                <div class="card">
                    <h3>Number of Participants</h3>
                    <p>
                        <?php 
                    $count_sql = "SELECT COUNT(*) AS total_users FROM events";
                    $count_result = $conn->query($count_sql);
                    
                    $total_users = 0;
                    
                    if ($count_result->num_rows > 0) {
                        // Fetch the result
                        $count_row = $count_result->fetch_assoc();
                        $total_users = $count_row['total_users'];
                    } else {
                        echo "Error retrieving user count";
                    }
                    
                    // Second SQL query to select all data from the 'users' table
                    $data_sql = "SELECT e.id,e.college, e.email, e.phone1, e.phone2, e.degree, e.department, e.order_id, e.payment_id, e.total_amount, d.event_name, d.participants
                        FROM events e
                        JOIN event_details d ON e.order_id = d.order_id
                    ";
                    $data_result = $conn->query($data_sql);
                    echo $total_users; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="one" id="one">
             <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="export-btn">					
				<button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn-excel">Export to Excel</button>
			</form>
        
        <table>
            <thead>
                <tr>
                    <th scope="col" style="width:100px;">P_ID</th>
                    <th scope="col" colspan="3">College</th>
                    <th scope="col" colspan="3">Email</th>
                    <th scope="col" colspan='2'>Phone1</th>
                    <th scope="col" colspan='2'>Phone2</th>
                    <th scope="col" colspan='2'>Degree</th>
                    <th scope="col" colspan='2'>Department</th>
                    <th scope="col" colspan='2'>Events</th>
                    <th scope="col" colspan='2' style="width:200px">Participant Name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($data_result->num_rows > 0) {
                    // Fetch the results as an associative array
                    while($row = $data_result->fetch_assoc()) {
                        $uniqueId = $row["order_id"]; // Unique ID for each modal and button
                        echo "<tr>";
                        echo "<td data-label='Participant_ID'>" . $row["id"]. "</td>";
                        echo "<td data-label='College' colspan='3'> ".$row["college"]."</td>";
                        echo "<td data-label='Email' colspan='3'>".$row["email"]."</td>";
                        echo "<td data-label='phone' colspan='2'>".$row["phone1"]."</td>";
                        echo "<td data-label='phone' colspan='2'>".$row["phone2"]."</td>";
                        echo "<td data-label='degree' colspan='2'>".$row["degree"]."</td>";
                        echo "<td data-label='Department' colspan='2'>".$row["department"]."</td>";
                        echo "<td data-label='event' colspan='2'>".$row["event_name"]."</td>";
                        echo "<td data-label='event' colspan='2'>".$row["participants"]."</td>";
                        ?>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='14'>0 results</td></tr>";
                }
                
                
                ?>
                
            </tbody>
        </table>
    </div>
    
    <div class="three" id="three">
    <table>
            <thead>
                <tr>
                    <th scope="col" >P_ID</th>
                    <th scope="col" colspan="3">Collge</th>
                    <th scope="col" colspan="2">Order_ID</th>
                    <th scope="col" colspan='2'>Payment_ID</th>
                    <th scope="col" colspan='2'>Total Amount</th>
                    <th scope="col" colspan='2'>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $tran_sql = "SELECT *  FROM `events`";
                 $tran_result = $conn->query($tran_sql);
                
                if ($tran_result->num_rows > 0) {
                    // Fetch the results as an associative array
                    while($row = $tran_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='T_ID'>" . $row["id"]. "</td>";
                        echo "<td data-label='college' colspan='3'>" . $row["college"]. "</td>";
                        echo "<td data-label='Order_ID' colspan='2'>" . $row["order_id"]. "</td>";
                        echo "<td data-label='Payement_ID' colspan='2'> ".$row["payment_id"]."</td>";
                        echo "<td data-label='totalamount' colspan='2' style='color:green;font-weight:bold;'>".$row["total_amount"]."</td>";
                        echo "<td data-label='Created_at' colspan='2'>".$row["created_at"]."</td>";
                        ?>
                        </tr>   
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='10'>0 results</td></tr>";
                }
                ?>
            </tbody>
            </table>
            <table>
            <thead>
                <tr>
                    <th scope="col" >Total Amount</th>
                </tr>
            </thead>
            <tbody>
    <?php
    // Correct SQL query to calculate the sum of total_amount
    $tot_sql = "SELECT SUM(total_amount) AS total_amount FROM `events`";
    
    // Execute the query
    $tot_result = $conn->query($tot_sql);
    
    if ($tot_result->num_rows > 0) {
        // Fetch the result as an associative array
        while($row = $tot_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td data-label='total_amount'>" . $row["total_amount"]. "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>0 results</td></tr>";
    }
    
    // Close the database connection
    $conn->close();
    ?>
</tbody>
        </table>    
    </div>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
    <script src="js/script.js"></script>
    <script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e)=>{
            let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("close");
    });



</script>
    </script>
</body>
</html>
