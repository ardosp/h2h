
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

    <link rel="stylesheet" type="text/css" href="<?php echo hostname(); ?>/js/dataTables/datatables.min.css">
    <script type="text/javascript" src="<?php echo hostname(); ?>/js/dataTables/datatables.min.js"></script>
    
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
        width: 70px;
        height: 50px;
      }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
          var d = new Date();
          var curr_year = d.getFullYear(); 
          $("#tgl_rekon,#tgl_rekon_end").datepicker({
            dateFormat  : 'dd/mm/yy',
            yearRange   : '1900:'+curr_year,
            changeMonth : true,
            changeYear  : true
          });          
        });

    </script>
    
</head>
<body>
    <div class="panel col-sm-12 col-md-12">
        <!-- HEADER -->
        <div class="panel panel-default" style="margin-top: 5px; margin-bottom: 5px; background-color: #e5ff33;">
            <div class="panel-heading" style="background-color: #f0f0f0;">
              <!-- <img class="logo-bank" src="<?php echo HOSTNAME();?>/module/payment/briva/pict/logo-bni.png">&nbsp;&nbsp; -->
              <strong style="font-size: 14px;">H2H REKONSILIASI DATA PAYMENT</strong>
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
                    <!-- <span>Upload Date :</span>&nbsp; &nbsp; &nbsp;
                    
                    <input name="tgl_rekon" type="text" id="tgl_rekon" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px; width: 10%; " /> s/d 
                    <input name="tgl_rekon_end" type="text" id="tgl_rekon_end" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px; width: 10%;" />
                    &nbsp;&nbsp;&nbsp;


                    <button class="btn btn-sm btn-primary" style="width: 7%; height: 35px; font-size: 12px;" onclick="getTglRekon()" id="post_klik" value="post_klik" name="post_klik"><i class="glyphicon glyphicon-search" style="width: 20px;"> </i><b>CARI</b></button>
                    &nbsp;&nbsp;&nbsp;

                    <button class="btn btn-sm btn-success" disabled="" style="width: 11%; height: 35px; font-size: 12px;" onclick="getDoRekon(0)" id="trf_post_klik" value="post_klik" name="post_klik"><i class="glyphicon glyphicon-refresh" style="width: 20px;"> </i><b>REKONSILIASI</b></button>    -->


                    <table>
                      <tr>
                        <td>Upload Date</td>
                        <td>:</td>
                        <td>
                          <input name="tgl_rekon" type="text" id="tgl_rekon" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px;" /> s/d 
                          <input name="tgl_rekon_end" type="text" id="tgl_rekon_end" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px;" />
                          &nbsp;&nbsp;&nbsp;
                        </td>
                      </tr>
                      <tr>
                        <td>Channel</td>
                        <td>:</td>
                        <td>
                        <?php 
                          $sql = "select * from delchannel where DelChannelID in ('0000001','0080017')";
                          $exec = mssql_query($sql);
                        ?>
                          
                          <select name="opt_channel" id="opt_channel" class="form-control" style="height: 29px;padding: 4px 10px;font-size: 11px;">
                          <?php 
                            while ($data = mssql_fetch_assoc($exec)) { ?>
                              <option value="<?php echo $data['DelChannelID'] ?>"><?php echo $data['DelChannelID'].' - '.$data['DelChannelName'] ?></option>

                          <?php
                            }
                          ?>
                            
                          </select>
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
                          <button class="btn btn-sm btn-primary" style="height: 35px; font-size: 12px;" onclick="cariData()" id="post_klik" value="post_klik" name="post_klik"><i class="glyphicon glyphicon-search" style="width: 20px;"> </i><b>CARI</b></button>
                          &nbsp;&nbsp;&nbsp;

                          <!-- <button class="btn btn-sm btn-success" disabled="" style="height: 35px; font-size: 12px;" onclick="getDoRekon(0)" id="trf_post_klik" value="post_klik" name="post_klik"><i class="glyphicon glyphicon-refresh" style="width: 20px;"> </i><b>REKONSILIASI</b></button>  -->
                        </td>
                      </tr>
                    </table>                                    
                </div>
            </div>
            </div>
        </div>
        
        <!-- TABEL DATA -->
        <!-- <div id="panel-data" class="panel panel-primary">
            <table class="table table-bordered" id="data-table" border="1px solid rgb(190,190,190);">
                <thead>
                    <tr>
                      <th style="width: 20px;">NO</th>
                      <th style="width: 8%;">CA CODE</th>
                      <th style="width: 8%;">TRANSACTION DATE</th>
                      <th style="width: 10%;">INTERNAL REFFNO</th>
                      <th style="width: 10%;">EXTERNAL REFFNO</th>
                      <th style="width: 10%;">CONTRACT NO</th>
                      <th style="width: 8%;">PAYMENT AMOUNT</th>
                      <th style="width: 8%;">REKON AMOUNT</th>
                      <th style="width: 12%;">PAYMENT STATUS</th>
                      <th style="width: 12%;">REKON STATUS</th>
                      <th style="width: 12%;">UPLOAD DATE</th>
                      <th style="width: 12%;">POSTED DATE</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div> -->

        <div id="show_dataH2H">

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

<script type="text/javascript">

    $(document).ready(function(){

      console.log('tes');

      

    });

    function cariData(){
        let tgl_rekon = $("input[name=tgl_rekon]").val();
        let tgl_rekon_end = $("input[name=tgl_rekon_end]").val();
        var delchannel = $('#opt_channel').find(":selected").val();

        // alert(tgl_release);

        $.ajax({
          type: "POST",
          url: "module/payment/h2h/rekon_rinci.php",
          datatype: "php",
          data: {
            tgl_rekon: tgl_rekon,
            tgl_rekon_end: tgl_rekon_end,
            delchannel: delchannel
            
          },
          cache: false,
          beforeSend: function() {
            HoldOn.open({
                theme: "sk-dot",
                message: "PLEASE WAIT... ",
                backgroundColor: "#fcf7f7",
                textColor: "#000"
            });
          },
          success: function(html) {
            HoldOn.close();
            $("#show_dataH2H").html(html);
          }
        });

    }


    var maximum = null;
    globResObj= null;

    /* Mengambil tanggal untuk parameter penarikan report */
    function getTglRekon(){ 
        let tgl_rekon = $("input[name=tgl_rekon]").val();
        let tgl_rekon_end = $("input[name=tgl_rekon_end]").val();
        var delchannel = $('#opt_channel').find(":selected").val();

        // alert(opt_channel);
        
        if(tgl_rekon=="" || tgl_rekon_end==""){
            alert("Tanggal tidak boleh kosong");
        }else{
          $.ajax({
              queue: true,
              cache: false,
              //dataType:"json",
              type: 'POST',
              url: 'module/payment/h2h/process_script.php',
              data: {
                'action':'cari.rekon.h2h',
                'tgl_rekon':tgl_rekon,
                'tgl_rekon_end':tgl_rekon_end,
                'delchannel':delchannel
              },
              beforeSend:function(){
                  console.log("beforeSend");
                  HoldOn.open({
                      theme: "sk-dot",
                      message: "PLEASE WAIT... ",
                      backgroundColor: "#fcf7f7",
                      textColor: "#000"
                  });
              },
              success: function(response) {
                  console.log("response : "+response) 
                  spcData = $("table#data-table > tbody:last-child");
                  spcData.children("tr").remove();
                  resObj = JSON.parse(response);
                  // maximum= resObj;
                  globResObj= resObj;                
                  var no=1;
                  for (i = 0; i < resObj.length; i++) {
                      markup = "<tr>"+
                                  "<td style=\"text-align: center;\">"+no+"</td>"+
                                  "<td style=\"text-align: center;\">"+resObj[i].delchannel+"</td>"+
                                  "<td style=\"text-align: center;\">"+resObj[i].trx_date+"</td>"+
                                  "<td>"+resObj[i].IntReff+"</td>"+
                                  "<td>"+resObj[i].ExtReff+"</td>"+
                                  "<td>"+resObj[i].contractno+"</td>"+
                                  "<td style=\"text-align: right;\">"+parseInt(resObj[i].payment_amount).toLocaleString()+"</td>"+
                                  "<td style=\"text-align: right;\">"+parseInt(resObj[i].rekon_amount).toLocaleString()+"</td>"+
                                  "<td>"+resObj[i].Payment_Status+"</td>"+
                                  "<td>"+resObj[i].reconcile_status+"</td>"+        
                                  "<td style=\"text-align: center;\">"+resObj[i].upload_date+"</td>"+
                                  "<td style=\"text-align: center;\">"+resObj[i].PostedDate+"</td>"+                        
                                  "</tr>";
                      spcData.append(markup)
                      no++;
                  }
                  HoldOn.close();
                  document.getElementById("trf_post_klik").disabled = false;
                  //getReport(response,0,response.length)
              }
          });
        }
    }

    function getDoRekon(id_x){ 
      if (id_x==0) {
           HoldOn.open({
            theme: "sk-dot",
            message: "PLEASE WAIT... ",
            backgroundColor: "#fcf7f7",
            textColor: "#000"
        });
      }
        if (id_x<globResObj.length) {
            console.log({'action':'rekon.vabni','custcode':globResObj[id_x].contractno, 'traceno':globResObj[id_x].TraceNo})
          $.ajax({
                queue: true,
                cache: false,
                type: 'POST',
                url: 'module/payment/h2h/process_script.php',
                data: {'action':'rekon.vabni','custcode':globResObj[id_x].contractno, 'traceno':globResObj[id_x].TraceNo},
                beforeSend:function(){
                  
                   
                },
                success: function(response) {
                    console.log(response) 
                    
                    if(id_x === (globResObj.length-1)){
                      HoldOn.close();                    
                      swal({
                          title:"Sukses",
                          text: "Rekon Success",
                          icon: "success"
                        }).then(function(){      
                              window.location.reload();
                        });
                         
                    }else{
                        setTimeout(function(){
                            getDoRekon(id_x+1); 
                        }, 100);
                    }
                }
            }); 
        }               
        
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