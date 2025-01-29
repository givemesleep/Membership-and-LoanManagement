<?php
    require_once '../cruds/config.php';
    session_start();

    // $memid = strip_tags($_POST['memid']);

    $lname=strtoupper(strip_tags($_POST['surname']));
    $given=strtoupper(strip_tags($_POST['givenname']));
    $middle=strtoupper(strip_tags($_POST['middle']));
    // $suffix=strip_tags($_POST['suffix']);

    if(isset($_POST['suffix']) == ""){
        $suffix = " ";
    }else{
        $suffix = $_POST['suffix'];
    }

    $nick=strip_tags($_POST['nickname']);
    $DOB=strip_tags($_POST['DOB']);
    $marit=strip_tags($_POST['cboMarital']);
    $sex=strip_tags($_POST['cboSex']);
    $high=strip_tags($_POST['cboHighest']);
    $sch=strip_tags($_POST['cboSchool']);
    $cour=strip_tags($_POST['cboCourse']);
    
    $addr=strip_tags($_POST['addr']);
    $prov=strip_tags($_POST['cboProv']);
    $cit=strip_tags($_POST['cboCity']);
    $brgy=strip_tags($_POST['brgy']);
    $mob1=strip_tags($_POST['mob1']);
    $mob2=strip_tags($_POST['mob2']);
    $land=strip_tags($_POST['landline']);
    $email=strip_tags($_POST['emailaddress']);
    $bname=strip_tags($_POST['busname']);
    $baddr=strip_tags($_POST['busaddr']);
    // $bcity=strip_tags($_POST['buscity']);

    if(isset($_POST['buscity']) == ""){
        $bcity = " ";
    }else{
        $bcity = $_POST['buscity'];
    }

    $company=strip_tags($_POST['company']);
    $occu=strip_tags($_POST['occupation']);

    $ben1=strip_tags($_POST['ben1']);
    $dob1=strip_tags($_POST['dob1']);
    $rels1=strip_tags($_POST['rels1']);
    $benmob1=strip_tags($_POST['benmob1']);

    $ben2=strip_tags($_POST['ben2']);
    $dob2=strip_tags($_POST['dob2']);
    // $rels2=strip_tags($_POST['rels2']);

    if(isset($_POST['rels2']) == ""){
        $rels2 = " ";
    }else{
        $rels2 = $_POST['rels2'];
    }

    $benmob2=strip_tags($_POST['benmob2']);
    
    $ben3=strip_tags($_POST['ben3']);
    $dob3=strip_tags($_POST['dob3']);
    // $rels3=strip_tags($_POST['rels3']);

    if(isset($_POST['rels3']) == ""){
        $rels3 = " ";
    }else{
        $rels3 = $_POST['rels3'];
    }

    $benmob3=strip_tags($_POST['benmob3']);
    
    $sss=strip_tags($_POST['sss']);
    $tin=strip_tags($_POST['tin']);
    // $cboID=strip_tags($_POST['cboID']);

    if(isset($_POST['cboID']) == ""){
        $cboID = " ";
    }else{
        $cboID = $_POST['cboID'];
    }

    $othID=strip_tags($_POST['othID']);
    $Resi=strip_tags($_POST['cboResi']);
    $ResiID=strip_tags($_POST['cboResiID']);
    $resyr=strip_tags($_POST['resyear']);
    $monthly=strip_tags($_POST['monthly']);
    $soc=strip_tags($_POST['soc']);
    $hob=strip_tags($_POST['hob']);
    $coop=strip_tags($_POST['coop']);
    $SchedPmes=strip_tags($_POST['schedPMES']);

    try{
        $sqlchecker="SELECT * FROM tbperinfo WHERE memSur=? AND memGiven=? AND memMiddle=? AND sufID=?";
        $datachecker=array(
            $lname, $given, $middle, $suffix
        );
        $stmtcheck=$conn->prepare($sqlchecker);
        $stmtcheck->execute($datachecker);

        if($stmtcheck->rowCount() > 0){
            $_SESSION['memExist'] = 'Member Exist!';
            header('location: ../applicant_pendings.php');
        }else{
                //Insert Into

            $sqlPer="INSERT INTO tbperinfo(memStatus, memSur, memGiven, memMiddle, sufID, memNick, AddrID, maritID, gendID, memDOB, EducID, memLan, memMob1, memMob2, memEmail, ApplicationDate, Score)
            VALUES(5, ?, ?, ?, ?, ?, 0, ?, ?, ?, 0, ?, ?, ?, ?, ?, 0)";
            $dataPer=array(
                $lname, $given, $middle, $suffix, $nick,
                $marit, $sex, $DOB, $land, $mob1, $mob2, $email,
                $SchedPmes
            );
            $stmtPer=$conn->prepare($sqlPer);
            $stmtPer->execute($dataPer);//

            $sqlAddr="INSERT INTO tbaddrinfo(memberID, addrinfo, provID, cityID, brgy)
            VALUES(0, ?, ?, ?, ?)";
            $dataAddr=array(
                $addr, $prov, $cit, $brgy
            );
            $stmtAddr=$conn->prepare($sqlAddr);
            $stmtAddr->execute($dataAddr);//

            $sqlEduc="INSERT INTO tbeducinfo(memberID, edulvlID, eduCourID, schlName)
            VALUES(0, ?, ?, ?)";
            $dataEduc=array(
                $high, $cour, $sch
            );
            $stmtEduc=$conn->prepare($sqlEduc);
            $stmtEduc->execute($dataEduc);//

            $sqlWork="INSERT INTO tboccuinfo(memberID, memBusiness, BusinAddr, cityID, memOccu, memCompName, monthlyID)
            VALUES(0, ?, ?, ?, ?, ?, ?)";
            $dataWork=array(
                $bname, $baddr, $bcity, $occu, $company, $monthly
            );
            $stmtWork=$conn->prepare($sqlWork);
            $stmtWork->execute($dataWork);//

            $sqlBen1="INSERT INTO tbbeninfo1(memberID, benFname1, benBdate1, RelsID, benNumber1)
            VALUES(0, ?, ?, ?, ?)";
            $dataBen1=array(
                $ben1, $dob1, $rels1, $benmob1
            );
            $stmtBen1=$conn->prepare($sqlBen1);
            $stmtBen1->execute($dataBen1);//

            $sqlBen2="INSERT INTO tbbeninfo2(memberID, benFname2, benBdate2, RelsID, benNumber2)
            VALUES(0, ?, ?, ?, ?)";
            $dataBen2=array(
                $ben2, $dob2, $rels2, $benmob2
            );
            $stmtBen2=$conn->prepare($sqlBen2);
            $stmtBen2->execute($dataBen2);//

            $sqlBen3="INSERT INTO tbbeninfo3(memberID, benFname3, benBdate3, RelsID, benNumber3)
            VALUES(0, ?, ?, ?, ?)";
            $dataBen3=array(
                $ben3, $dob3, $rels3, $benmob3
            );
            $stmtBen3=$conn->prepare($sqlBen3);
            $stmtBen3->execute($dataBen3);//

            $sqlIDs="INSERT INTO tbidinfo(memberID, SSSno, taxIdenNo, idTypesID, idTypeNo)
            VALUES(0, ?, ?, ?, ?)";
            $dataIDs=array(
                $sss, $tin, $cboID, $othID
            );
            $stmtIDs=$conn->prepare($sqlIDs);
            $stmtIDs->execute($dataIDs);//

            $sqlOth="INSERT INTO tbotherinfo(memberID, resID, othInfoID, yearStay, socint, hobbies, coop)
            VALUES(0, ?, ?, ?, ?, ?, ?)";
            $dataOth=array(
                $Resi, $ResiID, $resyr, $soc, $hob, $coop
            );
            $stmtOth=$conn->prepare($sqlOth);
            $stmtOth->execute($dataOth);//

            //Update ID 
            $sqlPerID="UPDATE tbperinfo SET AddrID = memberID, EducID = memberID";
            $stmtPerID=$conn->prepare($sqlPerID);
            $stmtPerID->execute();//

            $sqlAddrID="UPDATE tbaddrinfo SET memberID = AddrID";
            $stmtAddrID=$conn->prepare($sqlAddrID);
            $stmtAddrID->execute();//

            $sqlEducID="UPDATE tbeducinfo SET memberID = EducID";
            $stmtEducID=$conn->prepare($sqlEducID);
            $stmtEducID->execute();//

            $sqlWorkID="UPDATE tboccuinfo SET memberID = memOccuID";
            $stmtWorkID=$conn->prepare($sqlWorkID);
            $stmtWorkID->execute();//

            $sqlBen1ID="UPDATE tbbeninfo1 SET memberID = benefID1";
            $stmtBen1ID=$conn->prepare($sqlBen1ID);
            $stmtBen1ID->execute();//

            $sqlBen2ID="UPDATE tbbeninfo2 SET memberID = benefID2";
            $stmtBen2ID=$conn->prepare($sqlBen2ID);
            $stmtBen2ID->execute();//

            $sqlBen3ID="UPDATE tbbeninfo3 SET memberID = benefID3";
            $stmtBen3ID=$conn->prepare($sqlBen3ID);
            $stmtBen3ID->execute();//

            $sqlidsID="UPDATE tbidinfo SET memberID = memidsID";
            $stmtidsID=$conn->prepare($sqlidsID);
            $stmtidsID->execute();//

            $sqlOthID="UPDATE tbotherinfo SET memberID = othID";
            $stmtOthID=$conn->prepare($sqlOthID);
            $stmtOthID->execute();//            

            }
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    if($stmtPer && $stmtAddr && $stmtEduc && $stmtWork && $stmtBen1 && $stmtBen2 && $stmtBen3 && $stmtIDs && $stmtOth
        && $stmtPerID && $stmtAddrID && $stmtEducID && $stmtWorkID && $stmtBen1ID && $stmtBen2ID && $stmtBen3ID && $stmtidsID && $stmtOthID){
            $_SESSION['memAdded'] = 'Member Added!';
            header('location: ../applicant_pendings.php');
    }else{
        $_SESSION['memFailed'] = "Error Adding New Member!";
    }
?>