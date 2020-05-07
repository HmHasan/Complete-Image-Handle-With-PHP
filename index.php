    <?php include("include/header.php")?>
    <?php include("config/connection.php");?>
    <?php
    
        $database = new database;
    
    ?>
        <div class="main-part">
            <div class="form-part">
                <?php
                
                
                if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD']=="POST")
                {
                    //image type
                    $permitted = array('img','jpeg','png','ico','gif','jpg');
                    //image name
                    $file_name = $_FILES['image']['name'];
                    //image size 
                    $file_size = $_FILES['image']['size'];
                    //image tmp_nmae 
                    $file_temp = $_FILES['image']['tmp_name'];
                    //uniq name Generator
                    $div = explode(".",$file_name);
                    //get last extension
                    $extension = strtolower((end($div)));
                    //for uniq name
                    $uniq_name = substr(md5(time()),0,10).'.'.$extension;
                    //folder location
                    $folder = 'upload/'.$uniq_name;


                    if(empty($file_name))
                    {
                        echo "<span class='error'>Please Select An Image</span>";
                    }
                    elseif($file_size > 20000001)
                    {
                        echo "<span class='error'>Your Image Should be lessthan Or equeal 2mb</span>";
                    }

                    elseif(in_array($extension,$permitted)===false)
                    {
                        echo "<span class='error'>You Can Upload Only:-".implode(',',$permitted)."</span>";
                    }
                    else

                    {
                        move_uploaded_file($file_temp, $folder);
                        //upload image into database
                        $query = "INSERT INTO file_upload(image)VALUES('$folder')";
                        $insert_rows = $database->insert($query);
                        if($insert_rows)
                        {
                            echo "<span class='success'>Image Successfully Uploaded</span>";
                        }
                    }


                   
                }

                
                
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Upload a File</td>
                            <td><input type="file" name="image"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="submit">Upload</button></td>
                        </tr>
                    </table>
                </form>
                <?php
                
                if(isset($_GET['del']))
                {
                    $id = $_GET['del'];
                    $getquery = "SELECT * FROM file_upload where id='$id'";
                    $getimg = $database->show($getquery);

                    if( $getimg)
                    {
                        while($getresult=$getimg->fetch_assoc())
                    {
                        $uploaded = $getresult['image'];
                        unlink($uploaded);
                    }
                    }
                    

                    $query = "DELETE FROM file_upload where id = $id";
                    $result = $database->delete($query);
                    if($result)
                {
                    echo "<span class='success'>Image Successfully Delete</span>";
                }
                
                }
                
                ?>
                  <table border="3" width="100%" style="text-align: center">
                      <tr>
                          <th width="30%">Name</th>
                          <th width="40%">Image</th>
                          <th width="30%">Action</th>
                      </tr>
                      <?php
                      
                      $query = "SELECT * FROM file_upload";
                      $get_image = $database->show($query);
                      if($get_image)
                      {
                          $i = 0;
                          while($result = $get_image->fetch_assoc())
                          {
                                $i++;
                      ?>
                      <tr>
                          <td><?=$i;?></td>
                          <td><img src="<?php echo $result['image'];?>" alt="" height="40px" width="50px"></td>
                          <td><a href="?del=<?php echo $result['id'];?>" onclick="return confirm('Are You Sure To Delete This Image')">Delete</a></td>
                      </tr>
                      <?php } } ?>
                  </table>
            </div>
        </div>
        <?php include("include/footer.php")?>
       