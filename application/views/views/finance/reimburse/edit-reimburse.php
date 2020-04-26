<div class="panel-body col-lg-12">
    <div class="row row-lg">
        <div class="col-xl-12">
            <!-- Example Tabs Left -->
            <div class="example-wrap">
                <div class="nav-tabs-vertical" data-plugin="tabs">
                    <ul class="nav nav-tabs mr-25" role="tablist">
                        <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#primaryData" aria-controls="primaryData" role="tab">Primary Data</a></li>
                        
                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#detailData" aria-controls="primaryData" role="tab">Detail Data</a></li>

                        <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#additional" aria-controls="primaryData" role="tab">Detail Data</a></li>
                    </ul>
                    <form action = "<?php echo base_url();?>finance/payable/editinvoice" method = "post">    
                        <div class="tab-content">
                            <div class="tab-pane active" id="primaryData" role="tabpanel">
                                <input type = "hidden" class = "form-control">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Invoice</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Payment For</h5>
                                    <input type = "text" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">No Refrence</h5> <!-- Nanti ajax, kalau pilih supplier/shipper ngeload nomor po vendor, kalau courier, no OD -->
                                    <input type = "text" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Firm Name</h5>
                                    <input type = "text" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Written Amount</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Currency</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Transfer To</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                            </div>
                            <div class="tab-pane" id="detailData" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Subtotal</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Tax</h5>
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="inputUnchecked">
                                        <label for="inputUnchecked">PPN</label>
                                    </div>
                                    <input type = "text" class = "form-control">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" id="inputUnchecked">
                                        <label for="inputUnchecked">PPH 23</label>
                                    </div>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Discount</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Total</h5>
                                    <input type = "text" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Currency</h5>
                                    <input type = "text" class = "form-control" readonly>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Notes</h5>
                                    <textarea class = "form-control"></textarea>
                                </div>
                                <div class = "form-group">
                                    <button class = "col-lg-2 btn btn-primary btn-outline">SUBMIT</button>
                                    <a href = "<?php echo base_url();?>finance/payable/index" class = "col-lg-2 btn btn-outline btn-primary">BACK</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="additional" role="tabpanel">
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Notes</h5>
                                    <textarea class = "form-control"></textarea>
                                </div>
                                <div class = "form-group">
                                    <h5 style = "color:darkgrey; opacity:0.8">Photo</h5>
                                    <input type = "file" class = "form-control">
                                </div>
                                <div class = "form-group">
                                    <button class = "col-lg-2 btn btn-primary btn-outline">SUBMIT</button>
                                    <a href = "<?php echo base_url();?>finance/payable/index" class = "col-lg-2 btn btn-outline btn-primary">BACK</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Example Tabs Left -->
        </div>
    </div>
</div>
