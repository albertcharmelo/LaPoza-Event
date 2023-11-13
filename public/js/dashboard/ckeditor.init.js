let CKeditor;
$(document).ready(function () {
    ClassicEditor.create(document.querySelector("#ckeditorInvitacion"), {
        toolbar: {
            items: [
                "heading",
                "|",
                "bold",
                "italic",
                "|",
                "bulletedList",
                "numberedList",
                "|",
                "insertTable",
                "|",
                "|",
                "|",
                "undo",
                "redo",
            ],
        },

        table: {
            contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"],
        },
        language: "es",
        ckfinder: {
            uploadUrl:
                "/ckfinder/connector?command=QuickUpload&type=Files&responseType=json",
        },
    })
        .then((newEditor) => {
            CKeditor = newEditor;
        })
        .catch((err) => {
            console.error(err.stack);
        });
});
