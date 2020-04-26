
<div class="panel-body col-lg-12">
    <div class="row">
        <div class="col-lg-5 col-md-12">
            <div class="mb-15">
                <form action = "<?php echo base_url();?>finance/margin/sort" method = "post">
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
            <form action = "<?php echo base_url();?>finance/margin/search" method = "post">
                <div class = "row">
                    <div class = "form-group col-lg-6 col-md-12">
                        <input name = "search" value = "<?php echo $this->session->search;?>" type = "text" placeholder = "Search Everything About OC...." class = "form-control">
                    </div>
                    <div class = "form-group col-lg-6 col-md-12">
                        <button type = "submit" class = "btn btn-primary btn-sm">SEARCH</button>
                        <a href = "<?php echo base_url();?>finance/margin/removeFilter" class = "btn btn-primary btn-sm">REMOVE FILTER</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0">
        <thead>
            <tr>
                <th>Customer PO No</th> <!-- nanti ini keisi waktu nambahin OC-->
                <th>Tanggal Order</th>
                <th>Nama Customer</th>
                <th>No OC</th>
                <th>PO Price</th>
                <th>Action</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php for($a = 0; $a<count($oc); $a++):?>
            <tr>
                <td><?php echo strtoupper($oc[$a]["no_po_customer"]);?></td>
                <td><?php $date = date_create($oc[$a]["tgl_po_customer"]); echo date_format($date,"D d-m-Y");?></td>
                <td><?php echo ucwords($oc[$a]["nama_perusahaan"]);?></td>
                <td><?php echo strtoupper($oc[$a]["no_oc"]);?></td>
                <td><?php echo number_format($oc[$a]["total_oc_price"]);?></td>
                <td>
                    <a href = "<?php echo base_url();?>finance/margin/detail/<?php echo $oc[$a]["id_submit_oc"];?>" class = "btn btn-primary btn-sm">TRANSAKSI</a>
                </td>
                <td>
                    <form action = "<?php echo base_url();?>finance/margin/insertnotes" method = "post">
                        <input type = "hidden" name = "id_submit_oc" value = "<?php echo $oc[$a]["id_submit_oc"];?>">
                        <input type = "text" name = "notes" class = "form-control" placeholder="Input margin disini dan catatan lainnya.." value = "<?php echo $oc[$a]["notes_oc"];?>"><br/>
                        <button type = "submit" class = "btn btn-primary btn-sm">SUBMIT</button>
                    </form>
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
                <a class="page-link" href="<?php echo base_url();?>finance/margin/page/<?php echo $numbers[0]-1;?>" tabindex="-1">Previous</a>
            </li>
            <?php endif;?>
            <?php for($a = 0; $a<count($numbers);$a++):?>
            <?php if($numbers[$a] > 0):?>
            <li class="page-item <?php if($this->session->page == $numbers[$a]) echo "active"; ?>"><a class="page-link" href="<?php echo base_url();?>finance/margin/page/<?php echo $numbers[$a];?>"><?php echo $numbers[$a];?></a></li>
            <?php endif;?>
            <?php endfor;?>
            <li class="page-item">
                <a class="page-link" href="<?php echo base_url();?>finance/margin/page/<?php echo $numbers[4]+5;?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php endif;?>
</div>