<div class="modal" id="editusermodal">
<div class="modal-footer">
<button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
<input type="hidden" name="" id="recordID">
    <div class="row">
        <div class="col s12">
            <div class="input-field col s6">
                <input type="text" name="" id="edit_userid" placeholder="USER ID">
            </div>

            <div class="input-field col s6">
                <input type="text" name="" id="edit_password" placeholder="PASSWORD">
            </div>

            <div class="input-field col s6">
                <input type="text" name="" id="edit_fullname" placeholder="FULLNAME">
            </div>

            <div class="input-field col s6">
                <select name="" id="edit_user_type" class="browser-default z-depth-1">
                    <option value="">--USER TYPE--</option>
                    <option value="normal">NORMAL USER</option>
                    <option value="admin">ADMIN USER</option>
                </select>
            </div>
        </div>
        <div class="col s12">
            <button class="btn btn-large col s12 #ff6e40 deep-orange accent-2" onclick="update_user()" id="update_user_btn">UPDATE</button>
        </div>

    </div>
</div>
</div>