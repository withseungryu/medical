<?php
require_once './dbcontroller.php';
$conn = new DBController();

// $fkFormID = $_POST['fkFormID'];
// $SourceFileName = $_POST['SourceFileName'];
// $Note = $_POST['Note'];
// $FilePath = $_POST['FilePath'];

// echo($fkFormID);

// $sql="INSERT INTO tblFormAttachments(fkFormID, SourceFileName, Note, FilePath) VALUES ('$fkFormID' ,'$SourceFileName', '$Note', '$FilePath')";

// $result = $conn->runSelectQuery($sql);
// $data = array();

// if ($result->num_rows > 0) {

//     while ($row = $result->fetch_assoc()) {

//         $data[] = $row;
//     }
// }

if(!empty($_FILES)){
    echo("gi");
    $path = './upload/' . $_FILES['file']['name'];
    $FilePath = $_FILES['file']['name'];
    $fkFormID = $_POST['fkFormID'];
    $SourceFileName = $_POST['SourceFileName'];
    $Note = $_POST['Note'];
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
        $sql="INSERT INTO tblFormAttachments(fkFormID, SourceFileName, Note, FilePath) VALUES ('$fkFormID' ,'$SourceFileName', '$Note','/upload/$FilePath')";
        $result = $conn->runSelectQuery($sql);
        $data = array();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

            $data[] = $row;
            }
        }
        
    }    
}   

?>