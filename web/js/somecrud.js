function AjouterPanier(id)
{
    $.ajax({
        url: "/AjouterPanier",
        method: "POST",
        dataType: "JSON",
        data:{idProduct:id},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });

}

function AjouterWishlist(id)
{
    $.ajax({
        url: "/AjouterWishlist",
        method: "POST",
        dataType: "JSON",
        data:{idProduct:id},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });

}

function SupprimerPanier(id)
{
    $.ajax({
        url: "/SupprimerPanier/"+id,
        method: "POST",
        dataType: "JSON",
        data:{idProduct:id},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });

}

function SupprimerWishlist(id) {
    $.ajax({
        url: "/SupprimerWishlist/"+id,
        method: "POST",
        dataType: "JSON",
        data:{idProduct:id},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });
}