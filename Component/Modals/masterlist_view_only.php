<div class="modal bottom-sheet" id="master_view_only" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
    <div class="modal-content">
    <h5 class="center" style="margin-top:-3%;">MASTERLIST</h5>
        <div class="row">
            <div class="col s12">
                <div class="input-field col s5">
                    <input type="text" name="" id="masterSearch" onchange="load_masterlist();" autocomplete="OFF">
                    <label for="masterSearch">Search</label>
                </div>
                <div class="col s1 input-field">
                    <button class="btn #cfd8dc blue-grey lighten-4 black-text" onclick="clearSearch()">&times;</button>
                </div>
                <div class="input-field col s6">
                    <button class="btn #546e7a blue-grey darken-1 right" onclick="export_master_user('table_master_user')">export</button>
                </div>
            </div>

            <!-- TABLE -->
            <div class="col s12 collection" style="min-height:70vh;">
                <table class="centered" id="table_master_user">
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

<script>
    function clearSearch(){
        document.querySelector('#masterSearch').value = '';
        $('#masterSearch').focus();
    }
</script>
