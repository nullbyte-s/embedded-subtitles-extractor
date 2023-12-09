$(document).ready(function () {
    function loadContent(dir) {
        $.ajax({
            url: "backend/navegar_legenda.php?dir=" + dir,
            method: "GET",
            success: function (data) {
                $(".modal-body").html(data);
            }
        });
    }

    function displayNotification(message) {
        mdtoast(message, {
            duration: 3000,
            type: mdtoast.INFO,
            interaction: false
        });
    }

    var isModalOpened = false;

    $("#listaModal").on("show.bs.modal", function () {
        var currentDir = window.location.search.split('dir=')[1] || '';
        loadContent(currentDir);
        isModalOpened = true;
    });

    $("#listaModal").on("hidden.bs.modal", function () {
        if (isModalOpened) {
            window.history.pushState({ modal: false }, '', 'index.php');
            isModalOpened = false;
        }
    });

    $(".modal-body").on("click", ".directory-link", function (event) {
        event.preventDefault();
        var target = $(this).data('dir');
        loadContent(target);
        window.history.pushState({ modal: true }, '', 'index.php?dir=' + target);
    });

    $(".modal-body").on("click", ".file-link", function (event) {
        event.preventDefault();

        var filePath = $(this).data('file');
        var target = encodeURIComponent(filePath);

        $.ajax({
            url: 'backend/executar_script.php?file=' + target,
            method: 'GET',
            success: function (data) {
                displayNotification(data);
                var currentDir = window.location.search.split('dir=')[1] || '';
                loadContent(currentDir);
                window.history.pushState({ modal: true }, '', 'index.php?dir=' + currentDir);
            }
        });
    });

    $(".modal-body").on("click", ".btn-back", function (event) {
        event.preventDefault();
        var parentDir = $(this).data('parent-dir');
        parentDir = parentDir || '';

        $.ajax({
            url: 'backend/navegar_legenda.php?dir=' + parentDir,
            method: 'GET',
            success: function (data) {
                $(".modal-body").html(data);
                window.history.pushState({ modal: true }, '', 'index.php?dir=' + parentDir);
            }
        });
    });
});