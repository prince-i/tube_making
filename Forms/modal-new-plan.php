<p class="center flow-text" style="margin-top:-2%;">CREATE PLAN</p>
<div class="col s12">
    <!-- PARTSCODE -->
    <div class="input-field col l4 m4 s12">
        <input type="text" id="partscode_plan" onchange="detect_part_info()" placeholder="Parts Code" autocomplete="OFF">
    </div>

    <!-- PARTSNAME -->
    <div class="input-field col l4 m4 s12">
        <input type="text" id="partsname_plan" placeholder="Parts Name" autocomplete="OFF" disabled>
    </div>

    <!-- LENGTH -->
    <div class="input-field col l4 m4 s12">
        <input type="number" id="length_plan" min="0" placeholder="Length" autocomplete="OFF" disabled>
    </div>

    <!-- SHIFT -->
    <div class="input-field col l4 m4 s12">
        <select name="" id="shift_plan" class="browser-default z-depth-1">
            <option value="">--SHIFT--</option>
            <option value="A">A</option>
            <option value="B">B</option>
        </select>
    </div>
    <!-- MACHINE NUMBER -->
    <div class="input-field col l4 m4 s12">
        <select name="" id="machine_num_plan" class="browser-default z-depth-1" >
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
        <select name="" id="setup_num_plan" class="browser-default z-depth-1">
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
        <input type="number" id="planQty" min="0" placeholder="Plan" autocomplete="OFF">
    </div>
    
    <!-- QR CODE -->
    <div class="input-field col l4 m4 s12">
        <input type="text" id="qr_code_tubemaking" min="0" placeholder="QR Code" autocomplete="OFF" disabled>
    </div>


    <div class="row col s12">
        <div class="input-field col l4 m4 s12">
            <button class="btn btn-small #263238 blue-grey darken-4" onclick="save_plan()" id="planBtnCreate">submit</button>
        </div>

        <div class="input-field col l4 m4 s12">
            <p id="status_create" style="font-weight:bold;color:red;"></p>
        </div>
        <!-- LOADER -->
        <div class="col s12">
            <div class="progress" id="loader" style="display:none;">
                <div class="indeterminate #263238 blue-grey darken-4"></div>
            </div>
        </div>
    </div>
</div>