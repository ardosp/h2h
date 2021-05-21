<?php
  $sql_01="SELECT min(txndate)txndate FROM payment_bca_paid where ISNULL(Status,0)=0";
  $exec_01=mssql_query($sql_01);
  $res_01=mssql_fetch_assoc($exec_01);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!--title>.: Sistem Informasi MAF :.</title-->

    <link href="<?php echo HOSTNAME();?>/css/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <script src="<?php echo HOSTNAME();?>/css/bootstrap/js/jquery.min.js"></script>
    <script src="<?php echo HOSTNAME();?>/css/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME();?>/js/jquery-ui-1.8.16.custom.min.js"></script>

    <script type="text/javascript" src="<?php echo HOSTNAME();?>/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME();?>/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/css/bootstrap/bootstrap.min.js"></script>

    <link rel="stylesheet" href="<?php echo HOSTNAME(); ?>/css/bootstrap/bootstrap.min.css">    

    <!-- HoldOn loading animation -->
    <link rel="stylesheet" href="<?php echo HOSTNAME(); ?>/css/HoldOn.min.css">
    <script type="text/javascript" src="<?php echo HOSTNAME(); ?>/css/HoldOn.min.js"></script>

    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="<?php echo hostname(); ?>/plugins/sweetalert/sweetalert2.css">
    <script type="text/javascript" src="<?php echo hostname(); ?>/plugins/sweetalert/sweetalert.min.js"></script>
    
    <style media="screen">
      body{
        font-size: 11px;
        font-family: Arial;
      }
      .ui-datepicker-header, .ui-widget-header{
        color: rgb(37,37,37);
      }
      #top-table tr td{
        padding: 2px 3px;
      }
      #data-table thead tr th{
        background-color: rgb(69,107,119);
        color: #fff;
        text-align: center
      }
      #data-table tbody tr:nth-child(even){
        background-color: rgb(240,240,240);
      }
      #data-table tbody tr:hover{
        background-color: rgb(255,252,204);
      }
      .logo-bank{
        width: 100px;
      }
      
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
          var d = new Date();
          var curr_year = d.getFullYear(); 
          $("#tgl_transfer,#tgl_transfer_end").datepicker({
            dateFormat  : 'dd/mm/yy',
            yearRange   : '1900:'+curr_year,
            changeMonth : true,
            changeYear  : true
            // minDate: 0,
            // maxDate: '+30Y'
          }); 
          
          
          
        });

        var array = new Array();
        /* Mengambil tanggal untuk parameter penarikan report */
        function getPayVA(){ 
          // location.reload();
            array = [];
            var tgl_transfer = $("input[name=tgl_transfer]").val();
            var tgl_transfer_end = $("input[name='tgl_transfer_end']").val();
            if(tgl_transfer=="" || tgl_transfer_end==""){
                alert("Tanggal tidak boleh kosong")
            } else {
              $.ajax({
                queue: true,
                cache: false,
                //dataType:"json",
                type: 'POST',
                url: 'module/payment/bcava/action_api.php',
                data: {
                  'action':'getpayva.vabca',
                  'tgl_transfer':tgl_transfer,
                  'tgl_transfer_end':tgl_transfer_end
                },
                beforeSend:function(){
                    //console.log("beforeSend")
                    HoldOn.open({
                        theme: "sk-dot",
                        message: "PLEASE WAIT... ",
                        backgroundColor: "#fcf7f7",
                        textColor: "#000"
                    });
                },
                success: function(response) {
                    //console.log("response : "+response) 
                    spcData = $("table#data-table > tbody:last-child");
                    spcData.children("tr").remove();
                    respParse = parseJson(response);  
                    if(respParse.status_code==1){
                        resObj = respParse.results;
                        var no=1;
                        for (i = 0; i < resObj.length; i++) {
                            markup = "<tr>"+
                                        "<td style=\"text-align: center;\">"+no+"</td>"+
                                        "<td style=\"text-align: center;\">"+resObj[i].trxdate+"</td>"+
                                        "<td style=\"text-align: center;\">"+resObj[i].payment_date+"</td>"+
                                        "<td style=\"text-align: center;\">"+resObj[i].vano+"</td>"+
                                        "<td>"+resObj[i].nama+"</td>"+
                                        "<td style=\"text-align: right;\">"+parseInt(resObj[i].amount).toLocaleString()+"</td>"+
                                        "<td style=\"text-align: right;\">"+parseInt(resObj[i].angsuranround).toLocaleString()+"</td>"+
                                        "<td style=\"text-align: right;\">"+parseInt(resObj[i].amount-resObj[i].angsuranround).toLocaleString()+"</td>"+
                                        "<td>"+resObj[i].keterangan+"</td>"+
                                        "<td>"+resObj[i].traceno+"</td>"+
                                        "<td>"+resObj[i].delchannel+"</td>"+                                
                                        "</tr>";
                            spcData.append(markup);
                            data_arr = [
                              resObj[i].traceno,
                              resObj[i].vano,
                              resObj[i].trxdate
                            ];
                            /* ngepush data ke array */
                            array.push(data_arr);
                            data_arr=[];
                            no++;
                        }
                    }else{
                        swal({
                          title:"Sukses",
                          text: respParse.status_desc,
                          icon: "warning"
                        }).then(function(){                          
                          document.getElementById("trf_post_klik").disabled = true;
                        });   
                    }
                    HoldOn.close();
                    if(resObj.length > 0){
                        document.getElementById("trf_post_klik").disabled = false;
                    }
                }
              });
            }
        }
        /** */
        function getDoPaidFin(){ 
          console.log(array);
            var tgl_transfer = $("input[name=tgl_transfer]").val();
            var tgl_transfer_end = $("input[name='tgl_transfer_end']").val();

            if(tgl_transfer=="" || tgl_transfer_end==""){
                alert("Tanggal tidak boleh kosong");
            }else{
                swal({
                  icon: 'warning',
                  title: 'Apakah anda yakin?',
                  text: "Anda akan meneruskan proses pembayaran dari VA BCA ke Financore.",
                  buttons: {
                    cancel: {text: "Tidak", visible: true},
                    confirm: {text: "Lanjut | Bayar ke Financore",},
                  },
                }).then(function(isConf){
                  if (isConf) {
                    $.ajax({
                        queue: true,
                        cache: false,
                        timeout: 600000,
                        //dataType:"json",
                        type: 'POST',
                        url: 'module/payment/bcava/action_api.php',
                        data: {
                          'action':'dopaidfin.vabca',
                          'tgl_transfer':tgl_transfer,
                          'tgl_transfer_end':tgl_transfer_end,
                          'data_array': array
                        },
                        beforeSend:function(){
                            console.log("beforeSend")
                            HoldOn.open({
                                theme: "sk-dot",
                                message: "PLEASE WAIT... ",
                                backgroundColor: "#fcf7f7",
                                textColor: "#000"
                            });
                        },
                        success: function(response) {
                            console.log("response : "+response);   
                            respParse = parseJson(response);  
                            if(respParse.status_code==1){
                                icon = "success";
                                spcData = $("table#data-table > tbody:last-child");
                                spcData.children("tr").remove();
                            }else{
                                icon = "warning";
                            }
                            
                            swal({
                                  title:"Sukses",
                                  text: respParse.status_desc,
                                  icon: icon
                                }).then(function(){                          
                                    // location.reload();
                                });                                     
                            HoldOn.close();
                            document.getElementById("trf_post_klik").disabled = true;
                            //getReport(response,0,response.length)
                        }
                    });
                  }
                });
            }
        }
        
        /* custom parse json */
        function parseJson(str){
            jsn = "";
            try{
                jsn = JSON.parse(str);
            }catch(e){
                return false;
            }
            return jsn;
        }
        /* Membuat format tanggal jam */
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear(),
                hour = ''+d.getHours(),
                minute = ''+d.getMinutes(),
                second = ''+d.getSeconds();
        
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            if (hour.length < 2) hour = '0' + hour;
            if (minute.length < 2) minute = '0' + minute;
            if (second.length < 2) second = '0' + second;
        
            return [year, month, day].join('-')+" "+[hour, minute, second].join(':');
            
            //var DateCreated = new Date(Date.parse(Your Date Here)).format("MM/dd/yyyy");
        }
    </script>
</head>
<body>
    <div class="panel col-sm-12 col-md-12">
        <!-- HEADER -->
        <div class="panel panel-default" style="margin-top: 5px; margin-bottom: 5px; background-color: #e5ff33;">
            <div class="panel-heading" style="background-color: #ccdfe5;">
              <img style="width:100px;" src="<?php echo HOSTNAME();?>/module/payment/bcava/pict/logo-bca.png">&nbsp;&nbsp;<strong style="font-size: 16px;vertical-align:middle;color:#006280">TARIK PAYMENT VIRTUAL ACCOUNT BCA</strong>
            </div>
        </div>
        <div class="panel panel-default" id="top-table">
            <div class="panel-body">
            <div class="container-fluid">
                <div class="row" style="display: none;">
                    <div class="progress">
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="70"
                          aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            70%
                          </div>
                        </div>
                      </div>
                </div>
                <div class="row">
                <!-- <input name="tgl_transfer" type="text" id="tgl_transfer" readonly="" class="inpSmall" maxlength="50" size="15" value="<?php echo dateSQLKACO($res_01['txndate']);?>" style="padding:5px 10px; width: 10%; background-color: #dfdddd;" /> -->

                    <input name="tgl_transfer" type="text" id="tgl_transfer" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px; width: 10%; " /> s/d 
                    <input name="tgl_transfer_end" type="text" id="tgl_transfer_end" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px; width: 10%;" />
                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-sm btn-info" style="width: 7%; height: 35px; font-size: 12px;" onclick="getPayVA()" id="post_klik" value="cari_post_klik" name="cari_post_klik"><i class="glyphicon glyphicon-search" style="width: 20px;"> </i><b>CARI</b></button>
                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-sm btn-success" disabled="" style="height: 35px; font-size: 12px;" onclick="getDoPaidFin()" id="trf_post_klik" value="post_klik" name="post_klik"><i class="glyphicon glyphicon-send" style="width: 20px;"> </i><b>TRANSFER</b></button>
                                                           
                </div>
            </div>
            </div>
        </div>
        
        <!-- TABEL DATA -->
        <div id="panel-data" class="panel panel-primary">
            <table class="table table-bordered" id="data-table" border="1px solid rgb(190,190,190);">
                <thead>
                    <tr>
                      <th style="width: 30px;">NO</th>
                      <th style="width: 100px;">TGL TRANSAKSI</th>
                      <th style="width: 130px;">TGL PAYMENT NASABAH</th>
                      <th style="width: 100px;">CUSTCODE</th>
                      <th style="width: 270px;">NAMA</th>
                      <th style="width: 100px;">AMOUNT PAID</th>
                      <th style="width: 100px;">ANGSURAN</th>
                      <th style="width: 100px;">DENDA</th>
                      <th style="width: 250px;">KETERANGAN</th>
                      <th style="width: 140px;">TRX ID</th>
                      <th style="width: 65px;">CHANNEL</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- data tabel -->
                    
                </tbody>
            </table>
           
        </div>
        

        
        <!-- Modal -->
        <div class="modal fade" id="postModal" role="dialog" >
            <div class="modal-dialog" >
            
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
               
                  selesai
                </div>
                <div class="modal-footer">
                  <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
                </div>
              </div>
              
            </div>
        </div>
    </div>
</body>
<?php
//function dateSQLzz($stringDate){
//    if($stringDate!=''){
//        $time = strtotime($stringDate);
//        $dateSQL = date("Y-m-d",$time);
//        return $dateSQL;
//    }else{
//        $dateSQL    = "";
//        return $dateSQL;
//    }
//}
//function timeSQLzz($stringDate){
//    if($stringDate!=''){
//        $time = strtotime($stringDate);
//        $dateSQL = date("H:i",$time);
//        return $dateSQL;
//    }else{
//        $dateSQL    = "";
//        return $dateSQL;
//    }
//}
?>