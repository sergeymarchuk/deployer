$(document).ready(function() {
    $(".deploy-start").on('click', function() {
        checkAndRun({'status': 'OK', 'nextFunc': 'gitPull'});
    });
});

function checkAndRun(data) {
    if (data.status === 'OK') {
        switch (data.nextFunc) {
            case "gitPull": gitPull(); break;
            case "composerInstall": composerInstall(); break;
            case "artisanMigrate": artisanMigrate(); break;
            case "finishDeploy": finishDeploy(); break;
        }
    } else {

    }
}

function gitPull() {
    $.ajax({
        url: '/deploy/git-pull',
        success: checkAndRun,
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error git-pull");
        }
    });
}

function composerInstall() {
    $.ajax({
        url: '/deploy/composer-install',
        success: checkAndRun,
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error composer install");
        }
    });
}

function artisanMigrate() {
    $.ajax({
        url: '/deploy/artisan-migrate',
        success: checkAndRun,
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error Artisan Migrate");
        }
    });
}

function finishDeploy() {
    console.log('Finish!!!');
}