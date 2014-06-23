$( document ).ready(function(){
    // Détecte le hash dans l'url, l'utilise pour sélectionner le lien correspondant, déclenche le clique
    $("a[href='" + window.location.hash + "']").trigger('click')
});
