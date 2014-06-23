$('#fos_user_registration_form_postalCode').keyup(function(key)
{
    if (this.value.length === 5)
    {
        $.ajax({ url: '{{path("tryAjax")}}',
            data: {action: 'tryAction'},
            type: 'get',
            success: function(output) {
                alert("output");
            }
    });
    }
});


