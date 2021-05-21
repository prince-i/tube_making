<div class="modal bottom-sheet" id="history_logs" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <h5 class="center">HISTORY LOGS</h5>
    <div class="row">
        <div class="col s12">
            <!-- FROM -->
            <div class="col l3  m6 s12 input-field">
                <input type="text" class="datepicker" id="log_from" value="<?=$server_date_only;?>">
            </div>
            <!-- TO -->
            <div class="col l3 m6 s12 input-field">
                <input type="text" class="datepicker" id="log_to" value="<?=$server_date_only;?>">
            </div>
            <!-- KEYWORD -->
            <div class="col l3 m12 s12 input-field">
                <input type="text" name="" id="keywordHistory">
                <label for="">Search</label>
            </div>
            <!-- BUTTON -->
            <div class="col l3 m12 s12 input-field">
                <button class="btn col s12 btn-large #546e7a blue-grey darken-1" onclick="load_history()">Search</button>
            </div>
        </div>

        <div class="col s12 collection" style="min-height:100vh;border:1px solid black;">
            <table id="history_table">
                <thead>
                    <th>#</th>
                    <th>Log Detail</th>
                    <th>Log Date</th>
                </thead>
                <tbody id="history_data_output"></tbody>
            </table>
        </div>
    </div>
</div>
</div>