<div class="modal bottom-sheet" id="masterlist_admin" style="min-height:100vh;">
<div class="modal-footer">
<button class="btn-flat modal-close" style="color:red;font-size:30px;" onclick="uncheck_all()">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
        <div class="col s12">
            <div class="input-field col l6 m12 s12">
                <input type="text" name="" id="searchkey"  onchange="load_masterlist()"><label for="">Search</label>
            </div>
            <div class="input-field col l2 m12 s12">
                <button class="btn #546e7a blue-grey darken-2 col s12 modal-trigger" data-target="modal-upload-master" >Upload</button>
            </div>
            <div class="input-field col l2 m12 s12">
                <button class="btn #546e7a blue-grey darken-1 col s12 modal-trigger" data-target="create-master-item" >Add</button>
            </div>
            <div class="input-field col l2 m12 s12">
                <button class="btn #90a4ae blue-grey lighten-2 col s12" onclick="export_masterlist('adminMasterlist')">Export</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12" id="checkbox_control">
            <button class="btn #37474f blue-grey darken-3" onclick="uncheck_all()">Uncheck All</button>
            <button class="btn #ff3d00 deep-orange accent-3" onclick="get_masterlist_value()" >Delete</button>
        </div>
    </div>

    <div class="row">
        <div class="col s12 collection" style="height:80vh;overflow:auto;border:1px solid black;">
            <table class="centered" id="adminMasterlist">
                <thead>
                    <th>
                        <p>
                            <label>
                                <input type="checkbox" name="" id="selectmaster_all" onclick="select_all_master()">
                                <span></span>
                            </label>
                        </p>
                    </th>
                    <th>PARTSCODE</th>
                    <th>PARTSNAME</th>
                    <th>PACKING QUANTITY</th>
                    <th>QR CODE</th>
                </thead>
                <tbody id="masterData"></tbody>
            </table>
        </div>
    </div>
</div>

</div>