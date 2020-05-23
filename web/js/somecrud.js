function takelake(lala){
    alert(lala);
}

function takeDon()
{
    let x = document.getElementById("sommeadonner").value();
    alert(x);
    $.ajax({
        url: "/confirmpayment",
        method: "POST",
        dataType: "JSON",
        data:{montantDt:montant},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });

}

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

function ModifierPanier(id){
    var qte = $("#quantity"+id).val();
    $.ajax({
        url:"/ModifierPanier/"+id+"&uqte="+qte,
        method: "POST",
        dataType: "JSON",
        data:{idPanier:id,qtePanier:qte},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });
}

$(document).ready(function () {
    let qte = document.getElementsByClassName('qte');
    $.each(qte, function () {
        $(this).on('change', function () {
            ModifierPanier($(this).val())
        });
    });
})