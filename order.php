<?php include('partials-front/menu.php');?>


<?php

    if(isset($_GET['medicine_id']))
    {
        $medicine_id=$_GET['medicine_id'];

        $sql="SELECT * FROM tbl_medicine Where id=$medicine_id";

        $res=mysqli_query($conn,$sql);
      //Count rows to check whether we have data in database or not
      $count=mysqli_num_rows($res);//Function to get all rows in database

      //Check the no. of rows
            if($count==1)
            {
                //We have data in database
                $rows=mysqli_fetch_assoc($res);
                $title=$rows['title'];
                $price=$rows['price'];
                $image_name=$rows['image_name'];
            }
            else{

                header('location:'.SITEURL);
            }
    }
    else{

        header('location:'.SITEURL);
    }




?>

<!-- MED sEARCH Section Starts Here -->
<section class="medicine-search-new">
    <div class="container">

        <h2 class="text-center text-orderc">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Medicine</legend>

                <div class="medicine-menu-img">

                    <?php
            //Check whether the image is available or not
            if($image_name=="")
            {
                echo "<div class='error'>Image not Available</div>";
            }
            else
            {
                ?>
                    <img src="<?php echo SITEURL; ?>images/medicine/<?php echo $image_name;?>" alt="medicine"
                        class="img-responsive img-curve">
                    <?php
            }
           ?>

                </div>

                <div class="medicine-menu-desc">
                    <h3><?php echo $title;?></h3>
                    <input type="hidden" name="medicine" value="<?php echo $title;?>">

                    <p class="medicine-price"><?php echo $price;?></p>
                    <input type="hidden" name="price" value="<?php echo $price;?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name"  class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact"  class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email"  class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10"  class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
    if(isset($_POST['submit']))
    {
        $medicine=$_POST['medicine'];
        $price=$_POST['price'];
        $qty=$_POST['qty'];
        $total=$price * $qty;
        $order_date=date("Y-m-d h:i:sa");
        $status= "Ordered";
        $customer_name=$_POST['full-name'];
        $customer_contact=$_POST['contact'];
        $customer_email=$_POST['email'];
        $customer_address=$_POST['address'];

        $sql2="INSERT INTO tbl_order SET
            medicine='$medicine',
            price=$price,
            qty=$qty,
            total=$total,
            order_date='$order_date',
            status='$status',
            customer_name= '$customer_name',
            customer_contact='$customer_contact',
            customer_email='$customer_email',
            customer_address='$customer_address'
            ";

            $res2=mysqli_query($conn,$sql2);

            if($res2==true)
            {
                $_SESSION['order']="<div class='success text-center'>Medicine Ordered Successfully</div>";
                // Redirect page to add admin
                header('location:'.SITEURL); 
            }
            else{
                $_SESSION['order']="<div class='error text-center'>Failed to Order Medicine</div>";
                // Redirect page to add admin
                header('location:'.SITEURL);
            }

    }



?>
    </div>
</section>
<!-- MED sEARCH Section Ends Here -->

<?php include('partials-front/footer.php');?>