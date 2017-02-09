

function zaboravljenaLozinka(){
    var korIme = $('#kor_ime').val();
    console.log("U funkciji sam! KorIme = " + korIme);
    if(korIme == ""){
        $('#kor_ime').css("background-color", "orangered");
        $("#kor_ime").effect("highlight", 3000);
        $('#greske').html("Unesite korisničko ime!<hr>");
        $("#greske").effect("highlight", 3000);
        $('#kor_ime').focus();
        return false;
    }
    $('#zaboravljenaL').css('display', 'none');
    $('#zaboravljenaL').css('visibility', 'hidden');
    //$('#lozinka').css("background-color", "orangered");
      //  $("#lozinka").effect("highlight", 3000);
        //$('#greske').html("Unesite korisničko ime!<hr>");
        $("#prijava").effect("highlight", 5000);
      //  $('#lozinka').focus();
        console.log("U funkciji sam 2!");
        $('#greske').html("");
        
    $.ajax(
            {
                type: "GET",
                url: "php_xml/zaboravljenaLozinka.php",
                dataType: 'xml',
                data:{
                    'korisnik': korIme
                },
                success: function (data) {
                    console.log("U funkciji sam 3!");
                    var novaLozinka = $(data).find('korisnik').text();
                    console.log("Nova lozinka promjenjena = " + novaLozinka);
                    if(novaLozinka != 1){
                        $('#lozinka').css("background-color", "orangered");
                        $("#lozinka").effect("highlight", 3000);
                        $('#greske').html("Lozinka nije promijenjena i mail nije poslan (obratite se administratoru)!<hr>");
                        $("#lozinka").effect("highlight", 3000);
                        $('#kor_ime').focus();
                    }
                    else{
                        log('Na Vaš email poslana je nova lozinka!');
                        $('#lozinka').css("background-color", "yellow");
                        $('#kor_ime').css("background-color", "aqua");
                        $("#lozinka").effect("highlight", 3000);
                    } 
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
            );


}

function log(tekst) {
                $('#greske').append('<br>' + tekst + '<hr><br>');
            }