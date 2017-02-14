var idZahtijeva;
var idZahtijeva1;
var idGradjevinara;
var IdKor = $("#IdKor").val();
var komentarRegKor = "";
var imeGradjevinara = "";
var prezimeGradjevinara = "";
var ocjenaGradjevinara;
$("#a2").on('click', popisZupanija());
function popisZupanija() {
    console.log("U funkciji sam 2 popisZupanija!");
    
   
    var tablica = $('<table id="tablica1" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Ime županije</th><th class="drugi_stupac">Ser. br. zahtijeva</th><th>Status</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/zahtijeviGradjevinarZupanije.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3 popisZupanija!");
                    var tbody = $("<tbody>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac" id="prvi">' + $(this).attr('zupanija') + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).text() + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('status') + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica.append(tbody);
                    $('#tuto').html(tablica);
                    $('#tablica1').dataTable(
                        {
                        "aaSorting": [[2, "asc"],[0,"asc"]],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter":true,
                        "bSort":true,
                        "bInfo":true,
                        "bAutoWidth":true
                        });
                    
                    $('#tablica1 tr').click(function(){
                        $('#tablica1 tr').each(function(){
                            $(this).css('color', 'green');
                        });
            
                        $(this).css('color', 'blue');
                        $('#prica').html('');
                        statusZahtijeva1 = "";
                        statusZahtijeva1 = $(this).children('td:eq(2)').text();
                        $('#greske').html("Status zahtijeva: " + statusZahtijeva1);
                        idZahtijeva1 = $(this).children('td:eq(1)').text();
                        
                        $('#tuto5').html('');
                        if (statusZahtijeva1 === "poslan") {
                            $('#tuto5').html('<a id="a1" href="javascript:prihvatiZahtijev()">Prihvati zahtijev!</a> \n');
                            
                        }
                   });      
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
    
}

function zelenaTablica(){
    $('#tablica').css('color', 'green');
}

function prihvatiZahtijev(){
    akcija_9();
    console.log("U funkciji sam 2 prihvatiZahtijev!");
    console.log(idZahtijeva1, IdKor);
  $.ajax(
            {
                type: "GET",
                url: "php_xml/zahtijevGradjevinarPrihvacen.php",
                dataType: 'xml',
                data:{
                    'idZahtijeva': idZahtijeva1,
                    'idKor': IdKor
                },
                success: function (data) {
                    console.log("U funkciji sam 3 prihvatiZahtijev!");
                    var potvrdaObrade = $(data).find('obradjen').text();
                    console.log("Obrađen = " + potvrdaObrade);
                    if(potvrdaObrade != 1){
                        $('#prica').html("Zahtijev nije upisan u bazu podataka!<hr>");
                    }
                    else{
                        $("#prica").html("<br>Zahtijev za legalizaciju je prihvaćen na obradu!<hr><br>");
                        $('#prica').css("background-color", "yellow");
                        $('#prica').css("background-color", "aqua");
                        $("#prica").effect("highlight", 3000);
                        popisZupanija();
                        $('#greske').html('');
                        //svetiPetar();
                        
                    } 
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
}

function akcija_9() {
                $('#a1').css('position', 'absolute')
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
          
$("#a3").on('click', popisZahtijeva());

function popisZahtijeva(){
    console.log("U funkciji sam 2 popisZahtijeva!");
    
   
    var tablica = $('<table id="tablica2" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">ID</th><th class="drugi_stupac">Kor.ime</th><th>Datum podn.</th><th>Status</th><th>Adr.</th><th>Žup.</th><th>P.</th><th>K.</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/zahtijeviGradjevinarZahtijevi.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3 popisZahtijeva!");
                    var tbody = $("<tbody>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac">' + $(this).attr('zahtijev') + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('korIme') + '</td>';
                    red += '<td >' + $(this).attr('datum') + '</td>';
                    red += '<td >' + $(this).attr('status') + '</td>';
                    red += '<td >' + $(this).attr('adresa') + '</td>';
                    red += '<td >' + $(this).attr('zupanija') + '</td>';
                    red += '<td >' + $(this).attr('parcela') + '</td>';
                    
                    
                    red += '<td >' + $(this).text() + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica.append(tbody);
                    $('#tuto2').html(tablica);
                    $('#tablica2').dataTable(
                        {
                        "aaSorting": [[3, "desc"],[0,"asc"]],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter":true,
                        "bSort":true,
                        "bInfo":true,
                        "bAutoWidth":true
                        });
                    $('#tablica2').css('font-size', '12px');
                    
                    $('#tablica2 tr').click(function(){
                        $('#tablica2 tr').each(function(){
                            $(this).css('color', 'green');
                        });
            
                        $(this).css('color', 'blue');
                        $('#prica').html('');
                        statusZahtijeva = "";
                        statusZahtijeva = $(this).children('td:eq(3)').text();
                        $('#greske').html("Status zahtijeva: " + statusZahtijeva);
                        idZahtijeva = $(this).children('td:eq(0)').text();
                        
                        console.log(idZahtijeva);
                         
                        ispisSlikaPoIdZahtijeva();
                        ispisVideaPoIdZahtijeva();
                        ispisDokumenataPoIdZahtijeva();
                        
                        $('#tuto4').html('');
                        if (statusZahtijeva === "prihvaćen") {
                            $('#tuto4').html('<a id="a5" href="javascript:postaviSlike()">Postavite slike za projekt!</a> \n');
                            $('#tuto4').append('  -  ');
                            $('#tuto4').append('<a id="a6" href="javascript:postaviVideo()">Postavite video za projekt!</a> \n');
                            $('#tuto4').append('  -  ');
                            $('#tuto4').append('<a id="a7" href="javascript:postaviDokumente()">Postavite dokumente za projekt!</a> \n<br><br>');
                            $('#tuto4').append('<p align="center"><a id="a8" href="javascript:postaviStatusObradjen()">Postavite status dokumenta na obrađen!</a></p> \n<br><br>');
                        }
                   });      
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
}

function postaviStatusObradjen(){
    
}

function postaviSlike(){
    var window2 = window.open("zahtijeviGradjevinarUploadSlike.php?idZahtijeva=" + idZahtijeva, "Prozor_broj_2",
                    "scrollbars=no, width=500, height=340");
}

function postaviVideo(){
    var window2 = window.open("zahtijeviGradjevinarUploadVideo.php?idZahtijeva=" + idZahtijeva, "Prozor_broj_2",
                    "scrollbars=no, width=500, height=340");
}

function postaviDokumente(){
    var window2 = window.open("zahtijeviGradjevinarUploadDokumenti.php?idZahtijeva=" + idZahtijeva, "Prozor_broj_2",
                    "scrollbars=no, width=500, height=340");
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
                    $('#tuto7').empty();
                    $('#tuto7').append('<h3>Slike od zahtijeva za legalizaciju br. ' + idZahtijeva + '</h3>');
                    var brojac = 0;
                    $(data).find('name').each(function() {
                        brojac++;
                        $('#tuto7').append('<img src="' + $(this).text() + '" alt="' + $(this).attr('imeslike') + '" width="30%">');   
                    });
                    if (brojac === 0) {
                        $('#tuto7').append('<h4 align="center">Nema postavljenih slika!</h4><br><br>');
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
                    $('#tuto8').empty();
                    $('#tuto8').append('<h3>Video od zahtijeva za legalizaciju br. ' + idZahtijeva + '</h3>');
                    var brojac = 0;
                    $(data).find('name').each(function() {
                        brojac++;
                        $('#tuto8').append('<a href="' + $(this).text() + '">Prijava legalizacije video: ' + $(this).attr('imeVidea') + '</a>');   
                    });
                    if (brojac === 0) {
                        $('#tuto8').append('<h4 align="center">Nema postavljenih videa!</h4><br><br>');
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
                    $('#tuto9').empty();
                    $('#tuto9').append('<h3>Dokumenti od zahtijeva za legalizaciju br. ' + idZahtijeva + '</h3>');
                    var brojac = 0;
                    $(data).find('name').each(function() {
                        brojac++;
                        $('#tuto9').append('<a href="' + $(this).text() + '" target="_blank">Prijava legalizacije dokument: ' + $(this).attr('imeDokumenta') + '</a>');   
                    });
                    if (brojac === 0) {
                        $('#tuto9').append('<h4 align="center">Nema postavljenih dokumenata!</h4><br><br>');
                    }
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
        );
}