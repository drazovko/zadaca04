var idZahtijeva;
$( function() {
    console.log("U funkciji sam 2!");
    var IdKor = $("#IdKor").val();
   
    
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
                //$('<th>').css('color', 'black');
                $('tr').click(function(){
                    $('tr').each(function(){
                    $(this).css('color', 'green');
                });
            
                $(this).css('color', 'blue');
                idZahtijeva = $(this).children('td:first-child').text();
                console.log(idZahtijeva);
                $('#greske').html(idZahtijeva); 
                ispisZahtijeva();
                }
                ); 
                   
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
            );
    
  } );

function zelenaTablica(){
    $('#tablica').css('color', 'green');
}

function ispisZahtijeva(){
    console.log("U funkciji sam 2!");
    
    var tablica = $('<table id="tablica2" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Broj zaht.</th><th class="drugi_stupac">Broj građ.</th><th>Ime građ.</th><th>Prez. građ.</th><th>Datum podnošenja</th><th>Status</th><th>Adresa</th><th>Županija</th><th>Pov. parc.</th><th>Pov. kuće</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/pregledZahtijevaPoZaht.php",
                dataType: 'xml',
                data:{
                    'IdZahtijeva': idZahtijeva
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
        
                $('#tuto2').html(tablica);
            /*    zelenaTablica();
                //$('<th>').css('color', 'black');
                $('tr').click(function(){
                    $('tr').each(function(){
                    $(this).css('color', 'green');
                });
            
                $(this).css('color', 'blue');
                idZahtijeva = $(this).children('td:first-child').text();
                console.log(idZahtijeva);
                $('#greske').html(idZahtijeva); 
                //ispisZahtijeva();
                }
                ); 
              */     
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
            );
}