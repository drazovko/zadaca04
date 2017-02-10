$( function() {
    
    var IdKor = $("#IdKor").val();
   
    
    
  $.ajax(
            {
                type: "GET",
                url: "php_xml/zahtijevZaLegalizacijomPoKor.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor
                },
                success: function (data) {
                    console.log("U funkciji sam 3!");
                    var novaLozinka = $(data).find('korisnik').text();
                    console.log("Nova lozinka promjenjena = " + novaLozinka);
                    if(novaLozinka != 1){
                        $('#greske').html("Lozinka nije promijenjena i mail nije poslan (obratite se administratoru)!<hr>");
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
    
  } );

