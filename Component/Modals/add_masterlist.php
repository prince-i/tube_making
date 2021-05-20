<div class="modal" id="create-master-item">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
        <h5 class="center">ADD PARTS</h5>
        <div class="col s12">
            <div class="input-field col s6">
                <input type="text" name="" id="new_partcode"><label for="">Parts Code</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="" id="new_partname"><label for="">Parts Name</label>
            </div>
            <div class="input-field col s6">
                <input type="number" min="0" name="" id="new_packingQty"><label for="">Packing Quantity</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="" id="new_qrcode"><label for="">QR Code</label>
            </div>
            <div class="col s12 input-field">
                <button class="btn btn-large green col s12" onclick="saveItem()" id="saveMasterBtn">save</button>
            </div>
        </div>
    </div>
</div>
</div>