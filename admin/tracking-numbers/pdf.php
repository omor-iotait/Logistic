<?php
require_once("../../includes/configure.php");
include(ROOT_PATH . "includes/db.php");
include(ROOT_PATH . "classes/Session.php");
Session::checkSession();
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy();
}
$title = "Tracking Number View | Admin";
$tracking_number = $_GET['tracking_number'];
$query_track = "select * from tracking_numbers where tracking_number='$tracking_number' LIMIT 1";
$result_track = mysqli_query($con, $query_track);
$row_track = mysqli_fetch_assoc($result_track);
$prefix_id = $row_track['station_prefix_id'];
$query_prefix = "select * from station_prefix where id='$prefix_id' LIMIT 1";
$result_prefix = mysqli_query($con, $query_prefix);
$row_prefix = mysqli_fetch_assoc($result_prefix);
$station_id = $row_prefix['station_id'];
$query_station = "select * from stations where id='$station_id' LIMIT 1";
$result_station = mysqli_query($con, $query_station);
$row_station = mysqli_fetch_assoc($result_station);
$sender_id = $row_track['sender_id'];
$query_sender = "select * from customers where id='$sender_id' LIMIT 1";
$result_sender = mysqli_query($con, $query_sender);
$row_sender = mysqli_fetch_assoc($result_sender);
$receiver_id = $row_track['receiver_id'];
$query_receiver = "select * from customers where id='$receiver_id' LIMIT 1";
$result_receiver = mysqli_query($con, $query_receiver);
$row_receiver = mysqli_fetch_assoc($result_receiver);

require_once '../../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$html='<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>


<body>
<table border="1" cellspacing="0" cellpadding="0" width="661" id="printablessArea">
    <tbody>
    <tr>
        <td width="48" rowspan="2" valign="top">1
        </td>
        <td width="217" rowspan="2" valign="top">Account Number
        </td>
        <td width="77" colspan="2" rowspan="2" valign="top">
        </td>
        <td width="187" colspan="2" rowspan="2" valign="top">Tracking Number
        </td>
        <td width="132" colspan="3" valign="top">Customer reference
        </td>
        <td width="0" height="26">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">
        </td>
        <td width="0" height="30">
        </td>
    </tr>
    <tr>
        <td width="48" rowspan="4" valign="top">
         '.$row_station['name'].'
        </td>
        <td width="217" rowspan="4" valign="top">
        '.$row_station['primary_email'].'<br>
        '.$row_station['contact_number'].'<br>
        '.$row_station['address'].'<br>
        '.$row_station['city'].','.$row_station['state'].','.$row_station['post_code'].'<br>
        '.$row_station['country'].'
        </td>
        <td width="16" valign="top">2
        </td>
        <td width="249" colspan="3" rowspan="5" valign="top">lorem ipsum
        </td>
        <td width="20" colspan="2" valign="top">4
        </td>
        <td width="112" valign="top">service type
        </td>
        <td width="0" height="26">
        </td>
    </tr>
    <tr>
        <td width="16" rowspan="4" valign="top">consign
        </td>
        <td width="132" colspan="3" valign="top">E parcel
        </td>
        <td width="0" height="35">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">importance
        </td>
        <td width="0" height="37">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" rowspan="2" valign="top">Full description of content: Document
        </td>
        <td width="0" height="19">
        </td>
    </tr>
    <tr>
        <td width="48" valign="top">3
        </td>
        <td width="217" valign="top">senders authorization and signature
        </td>
        <td width="0" height="28">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="2" rowspan="3" valign="top"><br>Sender\'s Signature
        <br>
        <br>
        <br>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         Date: '.date('d M Y',$row_track['date_stamp']).'
        </td>
        <td width="124" colspan="3" valign="top">Customs duties
        </td>
        <td width="140" valign="top">Declared values for customs
        </td>
        <td width="132" colspan="3" valign="top">Special instructors
        </td>
        <td width="0" height="57">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="4" rowspan="6" valign="top">
        <br>
        <img src="barcode.php?codetype=Code39&size=100&text='.$tracking_number.'&print=true">
        </td>
        <td width="16" valign="top">5
        </td>
        <td width="116" colspan="2" valign="top">size weight
        </td>
        <td width="0" height="23">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">No. of pieces:
        </td>
        <td width="0" height="30">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="2" rowspan="2" valign="top">Proof of deliveries
        </td>
        <td width="132" colspan="3" valign="top">Weight:
        </td>
        <td width="0" height="35">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" rowspan="2" valign="top">Dimensions
        </td>
        <td width="0" height="32">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="2" rowspan="2" valign="top">Recievers signatures
        <br>
        <br>
        <br>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         Date:  &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
        </td>
        <td width="0" height="27">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">Volumetric and charged weight
        </td>
        <td width="0" height="66">
        </td>
    </tr>
    <tr height="0">
        <td width="48">
        </td>
        <td width="217">
        </td>
        <td width="16">
        </td>
        <td width="62">
        </td>
        <td width="47">
        </td>
        <td width="140">
        </td>
        <td width="16">
        </td>
        <td width="4">
        </td>
        <td width="112">
        </td>
        <td width="0">
        </td>
    </tr>
    </tbody>
</table>
<br>
<table border="1" cellspacing="0" cellpadding="0" width="661" id="printablessArea">
    <tbody>
    <tr>
        <td width="48" rowspan="2" valign="top">1
        </td>
        <td width="217" rowspan="2" valign="top">Account Number
        </td>
        <td width="77" colspan="2" rowspan="2" valign="top">
        </td>
        <td width="187" colspan="2" rowspan="2" valign="top">Tracking Number
        </td>
        <td width="132" colspan="3" valign="top">Customer reference
        </td>
        <td width="0" height="26">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">
        </td>
        <td width="0" height="30">
        </td>
    </tr>
    <tr>
        <td width="48" rowspan="4" valign="top">
         '.$row_station['name'].'
        </td>
        <td width="217" rowspan="4" valign="top">
        '.$row_station['primary_email'].'<br>
        '.$row_station['contact_number'].'<br>
        '.$row_station['address'].'<br>
        '.$row_station['city'].','.$row_station['state'].','.$row_station['post_code'].'<br>
        '.$row_station['country'].'
        </td>
        <td width="16" valign="top">2
        </td>
        <td width="249" colspan="3" rowspan="5" valign="top">lorem ipsum
        </td>
        <td width="20" colspan="2" valign="top">4
        </td>
        <td width="112" valign="top">service type
        </td>
        <td width="0" height="26">
        </td>
    </tr>
    <tr>
        <td width="16" rowspan="4" valign="top">consign
        </td>
        <td width="132" colspan="3" valign="top">E parcel
        </td>
        <td width="0" height="35">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">importance
        </td>
        <td width="0" height="37">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" rowspan="2" valign="top">Full description of content: Document
        </td>
        <td width="0" height="19">
        </td>
    </tr>
    <tr>
        <td width="48" valign="top">3
        </td>
        <td width="217" valign="top">senders authorization and signature
        </td>
        <td width="0" height="28">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="2" rowspan="3" valign="top"><br>Sender\'s Signature
        <br>
        <br>
        <br>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         Date: '.date('d M Y',$row_track['date_stamp']).'
        </td>
        <td width="124" colspan="3" valign="top">Customs duties
        </td>
        <td width="140" valign="top">Declared values for customs
        </td>
        <td width="132" colspan="3" valign="top">Special instructors
        </td>
        <td width="0" height="57">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="4" rowspan="6" valign="top">
        <br>
        <img src="barcode.php?codetype=Code39&size=100&text='.$tracking_number.'&print=true">
        </td>
        <td width="16" valign="top">5
        </td>
        <td width="116" colspan="2" valign="top">size weight
        </td>
        <td width="0" height="23">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">No. of pieces:
        </td>
        <td width="0" height="30">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="2" rowspan="2" valign="top">Proof of deliveries
        </td>
        <td width="132" colspan="3" valign="top">Weight:
        </td>
        <td width="0" height="35">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" rowspan="2" valign="top">Dimensions
        </td>
        <td width="0" height="32">
        </td>
    </tr>
    <tr>
        <td width="264" colspan="2" rowspan="2" valign="top">Recievers signatures
        <br>
        <br>
        <br>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         Date:  &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/
        </td>
        <td width="0" height="27">
        </td>
    </tr>
    <tr>
        <td width="132" colspan="3" valign="top">Volumetric and charged weight
        </td>
        <td width="0" height="66">
        </td>
    </tr>
    <tr height="0">
        <td width="48">
        </td>
        <td width="217">
        </td>
        <td width="16">
        </td>
        <td width="62">
        </td>
        <td width="47">
        </td>
        <td width="140">
        </td>
        <td width="16">
        </td>
        <td width="4">
        </td>
        <td width="112">
        </td>
        <td width="0">
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output();
?>



