var idZahtijeva;
var idGradjevinara;
var IdKor = $("#IdKor").val();
var komentarRegKor = "";
var imeGradjevinara = "";
var prezimeGradjevinara = "";
var ocjenaGradjevinara;
$(function () {
    console.log("U funkciji sam 2!");
    
   
    var tablica = $('<table id="tablica" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Broj zaht.</th><th class="drugi_stupac">Broj građ.</th><th>Ime građ.</th><th>Prez. građ.</th><th>Datum podnošenja</th><th>Status</th><th>Adresa</th><th>Županija</th><th>Pov. parc.</th><th>Pov. kuće</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaPoKor.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3!");
                    var tbody = $("<tbody>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac" id="prvi">' + $(this).text() + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('idGradjevinara') + '</td>';
                    red += '<td>' + $(this).attr('ime') + '</td>';
                    red += '<td>' + $(this).attr('prezime') + '</td>';
                    red += '<td>' + $(this).attr('datum') + '</td>';
                    red += '<td>' + $(this).attr('status') + '</td>';
                    red += '<td>' + $(this).attr('adresa') + '</td>';
                    red += '<td>' + $(this).attr('zupanija') + '</td>';
                    red += '<td>' + $(this).attr('parcela') + '</td>';
                    red += '<td>' + $(this).attr('kuca') + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica.append(tbody);
                    $('#tuto').html(tablica);
                    
                    zelenaTablica();
                    
                    $('tr').click(function(){
                        $('tr').each(function(){
                            $(this).css('color', 'green');
                        });
            
                        $(this).css('color', 'blue');
                        idZahtijeva = $(this).children('td:first-child').text();
                        idGradjevinara = $(this).children('td:eq(1)').text();
                        imeGradjevinara = $(this).children('td:eq(2)').text();
                        prezimeGradjevinara = $(this).children('td:eq(3)').text();
                        statusZahtijeva = "";
                        statusZahtijeva = $(this).children('td:eq(5)').text();
                        console.log(statusZahtijeva);
                        $('#greske').html("Status zahtijeva: " + statusZahtijeva);
                        $("#prica").html('');
                        // ocjenjivanje i komentiranje građevinara
                        $('#tuto6').html('');
                        if (statusZahtijeva === "obrađen" || statusZahtijeva === "prihvaćen" || statusZahtijeva === "potvrđen") {
                            $('#tuto6').html('<h3>Komentiranje i ocjenjivanje odabranog građevinara</h3>' + "\n" 
                                    + '<label for="imeGradjevinara">Ime i prezime građevinara: </label>' + "\n"
                                    + '<input type="text" disabled="" name="imeGradjevinara" id="imeGradjevinara"' 
                                    + 'readonly="" value=" - - - ' + imeGradjevinara + ' ' + prezimeGradjevinara +  ' - - -">' 
                                    + '<label for="komentar">Komentar građevinara: </label>' + "\n" 
                                    + '<textarea name="komentarRegKor" id="komentarRegKor" rows="3" cols="30" ></textarea><br />');
                            $('#tuto6').append('<div id="reservation">' + "\n"
                                + '<label for="minbeds">Ocjena građevinara:</label>' + "\n"
                                + '<select name="minbeds" id="minbeds">' + "\n"
                                + '<option>1</option>' + "\n"
                                + '<option>2</option>' + "\n"
                                + '<option>3</option>' + "\n"
                                + '<option>4</option>' + "\n"
                                + '<option>5</option>' + "\n"
                                + '</select>' + "\n" 
                                + '</div><br><br>' + "\n");
                            
                            $('#tuto6').append('<a id="linkKomentar" href="javascript:spremiKomentar()">Spremi komentar!</a> \n');
                            $('#tuto6').append(' - ');
                            $('#tuto6').append('<a id="linkOcjena" href="javascript:spremiOcjenu()">Spremi ocjenu!</a> \n');
                            $('#tuto6').append(' - ');
                            $('#tuto6').append('<a id="linkSviKomentari" href="javascript:prikaziSveKomentare()">Prikaži sve komentare za odabranog građevinara!</a> \n');
                            ocjenaGradjevinara = 1;
                            $( function() {
                                var select = $( "#minbeds" );
                                var slider = $( "<div id='slider'></div>" ).insertAfter( select ).slider({
                                min: 1,
                                max: 5,
                                range: "min",
                                value: select[ 0 ].selectedIndex + 1,
                                slide: function( event, ui ) {
                                    select[ 0 ].selectedIndex = ui.value - 1;
                                    ocjenaGradjevinara = ui.value;
                                }
                                });
                                $( "#minbeds" ).on( "change", function() {
                                    slider.slider( "value", this.selectedIndex + 1 );
                                    ocjenaGradjevinara = this.selectedIndex + 1;
                                });
                            } );
                        
                        }
                        $('#tuto5').html('');
                        // potvrđivanje obrađenog naloga
                        if (statusZahtijeva === "obrađen") {
                            $('#tuto5').html('<a id="potvrda" href="javascript:potvrdaObradjenogZahtijeva()">Potvrdi postupak obrade!</a>');
                            $('#greske').html('');
                        }
                        
                        console.log(idZahtijeva);
                         
                        ispisSlikaPoIdZahtijeva();
                        ispisVideaPoIdZahtijeva();
                        ispisDokumenataPoIdZahtijeva();
                    });    
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
    
});



function zelenaTablica(){
    $('#tablica').css('color', 'green');
}

function ispisSlikaPoIdZahtijeva(){
    console.log("U funkciji sam 22!");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaSlike.php",
                dataType: 'xml',
                data:{
                    'IdZahtijeva': idZahtijeva
                },
                success: function (data) {
                    console.log("U funkciji sam 33!");
                    $('#tuto2').empty();
                    $('#tuto2').append('<h3>Slike od zahtijeva za legalizaciju br. ' + idZahtijeva + '</h3>');
                    var brojac = 0;
                    $(data).find('name').each(function() {
                        brojac++;
                        $('#tuto2').append('<img src="' + $(this).text() + '" alt="' + $(this).attr('imeslike') + '" width="30%">');   
                    });
                    if (brojac === 0) {
                        $('#tuto2').append('<h4 align="center">Nema postavljenih slika!</h4><br><br>');
                    }
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}



function ispisVideaPoIdZahtijeva(){
    console.log("U funkciji sam 22!");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaVideo.php",
                dataType: 'xml',
                data:{
                    'IdZahtijeva': idZahtijeva
                },
                success: function (data) {
                    console.log("U funkciji sam 33!");
                    $('#tuto3').empty();
                    $('#tuto3').append('<h3>Video od zahtijeva za legalizaciju br. ' + idZahtijeva + '</h3>');
                    var brojac = 0;
                    $(data).find('name').each(function() {
                        brojac++;
                        $('#tuto3').append('<a href="' + $(this).text() + '">Prijava legalizacije video: ' + $(this).attr('imeVidea') + '</a>');   
                    });
                    if (brojac === 0) {
                        $('#tuto3').append('<h4 align="center">Nema postavljenih videa!</h4><br><br>');
                    }
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}

function ispisDokumenataPoIdZahtijeva(){
    console.log("U funkciji sam 22!");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaDokumenti.php",
                dataType: 'xml',
                data:{
                    'IdZahtijeva': idZahtijeva
                },
                success: function (data) {
                    console.log("U funkciji sam 33!");
                    $('#tuto4').empty();
                    $('#tuto4').append('<h3>Dokumenti od zahtijeva za legalizaciju br. ' + idZahtijeva + '</h3>');
                    var brojac = 0;
                    $(data).find('name').each(function() {
                        brojac++;
                        $('#tuto4').append('<a href="' + $(this).text() + '" target="_blank">Prijava legalizacije dokument: ' + $(this).attr('imeDokumenta') + '</a>');   
                    });
                    if (brojac === 0) {
                        $('#tuto4').append('<h4 align="center">Nema postavljenih dokumenata!</h4><br><br>');
                    }
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}

function potvrdaObradjenogZahtijeva(){
    
    akcija_9();
    
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaPotvrdaObr.php",
                dataType: 'xml',
                data:{
                    'IdZahtijeva': idZahtijeva 
                },
                success: function (data) {
                    console.log("U funkciji sam 3!");
                    var potvrdaObrade = $(data).find('obradjen').text();
                    console.log("Obrađen = " + potvrdaObrade);
                    if(potvrdaObrade != 1){
                        $('#prica').html("Zahtijev nije upisan u bazu podataka!<hr>");
                    }
                    else{
                        $("#prica").html("Zahtijev za legalizaciju je potvrđen!<hr><br><br>");
                        $('#prica').css("background-color", "yellow");
                        $('#prica').css("background-color", "aqua");
                        $("#prica").effect("highlight", 3000);
                        svetiPetar();
                    } 
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}

function akcija_9() {
                $('#potvrda').css('position', 'absolute')
                        .animate(
                        {
                            opacity: 0,
                            top: 10,
                            left: $(window).width()
                        },
                'slow',
                        function() {
                            $(this).hide();
                        });
            }
            
function svetiPetar() {
    $('#tuto').html("blja");
    console.log("U funkciji sam 2svetiPetar!");
    
   
    var tablica = $('<table id="tablica" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Broj zaht.</th><th class="drugi_stupac">Broj građ.</th><th>Ime građ.</th><th>Prez. građ.</th><th>Datum podnošenja</th><th>Status</th><th>Adresa</th><th>Županija</th><th>Pov. parc.</th><th>Pov. kuće</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaPoKor.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3SvetiPetar!");
                    var tbody = $("<tbody>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac" id="prvi">' + $(this).text() + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('idGradjevinara') + '</td>';
                    red += '<td>' + $(this).attr('ime') + '</td>';
                    red += '<td>' + $(this).attr('prezime') + '</td>';
                    red += '<td>' + $(this).attr('datum') + '</td>';
                    red += '<td>' + $(this).attr('status') + '</td>';
                    red += '<td>' + $(this).attr('adresa') + '</td>';
                    red += '<td>' + $(this).attr('zupanija') + '</td>';
                    red += '<td>' + $(this).attr('parcela') + '</td>';
                    red += '<td>' + $(this).attr('kuca') + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica.append(tbody);
                    $('#tuto').html(tablica);
                    $('#greske').html('');
                    
                    zelenaTablica();
                    
                    $('tr').click(function(){
                        $("#prica").html('');
                        $('tr').each(function(){
                            $(this).css('color', 'green');
                        });
            
                        $(this).css('color', 'blue');
                        idZahtijeva = $(this).children('td:first-child').text();
                        statusZahtijeva = $(this).children('td:eq(5)').text();
                        $('#greske').html("Status zahtijeva: " + statusZahtijeva);
                        
                        // svetiPetar - ocjenjivanje i komentiranje građevinara 
                        $('#tuto6').html('');
                        
                        
                        
                        $('#tuto5').html('');
                        if (statusZahtijeva === "obrađen") {
                            $('#tuto5').html('<a id="potvrda" href="javascript:potvrdaObradjenogZahtijeva()">Potvrdi postupak obrade!</a>');
                            
                        }
                        console.log(idZahtijeva);
                         
                        ispisSlikaPoIdZahtijeva();
                        ispisVideaPoIdZahtijeva();
                        ispisDokumenataPoIdZahtijeva();
                    });    
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
    
}

function spremiKomentar(){
    komentarRegKor = $('#komentarRegKor').val();
    console.log("U funkciji sam 2 spremiKomentar!");
    console.log(idGradjevinara, IdKor, komentarRegKor);
    
    $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaUnosKomentara.php",
                dataType: 'xml',
                data:{
                    'idZahtijeva': idZahtijeva,
                    'idGradjevinara': idGradjevinara,
                    'idKorisnika': IdKor,
                    'komentarRegKor': komentarRegKor
                },
                success: function (data) {
                    console.log("U funkciji sam 3 spremiKomentar!");
                    var potvrdaObrade = $(data).find('obradjen').text();
                    console.log("Komentar spremljen = " + potvrdaObrade);
                    if(potvrdaObrade != 1){
                        $('#prica').html("Zahtijev nije upisan u bazu podataka!<hr>");
                    }
                    else{
                        $("#prica").html("<br>Komentar registriranog korisnika je spremljen!<hr><br>");
                        $('#prica').css("background-color", "yellow");
                        $('#prica').css("background-color", "aqua");
                        $("#prica").effect("highlight", 3000);
                        skrivanjeLinkaKomentar();
                    } 
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}

function spremiOcjenu(){
    console.log("U funkciji sam 2 spremiOcjenu!");
    console.log(ocjenaGradjevinara);
    
    $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaUnosOcjene.php",
                dataType: 'xml',
                data:{
                    'idGradjevinara': idGradjevinara,
                    'idKorisnika': IdKor,
                    'ocjenaGradjevinara': ocjenaGradjevinara,
                    'idZahtijeva': idZahtijeva
                },
                success: function (data) {
                    console.log("U funkciji sam 3 spremiOcjenu!");
                    var potvrdaObrade = $(data).find('obradjen').text();
                    console.log("Komentar spremljen = " + potvrdaObrade);
                    if(potvrdaObrade != 1){
                        $('#prica').html("Ocjena nije upisana u bazu podataka!<hr>");
                    }
                    else{
                        $("#prica").html("<br>Ocjena građevinara je spremljena!<hr><br>");
                        $('#prica').css("background-color", "yellow");
                        $('#prica').css("background-color", "aqua");
                        $("#prica").effect("highlight", 3000);
                        skrivanjeLinkaOcjena();
                    } 
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}

function skrivanjeLinkaOcjena() {
                $('#linkOcjena').css('position', 'absolute')
                        .animate(
                        {
                            opacity: 0,
                            top: 10,
                            left: $(window).width()
                        },
                'slow',
                        function() {
                            $(this).hide();
                        });
            }
            
function skrivanjeLinkaKomentar() {
                $('#linkKomentar').css('position', 'absolute')
                        .animate(
                        {
                            opacity: 0,
                            top: 10,
                            left: $(window).width()
                        },
                'slow',
                        function() {
                            $(this).hide();
                        });
            }
            
function prikaziSveKomentare(){
    console.log("U funkciji sam 2 prikaziSveKomentare!");
    
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaSviKomentari.php",
                dataType: 'xml',
                data:{
                    'idGradjevinara': idGradjevinara,
                    'idKor': IdKor
                },
                success: function (data) {
                    
                    console.log("U funkciji sam 3 prikaziSveKomentare!");
   
                    $('#tuto6').append('<h3>Pregled svih komentara za odabranog građevinara</h3>');
                    var tablica = $('<table id="tablicaGradjevinari" class="display" cellspacing="0" width="100%">');
                    tablica.append('<thead><tr><th class="prvi_stupac">Reg. korisnik</th><th class="drugi_stupac">Komentar</th></tr></thead>');
                    var brojac = 0;
                    var tbody = $("<tbody>");
                    $(data).find('gradjevinar').each(function() {
                        brojac++;
                        var red = '<tr>';
                        red += '<td class="prvi_stupac">' + $(this).attr('korIme') + '</td>';
                        red += '<td class="drugi_stupac">' + $(this).text() + '</td>';
                        red += '</tr>';
                        tbody.append(red);   
                    });
                    tbody.append("</tbody>");
                    tablica.append(tbody);
                    
                    zelenaTablica();
                    if (brojac === 0) {
                        $('#tuto6').append('<h4 align="center">Za odabranog građevinara nema komentara!</h4><br><br>');
                    }else{
                        $('#tuto6').append(tablica);
                    }
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}