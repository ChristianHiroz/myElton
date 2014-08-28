var listeNom; var listeVille; var listeRue; var selectedActivity = 0; var selectedCart;

$('#fos_user_registration_form_postalCode').focusout(function()
{
    var selectedOne = $('#selectedOne');
    if ($(this).val().length === 5)
    {
        $.ajax({
            url: Routing.generate('tryAjax', {cp : $(this).val() }),
            data: {},
            success: function(data){ 
                    var data_array = $.parseJSON(data);
                    var name = data_array["NOM"];
                    listeNom = name;
                    listeVille =  data_array["VILLE"];
                    listeRue = data_array["VOIE"];
                    $.each(name, function(index, value) {
                        selectedOne.append('<option value="'+ index +'">'+ value +'</option>');
                        });
            }
        });
    }
});

$('#selectedOne').change(function()
{
    var nom = $('#fos_user_registration_form_school');
    var ville = $('#fos_user_registration_form_town');
    var rue = $('#fos_user_registration_form_address');
    
    var index = $("#selectedOne option:selected").prevAll().size();
    
    nom.val(listeNom[index]);
    ville.val(listeVille[index]);
    rue.val(listeRue[index]);
});

$("#attribuer").click(function()
{
    $.ajax({
        url: Routing.generate('set_to_division', {activityId : selectedActivity, cartId : selectedCart}),
        data: {}
    });
    var parentId = $("#" + selectedActivity + "parent").parent().attr("id");
    if(parentId === "setted1" || parentId === "setted2"){            
            if($("#unsetted1 div").length === 3){
                $("#unsetted2").prepend($("#" + selectedActivity + "parent"));
            }
            else{
                $("#unsetted1").prepend($("#" + selectedActivity + "parent"));
            }
            $("#" + selectedActivity + "parent").css("left", "0px");
            $("#" + selectedActivity + "parent").css("top", "0px");
            $("#attribuer").text("Attribuer à la classe");
        }
    else{            
        if($("#setted1 div").length === 3){
            $("#setted2").prepend($("#" + selectedActivity + "parent"));
        }
        else{
            $("#setted1").prepend($("#" + selectedActivity + "parent"));
        }
        $("#" + selectedActivity + "parent").css("left", "0px");
        $("#" + selectedActivity + "parent").css("top", "0px");
        $("#attribuer").text("Ne plus attribuer");
    }
});

function addToCart(activityId)
{
    if($("#nbPanier").length) {
        var value = parseInt($("#nbPanier").text());
    }
    else {
        var value = 0;
    }
    if(value >= 6) {
        $("#myFullModal").modal({
                                    show: true
                                });
    } else {
        $.ajax({
                url: Routing.generate('add_cart', {id : activityId }),
                data: {},
                success: function(){ 
                    value = value + 1;
                    if(value === 1)
                    {
                        $("#panier").append("<p id='nbPanier' class='redDot'>fefsf</p>");
                    }
                    $("#nbPanier").text(value);
                }
            });
    }
}

function setSelect(activityId, cartId)
{   
    if(activityId === selectedActivity){
        $("#" + selectedActivity).removeClass("culture");
        $("#" + selectedActivity+"p").removeClass("textBlc");
        $("#" + selectedActivity).parent().draggable("option", "disabled", true);
        $("#attribuer").text("Attribuer à la classe");
        selectedActivity = 0;
    }
    else{
        $("#" + selectedActivity).removeClass("culture");
        $("#" + selectedActivity+"p").removeClass("textBlc");
        $("#" + selectedActivity).parent().draggable("option", "disabled", true);
        selectedActivity = activityId;
        selectedCart = cartId;
        $("#" + selectedActivity).addClass("culture");
        $("#" + selectedActivity+"p").addClass("textBlc");
        $("#" + selectedActivity).parent().draggable({ revert: "invalid" });
        $("#" + selectedActivity).parent().draggable("option", "disabled", false);
        var parentId = $("#" + activityId + "parent").closest("div").parent().attr("id");
        if(parentId === "setted1" || parentId === "setted2"){
            $("#attribuer").text("Ne plus attribuer");
        }
        else{
            $("#attribuer").text("Attribuer à la classe");
        }
    }
    if(selectedActivity !== 0){
        $(".btnPanier1").addClass("violet");
        $(".btnPanier2").addClass("violetBis");
        $(".btnPanier4").addClass("bleu");
        $(".btnPanier4").removeClass("borderBleu");
        $(".btnPanier1").removeClass("borderViolet");
        $(".btnPanier2").removeClass("borderVioletBis");        
        $(".btnPanier1").removeClass("violetH");
        $(".btnPanier2").removeClass("violetBisH");
        $(".btnPanier4").removeClass("bleuH");
        
    }
    else{
        $(".btnPanier1").removeClass("violet");
        $(".btnPanier2").removeClass("violetBis");
        $(".btnPanier4").removeClass("bleu");
        $(".btnPanier4").addClass("borderBleu");
        $(".btnPanier1").addClass("borderViolet");
        $(".btnPanier2").addClass("borderVioletBis");        
        $(".btnPanier1").addClass("violetH");
        $(".btnPanier2").addClass("violetBisH");
        $(".btnPanier4").addClass("bleuH");
    }
}

function launchSelectedActivity()
{
    if(selectedActivity !== null)
    {
        $("#" + selectedActivity + "Modal").modal({
                                    show: true
                                });
    }
}

$("#setted").droppable({
    drop: function( event, ui ) {
        var parentId = $("#" + selectedActivity).closest("div").parent().parent().parent().attr("id");
        if(parentId === "unsetted") {  
            $.ajax({
                url: Routing.generate('set_to_division', {activityId : selectedActivity, cartId : selectedCart}),
                data: {}
            });
            if($("#setted1 div").length === 9) {
                $("#setted2").prepend($("#" + selectedActivity).parent());
            }
            else{
                if($("#setted1 div").length === 1) { $("#tadada").remove(); }
                $("#setted1").prepend($("#" + selectedActivity).parent());
            }
            if($("#unsetted1 div").length === 0 && $("#unsetted2 div").length === 0)
            {
                $("#unsetted1").append(' <div id="tadada" style="border:1px dashed grey; width: 80%; height: 170px; margin-top: 25px; text-align: center;display:inline-block;"><p style="display:table-cell; line-height: 55px; width:45%; margin:auto!important;">Déposez <br/> une activité <br/> ici</p></div>');
            }
            $("#attribuer").text("Ne plus attribuer");
        }         
        $("#"+selectedActivity).parent().css("left", "0px");
        $("#"+selectedActivity).parent().css("top", "0px");
    }
});

$("#unsetted").droppable({
    drop: function( event, ui ) {
        var parentId = $("#" + selectedActivity).closest("div").parent().parent().parent().attr("id");
        if(parentId === "setted") {  
            $.ajax({
                url: Routing.generate('set_to_division', {activityId : selectedActivity, cartId : selectedCart}),
                data: {}
            });
            if($("#unsetted1 div").length === 9) {
                $("#unsetted2").prepend($("#" + selectedActivity).parent());
            }
            else{
                if($("#unsetted1 div").length === 1) { $("#tadada").remove(); }
                $("#unsetted1").prepend($("#" + selectedActivity).parent());
            }
            if($("#setted1 div").length === 0 && $("#setted2 div").length === 0)
            {
                $("#setted1").append(' <div id="tadada" style="border:1px dashed grey; width: 80%; height: 170px; margin-top: 25px; text-align: center;display:inline-block;"><p style="display:table-cell; line-height: 55px; width:45%; margin:auto!important;">Déposez <br/> une activité <br/> ici</p></div>');
            }
            $("#attribuer").text("Attribuer de la classe");
        }           
        $("#"+selectedActivity).parent().css("left", "0px");
        $("#"+selectedActivity).parent().css("top", "0px");
    }
});

$("#supprimer").click(function()
{
    $.ajax({
        url: Routing.generate('delete_cart', {id : selectedActivity}),
        data: {},
        success: function(){
            $("#"+selectedActivity + "parent").remove();
            var value = parseInt($("#nbPanier").text());
            value = value - 1;
            if(value === 0) {
                $("#nbPanier").remove();
            }
            else {
                $("#nbPanier").text(value);
            }
        }
    });
});

function validateLesson(idLesson)
{
    $.ajax({
        url: Routing.generate('validate_lesson', {id : idLesson, bool : 0}),
        data: {},
        success: function(){
            $("#isValidated").attr("onclick", "unValidateLesson(" + idLesson + ")");
        }
    });
};

function unValidateLesson(idLesson)
{
    $.ajax({
        url: Routing.generate('validate_lesson', {id : idLesson, bool : 1}),
        data: {},
        success: function(){
            $("#isValidated").attr("onclick", "validateLesson(idLesson)");
        }
    });
};

$('#myVimeoModal').on('hidden.bs.modal', function (e) {
    var iframe = $("#vimeoIframe");
    var div = $("#vimeoIframe").parent();
    iframe.remove();
    div.append(iframe);

});

$('.myVimeoModal').on('hidden.bs.modal', function (e) {
    var iframe = $("#vimeoIframe");
    var div = $("#vimeoIframe").parent();
    iframe.remove();
    div.append(iframe);

});

$('#myAudioModal').on('hidden.bs.modal', function (e) {
    var iframe = $("#audioIframe");
    var div = $("#audioIframe").parent();
    iframe.remove();
    div.append(iframe);

});

$('.myAudioModal').on('hidden.bs.modal', function (e) {
    var iframe = $("#audioIframe");
    var div = $("#audioIframe").parent();
    iframe.remove();
    div.append(iframe);

});

$('.buttonActivity').click(function(e) {
    $('.buttonActivity').removeClass('active');
    $(this).addClass('active');
});