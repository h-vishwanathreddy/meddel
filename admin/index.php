<?php include('partials/menu.php'); ?>


<!-- main content section starts here -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>
        <?php
        if(isset($_SESSION['login']))
            {
              echo $_SESSION['login'];//Displaying session message
              unset($_SESSION['login']);//Removing session message
            }
?>
        <br><br>

        <div class="col-4 text-center">

            <?php
            //Query to get all admin
            $sql="SELECT * FROM tbl_category";
            //Execute the query
            $res=mysqli_query($conn,$sql);

            $count=mysqli_num_rows($res);
    
            

        ?>

            <h1><?php echo $count;?></h1>
            <br>
            Categories
        </div>

        <div class="col-4 text-center">

            <?php
            //Query to get all admin
            $sql2="SELECT * FROM tbl_medicine";
            //Execute the query
            $res2=mysqli_query($conn,$sql2);

            $count2=mysqli_num_rows($res2);
    
            

        ?>

            <h1><?php echo $count2;?></h1>
            <br>
            Medicines
        </div>

        <div class="col-4 text-center">

        <?php
            //Query to get all admin
            $sql3="SELECT * FROM tbl_order";
            //Execute the query
            $res3=mysqli_query($conn,$sql3);

            $count3=mysqli_num_rows($res3);
    
            

        ?>


            <h1><?php echo $count3;?></h1>
            <br>
            Total Orders
        </div>

        <div class="col-4 text-center">

            
        <?php
            //Query to get all admin
            $sql4="SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
            //Execute the query
            $res4=mysqli_query($conn,$sql4);

            $count4=mysqli_num_rows($res4);
    
            $rows4=mysqli_fetch_assoc($res4);

            $total_revenue=$rows4['Total'];

        ?>


            <h1>₹<?php echo  $total_revenue;?></h1>
            <br>
            Revenue Generated
        </div>

        <div class="clearfix"></div>

    </div>

</div>
<!-- main content section ends -->


<?php include('partials/footer.php'); ?>