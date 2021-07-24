<div class="modal bottom-sheet" id="modal-sequence" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
        <div class="col s12">
            <!-- <b>LOT NUMBER SEQUENCE</b> -->
            <button class="btn #263238 blue-grey darken-4" onclick="uncheck_all()">uncheck all</button>
            <button class="btn #263238 blue-grey darken-4" onclick="export_sequence('sequence_lot_data')">export record</button>
            <button class="btn #263238 blue-grey darken-4 right" onclick="get_to_reprint()">Re-Print</button>
        </div>
        <div class="col s12 collection" style="max-height:100vh;overflow:auto;">
            <table id="sequence_lot_data">
                <thead>
                    <th>
                        <p>
                            <label>
                                <input type="checkbox" name="" id="check_all" onclick="select_all_func()">
                                <span></span>
                            </label>
                        </p>
                    </th>
                    <th>PARTS CODE</th>
                    <th>LOT NUMBER</th>
                    <th>LENGTH</th>
                    <th>IN CHARGE</th>
                    <th>PRINT STATUS</th>
                    <th>LAST PRINT DATE</th>
                </thead>
                <tbody id="sequence_data"></tbody>
            </table>
        </div>
    </div>
</div>
</div>