/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var provjera_lozinke = document.getElementById("lozinka");
var provjera_obrasca = document.getElementById("obrazac");
var submit_button = document.getElementById("submit_btn");
var provjera_grada = document.getElementById("grad");
var provjera_adrese = document.getElementById("adresa");
var provjera_imena = document.getElementById("ime");
var provjera_prezimena = document.getElementById("prezime");
var provjera_spola = document.getElementById("spol");
var provjera_spola1 = document.getElementById("spol1");
var provjera_spola2 = document.getElementById("spol2");


var poruke_greske = {grad: "Grad se piše sa velikim početnim slovom!<hr>",
		adresa:	 "Adresa mora biti unešena i imati manje od 100 znakova!<hr>",
		ime:	 "Ime se piše velikim početnim slovom!<hr>",
		prezime: "Prezime se piše velikim početnim slovom!<hr>",
		spol:	 "Spol nije odabran! Odaberite.<hr>",
		lozinka: "Neispravna lozinka: minimalno 10 znakova sa brojevima i malim i velikim slovima.<hr>",
                unesite: "Unesite potrebne podatke! <hr>",
                ponovite: "Ponovite unos! ",
                ok: ""
            };
            
var obriši_greške = true;    
var doc_ok = false;




//provjera_lozinke.addEventListener("blur", function (e) { lozinka_test(lozinka); });
provjera_grada.addEventListener("blur", function (e) { veliko_slovo(grad); });
provjera_imena.addEventListener("keypress", function (e) { veliko_slovo(ime); });
provjera_prezimena.addEventListener("keypress", function (e) { veliko_slovo(prezime); });
provjera_adrese.addEventListener("blur", function (e) { sto_znakova(adresa); });
provjera_spola.addEventListener("blur", function (e) { odabir_spola(spol); });
provjera_spola1.addEventListener("blur", function (e) { odabir_spola(spol1); });
provjera_spola2.addEventListener("blur", function (e) { odabir_spola(spol2); });

provjera_obrasca.addEventListener("submit", function (e)  

{
    if(!veliko_slovo(grad)){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!veliko_slovo(ime)){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!veliko_slovo(prezime)){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!sto_znakova(adresa)){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!odabir_spola(spol)){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!lozinka_test(lozinka)){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!ima_nema(document.getElementById("mail"))){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!ima_nema(document.getElementById("kor_ime"))){
        submit_button.disabled = true;
        e.preventDefault();
    };
    obriši_greške = false;
    if(!ima_nema(document.getElementById("telefon"))){
        submit_button.disabled = true;
        e.preventDefault();
    };  
    obriši_greške = false;
    if(!ima_nema(document.getElementById("dat_rodj"))){
        submit_button.disabled = true;
        e.preventDefault();
    };
//    alert("KRAJ PROVJERE");
    
});

function ima_nema(provjera_inputa){
//    alert("Provjera IMA NEMA: PROVJERAVAM " + provjera_inputa.id);
    vrijednost = provjera_inputa.value;
    
    if (vrijednost.length < 1) {
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.unesite;
        
        provjera_inputa.focus();
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    else {
        provjera_inputa.className = 'točno';
        if(obriši_greške){
            document.getElementById("greske").innerHTML = poruke_greske.ok;
        };
        doc_ok = true;
        submit_button.disabled = false;
        return doc_ok;
    }
}


function lozinka_test(provjera_inputa){
    vrijednost = provjera_inputa.value;
    ispis = provjera_inputa.id;
    
    var patt = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{10,}$/g;
    if (vrijednost.length < 1){
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.unesite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        provjera_inputa.focus();
        doc_ok = false;
        obriši_greške = true;
        return doc_ok;
    }
    else if ( vrijednost.length > 9 && patt.test(provjera_inputa.value) ){
        
        provjera_inputa.className = 'točno';
        if(obriši_greške){
            document.getElementById("greske").innerHTML = poruke_greske.ok;
        };
        doc_ok = true;
        submit_button.disabled = false;
        return doc_ok; 
    }
    else {
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.ponovite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        provjera_inputa.focus();
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    
}


function  odabir_spola(provjera_inputa){
    vrijednost = provjera_inputa.value;
    ispis = provjera_inputa.name;
    if ( !document.getElementById("spol").checked && !document.getElementById("spol1").checked ) {
        
        document.getElementById("greske").innerHTML = poruke_greske.unesite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    else {
//       alert("Odabran spol");
        if(obriši_greške){
            document.getElementById("greske").innerHTML = poruke_greske.ok;
        };
        doc_ok = true;
        submit_button.disabled = false;
        return doc_ok;
    }
}

function sto_znakova(provjera_inputa){
    vrijednost = provjera_inputa.value;
    ispis = provjera_inputa.id;
    if (vrijednost.length < 1) {
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.unesite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        provjera_inputa.focus();
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    else if (vrijednost.length > 100) {
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.ponovite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        provjera_inputa.focus();
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    else {
        provjera_inputa.className = 'točno';
        if(obriši_greške){
        document.getElementById("greske").innerHTML = poruke_greske.ok;
        };
        doc_ok = true;
        submit_button.disabled = false;
        return doc_ok;
    }
}

function veliko_slovo(provjera_inputa){
 //   alert("Provjera veliko slovo: obriši greške = " + obriši_greške);
    vrijednost = provjera_inputa.value;
    ispis = provjera_inputa.id;
    if (vrijednost.length < 1 || !isNaN(vrijednost[0])) {
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.unesite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        provjera_inputa.focus();
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    else if (vrijednost[0] !== vrijednost[0].toUpperCase() ) {
        provjera_inputa.className = 'netočno';
        document.getElementById("greske").innerHTML = poruke_greske.ponovite;
        document.getElementById("greske").innerHTML += poruke_greske[ispis];
        provjera_inputa.focus();
        obriši_greške = true;
        doc_ok = false;
        return doc_ok;
    }
    else {
        provjera_inputa.className = 'točno';
        if(obriši_greške){
            document.getElementById("greske").innerHTML = poruke_greske.ok;
        };
        doc_ok = true;
        submit_button.disabled = false;
        return doc_ok;
    }
}