<p class="center flow-text" style="margin-top:-2%;">CREATE PLAN</p>
<div class="col s12">
    <div class="input-field col l4 m4 s12">
        <input type="text" id="partsname">
        <label for="partsname">Parts Name</label>
    </div>
    <!-- PARTSCODE -->
    <div class="input-field col l4 m4 s12">
        <input type="text" id="partscode">
        <label for="partscode">Parts Code</label>
    </div>
    <!-- LENGTH -->
    <div class="input-field col l4 m4 s12">
        <input type="number" id="length" min="0">
        <label for="length">Length</label>
    </div>

    <!-- SHIFT -->
    <div class="input-field col l4 m4 s12">
        <select name="" id="shift" class="browser-default z-depth-1">
            <option value="">--SHIFT--</option>
            <option value="A">A</option>
            <option value="B">B</option>
        </select>
    </div>
    <!-- MACHINE NUMBER -->
    <div class="input-field col l4 m4 s12">
        <select name="" id="machine_num" class="browser-default z-depth-1" >
            <option value="">--MACHINE NUMBER--</option>
            <?php
                for($x=1;$x<=4;$x++){
            ?>
            <option value="<?='0'.$x;?>"><?='0'.$x;?></option>
            <?php
                }
            ?>
        </select>
    </div>
    <!-- SETUP# -->
    <div class="input-field col l4 m4 s12">
        <select name="" id="setup_num" class="browser-default z-depth-1">
            <option value="">--SETUP NUMBER--</option>
            <?php
                for($x=1;$x<=3;$x++){
            ?>
            <option value="<?='0'.$x;?>"><?='0'.$x;?></option>
            <?php
                }
            ?>
        </select>
    </div>
    <!-- PLAN -->
    <div class="input-field col l4 m4 s12">
        <input type="number" id="planQty" min="0">
        <label for="planQty">Plan</label>
    </div>
    <div class="input-field col s12">
        <button class="btn btn-small #263238 blue-grey darken-4">submit</button>
    </div>
</div>