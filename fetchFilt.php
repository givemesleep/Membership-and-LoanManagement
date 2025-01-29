<?php 
    require_once 'cruds/config.php';

    if($_POST["query"] != ''){
        $searchArr = explode(",", $_POST["query"]);
        $searchText = "'" . implode("','", $searchArr) . "'";
        // $sqlQuer="SELECT * FROM tbperinfo WHERE memStatus IN ?";
        $sqlQuer="SELECT
                        p.memberID AS ID, ms.memStats AS Statuses,
                        CONCAT(p.memSur,', ' ,p.memGiven, ' ', p.memMiddle,' ',IF(p.sufID = 0, ' ', sf.suffixes)) AS Fullname,
                        CONCAT(ai.addrinfo,', ', pr.provname,', ', c.cityname, ', Brgy. ', ai.brgy) AS Complete_ADDR,
                        p.memMob1 AS Mobile1, p.memMob2 AS Mobile2, p.memLan AS Landline
                        
                    FROM tbperinfo p
                    
                    JOIN tbmemstats ms ON p.memStatus = ms.memStatus
                    LEFT JOIN tbsuffixes sf ON p.sufID = sf.sufID
                    JOIN tbaddrinfo ai ON p.AddrID = ai.AddrID
                    LEFT JOIN tbprov pr ON ai.provID = pr.provID
                    LEFT JOIN tbcities c ON ai.cityID = c.cityID 
                    
                    WHERE p.memStatus IN ($searchText)
                    ORDER BY p.memSur ASC
        
        ";
        $dataQuer=array($searchText);
        $stmtQuer=$conn->prepare($sqlQuer);
        $stmtQuer->execute();

        $res=$stmtQuer->fetchAll();
        $row=$stmtQuer->rowCount();

        $tbl = '';

        if($row > 0){
            foreach($res as $data){
                $btn='
                    <a href=".php"><button class="btn btn-dark" title="View"><i class="ri-eye-fill"></i></button></a>
                    <a href=""><button class="btn btn-warning" title="Loan"><i class="bi bi-layer-forward"></i></button></a>
                    <a href="deposit_mem.php?='.$data['ID'].'"><button class="btn btn-success" title="Deposit"><i class="bi bi-layer-backward"></i></button></a>
                    ';
                $tbl.='
                    <tr>
                    
                    <td>'.$data['Fullname'].'</td>
                    <td>'.$data['Complete_ADDR'].'</td>
                    <td>'.'+63'.$data['Mobile1'].'</td>
                    <td>'.$btn.'</td>
                    </tr>
                ';
            }
        }

        echo $tbl;


    }

?>