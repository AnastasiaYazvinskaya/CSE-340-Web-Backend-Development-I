<?php 
/*
 * A library of custom functions
 */

   // Build the navigation list using the classification information
   function createNavlist($classifications) {
      $navList = '<ul>';
      $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
      foreach ($classifications as $classification) {
         $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
      }
      $navList .= '</ul>';
      return $navList;
   }

   // Validate email
   function checkEmail($clientEmail) {
      /*
      * It will check the value of the $clientEmail variable, 
      * after having been sanitized, to see if it "looks" like 
      * a valid email address.
      */
      $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
      return $valEmail;
      
   }

   // Validate password
   function checkPassword($clientPassword) {
      /* Check the password for a minimum of 8 characters,
      * at least one 1 capital letter, at least 1 number and
      * at least 1 special character
      */
      $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
      return preg_match($pattern, $clientPassword);

   }

   // Build the classifications select list 
   function buildClassificationList($classifications){ 
      $classificationList = '<select name="classificationId" id="classificationList">'; 
      $classificationList .= "<option>Choose a Classification</option>"; 
      foreach ($classifications as $classification) { 
         $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
      } 
      $classificationList .= '</select>'; 
      return $classificationList; 
   }

   // Build a display of vehicles within an unordered list
   function buildVehiclesDisplay($vehicles){
      $dv = '<ul id="inv-display">';
      foreach ($vehicles as $vehicle) {
         $dv .= '<li>';
         $dv .= "<a class='vehicleImg' href='/phpmotors/vehicles/?action=vehicle&invId=".urlencode($vehicle['invId'])."'><img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a>";
         $dv .= '<hr>';
         $dv .= "<a href='/phpmotors/vehicles/?action=vehicle&invId=".urlencode($vehicle['invId'])."'><h2>$vehicle[invMake] $vehicle[invModel]</h2></a>";
         $dv .= "<span>$vehicle[invPrice]</span>";
         $dv .= '</li>';
      }
      $dv .= '</ul>';
      return $dv;
   }

   // Build a display of vehicle information
   function buildVehicleInfoDisplay($invInfo, $secondaryImages){
      $dvi = "<div id='invInfo'>";
      if ($secondaryImages){
         $dvi .= "<div class='secondaryImages'>";
         foreach ($secondaryImages as $sImage) {
            $dvi .= "<img src='$sImage[imgPath]' alt='$sImage[imgName]'>";
         }
         $dvi .= "</div>";
         $dvi .= "<img class='mainImg' src='$invInfo[imgPath]' alt='Image of $invInfo[invMake] $invInfo[invModel] on phpmotors.com'>";
      }
      else {
         $dvi .= "<img class='bigImg' src='$invInfo[imgPath]' alt='Image of $invInfo[invMake] $invInfo[invModel] on phpmotors.com'>";
      }
      $dvi .= "<div id='invContent'>";
      $dvi .= "<h1>$invInfo[invYear] $invInfo[classificationName] $invInfo[invMake] $invInfo[invModel]</h1>";
      $dvi .= "<h2 id='invPrice'>$".number_format($invInfo['invPrice'], 0, '.', ',')."</h2>";
      $dvi .= "<p>$invInfo[invDescription]</p>";
      $dvi .= "</div>";

      $dvi .= "<div id='invSummary'><h3>Vehicle Summary</h3>";
      $dvi .= '<ul>';
      $dvi .= "<li>Price:<span>$".number_format($invInfo['invPrice'], 0, '.', ',')."</span></li>";
      $dvi .= "<li>Stock:<span>$invInfo[invStock]</span></li>";
      $dvi .= "<li>Miles:<span>$invInfo[invMiles]</span></li>";
      $dvi .= "<li>Color:<span>$invInfo[invColor]</span></li>";
      $dvi .= '</ul></div>';
      $dvi .= "</div>";
      return $dvi;
   }

   /* * ********************************
   *  Functions for working with images
   * ********************************* */

   // Adds "-tn" designation to file name
   function makeThumbnailName($image) {
      $i = strrpos($image, '.');
      $image_name = substr($image, 0, $i);
      $ext = substr($image, $i);
      $image = $image_name . '-tn' . $ext;
      return $image;
   }

   // Build images display for image management view
   function buildImageDisplay($imageArray) {
      $id = '<ul id="image-display">';
      foreach ($imageArray as $image) {
         $id .= '<li>';
         $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
         $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
         $id .= '</li>';
      }
      $id .= '</ul>';
      return $id;
   }

   // Build the vehicles select list
   function buildVehiclesSelect($vehicles) {
      $prodList = '<select name="invId" id="invId">';
      $prodList .= "<option>Choose a Vehicle</option>";
      foreach ($vehicles as $vehicle) {
         $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
      }
      $prodList .= '</select>';
      return $prodList;
   }

   // Handles the file upload process and returns the path
   // The file path is stored into the database
   function uploadFile($name) {
      // Gets the paths, full and local directory
      global $image_dir, $image_dir_path;
      if (isset($_FILES[$name])) {
         // Gets the actual file name
         $filename = $_FILES[$name]['name'];
         if (empty($filename)) {
            return;
         }
         // Get the file from the temp folder on the server
         $source = $_FILES[$name]['tmp_name'];
         // Sets the new path - images folder in this directory
         $target = $image_dir_path . '/' . $filename;
         // Moves the file to the target folder
         move_uploaded_file($source, $target);
         // Send file for further processing
         processImage($image_dir_path, $filename);
         // Sets the path for the image for Database storage
         $filepath = $image_dir . '/' . $filename;
         // Returns the path where the file is stored
         return $filepath;
      }
   }

   // Processes images by getting paths and 
   // creating smaller versions of the image
   function processImage($dir, $filename) {
      // Set up the variables
      $dir = $dir . '/';
   
      // Set up the image path
      $image_path = $dir . $filename;
   
      // Set up the thumbnail image path
      $image_path_tn = $dir.makeThumbnailName($filename);
   
      // Create a thumbnail image that's a maximum of 200 pixels square
      resizeImage($image_path, $image_path_tn, 200, 200);
   
      // Resize original to a maximum of 500 pixels square
      resizeImage($image_path, $image_path, 500, 500);
   }

   // Checks and Resizes image
   function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
      
      // Get image type
      $image_info = getimagesize($old_image_path);
      $image_type = $image_info[2];
   
      // Set up the function names
      switch ($image_type) {
         case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
         case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
         case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
         default:
            return;
      } // ends the swith
   
      // Get the old image and its height and width
      $old_image = $image_from_file($old_image_path);
      $old_width = imagesx($old_image);
      $old_height = imagesy($old_image);
   
      // Calculate height and width ratios
      $width_ratio = $old_width / $max_width;
      $height_ratio = $old_height / $max_height;
   
      // If image is larger than specified ratio, create the new image
      if ($width_ratio > 1 || $height_ratio > 1) {
   
         // Calculate height and width for the new image
         $ratio = max($width_ratio, $height_ratio);
         $new_height = round($old_height / $ratio);
         $new_width = round($old_width / $ratio);
      
         // Create the new image
         $new_image = imagecreatetruecolor($new_width, $new_height);
      
         // Set transparency according to image type
         if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
         }
      
         if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
         }
      
         // Copy old image to new image - this resizes the image
         $new_x = 0;
         $new_y = 0;
         $old_x = 0;
         $old_y = 0;
         imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
      
         // Write the new image to a new file
         $image_to_file($new_image, $new_image_path);
         // Free any memory associated with the new image
         imagedestroy($new_image);
      } else {
         // Write the old image to a new file
         $image_to_file($old_image, $new_image_path);
      }
      // Free any memory associated with the old image
      imagedestroy($old_image);
   } // ends resizeImage function



   //Make a search, pass results toother functions to cretion a display view
   function searchResults($str, $page){
      $splitSTR = explode(" ", $str);

      $result = [];
      $ids = [];
      foreach ($splitSTR as $part){
         $result += search('%'.$part.'%', $ids);
         foreach ($result as $invId){
            if (!in_array($invId['invId'], $ids)){
               array_push($ids, $invId['invId']);
            }
         }
      }
      // Check and report the result
      if(!count($result)){
         $searchResultsDisplay = "<h2>Returned 0 results for: $str</h2>";
         $searchResultsDisplay .= "<p class='notice'>Sorry, no results were found to match $str.</p>";
      } else {
         $rNum = count($result);
         $searchResultsDisplay = "<h2>Returned $rNum results for: $str</h2>";
         $searchResultsDisplay .= searchResultsDisplay(array_slice($result, ($page-1)*10, 10), $page);
         $searchResultsDisplay .= paginationDisplay(ceil($rNum/10), $str, $page);
      }
      return $searchResultsDisplay;
   }

   // List of 10 vehicles display view
   function searchResultsDisplay($result, $page){
      $dsr = '<div id="result">';
      for ($i=0; $i<count($result); $i++){
         $dsr .= '<section class="vehicle">';
         $dsr .= "<a href='/phpmotors/vehicles/?action=vehicle&invId=".urlencode($result[$i]['invId'])."'><h3>".$result[$i]['invYear']." ".$result[$i]['invMake']." ".$result[$i]['invModel']."</h3></a>";
         $dsr .= "<p>".$result[$i]['invDescription']."</p>";
         $dsr .= '</section>';
      }
      $dsr .= '</div>';
      return $dsr;
   }

   // Pagination display view
   function paginationDisplay($tens, $str, $page){
      $pd = "";
      if ($tens > 1){
         $pd = '<div id="pagination">';
         if ($page != 1){
            $pd .= "<a href='/phpmotors/search/?action=result&page=".($page-1)."&str=$str' class='previous round'>&#8249;</a>";
         }
         for ($i=0; $i<$tens; $i++){
            if ($i == $page-1){
               $pd .= "<span class='round selected-page'>".($i+1)."</span>";
            } else {
               $pd .= "<a href='/phpmotors/search/?action=result&page=".($i+1)."&str=$str' class='round'>".($i+1)."</a>";
            }
         }
         if ($page != $tens){
            $pd .= "<a href='/phpmotors/search/?action=result&page=".($page+1)."&str=$str' class='next round'>&#8250;</a>";
         }
         $pd .= '</div>';
      }
      return $pd;
   }

?>