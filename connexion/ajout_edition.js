function showLieux(event) {
    document.getElementById("form3").style.display = "block";
}
function hideLieux(event) {
    document.getElementById("form3").style.display = "none";
}
function showAddLieux(event) {
    document.getElementById("form4").style.display = "block";
}
function hideAddLieux(event) {
    document.getElementById("form4").style.display = "none";
}

let inputDate = document.getElementById('date_festival');
let inputDuree = document.getElementById('duree_festival');

function getJour(day) {
    switch (day) {
        case 1:
            return "Lundi";
        case 2:
            return "Mardi";
        case 3:
            return "Mercredi";
        case 4:
            return "Jeudi";
        case 5:
            return "Vendredi";
        case 6:
            return "Samedi";
        case 0:
            return "Dimanche";
    }
}

function getMois(month) {
    switch (month) {
        case 0:
            return "Janvier";
        case 1:
            return "Fevrier";
        case 2:
            return "Mars";
        case 3:
            return "Avril";
        case 4:
            return "Mai";
        case 5:
            return "Juin";
        case 6:
            return "Juillet";
        case 7:
            return "Aout";
        case 8:
            return "Septembre";
        case 9:
            return "Octobre";
        case 10:
            return "Novembre";
        case 11:
            return "Decembre";
    }
}

let ancienneDuree = 0;
function updateDuree(ancienneDureeInput, nouvelleDuree) {
    if (ancienneDureeInput < nouvelleDuree) {
        let elementsDejaExistants = document.getElementsByClassName("lieu");
        let tabHeure = document.getElementsByClassName("tab_tr_heure");
        for (i = 0; i < elementsDejaExistants.length; i++) {
            for (j = 0; j < 24; j++) {
                    let tdInputHeureM = document.createElement("td");
                    let inputHeureM = document.createElement("input");
                    inputHeureM.setAttribute("type", "number");
                    inputHeureM.setAttribute("id", elementsDejaExistants[i].id + "_heure" + j + "_jour" + ancienneDureeInput + "_M");
                    inputHeureM.setAttribute("name", elementsDejaExistants[i].id + "_heure" + j + "_jour" + ancienneDureeInput + "_M");
                    inputHeureM.setAttribute("min", "0");
                    inputHeureM.setAttribute("class", "input_heure");
                    inputHeureM.setAttribute("style", "background-color:black; color: #FEFEE8; font-weight: bold; font-size: 1.2rem; text-align: center; width: 92px; border: none;");
                    inputHeureM.setAttribute("value", "0");
                    inputHeureM.setAttribute
                    tdInputHeureM.setAttribute("class", "tab_heure_input");
                    tdInputHeureM.setAttribute("style", "border: 1px solid #FEFEE8;border-collapse: collapse; display: none;");
                    tdInputHeureM.appendChild(inputHeureM);
                    tabHeure[j].appendChild(tdInputHeureM);
                    let tdInputHeureB = document.createElement("td");
                    let inputHeureB = document.createElement("input");
                    inputHeureB.setAttribute("type", "number");
                    inputHeureB.setAttribute("id", elementsDejaExistants[i].id + "_heure" + j + "_jour" + ancienneDureeInput + "_B");
                    inputHeureB.setAttribute("name", elementsDejaExistants[i].id + "_heure" + j + "_jour" + ancienneDureeInput + "_B");
                    inputHeureB.setAttribute("style", "background-color:black; color: #FEFEE8; font-weight : bold; font-size: 1.2rem; text-align: center; width: 92px; border: none;");
                    inputHeureB.setAttribute("min", "0");
                    inputHeureB.setAttribute("class", "input_heure");
                    inputHeureB.value = 0;
                    tdInputHeureB.setAttribute("class", "tab_heure_input");
                    tdInputHeureB.setAttribute("style", "border: 1px solid #FEFEE8;border-collapse: collapse; display: none;");
                    tdInputHeureB.appendChild(inputHeureB);
                    tabHeure[j].appendChild(tdInputHeureB);
                
            }

        }
        ancienneDuree = nouvelleDuree;
    }
    
}


function updateValue(e) {
    let anciennesValeurs = document.getElementsByClassName("tab_jour");
    let anciennesValeurs2 = document.getElementsByClassName("tab_besoins");
    let anciennesValeurs3 = document.getElementsByClassName("tab_heure_input_tmp");
    if (anciennesValeurs.length != 0) {
        while (anciennesValeurs.length > 0) {
            document.getElementById("thead1").removeChild(anciennesValeurs[0]);
        }
        while (anciennesValeurs2.length > 0) {
            document.getElementById("thead2").removeChild(anciennesValeurs2[0]);
        }
        while (anciennesValeurs3.length > 0) {
            anciennesValeurs3[0].parentNode.removeChild(anciennesValeurs3[0]);
        }
    }
    if (inputDate.value != "") {
        let dateFestival = new Date(document.getElementById('date_festival').value);
        let thead1 = document.getElementById("thead1");
        let thead2 = document.getElementById("thead2");
        let tabHeure = document.getElementsByClassName("tab_tr_heure");
        for (i = 0; i < inputDuree.value; i++) {
            let date = document.createElement("TH");
            date.classList.add("tab_jour");
            date.setAttribute("colspan", "2");
            let membre = document.createElement("TH");
            membre.classList.add("tab_besoins");
            membre.appendChild(document.createTextNode("Membres"));
            let benevole = document.createElement("TH");
            benevole.classList.add("tab_besoins");
            benevole.appendChild(document.createTextNode("Benevoles"));
            date.innerHTML = getJour(dateFestival.getDay()) + " " + dateFestival.getDate() + " " + getMois(dateFestival.getMonth()) + " " + dateFestival.getFullYear();
            thead1.appendChild(date);
            thead2.appendChild(membre);
            thead2.appendChild(benevole);
            dateFestival.setDate(dateFestival.getDate() + 1);
        }

        for (j = 0; j < 24; j++) {
            for (i = 0; i < inputDuree.value; i++) {
                let tdInputHeureM = document.createElement("td");
                let inputHeureM = document.createElement("input");
                inputHeureM.setAttribute("type", "number");
                inputHeureM.setAttribute("id", "heure" + j + "_jour" + i + "_M");
                inputHeureM.setAttribute("name", "heure" + j + "_jour" + i + "_M");
                inputHeureM.setAttribute("min", "0");
                inputHeureM.setAttribute("class", "input_heure_tmp");
                inputHeureM.setAttribute("style", "background-color:black; color: #FEFEE8; font-weight: bold; font-size: 1.2rem; text-align: center; width: 92px; border: none;");
                tdInputHeureM.setAttribute("class", "tab_heure_input_tmp");
                tdInputHeureM.setAttribute("style", "border: 1px solid #FEFEE8;border-collapse: collapse;");
                tdInputHeureM.appendChild(inputHeureM);
                tabHeure[j].appendChild(tdInputHeureM);
                let tdInputHeureB = document.createElement("td");
                let inputHeureB = document.createElement("input");
                inputHeureB.setAttribute("type", "number");
                inputHeureB.setAttribute("id", "heure" + j + "_jour" + i + "_B");
                inputHeureB.setAttribute("name", "heure" + j + "_jour" + i + "_B");
                inputHeureB.setAttribute("style", "background-color:black; color: #FEFEE8; font-weight : bold; font-size: 1.2rem; text-align: center; width: 92px; border: none;");
                inputHeureB.setAttribute("min", "0");
                inputHeureB.setAttribute("class", "input_heure_tmp");
                tdInputHeureB.setAttribute("class", "tab_heure_input_tmp");
                tdInputHeureB.setAttribute("style", "border: 1px solid #FEFEE8;border-collapse: collapse;");
                tdInputHeureB.appendChild(inputHeureB);
                tabHeure[j].appendChild(tdInputHeureB);
            }
        }

    }
    updateDuree(ancienneDuree, document.getElementById("duree_festival").value);
}

function supprimeLieu(lieu) {
    for (i = 0; i < inputDuree.value; i++) {
        for (j = 0; j < 24; j++) {
            document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_M").parentNode.parentNode.removeChild(document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_M").parentNode);
            document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_B").parentNode.parentNode.removeChild(document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_B").parentNode);
        }
    }
    lieu.parentNode.removeChild(lieu);
    document.getElementById("lieu_" + lieu.id).parentNode.removeChild(document.getElementById("lieu_" + lieu.id));
    document.getElementById("couleur_" + lieu.id).parentNode.removeChild(document.getElementById("couleur_" + lieu.id));
}

function convertisseurRgb_Hex(rgb) {
    let red = parseInt(rgb.slice(3, rgb.indexOf(','))).toString(16);
    let green = parseInt(rgb.slice(rgb.indexOf(','), rgb.lastIndexOf(','))).toString(16);
    let blue = parseInt(rgb.slice(rgb.lastIndexOf(','), rgb.indexOf(')'))).toString(16);
    return '#' + red + green + blue;
}


function showInfosLieu(lieu) {
    document.getElementById("form4").style.display = "block";
    document.getElementById("lieu_festival").value = lieu.id;
    document.getElementById("couleur_lieu").value = document.getElementById("couleur_" + lieu.id).value;

    for (i = 0; i < inputDuree.value; i++) {
        for (j = 0; j < 24; j++) {
            document.getElementById("heure" + j + "_jour" + i + "_M").value = document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_M").value;
            document.getElementById("heure" + j + "_jour" + i + "_B").value = document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_B").value;
        }
    }
    document.getElementById("bouton_ajouter").innerHTML = "MODIFIER";
    document.getElementById("bouton_ajouter").setAttribute("onclick", "changeInfos(" + lieu.id + "); hideInfosLieu(" + lieu.id + ")");
    document.getElementById("form4_close").setAttribute("onclick", "hideInfosLieu(" + lieu.id + ");");

}
function hideInfosLieu(lieu) {
    document.getElementById("form4").style.display = "none";
    document.getElementById("lieu_festival").value = "";
    document.getElementById("couleur_lieu").value = "#000000";

    for (i = 0; i < inputDuree.value; i++) {
        for (j = 0; j < 24; j++) {
            document.getElementById("heure" + j + "_jour" + i + "_M").value = "";
            document.getElementById("heure" + j + "_jour" + i + "_B").value = "";
        }
    }
    document.getElementById("bouton_ajouter").innerHTML = "AJOUTER";
    document.getElementById("bouton_ajouter").setAttribute("onclick", "setValue()");
    document.getElementById("form4_close").setAttribute("onclick", "hideAddLieux(event)");
}

function lieuDejaExistant(lieu) {
    let lieuxExistants = document.getElementsByClassName("lieu");
    for (i = 0; i < lieuxExistants.length; i++) {
        if (lieu == lieuxExistants[i].id) {
            return true;
        }
    }
    return false;
}

function changeInfos(lieu) {
    document.getElementById("couleur_" + lieu.id).value = document.getElementById("couleur_lieu").value;

    for (i = 0; i < inputDuree.value; i++) {
        for (j = 0; j < 24; j++) {
            document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_M").value = document.getElementById("heure" + j + "_jour" + i + "_M").value;
            document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_M").id = document.getElementById("lieu_festival").value + "_heure" + j + "_jour" + i + "_M";
            document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_B").value = document.getElementById("heure" + j + "_jour" + i + "_B").value;
            document.getElementById(lieu.id + "_heure" + j + "_jour" + i + "_B").id = document.getElementById("lieu_festival").value + "_heure" + j + "_jour" + i + "_B";
        }
    }

    document.getElementById(lieu.id).style.backgroundColor = document.getElementById("couleur_lieu").value;
    lieu.firstElementChild.innerText = document.getElementById("lieu_festival").value;
    document.getElementById("couleur_" + lieu.id).value = "couleur_" + document.getElementById("lieu_festival").value;
    document.getElementById("lieu_" + lieu.id).id = "lieu_" + document.getElementById("lieu_festival").value;
    lieu.value = document.getElementById("lieu_festival").value;
}

function setValue() {
    let nomLieu = document.getElementById("lieu_festival");
    if (lieuDejaExistant(nomLieu.value) == false) {
        let tab_heure_input = document.getElementsByClassName("tab_heure_input_tmp");
        let input_heure = document.getElementsByClassName("input_heure_tmp");
        let couleurLieu = document.getElementById("couleur_lieu");
        let champsComplets = true;
        if (!nomLieu.value || nomLieu.value == "") {
            champsComplets = false;
        }
        for (i = 0; i < tab_heure_input.length; i++) {
            if (!input_heure[i].value) {
                champsComplets = false;
            }
        }
        if (champsComplets == false) {
            return alert("Champs Incomplets");
        }
        while (tab_heure_input.length > 0) {
            tab_heure_input[0].style.display = "none";
            input_heure[0].id = nomLieu.value.toLowerCase() + "_" + input_heure[0].id;
            input_heure[0].name = input_heure[0].id;
            input_heure[0].setAttribute("class", "input_heure");
            tab_heure_input[0].setAttribute('class', 'tab_heure_input');
        }
        let inputNomLieu = document.createElement("input");
        inputNomLieu.type = "text";
        inputNomLieu.name = "lieu_" + nomLieu.value;
        inputNomLieu.id = "lieu_" + nomLieu.value;
        inputNomLieu.classList.add("nomLieu");
        inputNomLieu.style = "background-color: #FEFEE8; border: none; width: 40%; color: black; font-weight: bold; font-size: 1.2rem; padding-top: 1%; padding-bottom: 1%; margin-right: 0; margin-top: 1%; position: absolute;";
        inputNomLieu.style.display = "none";
        inputNomLieu.value = nomLieu.value;
        document.getElementById("ligne_lieu").appendChild(inputNomLieu);

        let inputCouleurLieu = document.createElement("input");
        inputCouleurLieu.type = "color";
        inputCouleurLieu.name = "couleur_" + nomLieu.value;
        inputCouleurLieu.id = "couleur_" + nomLieu.value;
        inputCouleurLieu.class = "input_form";
        inputCouleurLieu.style = "width:24%; border: 1px solid #FEFEE8; background-color: #FEFEE8; padding: 0px;color: black; font-weight: bold; font-size: 1.2rem; position: absolute;";
        inputCouleurLieu.style.display = "none";
        inputCouleurLieu.value = couleurLieu.value;
        document.getElementById("ligne_couleur").appendChild(inputCouleurLieu);

        // création du nouveau lieu dans le menu
        let newLieu = document.createElement("div");
        newLieu.setAttribute("id", nomLieu.value.toLowerCase());
        let newLieuTexte = document.createElement("a");
        let newLieuSupprime = document.createElement("a");
        newLieuTexte.innerHTML = nomLieu.value.toLowerCase();
        newLieuSupprime.innerHTML = "&#10006";
        newLieu.setAttribute("class", "lieu");

        newLieu.style.backgroundColor = couleurLieu.value;
        newLieuTexte.setAttribute("style", "; text-align: left; display: inline-block; width: 55%; padding-left: 20%;cursor: pointer;");
        newLieuSupprime.setAttribute("style", "text-align: right; display: inline-block; width: 5%; padding-right: 20%;cursor: pointer;");
        newLieu.appendChild(newLieuTexte);
        newLieu.appendChild(newLieuSupprime);
        let divForm = document.getElementById("form3");
        divForm.insertBefore(newLieu, document.getElementById("lienLieux"));
        newLieuTexte.setAttribute("onclick", "showInfosLieu(" + nomLieu.value.toLowerCase() + ")");
        newLieuSupprime.setAttribute("onclick", "supprimeLieu(" + nomLieu.value.toLowerCase() + ")");

        //réinitialisation des valeurs
        nomLieu.value = "";
        couleurLieu.value = "#000000";
        updateValue();
    }
    else {
        alert("Ce nom de lieu est deja pris.");
    }
}
