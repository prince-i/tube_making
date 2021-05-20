<div class="modal" id="modal-upload-master">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">

    <div class="row">
        <div class="col s12">

        <form action="../process/import_excel.php"  enctype="multipart/form-data" method="POST">
            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file" name="file">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
                <div class="input-field col s12">
                    <input type="submit" value="upload" class="#263238 blue-grey darken-4 btn col s12" name="upload">
                </div>
            </div>
        </form>

        </div>
    </div>

    <div class="col s12 collection">
        <table class="centered" id="exceltable">
            
        </table>
    </div>


    <div class="row divider"></div>
    <div class="row">
        <div class="col s12 center">
            <a href="../template/kanban_masterlist_template.csv" class="#607d8b blue-grey btn" download>Download Template</a>
        </div>
    </div>
</div>
</div>