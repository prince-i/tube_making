<div class="modal" id="plan_menu_admin">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
        <div class="col s12" style="font-size:20px;font-family:arial;">
            <div class="col s6">
                <b>Parts Code:</b>
                <span id="partscodeprev"></span>
            </div>
            <div class="col s6">
                <b>Parts Name:</b>
                <span id="partsnameprev"></span>
            </div>
            <div class="col s6">
                <b>Order Code:</b>
                <span id="ordercodeprev"></span>
            </div>
            <div class="col s6">
                <b>Quantity:</b>
                <span id="quantityprev"></span>
            </div>
            <div class="col s6">
                <b>In Charge:</b>
                <span id="inchargeprev"></span>
            </div>
        </div>

        <div class="col s12">
            <input type="hidden" name="" id="partscode_del">
            <input type="hidden" name="" id="ordercode_del">
            <input type="hidden" id="plan_code_del">
        </div>
        
    </div>
    <div class="row divider"></div>
    <div class="row">
    <div class="input-field col s12 center">
        <button class="btn red" onclick="delete_plan_admin()" id="delPlanBtn">delete plan</button>
    </div>
    </div>
</div>
</div>