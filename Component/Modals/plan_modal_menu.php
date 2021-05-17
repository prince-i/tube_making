<div class="modal" id="plan_menu">
    <div class="modal-content">
        <div class="row">
            <h6 class="center">MENU</h6>
            <div class="row divider"></div>
            <input type="hidden" name="" id="orderCodeReference">
            <input type="hidden" name="" id="orderPartsCode">
            <input type="hidden" name="" id="orderPlanCode">
            <div class="col s12">
               <!-- <div class="col s4">
               <button class="btn btn-large blue col s12" onclick="printTag()">Print Tube Making Tag</button> -->
               </div>
                <div class="col s6">
                <button class="btn btn-large #37474f blue-grey darken-3 col s12 modal-trigger" onclick="plan_details()" data-target="modal-sequence">Details</button>
                </div>
                <div class="col s6">
                <button class="btn btn-large #546e7a blue-grey darken-1 col s12" onclick="printKanban()">Print Kanban</button>
                </div>
            </div>
        </div>
    </div>
</div>