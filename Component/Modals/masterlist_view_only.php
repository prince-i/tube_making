<div class="modal bottom-sheet" id="master_view_only" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
    <div class="modal-content">
    <h5 class="center" style="margin-top:-3%;">MASTERLIST</h5>
        <div class="row">
            <div class="col s12">
                <div class="input-field col s6">
                    <input type="text" name="" id="masterSearch" onchange="load_masterlist();">
                    <label for="masterSearch">Search</label>
                </div>
            </div>
            <div class="col s12 collection" style="min-height:70vh;">
                <table class="centered">
                    <thead>
                        <th>PARTS CODE</th>
                        <th>PARTS NAME</th>
                        <th>PACKING QTY</th>
                        <th>QR CODE</th>
                    </thead>
                    <tbody id="master_details"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>