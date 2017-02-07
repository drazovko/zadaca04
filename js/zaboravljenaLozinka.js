$(document).ready(function() {
    $("#zaboravljenaL").click(function (e) {zaboravljenaLozinka("zaboravljenaL");});

} );

function zaboravljenaLozinka(izbornikID){
    log('over');
    $(izbornikID).css('color', 'green');
}

function log(tekst) {
                $('#konzola').append(tekst + '<br>');
            }