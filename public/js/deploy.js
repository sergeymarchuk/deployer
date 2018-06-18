$(document).ready(function() {
    $(".deploy-start").on('click', function() {
        checkAndRun({'status': 'OK', 'callback': 'gitPull'});
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
    if (data.status === 'OK') {
        switch (data.callback) {
            case "gitPull": remoteRequest("git-pull?callback=composerInstall"); break;
            case "composerInstall": remoteRequest("composer-install?callback=artisanMigrate"); break;
            case "artisanMigrate": remoteRequest("artisan-migrate?callback=finishDeploy"); break;
            case "finishDeploy": console.log('Finish!!!'); break;
        }
    } else {
        console.log('Error!!!');
    }
}