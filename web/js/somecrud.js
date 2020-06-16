function takelake(lala){
    alert(lala);
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

function AjouterPanierQte(id)
{
    var qte = $('#quantityDetails').val();
    $.ajax({
        url: "/AjouterPanierQte",
        method: "POST",
        dataType: "JSON",
        data:{idProduct:id,qte:qte},
        async:true,
        success: function (data,status) {

        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });
}

function showDetails(id){
    document.getElementById("tableP").style.visibility="visible";
    document.getElementById("order-detail-header").style.visibility="visible";
    let tabdiv = document.getElementById('list-prod-table');
    let bodyP = document.getElementById("bodyP");
    bodyP.innerHTML = ''

    $.ajax({
        url: "/showDetails",
        method: "POST",
        dataType: "JSON",
        data:{idCommande:id},
        async:true,
        success: function (data,status) {
            console.log(data)
            for(let i in data) {
                $.ajax({
                    url: "/getproducts",
                    method: "POST",
                    dataType: "JSON",
                    data: {idProd:data[i].product},
                    async: true,
                    success: function (dataP,status) {
                        console.log(dataP)
                        bodyP.innerHTML +=
                            '<tr><td class="cart-title" style="padding-top: 30px;"><h5><center>'+dataP.nomprod+'</center></h5>' +
                            '</td>' +
                            '<td class="p-price" style="padding-top: 30px;">' +
                                dataP.prix+" TND"+
                            '</td>'+
                            '<td class="qua-col" style="padding-top: 30px;">' +
                                data[i].qte+
                            '</td>' +
                            '<td class="total-price" style="padding-top: 30px;">' +
                                parseInt(data[i].qte) * parseInt(dataP.prix)+
                            '</td></tr>';
                    },
                    error: function (xhr, textStatus, errorThrown){

                    }
                })
            }
        },
        error: function (xhr, textStatus, errorThrown){

        }

    })
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
    var qtenew = $("#quantity"+id).val();
    let spaceprice = document.getElementById("total-price"+id);
    let spacesub = document.getElementById("subtotal");
    let spacetotal = document.getElementById("cart-total");


    $.ajax({
        url:"/ModifierPanier/"+id+"&uqte="+qtenew,
        method: "POST",
        dataType: "JSON",
        data:{idPanier:id,qtePanier:qtenew},
        async:true,
        success: function (data,status) {
            console.log(data);
            spaceprice.innerHTML = data.cart.prixTotal.toString()+' TND';
            spacesub.innerHTML=data.totalprice;
            spacetotal.innerHTML=data.totalprice;
        },
        error: function (xhr, textStatus, errorThrown) {

        }
    });
}

$(document).ready(function () {
    document.getElementById("tableP").style.visibility="hidden";
    document.getElementById("order-detail-header").style.visibility="hidden";
    qte = document.getElementsByClassName('qte');
    $.each(qte, function () {
        $(this).on('change', function () {
            ModifierPanier($(this).val())
        });
    });
})

