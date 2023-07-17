// requête ajax permettant d'activer une ligne de la section gallery en BDD
let contactImgActive = document.querySelectorAll("[type=checkbox]")
for (let button of contactImgActive) {
    button.addEventListener("click", function () {

        let xmlhttp = new XMLHttpRequest();

        // On récupère l'id de notre ligne
        xmlhttp.open("get", `/session/card/admin/activation/${this.dataset.id}`)

        // On envoie la requête
        xmlhttp.send()
    })
}