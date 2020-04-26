<?php
$form_data = array(
    "input0" => array(
        "input" => "input",
        "type" => "password",
        "name" => "name",
        "title" => "title",
        "placeholder" => "placeholder",
        "value" => "value",
        "help" => "help"
    ),
    "input1" => array(
        "input" => "select",
        "title" => "title",
        "name" => "name",
        "options" => $produk,
        "help" => "help"
    ),
    "input2" => array(
        "input" => "textarea",
        "title" => "title",
        "name" => "name",
        "placeholder" => "placeholder",
        "value" => "value",
        "help" => "help",
        "rows" => 5,
        "cols" => 0
    ),
);
?>
<?php for($a = 0; $a<count($form_data); $a++){ 
    
    switch($form_data["input".$a]["input"]){
        case "input": ?>
        <div class = "form-group">
            <div class="col-md-12 col-lg-12">
                <!-- Example With Help -->
                <h4 class="example-title"><?php echo $form_data["input".$a]["title"];?></h4>
                <input type="<?php echo $form_data["input".$a]["type"];?>" name = "<?php echo $form_data["input".$a]["name"];?>" class="form-control" id="inputHelpText" placeholder = "<?php echo $form_data["input".$a]["placeholder"];?>" required value = "<?php echo $form_data["input".$a]["value"];?>">
                <span class="text-help"><?php echo $form_data["input".$a]["help"];?></span>
            </div>
        </div>
        <?php
        break;
        case "select": ?>
        <div class = "form-group">
            <div class="col-md-12 col-lg-12">
                <!-- Example With Help -->
                <h4 class="example-title"><?php echo $form_data["input".$a]["title"];?></h4>
                <select name = "<?php echo $form_data["input".$a]["name"];?>" class="form-control" id="inputHelpText" required >
                <?php 
                foreach($form_data["input".$a]["options"]->result() as $option){ ?>
                    <option value = ""><?php echo $option->id_produk;?></option>
                <?php 
                } 
                ?>
                </select>
                <span class="text-help"><?php echo $form_data["input".$a]["help"];?></span>
            </div>
        </div>
        <?php
        break;
        case "textarea": ?>
        <div class = "form-group">
            <div class="col-md-12 col-lg-12">
                <!-- Example With Help -->
                <h4 class="example-title"><?php echo $form_data["input".$a]["title"];?></h4>
                <textarea name = "<?php echo $form_data["input".$a]["name"];?>" class="form-control" id="inputHelpText" required <?php if($form_data["input".$a]["rows"] != 0) echo "rows = ".$form_data["input".$a]["rows"];?> <?php if($form_data["input".$a]["cols"] != 0) echo "cols = ".$form_data["input".$a]["cols"];?> ><?php echo $form_data["input".$a]["value"];?></textarea>
                <span class="text-help"><?php echo $form_data["input".$a]["help"];?></span>
            </div>
        </div>
        <?php
        break;
    }
    ?>
    <?php
}
?>