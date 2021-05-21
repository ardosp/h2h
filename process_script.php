<?php 
set_time_limit(6000);
require_once "../../../include/fungsi.php";
$action = $_POST['action'] ? $_POST['action'] : $_GET['action'];
$user_nik = $_SESSION['nik'];


switch ($action) {
    /** UPLOAD TXT */
    case "uploadFile":
        
        // print_r($_FILES);
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileError = $_FILES['file']['error'];
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);
        $file_basename = substr($fileName, 0, strripos($fileName, '.')); // strip extention
        $file_ext = substr($fileName, strripos($fileName, '.')); // strip name
        $namafolder="../../../storage/fileupload_pos/";

        $tglUpload = dateSQL($_POST['tglUpload']);
        $status = 0;
        $error = 0;

        if($fileError == UPLOAD_ERR_OK){ 
            //Processes your file here
            // echo 'file aman, bisa diupload';
            // $message = 'file aman, bisa diupload';

            if ($file_ext==".txt") { // MERUBAH NAMA
                $newfilename = $fileName;
                if (file_exists($namafolder . $newfilename)) { 
                    
                    $message = "FILE SUDAH ADA, Pilih File Lain"; 
                    $error++;
                } else {  
                    // if (move_uploaded_file($_FILES["file"]["tmp_name"], $namafolder . $newfilename)) {
                    //     echo 'berhasil';
                    // }
                    move_uploaded_file($_FILES["file"]["tmp_name"], $namafolder . $newfilename);
                    $dest = $namafolder. $newfilename;
                    $fp = fopen($dest, "r");
                    $data = fread($fp, filesize($dest));
                    fclose($fp);
                    $output = str_replace("\t|\t", "|", $data);
                    $output = explode("\n", $output);
                    // echo $dest;
                    // echo filesize($dest);
                    mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;");

                    //Open database
                    foreach($output as $var) 
                    {
                        $tmp = explode("|", $var);
                        $a1 = trim($tmp[0]);
                        $a2 = trim($tmp[1]);
                        $a3 = trim($tmp[2]);
                        $a4 = trim($tmp[3]);
                        $a5 = trim($tmp[4]);
                        $a6 = trim($tmp[5]);
                        $a7 = trim($tmp[6]);
                        $a8 = trim($tmp[7]);
                        $a9 = trim($tmp[8]);
                        $a10 = trim($tmp[9]);
                        $a11 = trim($tmp[10]);
                        $a12 = trim($tmp[11]);
                        $a13 = ltrim(trim($tmp[12]),"0");
                        $a14 = ltrim(trim($tmp[13]),"0");
                        
                        if($jum==0) {

                            // $sql03 = "INSERT into mafserverdb.financore.dbo.vatemprekon_tes (contractno, dueperiod_from, dueperiod_to, no_reff_sc, no_reff_ca, trx_date, admin_amount, principal_amount, due_amount, total_payment, upload_date, create_date, modify_date, modify_uid)
                            // values ('$a1','$a2','$a3','$a4','$a7','$a9',$a10,$a12,$a13,$a14, '$tglUpload', getDate(), getDate(), '$user_nik')";
                            // mssql_query($sql03); 

                            $query_insert = "exec mafserverdb.financore.dbo.insert_vatemprekon_tes '$a1','$a2','$a3','$a4','$a7','$a9',$a10,$a12,$a13,$a14, '$tglUpload', '$user_nik', '$a9'";
                            
                            // mssql_query($query_insert);
                            if (mssql_query($query_insert)) {
                                $query_result = "Insert Query Berhasil";
                            } else {
                                $query_result = "Gagal melakukan Insert Query!";
                            }

                            // mssql_query($query_insert) or die("Error Query [" . $query_insert . "]");

                            // echo $query_insert;
                        }
                    }
                    /**Hapus file */
                    // unlink($namafolder.$newfilename);


                    mssql_query("SET ANSI_NULLS OFF; SET ANSI_WARNINGS OFF;");

                    $message = "File berhasil di Upload";
                    $status = 1;
                }
            } 
            else {  
                $message = "ERROR FILETYPE. File yang diperbolehkan hanya type .txt";
                $error++;
            }

            echo json_encode(array(
                'error' => $error,
                'status' => $status,
                'message' => $message,
                'query' => $query_result
            ));


        } else {
            switch($fileError){
                case UPLOAD_ERR_INI_SIZE:   
                    $message = 'Error when trying to upload a file that exceeds the allowed size.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:  
                    $message = 'Error when trying to upload a file that exceeds the allowed size.';
                    break;
                case UPLOAD_ERR_PARTIAL:    
                    $message = 'Error: uploading the file did not finish.';
                    break;
                case UPLOAD_ERR_NO_FILE:    
                    $message = 'Error: no file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR: 
                    $message = 'Error: server not configured for file upload.';
                    break;
                case UPLOAD_ERR_CANT_WRITE: 
                    $message= 'Error: possible failure to save file.';
                    break;
                case  UPLOAD_ERR_EXTENSION: 
                    $message = 'Error: file upload not completed.';
                    break;
                default: $message = 'Error: file upload not completed.';
                        break;
            }
            echo json_encode(array(
                // 'error' => true,
                'error' => $error,
                'status' => $status,
                'message' => $message,
                'query' => $query_result
            ));
        }
        break;

    /** CARI REKON */
    case 'cari.rekon.h2h':
        $tgl_rekon = dateSQL($_POST['tgl_rekon']);
        $tgl_rekon_end = dateSQL($_POST['tgl_rekon_end']);
        $delchannel = $_POST['delchannel'];

        mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;");

        $sql = "SELECT * from mafserverdb.financore.dbo.v_VATempRekon_new where upload_date between '$tgl_rekon' and '$tgl_rekon_end' and delchannel='$delchannel'";
        $exec = mssql_query($sql)or die ("Error Query [".$sql."]");
        $numbRows = mssql_num_rows($exec);
        // echo $sql;

        mssql_query("SET ANSI_NULLS OFF; SET ANSI_WARNINGS OFF;");
        $count_a = 1;
        $row = array();
        while($hsl = mssql_fetch_assoc($exec)){
            $col = array();
            $col['no'] = $count_a;
            $col['delchannel']          = $hsl['DelChannel'];
            $col['trx_date']            = dateSQLKaco($hsl['trx_date']);
            $col['IntReff']             = $hsl['IntReff'];
            $col['ExtReff']             = $hsl['ExtReff'];
            $col['contractno']          = $hsl['contractno'];
            $col['payment_amount']      = $hsl['payment_amount'];
            $col['rekon_amount']        = $hsl['rekon_amount'];
            $col['Payment_Status']      = $hsl['Payment_Status'];
            $col['reconcile_status']    = $hsl['reconcile_status'];
            $col['upload_date']         = dateSQLKaco($hsl['upload_date']);
            $col['PostedDate']          = dateSQLKaco($hsl['PostedDate']);
            $col['TraceNo']             = $hsl['TraceNo'];
            array_push($row,$col);
            $count_a++;
        }
        $jsonRow = json_encode($row);
        
        echo $jsonRow;

        break;

    /** */
    /** REKON H2H */
    /** */
    case "submit_rekon":
        // echo 'tes';
        $checkAmount = $_POST['checkAmount'];
        // $delchannel = $_POST['delchannel'];

        $array_release=array();
        foreach($checkAmount as $requestID => $customerNumber){
            
            $pecah = (explode(":",$requestID));
            $traceno = $pecah[0];
            $noreknopin = $pecah[1];
            $delchannel = $pecah[2];
            // echo $requestID;

            $array_release[] = array(
                // "query" => "bni_release_reconcile '$tgl_apldate','$custcode','$traceno','H2H'"
                "query" => "mafserverdb.financore.dbo.VATempRekonApproveUpload_sismaf '$delchannel','$noreknopin','$traceno','$user_nik',0"
                
            );

        }
        // print_r($array_release);
        $i = 0;
        $gagal = 0;

        while(count($array_release) > $i){
            mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;");
            $sql = "exec ".$array_release[$i]['query'];
            $exec = mssql_query($sql);
            mssql_query("SET ANSI_NULLS OFF; SET ANSI_WARNINGS OFF;");
            // echo $sql;

            if(!$exec){
                $i=count($array_release);
                $gagal++;
            }
            $i++;   
        }
        

        echo json_encode(array(
            'error' => $gagal,
            'success' => $i
        ));


        break;
    /** */
    /** RELEASE H2H */
    /** */
    case "submit_release":
        $sql_apldate = "select apldate from maf_apldate with(nolock)";
        $exec_apldate = mssql_query($sql_apldate);
        $data_apldate = mssql_fetch_assoc($exec_apldate);
        $tgl_apldate = dateSQL(dateSQLKaco($data_apldate['apldate']));
        
        $checkAmount = $_POST['checkAmount'];

        $array_release=array();
        foreach($checkAmount as $requestID => $customerNumber){
            
            $pecah = (explode(":",$requestID));
            $traceno = $pecah[0];
            $noreknopin = $pecah[1];
            $delchannel = $pecah[2];
            // echo $requestID;

            $array_release[] = array(
                
                "query" => "mafserverdb.financore.dbo.h2h_release_reconcile_sismaf '$delchannel','$tgl_apldate','$noreknopin','$traceno','$user_nik'"
                // exec h2h_release_reconcile '0000001','2020-05-17','0012051648002','162061725101039934','H2H'

                // exec h2h_release_reconcile '$channelid','$apldate','$contractno','$traceno','$userid'
            );

        }
        // print_r($array_release);
        $i = 0;
        $gagal = 0;

        while(count($array_release) > $i){
            mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;");
            // mssql_query("set XACT_ABORT ON");
            $sql = "exec ".$array_release[$i]['query'];
            $exec = mssql_query($sql);
            mssql_query("SET ANSI_NULLS OFF; SET ANSI_WARNINGS OFF;");
            // mssql_query("set XACT_ABORT OFF");

            // echo $sql;

            if(!$exec){
                $i=count($array_release);
                $gagal++;
            }
            $i++;   
        }
        

        echo json_encode(array(
            'error' => $gagal,
            'success' => $i
        ));


        break;
    /**
    /**
    /** */
    case "submit_rekon_x":
        $sql_apldate = "select apldate from maf_apldate with(nolock)";
        $exec_apldate = mssql_query($sql_apldate);
        $data_apldate = mssql_fetch_assoc($exec_apldate);

        $checkAmount = $_POST['checkAmount'];
        $tgl_apldate = dateSQL(dateSQLKaco($data_apldate['apldate']));
        $delchannel = $_POST['delchannel'];
        

        $array_release=array();
        foreach($checkAmount as $requestID => $customerNumber){
            
            $pecah = (explode(":",$requestID));
            $traceno = $pecah[0];
            $noreknopin = $pecah[1];
            // echo $requestID;

            $array_release[] = array(
                // "query" => "bni_release_reconcile '$tgl_apldate','$custcode','$traceno','H2H'"
                "query" => "mafserverdb.financore.dbo.VATempRekonApproveUpload_sismaf '$delchannel','$noreknopin','$traceno','$user_nik',0"
                
            );

        }
        print_r($array_release);
        $i = 0;
        $gagal = 0;
        // print_r($array_release[0]['query']);
        // echo count($array_release);

        while(count($array_release) > $i){
            mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;");
            $sql = "exec ".$array_release[$i]['query'];
            // $exec = mssql_query($sql);
            mssql_query("SET ANSI_NULLS OFF; SET ANSI_WARNINGS OFF;");
            echo $sql;

            if(!$exec){
                $i=count($array_release);
                $gagal++;
            }
            $i++;   
        }
        
        // alert("Sukses : ".$i.". Gagal : ".$gagal);
        // redirMeta("../../../isi.php?pid=1373");
        
        break;

}



?>
  

