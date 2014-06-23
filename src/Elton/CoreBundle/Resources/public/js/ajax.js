var listeNom; var listeVille; var listeRue;

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
    var nom = $('#name');
    var ville = $('#town');
    var rue = $('#way');
    
    var index = $("#selectedOne option:selected").prevAll().size();
    
    nom.val(listeNom[index]);
    ville.val(listeVille[index]);
    rue.val(listeRue[index]);
});