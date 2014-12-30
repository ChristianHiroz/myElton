$( document ).ready(function(){
    // Détecte le hash dans l'url, l'utilise pour sélectionner le lien correspondant, déclenche le clique
    $("a[href='" + window.location.hash + "']").trigger('click')
});

var selectedOffer = null;

$(function() {
    $('.carousel').each(function(){
        $(this).carousel({
            interval: false
        });
    });
});

$(".list-group-item").click(function()
{
    $(".list-group-item").removeClass("active");
    $(this).addClass("active");
    
    selectedOffer = $(this).attr('id');
    
    $(".offerButton").addClass("violetBis");
    $(".offerButton").addClass("textBlc");
    $(".offerButton").removeClass("borderVioletBis");
    $(".offerButton").removeClass("violetBisH");
    
    if(selectedOffer === "0"){
        $("#button1").parent().addClass("invisible");
        $("#button0").parent().addClass("visible");        
        $("#button0").parent().removeClass("invisible");
        $("#button0").parent().insertBefore($("#buttonDiv").children("div:first"));
    }
    else{
        $("#button0").parent().addClass("invisible");
        $("#button1").parent().addClass("visible");        
        $("#button1").parent().removeClass("invisible");
        $("#button1").parent().insertBefore($("#buttonDiv").children("div:first"));
    }
});

$(".offerButton").click(function(evt){
    if(selectedOffer === null){
        evt.preventDefault();
    }
    
    if(selectedOffer !== 0 && selectedOffer !== null){          
        $.ajax({
            url: Routing.generate('offer_choosed', {id : selectedOffer }),
            data: {},
            success: function(){ 
            }
        });
    }
});