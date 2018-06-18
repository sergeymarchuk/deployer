$(document).ready(function() {
    $(".deploy-start").on('click', function() {
        // Disable deploy buttons
        $(".deploy-start").attr("disabled", true);
        checkAndRun({'status': 'ok', 'message': '', 'next': 'gitPull', 'prev': null});
    });
});

// Construct the script tag at Runtime
function remoteRequest(url) {
    let head = document.head;
    let script = document.createElement("script");
    script.setAttribute("src", '/admin/deploy/' + url);
    head.appendChild(script);
    head.removeChild(script);
}

function checkAndRun(data) {
    if (data.status === 'ok') {
        if (data.prev) {
            lines = data.message.split('\n');
            $('#' + data.prev).val(data.message).attr('rows', lines.length-1);
        }
        $('#' + data.next).attr('placeholder', 'Waiting for result...');
        switch (data.next) {
            case "gitPull": remoteRequest("git-pull?next=composerInstall&prev=gitPull"); break;
            case "composerInstall": remoteRequest("composer-install?next=artisanMigrate&prev=composerInstall"); break;
            case "artisanMigrate": remoteRequest("artisan-migrate?next=finishDeploy&prev=artisanMigrate"); break;
            case "finishDeploy": $('.deploy-start').removeAttr("disabled"); break;
        }
    } else {
        console.log('Error!!!');
    }
}