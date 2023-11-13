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
        color: {
            options: [
                "automatic",
                "rgb(0, 0, 0)",
                "rgb(255, 255, 255)",
                "rgb(255, 0, 0)",
                "rgb(255, 153, 0)",
                "rgb(255, 255, 0)",
                "rgb(0, 255, 0)",
                "rgb(0, 255, 255)",
                "rgb(0, 0, 255)",
                "rgb(153, 0, 255)",
                "rgb(255, 0, 255)",
            ],
        },
        fontColor: {
            colors: [
                {
                    color: "black",
                    label: "Black",
                },
                {
                    color: "white",
                    label: "White",
                },
                {
                    color: "rgb(244, 67, 54)",
                    label: "Red",
                },
                {
                    color: "rgb(233, 30, 99)",
                    label: "Pink",
                },
                {
                    color: "rgb(156, 39, 176)",
                    label: "Purple",
                },
                {
                    color: "rgb(103, 58, 183)",
                    label: "Deep Purple",
                },
                {
                    color: "rgb(63, 81, 181)",
                    label: "Indigo",
                },
                {
                    color: "rgb(33, 150, 243)",
                    label: "Blue",
                },
                {
                    color: "rgb(3, 169, 244)",
                    label: "Light Blue",
                },
                {
                    color: "rgb(0, 188, 212)",
                    label: "Cyan",
                },
                {
                    color: "rgb(0, 150, 136)",
                    label: "Teal",
                },
                {
                    color: "rgb(76, 175, 80)",
                    label: "Green",
                },
                {
                    color: "rgb(139, 195, 74)",
                    label: "Light Green",
                },
                {
                    color: "rgb(205, 220, 57)",
                    label: "Lime",
                },
                {
                    color: "rgb(255, 235, 59)",
                    label: "Yellow",
                },
                {
                    color: "rgb(255, 193, 7)",
                    label: "Amber",
                },
                {
                    color: "rgb(255, 152, 0)",
                    label: "Orange",
                },
                {
                    color: "rgb(255, 87, 34)",
                    label: "Deep Orange",
                },
                {
                    color: "rgb(121, 85, 72)",
                    label: "Brown",
                },
                {
                    color: "rgb(158, 158, 158)",
                    label: "Grey",
                },
                {
                    color: "rgb(96, 125, 139)",
                    label: "Blue Grey",
                },
            ],
        },
    })
        .then((newEditor) => {
            CKeditor = newEditor;
        })
        .catch((err) => {
            console.error(err.stack);
        });
});
