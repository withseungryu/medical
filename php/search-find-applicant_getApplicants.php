<?php
//Using filter_input(INPUT_POST, ..) filters '
require_once './dbcontroller.php';

//Create connection
$conn = new DBController();


$sql = "SELECT a.ApplicantID, a.fkPersonID, a.ApplicantStatus, a.fkSiteID,
               p.PSalutation, p.PersonFN, p.PersonLN, p.PersonMN, p.PersonGenQual, p.PCity, p.PCounty, p.PDOB, p.PRegion
        FROM tblApplicants a, tblAppPeople p
        WHERE p.PersonID = a.fkPersonID";

if(isset($_POST['ApplicantStatus'])) {
    $ApplicantStatus=  $conn->sanitize($_POST['ApplicantStatus']);

    $sql = "$sql AND ApplicantStatus = '$ApplicantStatus'";
}
if(isset($_POST['PCounty'])) {
    $PCounty=  $conn->sanitize($_POST['PCounty']);

    if($PCounty!="") {
        $sql = "$sql AND p.PCounty LIKE '%$PCounty%'";
    }
}
if(isset($_POST['PCity'])) {
    $PCity=  $conn->sanitize($_POST['PCity']);

    if($PCity!="") {
        $sql = "$sql AND p.PCity LIKE '%$PCity%'";
    }
}
if(isset($_POST['PersonFN'])) {
    $PersonFN=  $conn->sanitize($_POST['PersonFN']);

    if($PersonFN!="") {
        $sql = "$sql AND p.PersonFN LIKE '%$PersonFN%'";
    }
}
if(isset($_POST['PersonLN'])) {
    $PersonLN=  $conn->sanitize($_POST['PersonLN']);

    if($PersonLN!="") {
        $sql = "$sql AND p.PersonLN LIKE '%$PersonLN%'";
    }
}

if(isset($_POST['PSite'])) {
    $siteID=  $conn->sanitize($_POST['PSite']);

    if($siteID!="") {
        $sql = "$sql AND a.fkSiteID LIKE '%$siteID%'";
    }
}

if(isset($_POST['PRegion'])) {
    $PRegion=  $conn->sanitize($_POST['PRegion']);
    if($PRegion!="") {
        $sql = "$sql AND p.PRegion = $PRegion";
    }
}

$data = array();

$result = $conn->runSelectQuery($sql);
if ($result->num_rows > 0) {

    //Loop for each applicant -- remove null values
    while ($row = $result->fetch_assoc()) {
        $ApplicantID = $row['ApplicantID'];
        $fkPersonID = $row['fkPersonID'];
        $county = $row['PCounty'];
        foreach ($row as $key=>$value) {
            if ($value == null) {
                $row[$key] = "";
            }
        }

        $data[] = $row;
    }
}

echo json_encode($data);
?>
