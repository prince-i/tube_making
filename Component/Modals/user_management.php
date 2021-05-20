<div class="modal bottom-sheet" id="manage_user" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;" onclick="uncheck_all_user()">&times;</button>
</div>
<div class="modal-content">
    <h5 class="center">USER MANAGEMENT</h5>
    <div class="row">
        <div class="col s12">
            <div class="col s6 input-field">
                <input type="text" name="" id="searchUser" onchange="load_users()"><label for="">Search</label>
            </div>
            <div class="col s6 input-field">
                <button class="btn #263238 blue-grey darken-4 right modal-trigger" data-target="showAdd">Add User</button>
            </div>
        </div>
        <!--  -->
        <div class="row" id="user_control">
            <div class="col s12">
                <button class="btn #607d8b blue-grey" onclick="uncheck_all_user()">Uncheck All</button>
                <button class="btn #40c4ff light-blue accent-2">Edit</button>
                <button class="btn #d32f2f red darken-2" onclick="get_to_delete_user()">delete</button>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col s12 collection" style="min-height:100vh;overflow:auto;">
            <table class="centered" id="userMasterlist">
                <thead>
                    <th>
                        <p>
                            <label>
                                <input type="checkbox" name="" id="check_all_user" onclick="select_all_user()">
                                <span></span>
                            </label>
                        </p>
                    </th>
                    <th>USER ID</th>
                    <th>PASSWORD</th>
                    <th>FULL NAME</th>
                    <th>USER TYPE</th>
                </thead>
                <tbody id="userData"></tbody>
            </table>
        </div>
    </div>
</div>
</div> 