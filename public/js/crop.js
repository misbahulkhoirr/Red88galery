var $modal = $("#modal");
var image = document.getElementById("image");
var cropper;
var fileTypes = ["jpg", "jpeg", "png"];

$("body").on("change", "#photo", function (e) {
    var files = e.target.files;
    // console.log(files);
    var done = function (url) {
        image.src = url;
        $modal.modal({ backdrop: "static", keyboard: false });
        $modal.modal("show");
    };

    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        var fileExt = file.type.split("/")[1]; // G
        if (fileTypes.indexOf(fileExt) !== -1) {
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
                $("#modal").modal("show");
            }
        } else {
            document.getElementById("photo").value = "";
            document.getElementById("img-hidden").value = "";
            document.querySelector(".img-preview").src = "";
            $(".error").html(
                `<small class="text-danger">Tipe file harus gambar : JPG, JPEG, PNG</small>`
            );
        }
    }
});

$modal
    .on("shown.bs.modal", function () {
        cropper = new Cropper(image, {
            aspectRatio: 16 / 9,
            viewMode: 3,
            preview: ".preview",
            autoCropArea: 1,
            // zoomable: false,
            // scalable: false,
            movable: false,
            // cropBoxResizable: true,
        });
    })
    .on("hidden.bs.modal", function () {
        cropper.destroy();
        cropper = null;
    });

$("#crop").click(function () {
    canvas = cropper.getCroppedCanvas({
        width: 320,
        height: 160,
    });
    canvas.toBlob(function (blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
            var base64data = reader.result;

            var image = new Image();
            image.src = base64data;
            const imgPreview = document.querySelector(".img-preview");
            document.querySelector("#img-hidden").value = image.src;
            imgPreview.style.display = "block";
            imgPreview.src = image.src;
            $modal.modal("hide");
            console.log(image.src);
        };
    });
});

$(".tutup").click(function () {
    $modal.modal("hide");
    document.getElementById("photo").value = "";
});
