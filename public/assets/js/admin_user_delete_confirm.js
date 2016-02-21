var func = func || {};

func.show_modal = function(admin_id)
{
    $('#modal').modal('show');

    $('#modal_delete').click(function ()
    {
        window.location.href = "/admin/delete/" + admin_id;
    });
};
