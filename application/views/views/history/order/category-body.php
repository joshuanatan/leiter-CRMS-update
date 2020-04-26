<div class="panel-body col-lg-12">
    <div class = "row">
        <div class = "col-lg-3 col-md-12">
            <h5>Margin didapat dari:</h5>1. Pembayaran invoice oleh customer<br/>2. Pembayaran tagihan ke vendor,forwarder, dan kurir<br/>3. Tambahan transaksi (bisa uang masuk/keluar)</h5><br/>
        </div>
        <div class="col-lg-5 col-md-12">
            <div class="mb-15">
                <form action = "<?php echo base_url();?>history/order/sort" method = "post">
                    <div class = "row">
                        <div class = "form-group col-lg-6 col-md-12">
                            <select class = "form-control" data-plugin = "select2" name = "order_by">
                                <?php for($a = 0; $a<count($search); $a++):?>
                                <option value = "<?php echo $search[$a];?>" <?php if($this->session->order_by == $search[$a]) echo "selected";?> ><?php echo ucwords($search_print[$a]);?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class = "form-group col-lg-2 col-md-12">
                            <select class = "form-control" name = "order_direction">
                                <option value = "ASC">A-Z</option>
                                <option value = "DESC" <?php if($this->session->order_direction == "DESC") echo "selected"; ?>>Z-A</option>
                            </select>
                        </div>
                        <div class = "form-group col-lg-4 col-md-12">
                            <button type = "submit" class = "btn btn-primary btn-sm">SORT TABLE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class = "col-lg-4 col-md-12">
            <form action = "<?php echo base_url();?>history/order/search" method = "post">
                <div class = "row">
                    <div class = "form-group col-lg-6 col-md-12">
                        <input name = "search" value = "<?php echo $this->session->search;?>" type = "text" placeholder = "Search Everything About ubah_page...." class = "form-control">
                    </div>
                    <div class = "form-group col-lg-6 col-md-12">
                        <button type = "submit" class = "btn btn-primary btn-sm">SEARCH</button>
                        <a href = "<?php echo base_url();?>history/order/removeFilter" class = "btn btn-primary btn-sm">REMOVE FILTER</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0">
        <thead>
            <tr>
                <th>No PO Customer</th>
                <th>OC</th>
                <th>Quotation</th>
                <th>RFQ</th>
                <th>Items</th>
                <th>OD</th>
                <th>Invoice</th>
                <th>Margin</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($history); $a++):?>
            <tr>
                <td><?php echo $history[$a]["no_po_customer"];?></td>
                <td>
                    <button class = "btn btn-primary btn-sm col-lg-12" data-toggle = "modal" data-target = "#detailOc<?php echo $a;?>"><?php echo $history[$a]["no_oc"];?></button>
                </td>
                <td>
                    <button class = "btn btn-success btn-sm col-lg-12" data-toggle = "modal" data-target = "#detailQuotation<?php echo $a;?>"><?php echo $history[$a]["no_quotation"];?></button>
                </td>
                <td>
                    <button class = "btn btn-warning btn-sm col-lg-12" data-toggle = "modal" data-target = "#detailRfq<?php echo $a;?>"><?php echo $history[$a]["no_request"];?></button>
                </td>
                <td>
                    <button class = "btn btn-light btn-sm col-lg-12" data-toggle = "modal" data-target = "#detailItems<?php echo $a;?>"><?php echo $history[$a]["jumlah_item"];?> Items</button>
                </td>
                <td>
                    <button class = "btn btn-dark btn-sm col-lg-12" data-toggle = "modal" data-target = "#detailOd<?php echo $a;?>"><?php echo $history[$a]["jumlah_od"];?> Order Deliveries</button></td>
                <td>
                    <button class = "btn btn-danger btn-sm col-lg-12" data-toggle = "modal" data-target = "#detailInvoice<?php echo $a;?>"><?php echo $history[$a]["jumlah_transaksi"];?> Invoice</button>
                </td>
                <td>
                    <?php echo number_format($history[$a]["margin"],2);?>%
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
    <?php if($search != 0):?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <?php if($numbers[0] -1 >= 0):?>
            <li class="page-item <?php if($prev == 1) echo "disabled";?>">
                <a class="page-link" href="<?php echo base_url();?>history/order/page/<?php echo $numbers[0]-1;?>" tabindex="-1">Previous</a>
            </li>
            <?php endif;?>
            <?php for($a = 0; $a<count($numbers);$a++):?>
            <?php if($numbers[$a] > 0):?>
            <li class="page-item <?php if($this->session->page == $numbers[$a]) echo "active"; ?>"><a class="page-link" href="<?php echo base_url();?>history/order/page/<?php echo $numbers[$a];?>"><?php echo $numbers[$a];?></a></li>
            <?php endif;?>
            <?php endfor;?>
            <li class="page-item">
                <a class="page-link" href="<?php echo base_url();?>history/order/page/<?php echo $numbers[4]+5;?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif;?>
</div>

<?php for($a = 0; $a<count($history); $a++):?>
            
<div class = "modal fade" id = "detailOc<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Detail OC</h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-striped table-hover table-bordered" style = "width:100%" data-plugin="dataTable">
                    <thead>
                        <td>No OC</td>
                        <td>No PO Customer</td>
                        <td>Tanggal PO Customer</td>
                        <td>Tanggal Buat OC</td>
                        <td>Harga OC</td>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $history[$a]["no_oc"];?></td>
                            <td><?php echo $history[$a]["no_po_customer"];?></td>
                            <td><?php $date = date_create($history[$a]["tgl_po_customer"]); echo date_format($date,"D d-m-Y");?></td>
                            <td><?php $date = date_create($history[$a]["date_oc_add"]); echo date_format($date,"D d-m-Y");?></td>
                            <td><?php echo number_format($history[$a]["total_oc_price"],2);?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "detailQuotation<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Detail Quotation</h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-striped table-hover table-bordered" style = "width:100%" data-plugin="dataTable">
                    <thead>
                        <td>No Quotation</td>
                        <td>Tanggal Buat Quotation</td>
                        <td>Harga Quotation</td>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $history[$a]["no_quotation"];?></td>
                            <td><?php $date = date_create($history[$a]["date_quotation_add"]); echo date_format($date,"D d-m-Y");?></td>
                            <td><?php echo number_format($history[$a]["total_quotation_price"],2);?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "detailRfq<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Detail RFQ</h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-striped table-hover table-bordered" style = "width:100%" data-plugin="dataTable">
                    <thead>
                        <td>No RFQ</td>
                        <td>Tanggal Buat RFQ</td>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $history[$a]["no_request"];?></td>
                            <td><?php $date = date_create($history[$a]["date_request_add"]); echo date_format($date,
                            "D d-m-Y");?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "detailItems<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Detail Items</h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-striped table-hover table-bordered" style = "width:100%" data-plugin="dataTable">
                    <thead>
                        <td>Nama Item OC</td>
                        <td>Jumlah Item OC</td>
                        <td>Selling Price</td>
                        <td>Nama Item Quotation</td>
                        <td>Jumlah Item Quotation</td>
                        <td>Quotation Price</td>
                        <td>Nama Item RFQ</td>
                        <td>Jumlah Item RFQ</td>
                    </thead>
                    <tbody>
                        <?php for($b = 0; $b<count($history[$a]["items"]); $b++):?>
                        <tr>
                            <td><?php echo nl2br($history[$a]["items"][$b]["nama_oc_item"]);?></td>
                            <td><?php echo number_format($history[$a]["items"][$b]["final_amount"],2);?> <?php echo $history[$a]["items"][$b]["satuan_oc_item"];?></td>
                            <td><?php echo number_format($history[$a]["items"][$b]["final_selling_price"],2);?></td>
                            <td><?php echo nl2br($history[$a]["items"][$b]["nama_quotation_item"]);?></td>
                            <td><?php echo number_format($history[$a]["items"][$b]["item_amount"],2);?> <?php echo $history[$a]["items"][$b]["satuan_quotation_item"];?></td>
                            <td><?php echo number_format($history[$a]["items"][$b]["selling_price"],2);?></td>
                            <td><?php echo nl2br($history[$a]["items"][$b]["nama_request_item"]);?></td>
                            <td><?php echo number_format($history[$a]["items"][$b]["jumlah_produk"],2);?> <?php echo $history[$a]["items"][$b]["satuan_request_item"];?></td>
                        </tr>
                        <?php endfor;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "detailOd<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Detail OD</h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-striped table-hover table-bordered" style = "width:100%" data-plugin="dataTable">
                    <thead>
                        <td>No OD</td>
                        <td>Tanggal Buat OD</td>
                        <td>Delivery Method</td>
                    </thead>
                    <tbody>
                        <?php for($b = 0; $b<count($history[$a]["od"]); $b++):?>
                        <tr>
                            <td><?php echo $history[$a]["od"][$b]["no_od"];?></td>
                            <td><?php $date = date_create($history[$a]["od"][$b]["date_od_add"]); echo date_format($date,"D d-m-Y");?></td>
                            <td><?php echo $history[$a]["od"][$b]["delivery_method"];?></td>
                        </tr>
                        <?php endfor;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class = "modal fade" id = "detailInvoice<?php echo $a;?>">
    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
            <div class = "modal-header">
                <h4 class = "modal-title">Detail Invoice</h4>
            </div>
            <div class = "modal-body">
                <table class = "table table-striped table-hover table-bordered" style = "width:100%">
                    <thead>
                        <th>No Invoice</th>
                        <th>Subject Transaksi</th>
                        <th>Total</th>
                        <th>Tanggal Transaksi</th>
                        <th>Subject Pembayaran</th>
                        <th>Flow Transaksi</th>
                    </thead>
                    <tbody>
                        <?php for($b = 0; $b<count($history[$a]["transaksi"]); $b++):?>
                        <tr>
                            <td><?php echo $history[$a]["transaksi"][$b]["no_invoice"];?></td>
                            <td><?php echo $history[$a]["transaksi"][$b]["status_transaksi"];?></td>
                            <td><?php echo number_format($history[$a]["transaksi"][$b]["total_pembayaran"],2);?></td>
                            <td><?php echo $history[$a]["transaksi"][$b]["tgl_bayar"];?></td>
                            <td><?php echo $history[$a]["transaksi"][$b]["subject_pembayaran"];?></td>
                            <td>
                                <?php 
                                if($history[$a]["transaksi"][$b]["flow_transaksi"] == 0){
                                    echo "MASUK";
                                }
                                else echo "KELUAR";
                                ?>
                            </td>
                        </tr>
                        <?php endfor;?>
                        <tr>
                            <td colspan = "4"></td>
                            <td>Uang Masuk</td>
                            <td colspan = "2"><?php echo number_format($history[$a]["masuk"],2);?></td>
                        </tr>
                        <tr>
                            <td colspan = "4"></td>
                            <td>Uang Keluar</td>
                            <td colspan = "2"><?php echo number_format($history[$a]["keluar"],2);?></td>
                        </tr>
                        <tr>
                            <td colspan = "4"></td>
                            <td>Selisih</td>
                            <td colspan = "2"><?php echo number_format($history[$a]["selisih"],2);?></td>
                        </tr>
                        <tr>
                            <td colspan = "4"></td>
                            <td>Margin</td>
                            <td colspan = "2"><?php echo number_format($history[$a]["margin"],2);?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endfor;?>