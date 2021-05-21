
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
          $("#tgl_release,#tgl_release_end").datepicker({
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
              <strong style="font-size: 14px;">H2H RELEASE DATA PAYMENT</strong>
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

                    <table>
                      <tr>
                        <td>Upload Date</td>
                        <td>:</td>
                        <td>

                          <input name="tgl_release" type="text" id="tgl_release" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px;" /> s/d 
                          <input name="tgl_release_end" type="text" id="tgl_release_end" class="inpSmall" maxlength="50" size="15" value="" style="padding:5px 10px;" />
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
        
        
    </div>
</body>

<script type="text/javascript">

    $(document).ready(function(){

      

    });

    function cariData(){
        let tgl_release = $("input[name=tgl_release]").val();
        let tgl_release_end = $("input[name=tgl_release_end]").val();
        var delchannel = $('#opt_channel').find(":selected").val();

        // alert(tgl_release);

        $.ajax({
          type: "POST",
          url: "module/payment/h2h/release_rinci.php",
          datatype: "php",
          data: {
            tgl_release: tgl_release,
            tgl_release_end: tgl_release_end,
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