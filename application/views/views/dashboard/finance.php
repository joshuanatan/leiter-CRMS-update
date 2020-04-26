<?php
$tahun = date("Y");
?>
<div class="page">
    <div class="page-content">
        <!-- Panel -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card p-30 flex-row justify-content-between">
                            <div class="white">
                                <i class="icon icon-circle icon-2x wb-order bg-green-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-right">
                                <div class="counter-number-group">
                                    <span class="counter-number" style = "font-size:18px"><?php echo number_format($cashflow_balance[0]["cashflow"],2); ?></span><br/>
                                    <span class="counter-number-related text-capitalize">Cash Balance</span>
                                </div>
                                <div class="counter-label text-capitalize font-size-16"><?php echo date("M")."/".date("Y");?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-30 flex-row justify-content-between">
                            <div class="white">
                                <i class="icon icon-circle icon-2x wb-clipboard bg-purple-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-right">
                                <div class="counter-number-group">
                                    <span class="counter-number" style = "font-size:18px"><?php echo number_format($margin_overview,2);?>%</span><br/>
                                    <span class="counter-number-related text-capitalize">Margin</span>
                                </div>
                                <div class="counter-label text-capitalize font-size-16"><?php echo date("M")."/".date("Y");?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-30 flex-row justify-content-between">
                            <div class="white">
                                <i class="icon icon-circle icon-2x wb-dropdown bg-red-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-right">
                                <div class="counter-number-group">
                                    <span class="counter-number" style = "font-size:18px"><?php echo number_format($pengeluaran[0]["cashflow"],2);?></span><br/>
                                    <span class="counter-number-related text-capitalize">Pengeluaran</span>
                                </div>
                                <div class="counter-label text-capitalize font-size-16"><?php echo date("M")."/".date("Y");?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card p-30 flex-row justify-content-between">
                            <div class="white">
                                <i class="icon icon-circle icon-2x wb-dropup bg-blue-600" aria-hidden="true"></i>
                            </div>
                            <div class="counter counter-md counter text-right">
                                <div class="counter-number-group">
                                    <span class="counter-number" style = "font-size:18px"><?php echo number_format($pemasukan[0]["cashflow"],2);?></span><br/>
                                    <span class="counter-number-related text-capitalize">Pemasukan</span>
                                </div>
                                <div class="counter-label text-capitalize font-size-16"><?php echo date("M")."/".date("Y");?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-lg">
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">CASHFLOW <?php echo date("Y");?></h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>

                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">MARGIN <?php echo $tahun-0;?>-<?php echo $tahun-1;?>-<?php echo $tahun-2;?></h4>
                            <div class="example text-center">
                                <canvas id="exampleChartjsBar2" style = "width:100%"></canvas>
                            </div>
                        </div>
                    <!-- End Example Bar -->
                    </div>
                </div>
                <div class="row row-lg">
                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">Invoice Customer Mendekati Jatuh Tempo</h4>
                            <table class = "table table-striped table-hover table-bordered" data-plugin = "DataTable">
                                <thead>
                                    <th>No Invoice</th>
                                    <th>PO Customer No</th>
                                    <th>Invoice Amount</th>
                                    <th>Purpose</th>
                                    <th>Tanggal Buat Invoice</th>
                                    <th>Days Remaining</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Update</th>
                                </thead>
                                <tbody>
                                    <?php for($a = 0; $a<count($tagihan_customer); $a++):?>
                                    <tr>
                                        <td><?php echo $tagihan_customer[$a]["no_invoice"];?></td>
                                        <td><?php echo $tagihan_customer[$a]["no_po_customer"];?></td>
                                        <td><?php echo number_format($tagihan_customer[$a]["nominal_pembayaran"],2);?></td>
                                        <td><?php echo $tagihan_customer[$a]["tipe_pembayaran"];?></td>
                                        <td><?php $date = date_create($tagihan_customer[$a]["tgl_invoice_add"]); echo date_format($date,"d-m-Y");?></td>
                                        <td>
                                            <?php if($tagihan_customer[$a]["sisa_waktu"] < 0):?>
                                            <button class = "btn col-lg-12 btn-danger btn-sm"><?php echo abs($tagihan_customer[$a]["sisa_waktu"]);?> Days</button>
                                            <?php else:?>
                                            <button class = "btn col-lg-12 btn-warning btn-sm"><?php echo abs($tagihan_customer[$a]["sisa_waktu"]);?> Days</button>
                                            <?php endif;?>
                                        </td>
                                        <form action = "<?php echo base_url();?>welcome/updateJatuhTempoInvoiceCustomer" method = "POST">
                                        <td>
                                            <input type = "hidden" name = "id_submit_invoice" value = "<?php echo $tagihan_customer[$a]["id_submit_invoice"];?>">
                                            <input type = "date" class = "form-control" name = "updateTanggal<?php echo $tagihan_customer[$a]["id_submit_invoice"]; ?>" value = "<?php echo $tagihan_customer[$a]["jatuh_tempo"];?>">
                                        </td>
                                        <td>
                                            <button type = "submit" class = "btn btn-primary btn-sm col-lg-12">Extend</button>
                                        </td>
                                        </form>
                                    </tr>
                                    <?php endfor;?>
                                </tbody>
                            </table>
                        </div>
                    <!-- End Example Bar -->
                    </div>

                    <div class="col-lg-12 col-xl-12">
                    <!-- Example Bar -->
                        <div class="example-wrap">
                            <h4 class="example-title">Tagihan Vendor Mendekati Jatuh Tempo</h4>
                            <table class = "table table-striped table-hover table-bordered" data-plugin = "DataTable">
                                <thead>
                                    <th>No Invoice</th>
                                    <th>No Refrence</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Jumlah</th> 
                                    <th>Purpose</th> 
                                    <th>Rekening Pembayaran</th> 
                                    <th>Currency</th>
                                    <th>Days Remaining</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Update</th>
                                </thead>
                                <tbody>
                                    <?php for($a = 0; $a<count($tagihan_vendor); $a++):?>
                                    <tr>
                                        <td><?php echo $tagihan_vendor[$a]["no_invoice"];?></td>
                                        <td><?php echo $tagihan_vendor[$a]["no_refrence"];?></td>
                                        <td><?php echo $tagihan_vendor[$a]["nama_target"];?></td>
                                        <td><?php echo number_format($tagihan_vendor[$a]["total"],2);?></td>
                                        <td><?php echo $tagihan_vendor[$a]["peruntukan_tagihan"];?></td>
                                        <td><?php echo $tagihan_vendor[$a]["rekening_pembayaran"];?></td>
                                        <td><?php echo $tagihan_vendor[$a]["mata_uang"];?></td>
                                        <td>
                                            <?php if($tagihan_vendor[$a]["sisa_waktu"] < 0):?>
                                            <button class = "btn col-lg-12 btn-danger btn-sm"><?php echo abs($tagihan_vendor[$a]["sisa_waktu"]);?> Days</button>
                                            <?php else:?>
                                            <button class = "btn col-lg-12 btn-warning btn-sm"><?php echo abs($tagihan_vendor[$a]["sisa_waktu"]);?> Days</button>
                                            <?php endif;?>
                                        </td>
                                        <form action = "<?php echo base_url();?>welcome/updateJatuhTempoTagihanVendor" method = "POST">
                                        <td>
                                            <input type = "hidden" name = "id_tagihan" value = "<?php echo $tagihan_vendor[$a]["id_tagihan"];?>">
                                            <input type = "date" class = "form-control" name = "updateTanggal<?php echo $tagihan_vendor[$a]["id_tagihan"];?>" value = "<?php echo $tagihan_vendor[$a]["dateline_invoice"];?>"></td>
                                        <td>
                                            <button type = "submit" class = "btn btn-primary btn-sm col-lg-12">EXTEND</button>
                                        </td>
                                        </form>
                                    </tr>
                                    <?php endfor;?>
                                </tbody>
                            </table>
                        </div>
                    <!-- End Example Bar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel -->
    </div>
</div>