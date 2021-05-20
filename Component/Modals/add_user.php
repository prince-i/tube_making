<div class="modal" id="showAdd">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
        <div class="col s12">
            <div class="input-field col s6">
                <input type="text" name="" id="addUserID"><label for="">USER ID</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="" id="addPassword"><label for="">USER PASSWORD</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="" id="addFullname"><label for="">FULLNAME</label>
            </div>
            <div class="input-field col s6 ">
                <select name="" id="addUsertype" class="browser-default z-depth-1">
                <option value="">--USER TYPE--</option>
                <option value="normal">NORMAL USER</option>
                <option value="admin">ADMIN</option>
                </select>
            </div>
        </div>
        <div class="col s12">
            <button class="btn green col s12 btn-large" onclick="saveUser()">Save</button>
        </div>
    </div>
</div>
</div>