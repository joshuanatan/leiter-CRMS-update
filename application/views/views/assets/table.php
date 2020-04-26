<div class="panel-body col-lg-12">
    <div class="row">
        
    </div>
    <div class = "row">
        <div class = "form-group col-lg-3">
            <h5>Search Text</h5>
            <h5></h5>
            <input type = "text" class = "form-control" oninput = "">
        </div>
        <div class = "form-group col-lg-3">
            <h5>Search By</h5>
            <select class = "form-control" oninput = ""></select>
        </div>
        <div class = "form-group col-lg-3">
            <h5>Sort By</h5>
            <select class = "form-control"></select>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped w-full" cellspacing="0">
        <thead>
            <tr>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
            </tr>
        </tbody>
    </table>
    <nav aria-label="...">
        <ul class="pagination">
            <?php for($a =0; $a<5; $a++):?>
            <li class="page-item <?php if(($a+1) == 5) echo "active"; ?>">
                <a class="page-link" href="#"><?php echo $a+1;?></a>
            </li>
            <?php endfor;?>
        </ul>
    </nav>
</div>