var klizac1;
$( function() {
    var handle = $( "#custom-handle" );
    $( "#slider" ).slider({
      create: function() {
        handle.text( $( this ).slider( "value" ) );
      },
      slide: function( event, ui ) {
        handle.text( ui.value );
        klizac1 = ui.value;
      }
    });
  } );
  
  var klizac2;
  $( function() {
    var handle2 = $( "#custom-handle2" );
    $( "#slider2" ).slider({
      create: function() {
        handle2.text( $( this ).slider( "value" ) );
      },
      slide: function( event, ui ) {
        handle2.text( ui.value );
        klizac2 = ui.value;
        console.log(klizac2);
      }
    });
  } );
  


  
  $( function() {
    $( ".widget input[type=submit], .widget button" ).button();
    $( "button" ).click( function( event ) {
      event.preventDefault();
      akcija_9();
      $("#prica").css('color', 'blue');
      $("#prica").html("Zahtijev poslan na obradu!<hr><br><br>");
    
    var zupanije = $("#zupanije").val();
    var adresa = $("#adresa").val();
    var IdKor = $("#IdKor").val();
    $("button").hide();
    
    
  $.ajax(
            {
                type: "GET",
                url: "php_xml/zahtijevZaLegalizacijomObrada.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor,
                    'zupanija': zupanije,
                    'adresa': adresa,
                    'klizac1': klizac1,
                    'klizac2': klizac2,
                    'idGradjevinara': idGradjevinara
                    
                },
                success: function (data) {
                    console.log("U funkciji sam 3!");
                    var novaLozinka = $(data).find('korisnik').text();
                    console.log("Nova lozinka promjenjena = " + novaLozinka);
                    if(novaLozinka != 1){
                        $('#prica').html("Zahtijev nije upisan u bazu podataka!<hr>");
                    }
                    else{
                        $("#prica").html("Status zahtijeva je poslan!<hr><br><br>");
                        $('#prica').css("background-color", "yellow");
                        $('#prica').css("background-color", "aqua");
                        $("#prica").effect("highlight", 3000);
                    } 
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            }
            );
    } );
  } );
  $("#zupanije").one( "click", puniIzbornikZupanijama);
  $("#zupanije").on( "click", testSlova2);
  
  
  function testSlova(){
    var izbornikID = $("#greske");
    $(izbornikID).css('color', 'blue');
  }
  
  function testSlova2(){
    var izbornikID = $("#zupanije");
    $(izbornikID).css('color', 'green');
    var vrijednost = $("#zupanije").val();
    console.log(vrijednost);
    if (vrijednost > 0) {
        console.log("Dinamo!");
        puniTablicuGradjevinarima(vrijednost);
    }
}
  
  function akcija_9() {
                $('#slanjeZahtijeva').css('position', 'absolute')
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
            
function puniIzbornikZupanijama()
{
    var izbornikID = $("#zupanije");
    $.ajax({
        url: 'php_xml/pocetna_stranica_jquery.php',
        type: 'GET',
        dataType: 'xml',
        success: function(xml) {
            //isprazniIzbornik(izbornikID);
            $(xml).find('name').each(function() {
                $(izbornikID).append('<option value="' + $(this).attr('sifra') + '">' +
                   $(this).text() + '</option>');
            });
        }
    });
}

var idGradjevinara;
function puniTablicuGradjevinarima(izbornikID)
{
    var tablica = $('<table id="tablica" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Id građevinara</th><th class="drugi_stupac">Ime</th><th>Prezime</th></tr></thead>');
        console.log("Radi");
    
    $.ajax({
        url: "php_xml/zahtijevZaLegalizacijomModeratori.php",
        type: 'GET',
        dataType: 'xml',
        data:{
            'idZupanije': izbornikID
        },
        success: function(xml) {
            var tbody = $("<tbody>");
            $(xml).find('name').each(function() {
                var red = '<tr>';
                red += '<td>' + $(this).attr('idkorisnik') + '</td>';
                red += '<td>' + $(this).attr('ime') + '</td>';
                red += '<td>' + $(this).text() + '</td>';
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
            idGradjevinara = $(this).text();
            console.log(idGradjevinara);
            //$('#greske').html(idGradjevinara);
        }
                );
    /*    $('#tablica').dataTable(
            {
             "aaSorting": [[0, "asc"],[1,"asc"]],
             "bPaginate": true,
             "bLengthChange": true,
             "bFilter":true,
             "bSort":true,
             "bInfo":true,
             "bAutoWidth":true
            });
    */    
        }
    });
}
function zelenaTablica(){
    $('#tablica').css('color', 'green');
}