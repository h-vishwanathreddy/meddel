<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br>

        <?php
    if(isset($_GET['id']))
    {

        // echo "Getting the data";
        $id=$_GET['id'];

        $sql="Select * FROM tbl_category WHERE id=$id";

        $res=mysqli_query($conn,$sql);

        $count=mysqli_num_rows($res);

        
        if($count==1)
        {
            $rows=mysqli_fetch_assoc($res);
            $title=$rows['title'];
            $current_image=$rows['image_name'];
            $featured=$rows['featured'];
            $active=$rows['active'];
        }
        else{

            $_SESSION['no-category-found']="<div class='error'>Category not found</div>";
            // Redirect page to add admin
            header('location:'.SITEURL.'admin/manage-category.php'); 
        }
        
    }
    else{

        header('location:'.SITEURL.'admin/manage-category.php');
    }
    ?>


        <form action="" method="post" enctype="multipart/form-data">

            <table>
                <tr>
                    <td>Title</td>
                    <td><input type="text" name="title" placeholder="Category Title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                    if($current_image!="")
                    {
                        ?>

                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?>" width="150px">

                        <?php

                    }
                    else{

                        echo "<div class='error'>Image not added.</div>";

                    }
        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured"
                            value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>

                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">

                        <input type="hidden" name="id" value="<?php echo $id;?>">

                        <input class="btn btn-success" type="submit" name="submit" value="Update Category">
                    </td>
                </tr>
            </table>
        </form>

        <?php

            if(isset($_POST['submit']))
            {
                $id=$_POST['id'];
                $title=$_POST['title'];
                $current_image=$_POST['current_image'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];

                //Updating new image
                //Check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                        //Upload image
                        //to upload image, we need image name, source path and destination path
                        $image_name=$_FILES['image']['name'];
                
                        //Check whether the image is available or not
                                if($image_name!="")
                        {
                                                    
                                                    //Auto rename our image
                                //Get extension of our image(jpg,png,etc.)
                                $ext = end(explode('.', $image_name));

                                //Rename the image
                                $image_name="Food_Category_".rand(000,999).'.'.$ext;  //Food_Category_798.jpg



                                $source_path=$_FILES['image']['tmp_name'];

                                $destination_path="../images/Category/".$image_name;

                                //Finally upload image
                                $upload=move_uploaded_file($source_path,$destination_path);

                                //Check whether the image is uploaded or not
                                //If image is not uploaded, will redirect with error message
                                if($upload==false)
                                {
                                    $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";

                                    // Redirect page to manage admin
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    //Stop the process
                                    die();
                                }

                                //Remove current image if available
                                if($current_image!="")
                                {
                                    $remove_path="../images/category/".$current_image;

                                    $remove=unlink($remove_path);
    
                                    //Check whether the image is removed or not
                                    //If failed to remove then displaay message and stop the process
                                    if($remove==false)
                                    {
                                        //Failed to remove the image
                                        $_SESSION['failed-remove']="<div class='error>Failed to remove current image.</div>";
                                        header('location:'.SITEURL.'admin/manage-category.php');
                                        die();//Stop the process
                                    }
                                }
                                

                                else{
                                    $image_name=$current_image;
                                }
                        }
                        
                else{

                    $image_name=$current_image;
                }



                //Update the database
                $sql2="UPDATE tbl_category SET title='$title',image_name='$image_name',featured='$featured',active='$active' WHERE id=$id";

                $res2=mysqli_query($conn,$sql2);

                if($res2==true)
                {
                    $_SESSION['update']="<div class='success'>Category added Successfully</div>";
                    // Redirect page to add admin
                    header('location:'.SITEURL.'admin/manage-category.php'); 
                }
                else{
                    $_SESSION['update']="<div class='error'>Failed to update Category</div>";
                    // Redirect page to add admin
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
        }

        ?>




    </div>
</div>



<?php include('partials/footer.php'); ?>