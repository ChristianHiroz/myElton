var listeNom; var listeVille; var listeRue; var selectedActivity; var selectedCart;

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
    var parentId = $("#" + selectedActivity).closest("div").parent().attr("id");
    if(parentId === "setted1" || parentId === "setted2"){            
            if($("#unsetted1 div").length === 3){
                $("#unsetted2").prepend($("#" + selectedActivity));
            }
            else{
                $("#unsetted1").prepend($("#" + selectedActivity));
            }
            $("#"+selectedActivity).css("left", "0px");
            $("#"+selectedActivity).css("top", "0px");
            $("#attribuer").text("Attribuer à la classe");
        }
    else{            
        if($("#setted1 div").length === 3){
            $("#setted2").prepend($("#" + selectedActivity));
        }
        else{
            $("#setted1").prepend($("#" + selectedActivity));
        }
        $("#"+selectedActivity).css("left", "0px");
        $("#"+selectedActivity).css("top", "0px");
        $("#attribuer").text("Désattribuer de la classe");
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
        $("#" + selectedActivity).removeClass("rouge");
        $("#" + selectedActivity).draggable("option", "disabled", true);
        $("#attribuer").text("Attribuer à la classe");
        selectedActivity = 0;
    }
    else{
        $("#" + selectedActivity).removeClass("rouge");
        $("#" + selectedActivity).draggable("option", "disabled", true);
        selectedActivity = activityId;
        selectedCart = cartId;
        $("#" + selectedActivity).addClass("rouge");
        $("#" + selectedActivity).draggable({ revert: "invalid" });
        $("#" + selectedActivity).draggable("option", "disabled", false);
        var parentId = $("#" + activityId).closest("div").parent().attr("id");
        if(parentId === "setted1" || parentId === "setted2"){
            $("#attribuer").text("Désattribuer de la classe");
        }
        else{
            $("#attribuer").text("Attribuer à la classe");
        }
    }
}

$("#setted").droppable({
    drop: function( event, ui ) {
        var parentId = $("#" + selectedActivity).closest("div").parent().parent().attr("id");
        if(parentId === "unsetted") {  
            $.ajax({
                url: Routing.generate('set_to_division', {activityId : selectedActivity, cartId : selectedCart}),
                data: {}
            });
            if($("#setted1 div").length === 3) {
                $("#setted2").prepend($("#" + selectedActivity));
            }
            else{
                $("#setted1").prepend($("#" + selectedActivity));
            }
            $("#attribuer").text("Désattribuer de la classe");
        }         
        $("#"+selectedActivity).css("left", "0px");
        $("#"+selectedActivity).css("top", "0px");
    }
});

$("#unsetted").droppable({
    drop: function( event, ui ) {
        var parentId = $("#" + selectedActivity).closest("div").parent().parent().attr("id");
        if(parentId === "setted") {  
            $.ajax({
                url: Routing.generate('set_to_division', {activityId : selectedActivity, cartId : selectedCart}),
                data: {}
            });
            if($("#unsetted div").length === 3) {
                $("#unsetted2").prepend($("#" + selectedActivity));
            }
            else{
                $("#unsetted1").prepend($("#" + selectedActivity));
            }
            $("#attribuer").text("Attribuer de la classe");
        }           
        $("#"+selectedActivity).css("left", "0px");
        $("#"+selectedActivity).css("top", "0px");
    }
});

$("#supprimer").click(function()
{
    $.ajax({
        url: Routing.generate('delete_cart', {id : selectedActivity}),
        data: {},
        success: function(){
            $("#"+selectedActivity).remove();
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