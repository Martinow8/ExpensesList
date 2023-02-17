<?php 
    session_start();
    if(!isset($_SESSION['logged'])){
        header("location: login.php");
        die;
    }




    $conn = mysqli_connect("localhost",'expense','123456','expense');


    ### Expenses this month
    function getMonthExpenses($conn){
        $currentMonth = date("m");
        $currentDate = date("d");
        $currentYear = date("Y");
        $startDate = $currentYear . "-" . $currentMonth . "-01";
        $endDate = date("Y-m-d");

        $expensesThisMonth;
    
        $result = mysqli_query($conn, "SELECT * FROM expenses WHERE expense_date BETWEEN '$startDate' AND '$endDate'"); 
        $expensesArray = [];
        while($row = mysqli_fetch_assoc($result)){
            $expensesArray[] = $row;
        }
    
        $thisMonthExpensesPrice = 0;
        foreach($expensesArray as $expense){
            $thisMonthExpensesPrice+=$expense['expense_price'];
        }
        return $thisMonthExpensesPrice;
    }
    
    function getTodayExpenses($conn){
        $endDate = $startDate = date("Y-m-d");
        $expensesThisMonth;
    
        $result = mysqli_query($conn, "SELECT * FROM expenses WHERE expense_date BETWEEN '$startDate' AND '$endDate'"); 
        $expensesArray = [];
        while($row = mysqli_fetch_assoc($result)){
            $expensesArray[] = $row;
        }
    
        $todayExpensesPrice = 0;
        foreach($expensesArray as $expense){
            $todayExpensesPrice+=$expense['expense_price'];
        }
        return $todayExpensesPrice;
    }


    $monthExpenses = getMonthExpenses($conn);
    $todayExpenses = getTodayExpenses($conn);

#    echo $monthExpenses;
#    echo $todayExpenses;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    html{
        min-height:100vh;
    }

    body{
        min-height:100vh;
        background-color:grey;
        margin:0;
        padding:0;
    }

    .main{
        min-height:85vh;
        width:80vw;
        margin-left:10vw;
        background-color:#00004a;
        color:white;
        padding-top:10vh;
    }

    .main .monthlyExpenses{
        height:30vh;
        font-size:20vh;
        width:40vw;
        margin-left:20vw;
        background-color:red;
        text-align:center;
    }

    .main .monthlyExpenses .monthlyExpensesHeader{
        font-size:8vh;
        text-align:center;
        display:block;
    }

    .main .dailyExpenses{
        height:20vh;
        font-size:10vh;
        width:40vw;
        margin-left:20vw;
        background-color:red;
        text-align:center;
        margin-top:5vh;
    }

    .main .dailyExpenses .dailyExpensesHeader{
        font-size:5vh;
        text-align:center;
        display:block;
    }

    .addNewRecordButton{
        position:absolute;
        bottom:5vw;
        right:4vw;
        height:6vh;
        width:6vh;
        background-color:red;
        color:white;
        font-size:4vh;
        border-radius:20px;
        text-align:center;
        padding-top:1vh;
        font-weight:bold;
    }

    .addRecordModal{
        min-height:85vh;
        width:80vw;
        margin-left:10vw;
        background-color:red;
        color:white;
        padding-top:10vh;
        display:none;
        position:absolute;
        z-index:1;
        top:0;
    }

    #closeAddRecordModal{
        position:absolute;
        top:1vh;
        right:1vh;
        font-size:5em;
    }
</style>
<body>
    <div class="main">
        <div class="monthlyExpenses">
            <span class="monthlyExpensesHeader">Месец</span>
            <span><?php echo $monthExpenses; ?></span>
        </div>
        <div class="dailyExpenses">
            <span class="dailyExpensesHeader">Днес</span>
            <span><?php echo $todayExpenses; ?></span>
        </div>
    </div>

        <div class="addNewRecordButton" id="addNewRecordButton">
            +
        </div>
    
    <div class="addRecordModal">
        <span id="closeAddRecordModal">X</span>
        <div>Add record modal</div>
        <div class="addNewRecordForm">
            <form action="" method="">
                <span>Input1</span>
                <input type="text">
                <span>Input2</span>
                <input type="text">
                <input type="submit">
            </form>
        </div>
    </div>

    <script>

        /* Open add new record modal */
        let addNewRecordButton = document.getElementById("addNewRecordButton");
        addNewRecordButton.addEventListener("click", function(e){
            document.querySelector(".addRecordModal").style.display = "block";
            document.querySelector(".main").style.display = "none";
            e.currentTarget.style.display = "none";
        })

        /* Close add new record modal */
        let closeAddNewRecordButton = document.querySelector("#closeAddRecordModal");
        closeAddNewRecordButton.addEventListener("click", function(){
            document.querySelector(".addRecordModal").style.display = "none";
            document.querySelector(".main").style.display = "block";
            document.querySelector("#addNewRecordButton").style.display = "block";
        })
    </script>
</body>
</html>