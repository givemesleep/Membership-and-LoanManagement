<?php 

require_once '../cruds/config.php';

$reg = $prov = $cit = '';
// if(!empty($_POST['regID'])){
//     $reg = htmlspecialchars(trim($_POST['regID']));

//     $sqlreg = 

//     $sqlpro = "SELECT provID AS proID, provDesc AS prov, provCode FROM tbprovince WHERE regCode = ?";
//     $datapro = array($reg);
//     $stmtpro = $conn->prepare($sqlpro);
//     $stmtpro->execute($datapro);
//     if($stmtpro->rowCount() > 0){
//         echo '<option value="">Select Province</option>';
//         while($rowpro=$stmtpro->fetch()){
//             echo '<option value="'.$rowpro['provCode'].'">'.$rowpro['prov'].'</option>';
//         }
//     }else {
//         echo '<option value="">No Province</option>';
//     }
// }elseif(!empty($_POST['provID'])){
//     $prov = htmlspecialchars(trim($_POST['provID']));

//     $sqlcit = "SELECT citID, citymunDesc AS cit, provCode, citymunCode FROM tbmuni WHERE provCode = ? LIMIT 1000";
//     $datacit = array($prov);
//     $stmtcit = $conn->prepare($sqlcit);
//     $stmtcit->execute($datacit);
//     if($stmtcit->rowCount() > 0){
//         echo '<option value="">Select City</option>';
//         while($rowcit=$stmtcit->fetch()){
//             echo '<option value="'.$rowcit['citymunCode'].'">'.$rowcit['cit'].'</option>';
//         }
//     }else {
//         echo '<option value="">No City</option>';
//     }
// }elseif(!empty($_POST['citID'])){
//     $cit = htmlspecialchars(trim($_POST['citID']));

//     $sqlbg = "SELECT brgyID, brgyDesc AS brgy, citymunCode FROM tbbrgys WHERE citymunCode = ? LIMIT 1000";
//     $databg = array($cit);
//     $stmtbg = $conn->prepare($sqlbg);
//     $stmtbg->execute($databg);
//     if($stmtbg->rowCount() > 0){
//         echo '<option value="">Select Barangay</option>';
//         while($rowbg=$stmtbg->fetch()){
//             echo '<option value="'.$rowbg['brgyID'].'">'.$rowbg['brgy'].'</option>';
//         }
//     }else {
//         echo '<option value="">No Barangay</option>';
//     }
// }


if(!empty($_POST['regID'])){
    $reg = htmlspecialchars(trim($_POST['regID']));

    $sqlreg = "SELECT regDesc, regCode FROM tbreg WHERE regDesc = ?";
    $datareg = array($reg);
    $stmtreg = $conn->prepare($sqlreg);
    $stmtreg->execute($datareg);
    $rowreg = $stmtreg->fetch();
    $provID = $rowreg['regCode'];

    $sqlpro = "SELECT provDesc, regCode FROM tbprovince WHERE regCode = ?";
    $datapro = array($provID);
    $stmtpro = $conn->prepare($sqlpro);
    $stmtpro->execute($datapro);
    if($stmtpro->rowCount() > 0){
        echo '<option value="">Select Province</option>';
        while($rowpro=$stmtpro->fetch()){
            echo '<option value="'.$rowpro['provDesc'].'">'.$rowpro['provDesc'].'</option>';
        }
    }else {
        echo '<option value="">No Province</option>';
    }
}elseif(!empty($_POST['provID'])){
    $prov = htmlspecialchars(trim($_POST['provID']));

    $sqlpro = "SELECT provDesc, provCode FROM tbprovince WHERE provDesc = ?";
    $datareg = array($prov);
    $stmtpro = $conn->prepare($sqlpro);
    $stmtpro->execute($datareg);
    $rowpro = $stmtpro->fetch();
    $provID = $rowpro['provCode'];

    $sqlcit = "SELECT citymunDesc, provCode FROM tbmuni WHERE provCode = ? LIMIT 1000";
    $datacit = array($provID);
    $stmtcit = $conn->prepare($sqlcit);
    $stmtcit->execute($datacit);
    if($stmtcit->rowCount() > 0){
        echo '<option value="">Select City</option>';
        while($rowcit=$stmtcit->fetch()){
            echo '<option value="'.$rowcit['citymunDesc'].'">'.$rowcit['citymunDesc'].'</option>';
        }
    }else {
        echo '<option value="">No City</option>';
    }
}elseif(!empty($_POST['citID'])){
    $cit = htmlspecialchars(trim($_POST['citID']));

    $sqlcit = "SELECT citymunDesc, citymunCode FROM tbmuni WHERE citymunDesc = ? LIMIT 1000";
    $datacit = array($cit);
    $stmtcit = $conn->prepare($sqlcit);
    $stmtcit->execute($datacit);
    $rowcit = $stmtcit->fetch();
    $citID = $rowcit['citymunCode'];

    $sqlbg = "SELECT brgyDesc, citymunCode FROM tbbrgys WHERE citymunCode = ? LIMIT 1000";
    $databg = array($citID);
    $stmtbg = $conn->prepare($sqlbg);
    $stmtbg->execute($databg);
    if($stmtbg->rowCount() > 0){
        echo '<option value="">Select Barangay</option>';
        while($rowbg=$stmtbg->fetch()){
            echo '<option value="'.$rowbg['brgyDesc'].'">'.$rowbg['brgyDesc'].'</option>';
        }
    }else {
        echo '<option value="">No Barangay</option>';
    }
}

$high = '';
if(!empty($_POST['highID'])){
    $high = htmlspecialchars(trim($_POST['highID']));

    $sqlhigh = "SELECT edudescription, coursetype FROM tbeduclvl WHERE edudescription = ?";
    $datahigh = array($high);
    $stmthigh = $conn->prepare($sqlhigh);
    $stmthigh->execute($datahigh);
    $rowhigh = $stmthigh->fetch();
    $highID = $rowhigh['coursetype'];

    $sqlcourse = "SELECT courseDesc, coursetype FROM tbcourses WHERE coursetype = ?";
    $datacourse = array($highID);
    $stmtcourse = $conn->prepare($sqlcourse);
    $stmtcourse->execute($datacourse);
    if($stmtcourse->rowCount() > 0){
        echo '<option value="">Select Course</option>';
        while($rowcourse=$stmtcourse->fetch()){
            echo '<option value="'.$rowcourse['courseDesc'].'">'.$rowcourse['courseDesc'].'</option>';
        }
    }else{
        echo '<option value="N/A">No Programs</option>';
        }


}
?>