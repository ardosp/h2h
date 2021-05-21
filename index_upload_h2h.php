<?php
  $sql_apldate = "select apldate from maf_apldate with(nolock)";
  $exec_apldate = mssql_query($sql_apldate);
  $data_apldate = mssql_fetch_assoc($exec_apldate);
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
      /* GRID */
      .grid-container {
          display: grid;
          grid-template-columns: 450px auto;
          /* background-color: #2196F3; */
          /*padding: 10px;*/
          grid-gap: 10px;
      }
      .grid-item {
          /* background-color: rgba(255, 255, 255, 0.8); */
          /*padding: 2px;*/
          /* font-size: 30px; */
          /* border: 1px solid rgba(0, 0, 0, 0.8); */
          text-align: left;
      }

      .grid-container-100 {
          display: grid;
          grid-template-columns: auto;
          grid-gap: 10px;
      }
      .grid-container-50 {
          display: grid;
          grid-template-columns: auto auto;
          grid-gap: 10px;
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
    </script>
</head>
<body>
    <div class="panel col-sm-12 col-md-12">
        <!-- HEADER -->
        <div class="panel panel-default" style="margin-top: 5px; margin-bottom: 5px; background-color: #e5ff33;">
            <div class="panel-heading" style="background-color: #f0f0f0;">
             <!-- #ffe5c5  color:#df8008-->
              <!-- <img style="width:100px;" src="<?php echo HOSTNAME();?>/module/payment/pos/img/logo-pos-sm.png"> -->
              <strong style="font-size: 14px;vertical-align:middle;">UPLOAD H2H TEXTFILE REKON</strong>
            </div>
        </div>
        
        <div class="panel panel-default" id="top-table">
            <div class="panel-body">
              <!-- <div class="alert alert-danger">
                <strong>payment_bca_paid_tes</strong> 
              </div> -->
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
                    <form method="post" action="" enctype="multipart/form-data">
                        <table>
                          
                          <tr>
                            <td>Upload Date</td>
                            <td>:</td>
                            <td>
                              <input name="tglUpload" type="text" id="tglUpload" readonly="" class="form-control" style="height: 30px;padding: 4px 10px;font-size: 11px;" maxlength="50" size="15" value="<?php echo dateSQLKACO($data_apldate['apldate']);?>"  /> 
                            </td>
                          </tr>
                          <tr>
                            <td>Pilih File</td>
                            <td>:</td>
                            <td>
                              <input type="file" name="fileUpload" id="fileUpload" class="form-control " style="width: 220px;height: 30px;padding: 4px 10px;font-size: 11px;" required/>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>
                              <button class="btn btn-sm btn-primary" style="height: 35px; font-size: 12px;" name="btnUpload" id="btnUpload" value="cari_post_klik" ><i class="glyphicon glyphicon-cloud-upload" style="width: 20px;"> </i><b>UPLOAD</b></button>
                            </td>
                          </tr>
                        </table>
                    </form>
                      
                      

                      <!-- <div class="pull-right">
                      APLDATE : <strong><?php
                      
                        echo dateSQLKaco($data_apldate['apldate']); ?></strong>

                        <input type="hidden" name="h_apldate" id="h_apldate" value="<?php echo dateSQL(dateSQLKaco($data_apldate['apldate'])); ?>">
                      </div> -->
                                                            
                  </div>
              </div>
            </div>
        </div>
        
        <!-- TABEL DATA -->
        <!-- <div id="panel-data" class="panel panel-primary">
            <table class="table table-bordered" id="data-table" border="1px solid rgb(190,190,190);">
                <thead>
                    <tr>
                      <th style="width: 30px; vertical-align:middle;">NO</th>
                      <th style="width: 100px; vertical-align:middle;">TGL TRANSAKSI</th>
                      <th style="width: 130px; vertical-align:middle;">TGL PAYMENT NASABAH</th>
                      <th style="width: 100px; vertical-align:middle;">CUSTCODE</th>
                      <th style="width: 270px; vertical-align:middle;">NAMA</th>
                      <th style="width: 100px; vertical-align:middle;">AMOUNT PAID</th>
                      <th style="width: 100px; vertical-align:middle;">ANGSURAN</th>
                      <th style="width: 100px; vertical-align:middle;">DENDA</th>
                      <th style="width: 250px; vertical-align:middle;">KETERANGAN</th>
                      <th style="width: 140px; vertical-align:middle;">TRX ID</th>
                      <th style="width: 65px; vertical-align:middle;">CHANNEL</th>
                      <th style="width: 10px; vertical-align:middle;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div> -->


        
        

    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
      console.log($("button[name='fileUpload']").val());

      $("form").on("click","button[name=btnUpload]",function(e){
          e.preventDefault();
          // alert('satu');
          let formData = new FormData();
          formData.append('file', $('#fileUpload')[0].files[0]);
          formData.append('tglUpload', $('#tglUpload').val());

          swal({
            icon: 'warning',
            title: 'Apakah anda yakin?',
            text: "Anda akan melakukan upload textfile H2H ke Financore.",
            buttons: {
              cancel: {text: "Tidak", visible: true},
              confirm: {text: "Upload ke Financore",},
            },
          }).then(function(isConf){
            if (isConf) {

              $.ajax({
                url : 'module/payment/h2h/process_script.php?action=uploadFile',
                type : 'POST',
                data : formData,
                // dataType: "json",
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                beforeSend:function(){
                    // console.log("beforeSend");
                    HoldOn.open({
                        theme: "sk-dot",
                        message: "PLEASE WAIT... ",
                        backgroundColor: "#fcf7f7",
                        textColor: "#000"
                    });
                },
                success : function(response) {
                    console.log(response);
                    // alert(response);
                    data = parseJson(response);
                    // alert(data);
                    // alert(data.status+'-'+data.error+'-'+data.message);

                    if(data.status==1){
                        swal({
                            icon: "success",
                            title: "Success!",
                            text: data.message
                            
                        }).then(function() {
                            $("button[name='fileUpload']").val('');
                        });
                        
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message
                        }).then(function() {
                            preventDefault();
                        });

                    }
                    HoldOn.close();

                }
              });

            }
          
          });
          // console.log(formData);
      });


      $("body table").on("click","button[name=trf_post_klik]",function(){
          // alert('tes');
          ini = $(this);
          let traceno = $(this).attr('data-traceno');
          let vano = $(this).attr('data-vano');
          let paymentdate = $(this).attr('data-paymentdate');
          let amount = $(this).attr('data-amount');

          
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
                    'action':'v2.dopaidfin.vabca',
                    'traceno': traceno,
                    'vano': vano,
                    'paymentdate': paymentdate,
                    'amount': amount
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
                        swal({
                            icon: "success",
                            title: "Success!",
                            text: respParse.status_desc
                            // button: "Okay"
                        }).then(function() {
                            ini.closest("tr").remove();
                            // ini.attr('class','hide');  
                            // $('.print_slip').removeClass("hide");
                              
                            // $("a.print_slip").prop("href","module/payment/installment/print_slip_query.php?norek="+respParse.norek+"&nopin="+respParse.nopin+"&noinvoice="+respParse.invblankono);
                        });
                          
                      } else {
                        swal({
                            icon: 'error',
                            title: 'Oops...',
                            text: respParse.status_desc
                        }).then(function() {
                            preventDefault();
                        });

                      }
                                                      
                      HoldOn.close();
                                        
                  }
              });
            }
          });
      });

    });


    /** Upload file text */
    function uploadFile(e) {
        // alert('tes');
        e.preventDefault();
        let formData = new FormData();
        formData.append('file', $('#fileUpload')[0].files[0]);

        console.log(formData);
    }



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
                                    "<td><button class=\"btn btn-sm btn-success\"  style=\"height: 35px; font-size: 12px;\"  id=\"trf_post_klik\" value=\"trf_post_klik\" name=\"trf_post_klik\" data-traceno="+resObj[i].traceno+" data-vano="+resObj[i].vano+" data-paymentdate="+resObj[i].payment_date+" data-amount="+resObj[i].amount+"><i class=\"glyphicon glyphicon-send\" style=\"width: 20px;\"> </i><b>TRANSFER</b></button> <a href=\"\" id=\"print_slip\" name=\"print_slip\" class=\"btn_gedi btn-primary print_slip hide\" target=\"_blank\" style=\"font-size:12px; Font-weight:bold;\"><i class=\"glyphicon glyphicon-print\"></i> Print Slip</a>  </td>"+  
                                                              
                                    "</tr>";
                                    // onclick="+getDoPaidFin()+"
                                    // disabled=\"\"
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
                    if(respParse.status_code==1){
                        icon = "success";
                        title = "Sukses";
                        spcData = $("table#data-table > tbody:last-child");
                        spcData.children("tr").remove();
                    }else{
                        icon = "error";
                        title = "Gagal";
                    }
                    
                    swal({
                      title: title,
                      text: respParse.status_desc,
                      icon: icon
                    }).then(function(){                          
                        // location.reload();
                        document.getElementById("trf_post_klik").disabled = true;
                    }); 


                    // swal({
                    //   title:"Sukses",
                    //   text: respParse.status_desc,
                    //   icon: "warning"
                    // }).then(function(){                          
                    //   document.getElementById("trf_post_klik").disabled = true;
                    // });   
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
    // function getDoPaidFin(){ 
    //   // console.log(array);
    //   // alert('tes');
    //     // var tgl_transfer = $("input[name=tgl_transfer]").val();
    //     // var tgl_transfer_end = $("input[name='tgl_transfer_end']").val();
    //     let traceno = $(this).attr('data-traceno');
    //     let vano = $(this).attr('data-vano');
    //     let trxdate = $(this).attr('data-trxdate');

    //     console.log(traceno, vano, trxdate);
        

    //     // if(tgl_transfer=="" || tgl_transfer_end==""){
    //     //     alert("Tanggal tidak boleh kosong");
    //     // }else{
    //         swal({
    //           icon: 'warning',
    //           title: 'Apakah anda yakin?',
    //           text: "Anda akan meneruskan proses pembayaran dari VA BCA ke Financore.",
    //           buttons: {
    //             cancel: {text: "Tidak", visible: true},
    //             confirm: {text: "Lanjut | Bayar ke Financore",},
    //           },
    //         }).then(function(isConf){
    //           if (isConf) {
    //             $.ajax({
    //                 queue: true,
    //                 cache: false,
    //                 timeout: 600000,
    //                 //dataType:"json",
    //                 type: 'POST',
    //                 url: 'module/payment/bcava/action_api.php',
    //                 data: {
    //                   'action':'tes.dopaidfin.vabca',
    //                   'traceno': traceno,
    //                   'vano': vano,
    //                   'trxdate': trxdate
    //                   // 'tgl_transfer':tgl_transfer,
    //                   // 'tgl_transfer_end':tgl_transfer_end,
    //                   // 'data_array': array
    //                 },
    //                 beforeSend:function(){
    //                     console.log("beforeSend")
    //                     HoldOn.open({
    //                         theme: "sk-dot",
    //                         message: "PLEASE WAIT... ",
    //                         backgroundColor: "#fcf7f7",
    //                         textColor: "#000"
    //                     });
    //                 },
    //                 success: function(response) {
    //                     console.log("response : "+response);   
    //                     respParse = parseJson(response);  
    //                     if(respParse.status_code==1){
    //                         icon = "success";
    //                         title = "Sukses";
    //                         spcData = $("table#data-table > tbody:last-child");
    //                         spcData.children("tr").remove();
    //                     }else{
    //                         icon = "error";
    //                         title = "Gagal";
    //                     }
                        
    //                     swal({
    //                       title: title,
    //                       text: respParse.status_desc,
    //                       icon: icon
    //                     }).then(function(){                          
    //                         // location.reload();
    //                     });                                     
    //                     HoldOn.close();
    //                     document.getElementById("trf_post_klik").disabled = true;
    //                     //getReport(response,0,response.length)
    //                 }
    //             });
    //           }
    //         });
    //     // }
    // }
    
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

</html>