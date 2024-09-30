<?php
session_start();
if (!(isset($_SESSION['EMP_Number']) && $_SESSION['EMP_Number'] != '')) {
    header("Location: index.php");
}

include('database.php'); // Include your database connection

// Function to count the number of students per grade
function getGradeCounts()
{
    global $conn;

    $grades = array('A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'F');
    $gradeCounts = array_fill_keys($grades, 0); // Initialize with 0 counts

    foreach ($grades as $grade) {
        $query = "SELECT COUNT(*) AS count FROM marks WHERE Grade = '$grade'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $gradeCounts[$grade] = $row['count'];
    }

    return $gradeCounts;
}

// Get the grade counts
$gradeCounts = getGradeCounts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="images/Kdu.ico">
    <title>KDU-Examination Management System</title>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <h2>Grade Distribution</h2>

        <!-- Bar Chart -->
        <canvas id="gradeChart" width="400" height="200"></canvas>

        <script>
            var ctx = document.getElementById('gradeChart').getContext('2d');
            var gradeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'F'],
                    datasets: [{
                        label: '# of Students',
                        data: [
                            <?php echo implode(',', $gradeCounts); // Output the counts 
                            ?>
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>

</html>