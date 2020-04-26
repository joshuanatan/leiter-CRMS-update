<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Print PO to Vendor</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
    <!-- Custom CSS -->
    <style>
        @media screen {
            div#footer_wrapper {
            }
          }



          @media print {
                tfoot { visibility: hidden; }

                div#footer_wrapper {
                  margin: 0px 2px 0px 7px;
                  position: fixed;
                  bottom: 0;
                  height: 80px;

                }

                div#footer_content {
                  color: green;
                }

                tr.vendorListHeading {
                    background-color: silver !important;
                    -webkit-print-color-adjust: exact; 
                }

                td.requirementHeading {
                    -webkit-print-color-adjust: exact; 
                }
                th.listFoot {
                    -webkit-print-color-adjust: exact; 
                }
            }

            @media print {
                .vendorListHeading th {
                    color: black !important;
                }
            }


    </style>

</head>
<body onload="window.print()">
<div id="laporan" class="container" style="padding-left: 10px;padding-right: 10px;">


<div class="row">
<table border="0" align="center" style="width:900px; border:none;margin-top:5px;margin-bottom:0px;align-content: flex-start;">
    <tr>
        <img width="150px" src="<?php echo base_url().'assets/img/leiter.jpg'?>" alt="gambar" class="bg" /> 
    </tr>                   
</table>
</div>

<div class="row">
<table border="0" style=" border:none;margin-top:10px;margin-bottom:0px;width: 900px;">
    <tr>
        <th style="font-size: 20px;text-align: center;">PURCHASE ORDER</th>
    </tr>                   
</table>
</div>


<div class="row">
<div class="col-lg-12" style="padding-bottom:30px;padding-top: 10px;">
    <table border="0" align="left" style="font-size: 11px;border: none; text-align: left;width: 900px;">
        <?php
            foreach ($order->result_array() as $a) {
                $id=$a['po_id'];
                $nomorpo=$a['po_no'];
                $tid=$a['transaction_id'];
                $podate=$a['po_date'];
                $kodecustomer=$a['po_kode_customer'];
                $shippername=$a['shipper_name'];
                $shipperid=$a['shipper_id'];
                $shipperaddress=$a['shipper_address'];
                $vendorname=$a['vendor_name'];
                $vendorid=$a['vendor_id'];
                $vendoraddress=$a['vendor_address'];
                $method=$a['po_shipping'];
                $term=$a['po_term'];
                $req_date=$a['requirement_date'];
            ?>
        <!--<tr>
            <td colspan="3"><?php echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <th style="padding-right: 20px;width: 40px;"><b>Date</b></th>
            <th style="padding-right: 5px;width: 1px;"><b>: </b></th> 
            <th style=""><b><?php echo date("F d<\s\u\p>S</\s\u\p>, Y", strtotime($podate)); ?></b></th>  
        </tr>
        <tr>
            <th style="padding-right: 20px;">Ref</th>
            <th>: </th> 
            <th><?php echo $nomorpo; ?></th>  
        </tr>    
        <?php
            }
        ?>            
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:20px;padding-top: 20px;">
    <table border="0" align="left" style="font-size: 11px;border: none; text-align: left;width: 900px;">
        <?php
            foreach ($order->result_array() as $a) {
                $id=$a['po_id'];
                $tid=$a['transaction_id'];
                $podate=$a['po_date'];
                $kodecustomer=$a['po_kode_customer'];
                $shippername=$a['shipper_name'];
                $shipperpic=$a['shipper_pic'];
                $shipperphone=$a['shipper_phone'];
                $shipperfax=$a['shipper_fax'];
                $shipperemail=$a['shipper_email'];
                $shipperid=$a['shipper_id'];
                $shipperaddress=$a['shipper_address'];
                $vendorname=$a['vendor_name'];
                $vendorid=$a['vendor_id'];
                $vendorpic=$a['vendor_pic'];
                $vendorphone=$a['vendor_phone'];
                $vendorfax=$a['vendor_fax'];
                $vendoremail=$a['vendor_email'];
                $vendoraddress=$a['vendor_address'];
                $method=$a['po_shipping'];
                $term=$a['po_term'];
                $req_date=$a['requirement_date'];
            ?>
        <!--<tr>
            <td colspan="3"><?php echo 'Tangerang, '.date("d F Y", strtotime($podate)); ?></td>
        </tr>-->
        <tr>
            <td style="width: 250px;" valign="top">
                <b>PT. LEITER INDONESIA</b><br>
                Ruko Prominence Alam Sutera F38/53-55<br>
                Jln. Jalur Sutera Prominence<br>
                Alam Sutera, Tangerang 15143 Banten<br>
                INDONESIA<br>
                Phone : +6221 2958 6786<br>
                Fax : +6221 2949 0663<br>
                Email : info@leiter.co.id
            </td>
            <td style="width: 40;padding-left: 7px" valign="top">VENDOR:</td>
            <td style="width: 240px;padding-left: 3px;" valign="top">
                <b><?php echo $vendorname; ?></b><br>
                <?php echo str_replace("\n", "<br/>", $vendoraddress); ?><br>
                attn : <?php echo $vendorpic; ?><br>
                <?php if($vendorphone){echo "Phone : ".$vendorphone."<br>";} ?>
                <?php if($vendorfax){echo "Fax : ".$vendorfax."<br>";} ?>
                <?php if($vendoremail){echo "Email : ".$vendoremail;} ?>
            </td> 
            <td style="width: 55;padding-left: 7px" valign="top">SHIP TO:</td>
            <td style="width: 240px" valign="top">
                <b><?php echo $shippername; ?></b><br>
                <?php echo str_replace("\n", "<br/>", $shipperaddress); ?><br>
                attn : <?php echo $shipperpic; ?><br>
                <?php if($shipperphone){echo "Phone : ".$shipperphone."<br>";} ?>
                <?php if($shipperfax){echo "Fax : ".$shipperfax."<br>";} ?>
                <?php if($shipperemail){echo "Email : ".$shipperemail;} ?>
            </td>  
        </tr>
   
        <?php
            }
        ?>            
    </table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-top: 15px;">
<table align="left" class="table table-condensed" style="font-size:11px;width: 900px;margin-bottom: 20px;margin-top: 20px;color: #000;border-collapse: collapse;" id="">
    <thead>    
        <tr class="vendorListHeading" style="background-color: silver;">
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">SHIPPING METHOD</th>
            <th style="text-align:center;border: 1px solid #000;padding: 5px;">SHIPPING TERMS</th>
            <th style="text-align:center;width:330px;border: 1px solid #000;padding: 5px;">REQUIREMENT DATE</th>
    </thead>
    <tbody>
        <?php 
            foreach ($order->result_array() as $a) {
                $id=$a['po_id'];
                $tid=$a['transaction_id'];
                $podate=$a['po_date'];
                $kodecustomer=$a['po_kode_customer'];
                $shippername=$a['shipper_name'];
                $shipperpic=$a['shipper_pic'];
                $shipperphone=$a['shipper_phone'];
                $shipperfax=$a['shipper_fax'];
                $shipperemail=$a['shipper_email'];
                $shipperid=$a['shipper_id'];
                $shipperaddress=$a['shipper_address'];
                $vendorname=$a['vendor_name'];
                $vendorid=$a['vendor_id'];
                $vendorpic=$a['vendor_pic'];
                $vendorphone=$a['vendor_phone'];
                $vendorfax=$a['vendor_fax'];
                $vendoremail=$a['vendor_email'];
                $vendoraddress=$a['vendor_address'];
                $method=$a['po_shipping'];
                $term=$a['po_term'];
                $req_date=$a['requirement_date'];
                $kurs=$a['po_kurs'];
                $req_location=$a['requirement_location'];
        ?>
        <tr>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php echo $method;?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php echo ' ';?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;" class="requirementHeading"><font style="background-color: yellow;"><?php echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.date("F d<\s\u\p>S</\s\u\p>, Y", strtotime($req_date)).' in '.$req_location.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'; ?></font></td>
        </tr>
        <?php
            }
        ?>  
    </tbody>  
</table>
</div>
</div>


<div class="row">
<div class="col-lg-12" style="padding-top: 15px;">
<table align="left" class="table table-condensed" style="font-size:11px;width: 900px;margin-bottom: 35px;" id="">
    <thead>    
        <tr class="vendorListHeading" style="background: silver">
            <th style="text-align:center;width:40px;border: 1px solid #000;padding: 5px;">No.</th>
            <th style="text-align:center;border: 1px solid #000;padding: 5px;">Description</th>
            <th style="text-align:center;width:60px;border: 1px solid #000;padding: 5px;">Qty</th>
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">Price<?php echo '('.$kurs.')'; ?></th>
            <th style="text-align:center;width:160px;border: 1px solid #000;padding: 5px;">Amount<?php echo '('.$kurs.')'; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no=0;
            $subtotal=0;
            foreach ($product->result_array() as $a):
                $no++;
                $id=$a['product_id'];
                $bn=$a['product_bn'];
                $desc=$a['product_desc'];
                $price=$a['det_po_price'];
                $qty=$a['det_po_qty'];
                $total=$a['det_po_amount'];

                $subtotal = $subtotal+$total;
        ?>
        <tr>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php echo $no;?></td>
            <td style="border: 1px solid #000;padding: 5px;"><?php echo $bn;?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php echo $qty;?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php echo number_format($price);?></td>
            <td style="text-align:center;border: 1px solid #000;padding: 5px;"><?php echo number_format($total);?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <th style="border: 0px solid #000;"></th>
            <th></th>
            <th></th>
            <th class="listFoot" style="text-align:right;border: 1px solid #000;padding: 5px;background-color: silver;">Total</th>
            <th class="listFoot" style="text-align:center;border: 1px solid #000;padding: 5px;background-color: silver;"><?php echo number_format($subtotal);?></th>
        </tr>
    </tbody>  
</table>
</div>
</div>

<div class="row">
<div class="col-lg-12" style="padding-bottom:30px;">
<table border="0" align="left" style="font-size: 12px;border: none; text-align: left;width: 900px;">
    <tr>
        <td colspan="3" style="padding-bottom: 10px;"><hr style="border-width: 2px;border-color: silver;width: 900px;"></td>
    </tr>
    <tr>
        <td style="" colspan="3">TERM & CONDITION</td>
    </tr>
    <?php
            foreach ($order->result_array() as $a) {
                $id=$a['po_id'];
                $tid=$a['transaction_id'];
                $podate=$a['po_date'];
                $kodecustomer=$a['po_kode_customer'];
                $shippername=$a['shipper_name'];
                $shipperpic=$a['shipper_pic'];
                $shipperphone=$a['shipper_phone'];
                $shipperfax=$a['shipper_fax'];
                $shipperemail=$a['shipper_email'];
                $shipperid=$a['shipper_id'];
                $shipperaddress=$a['shipper_address'];
                $vendorname=$a['vendor_name'];
                $vendorid=$a['vendor_id'];
                $vendorpic=$a['vendor_pic'];
                $vendorphone=$a['vendor_phone'];
                $vendorfax=$a['vendor_fax'];
                $vendoremail=$a['vendor_email'];
                $vendoraddress=$a['vendor_address'];
                $method=$a['po_shipping'];
                $term=$a['po_term'];
                $req_date=$a['requirement_date'];
            ?>
    <tr>
        <td style="padding-top: 10px;" colspan="3">1. <?php echo $term; ?></td>
    </tr>
    <tr>
        <td style="padding-top: 5px;" colspan="3">2. Please notify us immediately if you are unable to ship as specified.</td>
    </tr>
    <tr>
        <td style="padding-top: 5px;" colspan="3">3. Payment T/T with AR 60 days after goods received in good condition.</td>
    </tr>

    <tr>
        <td valign="top" style="padding-top: 5px;width: 120px;">4. Delivery Condition</td>
        <td valign="top" style="padding-top: 5px;"> :</td>
        <td valign="top" style="padding-left: 5px;padding-top: 5px;">Vendor will be apply penalty for any lateness of shipment. Penalty 2% for lateness within 1 week or penalty 5% for lateness after 1 week onward.</td>
    </tr>

    <?php
            }
        ?>

</table>
</div>
</div>


<div class="row">
<div class="col-lg-12" style="padding-bottom:30px;padding-top: 30px;">
<table align="left" style="border: none; font-size: 12px;text-align: left;margin-top: 35px;width: 900px;">
    <tr>
        <td style="padding-top: 20px;">Best regards,</td>
    </tr>
    <tr>
        <td style="font-family: Monotype Corsiva;font-size: 23px; padding-top: 50px;"><?php echo $sales; ?></td>
    </tr>  
    <tr>
        <td style="font-size: 14">PT LEITER Indonesia</td>
    </tr>
</table>
</div>
</div>

<div id="footer_wrapper">
    <div id="footer_content">
        <div class="col-lg-16" style="padding-left:0px;padding-right:30px;">
        <table align="left" style="width: 900px; padding-left:20px;padding-right:30px;border: none; font-size: 12px;text-align: left;">
            <tr>
                <hr style="border-width: 1px;border-color: green;width: 1300px;">
            </tr>
            <tr>
                <td style="font-size: 16px;color: green";>PT. LEITER Indonesia</td>
            </tr>
            <tr>
                <td style="color: green;">Ruko Prominence Alam Sutera 38F / 53 Jln. Jalur Sutera Prominence Alam Sutera, Tangerang 15143 Banten - INDONESIA<br>Telp. 021-29586786 Fax. 021-29490663</td>
            </tr>  
            
        </table>
        </div>
    </div>
</div>

</div>
</body>
</html>