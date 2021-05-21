<?php 
include_once("../../../include/fungsi.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$tgl_rekon = dateSQL($_POST['tgl_rekon']);
$tgl_rekon_end = dateSQL($_POST['tgl_rekon_end']);
$delchannel = $_POST['delchannel'];

mssql_query("SET ANSI_NULLS ON; SET ANSI_WARNINGS ON;");

$sql = "SELECT * from mafserverdb.financore.dbo.v_VATempRekon_new where reconcile_status = 'P' and upload_date between '$tgl_rekon' and '$tgl_rekon_end' and delchannel='$delchannel'";
$exec = mssql_query($sql)or die ("Error Query [".$sql."]");

mssql_query("SET ANSI_NULLS OFF; SET ANSI_WARNINGS OFF;");
echo $sql;


// $sql = "SELECT right(virtual_account,13)+cast(cast(cast(datetime_payment as float) as decimal(18,12)) as varchar(37)) traceno,
// status=case when paid_status=0 then 'UNPAID' when paid_status=1 then 'PAID' end,amount=payment_amount,nama=customer_name,custcode=right(virtual_account,13),
// paymentdate=datetime_payment,* from payment_bni_callback_paid with(nolock)
// where dbo.tanggal_saja(datetime_payment)='$tgl_release'
// and paid_status=1 order by paymentdate";
// $exec = mssql_query($sql);


?>
<style>
  /* The container */
.container-cekbox {
  display: block;
  position: relative;
  padding-left: 35px;
  /* margin-bottom: 12px; */
  cursor: pointer;
  /* font-size: 22px; */
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container-cekbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
  /* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #aaa;
  border-radius:7px;
}

/* On mouse-over, add a grey background color */
.container-cekbox:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container-cekbox input:checked ~ .checkmark {
  background-color: #28a745;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container-cekbox input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container-cekbox .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>

<form name="form-table" id="form-table">
<!-- <form action="module/payment/h2h/process_script.php?action=submit_release" id="form_rekonrinci" method="POST" > -->
<input type="hidden" name="delchannel" id="delchannel" value="<?php echo $delchannel ?>">
<div id="panel-data" class="panel panel-primary">

  <table class="table table-bordered" id="data-table" border="1px solid rgb(190,190,190);">
      <thead>
          <tr>
            <th style="width: 20px; vertical-align:middle;">NO</th>
            <th style="width: 8%;vertical-align:middle;">CA CODE</th>
            <th style="width: 8%;vertical-align:middle;">TRANSACTION DATE</th>
            <th style="width: 10%;vertical-align:middle;">INTERNAL REFFNO</th>
            <th style="width: 10%;vertical-align:middle;">EXTERNAL REFFNO</th>
            <th style="width: 10%;vertical-align:middle;">CONTRACT NO</th>
            <th style="width: 8%;vertical-align:middle;">PAYMENT AMOUNT</th>
            <th style="width: 8%;vertical-align:middle;">REKON AMOUNT</th>
            <th style="width: 12%;vertical-align:middle;">PAYMENT STATUS</th>
            <th style="width: 12%;vertical-align:middle;">REKON STATUS</th>
            <th style="width: 12%;vertical-align:middle;">UPLOAD DATE</th>
            <th style="width: 12%;vertical-align:middle;">POSTED DATE</th>
            <th style="width: 12%;vertical-align:middle;">TRACENO</th>
            <th style="vertical-align:middle; width: 5%;">
              
              <label class="container-cekbox">Check All
                <input type="checkbox" class="custom-control-input" id="checkAll" />
                <span class="checkmark"></span>
              </label>
              
            </th>
          </tr>
      </thead>
      <tbody>
              
          <?php 
            $no = 1;
            $totalAmount = 0;
            $counter = 0;
            $sts_unpaid = 0;
            $sts_release = 0;
            while ($data = mssql_fetch_assoc($exec)) { ?>
            
              <tr>
                <td style="text-align: center;"><?php echo $no; ?></td>
                <td style="text-align: center;"><?php echo $data['DelChannel']; ?></td>
                <td style="text-align: center;"><?php echo dateSQLKacoTime($data['trx_date']); ?></td>
                <td style="text-align: center;"><?php echo $data['IntReff']; ?></td>
                <td style="text-align: left;"><?php echo $data['ExtReff']; ?></td>
                <td style="text-align: right;"><?php echo $data['contractno']; ?></td>
                <td style="text-align: center;"><?php echo number_format($data['payment_amount']); ?></td>
                <td style="text-align: center;"><?php echo number_format($data['rekon_amount']); ?></td>
                <td style="text-align: center;"><?php echo $data['Payment_Status']; ?></td>
                <td style="text-align: center;"><?php echo $data['reconcile_status']; ?></td>
                <td style="text-align: center;"><?php echo dateSQLKaco($data['upload_date']); ?></td>
                <td style="text-align: center;"><?php echo dateSQLKaco($data['PostedDate']); ?></td>
                <td style="text-align: center;"><?php echo $data['TraceNo']; ?></td>
                <td>
               
                  <label class="container-cekbox">Check
                    <input type="checkbox" class="custom-control-input checkAmount" id="checkAmount" name="checkAmount[<?php echo $data['TraceNo'].":".$data['contractno'].":".$data['DelChannel']; ?>]" value="<?php echo $data['rekon_amount']; ?>" >
                    <span class="checkmark"></span>
                  </label>
                  
                </td>
              </tr>
          <?php
            $no++;
            $totalAmount += $data['rekon_amount'];
            
              
            }
          ?>
          

      </tbody>
  </table>

  
</div>

<?php 
/**ALERT JIKA ADA PAYMENT YANG BELUM DITARIK */
//if($sts_unpaid>0){ ?>
  <!-- <div class="alert alert-danger">
    <strong>Perhatian!</strong> ada Transaksi yang belum ditarik, harap tarik payment di menu Tarik Payment.
  </div> -->
<?php //} ?>

<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 pull-right" style="padding-bottom: 10px;margin-left: -15px !important;">
  <div id="panel-data" class="panel panel-primary">
    <table class="table table-bordered" id="" border="1px solid rgb(190,190,190);">
      <tr>
        <td style="width:560px;"><strong>Total Payment Amount</strong></td>
        <td style="text-align:right; width:250px;">
          
          <strong><input type="text" class="form-control text-right total_amountva" style="height:auto;padding:3px 5px;font-size:11px;color:#333;" id="total_amountva" readonly></strong>
          <input type="hidden" name="h_total_amountva" class="h_total_amountva" value="0">
        </td>
      </tr>
      
      <tr>
        <td></td>
        <td style="text-align:right;">

            <button type="submit" class="btn btn-sm btn-success" disabled="" style="height: 35px; font-size: 12px;" id="rekon_post_klik" value="rekon_post_klik" name="rekon_post_klik"><i class="glyphicon glyphicon-refresh" style="width: 20px;"> </i><b>REKONSILIASI</b></button>

            <!-- <button type="submit" class="btn btn-sm btn-success" disabled="" style="height: 35px; font-size: 12px;" id="release_post_klik" value="post_klik" name="post_klik"><i class="glyphicon glyphicon-check" style="width: 20px;"> </i><b>RELEASE</b></button> -->
         
        </td>
      </tr>
    </table>
  </div>
</div>

<!-- </form> -->
</form>



<script type="text/javascript">
$(document).ready(function(){
    
    /**Check all */
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);

        var total = 0;
        $('input:checkbox:checked').each(function(){
          total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
        }); 
        console.log(total);
        $(".total_amountva").val(Comma(total));
        $(".h_total_amountva").val(total);

        /**Control tombol release */
        if ($(".h_total_amountva").val() !=0 && $(".total_amountva").val()!=0) {
          $('#rekon_post_klik').prop('disabled',false);
        } else { 
          $('#rekon_post_klik').prop('disabled',true);
        }
    });

    /**Loading when release */
    // $("form#form_rekonrinci").on("submit", function(){
    //   HoldOn.open({
    //       theme: "sk-dot",
    //       message: "PROCESSING RELEASE... ",
    //       backgroundColor: "#fcf7f7",
    //       textColor: "#000"
    //   });
    // });

    /**Ceklist hitung amount */
    $('table#data-table').on("change",".checkAmount", function (){
      // alert('tes');
      var total = 0;
      $('input:checkbox:checked').each(function(){
        total += isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
      });   
      // console.log(total);
  
      $(".total_amountva").val(Comma(total));
      $(".h_total_amountva").val(total);
      console.log($(".h_total_amountva").val());
      console.log($(".h_settlementAmount").val());
      
      /**Control tombol release */
      if ($(".h_total_amountva").val()!=0 && $(".total_amountva").val()!=0) {
        
        $('#rekon_post_klik').prop('disabled',false);
      } else {
        
        $('#rekon_post_klik').prop('disabled',true);
      }
      
    });

    
    /** Setting Datatabel */
    var table = $('#data-table').DataTable({
        pageLength: 10,
        "bLengthChange": false
    });

    /** Handle form submission event */ 
    $('#form-table').on('submit', function(e){
        /** Prevent actual form submission */
        e.preventDefault();

        /** Serialize form data */
        var data = table.$('input,select,textarea').serializeArray();
        // alert(data);

        /** Include extra data if necessary */
        // data.push({'name': 'extra_param', 'value': 'extra_value'});

        /** Submit form data via Ajax */
        // $.post({
        //   url: "module/payment/h2h/process_script.php?action=submit_release",
        //   data: data
        // });
        $.ajax({
          type: "POST",
          url: "module/payment/h2h/process_script.php?action=submit_rekon",
          dataType: "json",
          data: data,
          cache: false,
          beforeSend: function() {
            HoldOn.open({
                theme: "sk-dot",
                message: "PLEASE WAIT... ",
                backgroundColor: "#fcf7f7",
                textColor: "#000"
            });
          },
          success: function(response) {
            HoldOn.close();
            console.log(response);
            // data = parseJson(response);
            // console.log(data);
            if(response.error == 0){
                swal({
                    icon: "success",
                    title: "Success!",
                    text: "Berhasil rekonsiliasi : "+response.success
                    
                }).then(function() {
                    location.reload();
                });
                
            } else {
                swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Gagal : "+response.error
                }).then(function() {
                    preventDefault();
                });

            }
            
          }
        });
    });

    // if ( $.fn.DataTable.isDataTable( '#form-table' ) ) {
    //   alert('bisa');
    // }
    

    
});



function HapusKoma(n){
    return parseFloat(n.replace(/,/g, ''));
}

function numberWithCommas(n) {
    var parts = n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + (parts[1] ? "." + parts[1] : "");
}

function Comma(Num) {
    Num += '';
    Num = Num.replace(/,/g, '');

    x = Num.split('.');
    x1 = x[0];

    x2 = x.length > 1 ? '.' + x[1] : '';


    var rgx = /(\d)((\d{3}?)+)$/;

    while (rgx.test(x1))

        x1 = x1.replace(rgx, '$1' + ',' + '$2');

    return x1 + x2;

}

</script>