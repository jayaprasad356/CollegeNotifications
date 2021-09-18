<?php
include_once('includes/functions.php');
date_default_timezone_set('Asia/Kolkata');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;



$res_cur = $db->getResult();
if (isset($_POST['btnAdd'])) {
    $error = array();
        
        $title = $db->escapeString($fn->xss_clean($_POST['title']));
        $description = $db->escapeString($fn->xss_clean($_POST['description']));
        $meetlink = $db->escapeString($fn->xss_clean($_POST['meetlink']));
        
        // get image info
        $image = $db->escapeString($fn->xss_clean($_FILES['image']['name']));
        $image_error = $db->escapeString($fn->xss_clean($_FILES['image']['error']));
        $image_type = $db->escapeString($fn->xss_clean($_FILES['image']['type']));
        $category = 'hostel';

        // create array variable to handle error
        

        if (empty($title)) {
            $error['title'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($description)) {
            $error['description'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($meetlink)) {
            $error['meetlink'] = " <span class='label label-danger'>Required!</span>";
        }
        
        

        // common image file extensions
        $allowedExts = array("gif", "jpeg", "jpg", "png");

        // get image file extension
        error_reporting(E_ERROR | E_PARSE);
        $extension = end(explode(".", $_FILES["image"]["name"]));

        if ($image_error > 0) {
            $error['image'] = " <span class='label label-danger'>Not uploaded!</span>";
        } else {
            
            $result = $fn->validate_image($_FILES["image"]);
            if ($result) {
                $error['image'] = " <span class='label label-danger'>Image type must jpg, jpeg, gif, or png!!!</span>";
            }
        }
        

        if (!empty($title) && !empty($description) && !empty($meetlink) && empty($error['image'])) {

            // create random image file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image']['name']);

            $image = $function->get_random_string($string, 4) . "-" . date("Y-m-d") . "." . $extension;

            // upload new image
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], 'upload/images/' . $image);
            
            

            $upload_image = 'upload/images/' . $image;
            $checkBox = implode(',', $_POST['batch']);

            // insert new data to product table
            $sql = "INSERT INTO notifications (title,description,meetlink,image,batch,category) VALUES('$title','$description','$meetlink','$upload_image','$checkBox','$category')";
            // echo $sql;
            $db->sql($sql);
            $product_result = $db->getResult();
            if (!empty($product_result)) {
                $product_result = 0;
            } else {
                $product_result = 1;
            }

            
            if ($product_result == 1) {
                $error['add_menu'] = "<section class='content-header'>
                                                <span class='label label-success'>Notifications Send Successfully</span>
                                                <h4><small><a  href='products.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to College Notifications</a></small></h4>
                                                 </section>";
            } else {
                $error['add_menu'] = " <span class='label label-danger'>Failed</span>";
            }
        }
}
?>
<section class="content-header">
    <h1>Send Notification</h1>
    <?php echo isset($error['add_menu']) ? $error['add_menu'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>

</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Send Notification</h3>
                </div>
                <div class="box-header">
                    <?php echo isset($error['cancelable']) ? '<span class="label label-danger">Till status is required.</span>' : ''; ?>
                </div>

                <!-- /.box-header -->
                <!-- form start -->
                <form id='add_product_form' method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label> <i class="text-danger asterik">*</i>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description :</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                            <textarea name="description" id="description" class="form-control" rows="8"></textarea>
                            <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                            <script type="text/javascript">
                                CKEDITOR.replace('description');
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Meet Link (optional)</label> 
                            <input  type="url" class="form-control" name="meetlink" required>
                            
                        </div>
                        
                    
                        <div class="form-group">
                            <label for="image">Main Image : <?php echo isset($error['image']) ? $error['image'] : ''; ?>
                            <input type="file" name="image" id="image" >
                        </div>
                        <div >
                        <b>Choose to Send Notify</b>
                        </div>
                        


                        <div class="form-group form-check">
                        <label class="form-check-label">
                            <?php
                            for($i = 0; $i < count($sb); $i++) {
                                echo "<input name='batch[]' ";
                                ?>
                                value='<?php echo $sb[$i]; ?>'  type='checkbox'>&nbsp; <?php echo $sb[$i]; ?> &nbsp;
                                <?php
                            }
                                ?>
                            
                        </label>
                        </div>
                        
                    
                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="submit" class="btn-primary btn" value="Add" name="btnAdd" />&nbsp;
                        <input type="reset" class="btn-danger btn" value="Clear" id="btnClear" />
                        <!--<div  id="res"></div>-->
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<div class="separator"> </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>






<script>
    
    $('#add_product_form').validate({
        ignore: [],
        debug: false,
        rules: {
            title: "required",
            meetlink: "required",
            description: {
                required: function(textarea) {
                    CKEDITOR.instances[textarea.id].updateElement();
                    var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                    return editorcontent.length === 0;
                }
            }
            

        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
    
</script>
