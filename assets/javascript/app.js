$(function () {

    const ROOT_HOST = window.location.origin + "/boutique/";
    const ROOT_SIMPLE = window.location.origin + "/";
    var STARDATE = "";
    const KEY = "start@1234";
    let charts = {}; // stocker les graphiques par ID
    let articleSelected = [];
    let articlesMap = {};
    let montant_global = 0;
    let taxe_global = 0;

    let date_start_picker = moment().startOf('month'); // 1er du mois
    let date_end_picker = moment(); // aujourd’hui

    function money(val) {
        return val.toLocaleString('fr-FR', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        })
    }
    function formatMontant(montant) {
    return new Intl.NumberFormat('fr-FR').format(montant) + ' FCFA';
}

    btnReload();

    function btnReload() {
        $('body').on('click', '.btn_reload', function (e) {
            history.go(0);
        });
    }

    loadDate();

    function loadDate() {

        var st = localStorage.getItem(KEY);
        if (st == null || st == 'null') {

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    loadDate: 1
                },
                success: function (data) {
                    localStorage.setItem(KEY, data);
                    STARDATE = data;

                }
            });

        } else {
            STARDATE = st;
        }

    }

    function isEmpty(value) {
    return (
        value === undefined ||
        value === null ||
        value === '' ||
        (Array.isArray(value) && value.length === 0) ||
        (typeof value === 'object' && Object.keys(value).length === 0)
    );
}

    function getDateInterval() {
        var dateDebut = new Date(STARDATE).getFullYear();
        var dateActu = new Date().getFullYear();

        let output = '<option value=""></option>';
        if (dateDebut == dateActu) {
            output += '<option value="' + dateDebut + '">' + dateDebut + '</option>';

        } else {
            for (let index = dateActu; index >= dateDebut; index--) {
                output += '<option value="' + index + '">' + index + '</option>';
            }
        }
        $(".select_year").html(output);

    }

    // localStorage.setItem(KEY,'{"test":true,"pol":false}');

    // notify();
    function notify(text = "", callback = "", title = "succès", icon = "success") {

        swal({
            title: title,
            text: text,
            icon: icon,
            button: true,

        }).then(callback);
    }

    // toconf() 

    function toconf(callback = "") {
        swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            })
            .then((a) => {
                if (a) {
                    callback
                }
            });
    }

    function changerMontant(val = 0) {
        $('.mtt').text(money(val));
        $('.mtt').val((val));

        $("#total_ttc").text(money(val));

    $(".montant_total_ttc").text(calculMontantTaxe(val));
    $("#total_ttc_hidden").val(calculMontantTaxe(val));

    }

    function calculMontantTaxe(total_ht = 0) {
 let taxe = parseFloat($("#taxe").val()) || 0;

    let montant_taxe = total_ht * (taxe / 100);

    let total_ttc = total_ht + montant_taxe;
    
return total_ttc;
    
}

    // RESET FORM
    function resetForm() {
        // $(".reset").click(function(){
        $("form").trigger("reset");
        // $("form")[0].reset()
        $("input[type='text']").val('');
        $("input[type='number']").val('');
        // $("form").remove();
        // $(selector)[0].reset()
        //   });
    }

    // CLOSE MODAL
    closeModal();

    function closeModal() {
        $('body').delegate('.dismiss_modal', 'click', function (e) {
            e.preventDefault();
            resetForm();
            $(".modal").modal('hide');

        })
    }

    // EMPLOYE
    btn_ajouter_employe();

    function btn_ajouter_employe() {
        $('body').delegate('#btn_ajouter_employe', 'submit', function (e) {
            e.preventDefault();

            var employe = $(this).serialize();
            ajouter_employe(employe);

        });
    }

    function ajouter_employe(employe) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: employe,
            success: function (data) {
                
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#employe-modal').modal('hide');
                    liste_employe();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                    // reinit();
                } else {

                    notify(verif[1], "", "alert", "warning");

                }

            }
        });
    }


    function liste_employe() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_employe: 1
            },
            success: function (data) {
                // // 
                $('.emp-table').html(data);
            }
        });
    }


    btn_update_employe();

    function btn_update_employe() {
        $('body').delegate('.btn_update_employe', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_employe: id,
                    frm_upemploye: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    
                    $(".menu-modal").html(data);
                    $("#employe-modal").modal('show');
                }
            });
        });
    }

    btn_update_login_employe();

    function btn_update_login_employe() {
        $('body').delegate('#btn_update_login_employe', 'submit', function (e) {
            e.preventDefault();
            // var id = $(this).data('id');
            var employe = $(this).serialize();
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: employe,
                success: function (data) {
                    var verif = data.split("&");
                    if (verif[0] == 1) {
                        notify(verif[1]);
                        resetForm();
                    } else {
                        notify(verif[1], "", "alert", "warning");

                    }

                }
            });
        });
    }

    btn_suprimer_employe();

    function btn_suprimer_employe() {
        $('body').delegate('.btn_remove_employe', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_employe: id,
                            btn_supprimer_employe: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            });
        });
    }


    const TIME = 600000;
    var i = 0;

    //setInterval(logout, TIME);


    deconnexion();

    function deconnexion() {
        $('body').delegate('.btn_deconnexion', 'click', function (e) {
            e.preventDefault();
            logout();

        });
    }

    function logout() {

        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_deconnexion: 1
            },
            dataType: 'JSON',
            success: function (data) {
                if (data.code == 200) {
                    localStorage.setItem(KEY, null);
                    // // ;
                    document.location.href = ROOT_SIMPLE;
                }
            }
        });
    }

    // CLIENT

    btn_ajouter_client();

    function btn_ajouter_client() {
        $('body').delegate('#btn_ajouter_client', 'submit', function (e) {
            e.preventDefault();

            var clent = $(this).serialize();
            ajouter_client(clent);

        });
    }

    function ajouter_client(client) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: client,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#client-modal').modal('hide');
                    liste_client();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                } else {
                    // // 
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }

    function liste_client() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_client: 1
            },
            success: function (data) {
                // // 
                $('.client-table').html(data);
            }
        });
    }

    btn_update_client();

    function btn_update_client() {
        $('body').delegate('.btn_update_client', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_client: id,
                    frm_upclient: 1
                },
                // dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    
                    $(".menu-modal").html(data);
                    $("#client-modal").modal('show');
                }
            });
        });
    }

    btn_suprimer_client();

    function btn_suprimer_client() {
        $('body').delegate('.btn_remove_client', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_client: id,
                            btn_supprimer_client: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    btn_add_client_vente();

    function btn_add_client_vente() {
        $('body').on('click', '#client-data-modal', function (e) {
            e.preventDefault();
            $("#client-modal").modal('show');
        });
    }

    // FOURNISSEUR

       btn_add_fournisseur();

    function btn_add_fournisseur() {
        $('body').on('click', '#fournisseur-data-modal', function (e) {
            e.preventDefault();
            $("#fournisseur-modal").modal('show');
        });
    }

    btn_ajouter_fournisseur();

    function btn_ajouter_fournisseur() {
        $('body').delegate('#btn_ajouter_fournisseur', 'submit', function (e) {
            e.preventDefault();


            var fournisseur = $(this).serialize();

            ajouter_fournisseur(fournisseur);

        });
    }

    function ajouter_fournisseur(fournisseur) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: fournisseur,
            success: function (data) {

                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#fournisseur-modal').modal('hide');
                    liste_fournisseur();

                } else {
                    // // 
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }

    function liste_fournisseur() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_fournisseur: 1
            },
            success: function (data) {
                // // 
                $('.fournisseur-table').html(data);
            }
        });
    }

    btn_update_fournisseur();

    function btn_update_fournisseur() {
        $('body').delegate('.btn_update_fournisseur', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_fournisseur: id,
                    frm_upfournisseur: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);

                    // // 
                    $(".menu-modal").html(data.data);
                    $("#fournisseur-modal").modal('show');
                }
            });
        });
    }

    btn_suprimer_fournisseur();

    function btn_suprimer_fournisseur() {
        $('body').delegate('.btn_remove_fournisseur', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_fournisseur: id,
                            btn_supprimer_fournisseur: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }


    // CATEGORIE

    btn_ajouter_categorie();

    function btn_ajouter_categorie() {
        $('body').delegate('#btn_ajouter_categorie', 'submit', function (e) {
            e.preventDefault();

            var categorie = $(this).serialize();
            ajouter_categorie(categorie);

        });
    }

    function ajouter_categorie(categorie) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: categorie,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#categorie-modal').modal('hide');
                    $('#id_categorie').remove();
                    liste_categorie();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                } else {
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }

    function liste_categorie() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_categorie: 1
            },
            success: function (data) {
                // // 
                $('.categorie-table').html(data);
            }
        });
    }

    btn_update_categorie();

    function btn_update_categorie() {

        $('body').delegate('.btn_update_categorie', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_categorie: id,
                    frm_upcategorie: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.success) {
                        $(".menu-modal").html(data.html);
                        $("#categorie-modal").modal('show');
                    }else{
                        $.notify("Erreur lors de la récupération de la catégorie", "error");
                    }
                }
            });
        });
    }

    btn_suprimer_categorie();

    function btn_suprimer_categorie() {
        $('body').delegate('.btn_remove_categorie', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_categorie: id,
                            btn_supprimer_categorie: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    // FAMILLE

    function liste_famille() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_famille: 1
            },
            success: function (data) {
                // // 
                $('.famille-table').html(data);
            }
        });
    }

    btn_ajouter_Famille();

    function btn_ajouter_Famille() {
        $('body').delegate('#btn_ajouter_famille', 'submit', function (e) {
            e.preventDefault();

            var famille = $(this).serialize();
            ajouter_famille(famille);

        });
    }

    function ajouter_famille(famille) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: famille,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#famille-modal').modal('hide');
                    $('#id_famille').remove();
                    liste_famille();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                } else {
                    // // 
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }


    btn_update_famille();

    function btn_update_famille() {

        $('body').delegate('.btn_update_famille', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_famille: id,
                    frm_upfamille: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.success) {
                        $(".menu-modal").html(data.html);
                        $("#famille-modal").modal('show');
                    }else{
                        $.notify("Erreur lors de la récupération du formulaire", "error");
                    }
                }
            });
        });
    }

    btn_suprimer_famille();

    function btn_suprimer_famille() {
        $('body').delegate('.btn_remove_famille', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_famille: id,
                            btn_supprimer_famille: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    // MARK

    btn_ajouter_mark();

    function btn_ajouter_mark() {
        $('body').delegate('#btn_ajouter_mark', 'submit', function (e) {
            e.preventDefault();

            var mark = $(this).serialize();
            ajouter_mark(mark);

        });
    }

    function ajouter_mark(mark) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: mark,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#mark-modal').modal('hide');
                    $('#id_mark').remove();

                    liste_mark();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                } else {
                    // // 
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }

    function liste_mark() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_mark: 1
            },
            success: function (data) {
                // 
                $('.mark-table').html(data);
            }
        });
    }

    btn_update_mark();

    function btn_update_mark() {

        $('body').delegate('.btn_update_mark', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_mark: id,
                    frm_upmark: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.success) {
                        $(".menu-modal").html(data.html);
                        $("#mark-modal").modal('show');
                    }else{
                        $.notify("Erreur lors de la récupération de la marque", "error");
                    }
                }
            });
        });
    }

    btn_suprimer_mark();

    function btn_suprimer_mark() {
        $('body').delegate('.btn_remove_mark', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_mark: id,
                            btn_supprimer_mark: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    //UNITE
    btn_ajouter_unite();

    function btn_ajouter_unite() {
        $('body').delegate('#btn_ajouter_unite', 'submit', function (e) {
            e.preventDefault();

            var unite = $(this).serialize();
            ajouter_unite(unite);

        });
    }

    function ajouter_unite(unite) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: unite,
            success: function (data) {

                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#unite-modal').modal('hide');
                    $('#id_unite').remove();
                    liste_unite();

                } else {
                    notify(verif[1], "", "alert", "warning");

                }

            }
        });
    }

    function liste_unite() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_unite: 1
            },
            success: function (data) {
                // // 
                $('.unite-table').html(data);
            }
        });
    }

    btn_update_unite();

    function btn_update_unite() {
        $('body').delegate('.btn_update_unite', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_unite: id,
                    frm_upunite: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.success) {
                        $(".menu-modal").html(data.html);
                        $("#unite-modal").modal('show');
                    }else{
                        $.notify("Erreur lors de la récupération du formulaire", "error");
                    }
                }
            });
        });
    }

    btn_suprimer_unite();

    function btn_suprimer_unite() {
        $('body').delegate('.btn_remove_unite', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_unite: id,
                            btn_supprimer_unite: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }


    // ARTICLE

    $('.entrepot_search').select2();
    btn_ajouter_article();

    function btn_ajouter_article() {
        $('body').delegate('#btn_ajouter_article', 'submit', function (e) {
            e.preventDefault();

            var article = $(this).serialize();
            ajouter_article(article);

        });
    }

    function ajouter_article(article) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: article,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[1]);
                    resetForm();
                    $('#article-modal').modal('hide');
                    $('#id_article').remove();
                    liste_article();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                } else {
                    // 
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }




    function liste_article() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_article: 1
            },
            success: function (data) {

                $('.article-table').html(data);
            }
        });
    }

    btn_update_article();

    function btn_update_article() {

        $('body').delegate('.btn_update_article', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_article: id,
                    frm_uparticle: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);

                    // 
                    $(".menu-modal").html(data.data);
                    $("#article-modal").modal('show');
                }
            });
        });
    }

    form_attribuer_entrepot_article();

    function form_attribuer_entrepot_article() {
        $('body').delegate('#form_add_attribuer_entrepot_article', 'submit', function (e) {
            e.preventDefault();

            var article = $(this).serialize();
               $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: article,
            dataType:"JSON",
            success: function (data) {
                console.log(data);
                
                // return;
                if (data.code == 200) {
                    notify(data.message);
                    $('#attribuer-modal').modal('hide');

                } else {
                    // 
                    notify(data.message, "", "alert", "warning");
                }
            }
        });

        });
    }

    form_add_attribuer_employe_entrepot();

    function form_add_attribuer_employe_entrepot() {
        $('body').delegate('#form_add_attribuer_employe_entrepot', 'submit', function (e) {
            e.preventDefault();

            var data = $(this).serialize();
            $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: data,
            dataType:"JSON",
            success: function (data) {
                console.log(data);
                
                if (data.success) {
                    $.notify(data.msg, "success");
                    $('#attribuer-modal').modal('hide');

                } else {
                    // 
                    $.notify(data.msg, "error");
                }
            }
        });

        });
    }


    btn_attribuer_article();

    function btn_attribuer_article() {
        $('body').on('click','.btn_attribuer_article', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let action = $(this).data('action');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_action: id,
                    frm_attribution_action: action
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    // return

                    // 
                    $(".menu-modal-attribuer").html(data.data);
                    $("#attribuer-modal").modal('show');
                }
            });
        });
    }

    btn_attribuer_employe();

    function btn_attribuer_employe() {
        $('body').delegate('.btn_attribuer_employe', 'click', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let action = $(this).data('action');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_action: id,
                    attribuer_employe_a_entrepot: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data.html);
                    
                    $(".menu-modal-attribuer").html(data.html);
                    $("#attribuer-modal").modal('show');
                }
            });
        });
    }

    btn_suprimer_article();
    function btn_suprimer_article() {
        $('body').delegate('.btn_remove_article', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_article: id,
                            btn_supprimer_article: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    // SEXION ENTREPOS

    $('.select2').select2();
    $('#responsable_entrepot').select2();
    changeStatutEntrepot();

    function changeStatutEntrepot() {  
        $('body').on('click', '.btnChangeStatutEntrepot', function (e) {
            const code = $(this).data('code');
            const statut = $(this).data('statut');
        
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    code: code,
                    statut: statut,
                    btnChangeStatutEntrepot: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if (data.code == 200) {
                        $.notify(data.message, "success");
                        liste_entrepot();
                    } else {
                        $.notify(data.message, "");
                        
                    }
                }
            });
        });
    }
    
     function liste_entrepot() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_entrepot: 1
            },
            success: function (data) {
                // // 
                $('.entrepot-table').html(data);
            }
        });
    }

    btn_ajouter_entrepot();

    function btn_ajouter_entrepot() {
        $('body').delegate('#btn_ajouter_entrepot', 'submit', function (e) {
            e.preventDefault();

            var entrepotData = $(this).serialize();
            console.log(entrepotData);

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: entrepotData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    if (data.code == 200) {
                        notify(data.message);
                        $('#entrepot-modal').modal('hide');
                        liste_entrepot();

                    } else {
                        // // 
                        notify(data.message, "", "alert", "warning");


                    }

                }
            });

        });
    }




    btn_update_entrepot();

    function btn_update_entrepot() {

        $('body').on('click','.btn_update_entrepot', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_entrepot: id,
                    frm_update_entrepot: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);

                    $(".menu-modal").html(data.data);
                    $("#entrepot-modal").modal('show');
                }
            });
        });
    }

    btn_modifier_entrepot();

    function btn_modifier_entrepot() {
        $('body').on('submit','#btn_modifier_entrepot', function (e) {
            e.preventDefault();

            var entrepotData = $(this).serialize();
            // console.log(entrepotData);

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: entrepotData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    if (data.code == 200) {
                        $.notify(data.message,'success');
                        $('#entrepot-modal').modal('hide');
                        liste_entrepot();

                    } else {
                        // // 
                        notify(data.message, "", "alert", "warning");


                    }

                }
            });

        });
    }

    // btn_suprimer_famille();

    // function btn_suprimer_famille() {
    //     $('body').delegate('.btn_remove_famille', 'click', function (e) {
    //         e.preventDefault();
    //         var id = $(this).data('id');
    //         swal({
    //             title: "Etes vous sure",
    //             text: "de vouloir supprimer cet element ?",
    //             icon: "warning",
    //             buttons: ['Non', 'Oui'],
    //             dangerMode: true,
    //         }).then((a) => {
    //             if (a) {

    //                 $.ajax({
    //                     url: "../partials/rooter.php",
    //                     method: "POST",
    //                     data: {
    //                         id_famille: id,
    //                         btn_supprimer_famille: 1
    //                     },
    //                     dataType: 'JSON',
    //                     success: function (data) {
    //                         $('.row' + id).remove();
    //                         notify("Element supprimé avec succès", "", "");
    //                     }
    //                 });
    //             }
    //         })
    //     });
    // }

    // SEXION VENTE
    $('#select_code_vente').select2();
    $('.client_search').select2();
    $('#select_article_vente').select2();


    selectClientToSearchVente();

    function selectClientToSearchVente() {

        $('body').on('change', '.client_search', function (e) {
            e.preventDefault();

            var id = $(this).val();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_client: id,
                    btn_search_client_vente: 1
                },
                dataType: 'json',
                success: function (response) {
                    
                    if (response.code === 200) {

                        const c = response.client;
                        $("#nom_client").val(c.nom_client);
                        $("#telephone_client").val(c.telephone_client);
                        $("#email_client").val(c.email_client);

                    } else {
                        console.log("Client non trouvé");
                    }
                },
                error: function (err) {
                    console.log("Erreur AJAX :", err);
                }
            });
        });
    }

 
    
    // SEXION VENTE
    $('#select_code_achat').select2(); // Select2 pour la recherche de code d'achat
    $('.fournisseur_search').select2(); // Select2 pour la recherche de fournisseur
    $('#select_article_achat').select2(); // Select2 pour la recherche d'article
    $('.transfert_entrepot').select2(); // Select2 pour l'entrepôt source
    // $('#transfert_entrepot_destination').select2(); // Select2 pour l'entrepôt destination

// console.log('debut');
    selectFournisseurToSearchachat();

    function selectFournisseurToSearchachat() {

        $('body').on('change', '.fournisseur_search', function (e) {
            e.preventDefault();

            var id = $(this).val();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_fournisseur: id,
                    btn_search_fournisseur_achat: 1
                },
                dataType: 'json',
                success: function (response) {
                    // console.log(response.code);return

                    if (response.code === 200) {

                        const f = response.fournisseur;
                        $("#nom_fournisseur").val(f.nom_fournisseur);
                        $("#telephone_fournisseur").val(f.telephone_fournisseur);
                        $("#email_fournisseur").val(f.email_fournisseur);

                    } else {
                        console.log("Fournisseur non trouvé");
                    }
                },
                error: function (err) {
                    console.log("Erreur AJAX :", err);
                }
            });
        });
    }
    
    selectEntrepotToSearchTransfert();

    function selectEntrepotToSearchTransfert() {

        $('body').on('change', '.transfert_entrepot', function (e) {
            e.preventDefault();
            let id = $(this).val();
            var input = "";
            let action = $(this).find(':selected').data('action');

            input = $(this).attr('id') == 'transfert_entrepot_source' ?
                    $('#transfert_entrepot_destination').val() :
                    $('#transfert_entrepot_source').val();
            
            
            if (input == id) {
                $.notify("Désolé, choisissez deux entrepots differents!");  
                return;
            }
            // console.log(id);
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_entrepot: id,
                    btn_search_entrepot_transfert: action
                },
                dataType: 'json',
                success: function (response) {

                    if (response.code === 200) {

                        const f = response.entrepot;
                        $("#libelle_entrepot_" + action).val(f.libelle_entrepot);
                        $("#ville_entrepot_" + action).val(f.ville_entrepot);
                        $("#id_entrepot_" + action).val(id);
                        

                    } else {
                        console.log("Entrepot non trouvé");
                    }
                },
                error: function (err) {
                    console.log("Erreur AJAX :", err);
                }
            });
        });
    }

    ajax_ajouter_panier_transfert();
    function ajax_ajouter_panier_transfert() {
        $('body').delegate('#btn_ajouter_panier_transfert', 'submit', function (e) {
            e.preventDefault();
            var transfert = $(this).serialize();
            
            if (!transfert.includes('article')) {
                $.notify("Désolé, Veuiller choisir au moins un article");  
                return;
            }

            $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: transfert,
            dataType : 'JSON',
            success: function (data) {
            // console.log(data);return;
                
                if (data) {

                    
                    AddNewRowTableTransfert(data);
                    $.notify("Produit ajouté dans la liste", 'success')
                } else {
                    $.notify("Veuillez choisir au moins un article svp!")
                }
            }
        });
        });
    }

    btn_ajouter_transfert();

    function btn_ajouter_transfert() {
        $('body').on('click','#btn_ajouter_transfert', function (e) {
            e.preventDefault();

            var source = $('#transfert_entrepot_source').val();
            var destination = $('#transfert_entrepot_destination').val();

            if (source == ""  || destination == "") {
                $.notify("Veuiller choisir l'entrepot!");  
                return;
            }else if (source == destination) {
                $.notify("Désolé, choisissez deux entrepots differents!");  
                return;
            }
            else if (!articleSelected || articleSelected.length === 0) {
                $.notify("Désolé, Veuiller choisir au moins un article");  
                return;
            }

            var data = {
                id: articleSelected,
                qte: pushData("qte"),
                pu: pushData("pu"),
                total:pushData("total"),
                code_achat: $(this).data('code'),
                source: source,
                destination: destination,
                btn_ajouter_transfert: 1
            };

            ajouter_transfert(data);

        });
    }

    function ajouter_transfert(data) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if (data.code == 200) {
                     swal({
                        title: "Succès",
                        text: data.message,
                        icon: "success",
                        button: true,

                    }).then(() =>
                        window.history.go(0)
                    );

                } else {
                    $.notify(data.message);
                }
            }
        });
    }

     btn_suprimer_ajouter_panier_transfert();
    function btn_suprimer_ajouter_panier_transfert() {
        $('body').on('click','.btn_remove_data_ajouter_panier_transfert', function (e) {
            e.preventDefault();
            var element = $(this);
            var id_article = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir retirer cet element de la liste?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_article: id_article,
                            remove_ajouter_panier_transfert: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data.code = 200) {
                                element.closest('tr').remove();
                                articleSelected = articleSelected.filter(a => a != id_article);
                                $.notify(data.message, "success");
                                loadTotalRow();
                            } else {
                                $.notify("Erreur de suppression du produit!")
                            }
                        }
                    });
                }
            })
        });
    }

    function updateELementTransfert(btn_action,code) {
    let btn = btn_action.id;
    swal({
            title: "Etes vous sure",
            text: "de vouloir effectuer cette opération?",
            icon: "warning",
            buttons: ['Non', 'Oui'],
            dangerMode: true,
        }).then((a) => {
            if (a) {

                $.ajax({
                    url: "../partials/rooter.php",
                    method: "POST",
                    data: {
                        code: code,
                        btn_action_transfert: btn
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        
                        if (data.success) {
                            swal("Notification", data.msg, "success")
                            .then(function () {
                                history.go(0);
                            });
                        }else{
                            swal("Notification", data.msg, "error");
                            // .then(function () {
                            //     history.go(0);
                            // });
                        }

                        
                    }
                });
            }
    });
}


  

// rien
    function totalAll() {
        var somme = 0;
        $('.table_total tbody tr').each(function () {
            var val = $(this).find('.total').text();
            somme += Number(val);
        });
        // montant_global = somme;
        changerMontant(somme);
        $("#total_ttc").text(somme);
        console.log($("#total_ttc").text(somme));
        
        let taxe = $("#total_ttc").data("taxe");
        // console.log(taxe);
        
    }

    function pushData(selector) {
        let dataselector = [];
        $('.table_total tbody tr').each(function () {
            var el = $(this).find('.' + selector).text();
            dataselector.push(el);
        });
        return dataselector
    }


 

    btn_ajouter_panier_vente();

    function btn_ajouter_panier_vente() {
        $('body').delegate('#btn_ajouter_panier_vente', 'submit', function (e) {
            e.preventDefault();
            var vente = $(this).serialize();
            console.log(vente);
            
            ajouter_panier_vente(vente);
        });
    }

    function ajouter_panier_vente(vente) {

        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: vente,
            success: function (data) {

                if (data) {
                    // changerMontant();
                    $('.vente-data-table').html(data);
                } else {
                    notify("Veuillez choisir au moins un article svp!", "", "", "warning")
                }
            }
        });
    }

    btn_modifier_panier_vente();

    function btn_modifier_panier_vente() {
        $('body').delegate('#btn_modifier_panier_vente', 'submit', function (e) {
            e.preventDefault();
            
            var vente = $(this).serialize();
            modifier_panier_vente(vente);
        });
    }


    function modifier_panier_vente(vente) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: vente,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);  
                // return;
                AddNewRowTableVente(data);
                $.notify("Produit ajouté dans la liste",'success')
            }
        });
    }

    btn_modifier_vente();

    function btn_modifier_vente() {
        $('body').on('click','#btn_modifier_vente', function (e) {
            e.preventDefault();

            var client = $('#client').val();
            if (!client) {
                $.notify("Veuillez choisir un client");
                return;
            }

            var data = {
                id: articleSelected,
                qte: pushData("qte"),
                pu: pushData("pu"),
                total:pushData("total"),
                code_vente: $(this).data('code'),
                client: client,
                btn_modifier_vente: 1
            };
            console.log(data);
            
            modifier_vente(data);

        });
    }

    function modifier_vente(data) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data,
            dataType: 'JSON',
            success: function (data) {
                if (data.code == 200){
                    articleSelected = null;
                    $.notify(data.message, 'success');
                } else {
                    $.notify(data.message);
                }
            }
        });
    }

    btn_suprimer_modifier_panier_vente();
    function btn_suprimer_modifier_panier_vente() {
        $('body').on('click','.btn_remove_data_modifier_panier_vente', function (e) {
            e.preventDefault();
            var element = $(this);
            var id_article = $(this).data('id');
            var id_vente = $(this).data('vente');

            // console.log(id_vente,id_article);
            // return:
            

          swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_vente: id_vente,
                            id_article: id_article,
                            remove_modifier_panier_vente: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data.code = 200) {
                                element.closest('tr').remove();
                                articleSelected = articleSelected.filter(a => a != id_article);
                                $.notify(data.message, "success");
                                loadTotalRow();
                            } else {
                                $.notify("Erreur de suppression du produit!")
                            }
                        }
                    });
                }
            })
        });
    }

    // SEXION ACHAT_VENTE


    $('#select_article').select2();

    $('.fournisseur_search').select2();

    btn_ajouter_panier_achat();

    function btn_ajouter_panier_achat() {
        $('body').delegate('#btn_ajouter_panier_achat', 'submit', function (e) {
            e.preventDefault();
            var achat = $(this).serialize();
            ajouter_panier_achat(achat);
        });
    }

    initDataSelected();
    function initDataSelected() {
       if ($('.table_commande').length && $('.table_commande').is(':visible')) {
            $('.table_commande tbody tr').each(function () {
                articleSelected.push($(this).data('code'));
            });
            // taxe_global = $('#total_ttc').data('taxe');
           loadTotalRow();
        //    console.log(articleSelected);
           
        }
    }

    function transformToMap(dataArticles) {
      dataArticles.forEach(a => {
    articlesMap[a.ID_article] = a;
      });
        console.log(articlesMap);
    }

    function AddNewRowTable(dataArticles) {
        let html = '';

        dataArticles.forEach(article => {

        if (articleSelected.includes(article.ID_article)) return;

        let index = $('.table_commande tbody tr').length + 1;

        html += `
        <tr data-code="${article.ID_article}">
            <td>${index}</td>
            <td>${article.libelle_article}</td>
            <td>${article.famille}</td>
            <td>${article.mark}</td>
            <td class="label-price col pu" contenteditable="true">${article.prix_achat}</td>
            <td class="label-price col qte" contenteditable="true">0</td>
            <td class="col total">0</td>
            
            <td> <button data-achat="${article.achat_id}" data-id="${article.ID_article}" title="Supprimer l\'article de la liste" class="btn btn-danger btn-sm btn_remove_data_modifier_panier">
                        <i class="fa fa-trash"></i> </button>
            </td>
        </tr>`;

        articleSelected.push(article.ID_article);
        });

        $('.table_commande tbody').append(html);
    }

     function AddNewRowTableVente(dataArticles) {
        let html = '';

        dataArticles.forEach(article => {

        if (articleSelected.includes(article.ID_article)) return;

        let index = $('.table_commande tbody tr').length + 1;

        html += `
        <tr data-code="${article.ID_article}">
            <td>${index}</td>
            <td>${article.libelle_article}</td>
            <td>${article.famille}</td>
            <td>${article.mark}</td>
            <td class="label-price col pu" contenteditable="true">${article.prix_vente}</td>
            <td class="label-price col qte" contenteditable="true">0</td>
            <td class="col total">0</td>
            
            <td> <button data-vente="${article.vente_id}" data-id="${article.ID_article}" title="Supprimer l\'article de la liste" class="btn btn-danger btn-sm btn_remove_data_modifier_panier_vente">
                        <i class="fa fa-trash"></i> </button>
            </td>
        </tr>`;

        articleSelected.push(article.ID_article);
        });

        $('.table_commande tbody').append(html);
    }

      function AddNewRowTableTransfert(dataArticles) {
        let html = '';

        dataArticles.forEach(article => {

        if (articleSelected.includes(article.ID_article)) return;

        let index = $('.table_commande tbody tr').length + 1;

        html += `
        <tr data-code="${article.ID_article}">
            <td>${index}</td>
            <td>${article.libelle_article}</td>
            <td>${article.famille}</td>
            <td>${article.mark}</td>
            <td class="label-price col pu" contenteditable="true"></td>
            <td class="label-price col qte" contenteditable="true"></td>
            <td class="col total"></td>
            
            <td> <button data-id="${article.ID_article}" title="Supprimer l\'article de la liste" class="btn btn-danger btn-sm btn_remove_data_ajouter_panier_transfert">
                        <i class="fa fa-trash"></i> </button>
            </td>
        </tr>`;

        articleSelected.push(article.ID_article);
        });

        $('.table_commande tbody').append(html);
    }

    function ajouter_panier_achat(achat) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: achat,
            success: function (data) {
                if (data) {
                    changerMontant();
                    $('.achat-table').html(data);
                    $('.row_montant').show();
                    $('.panier_achat_content').show();
                } else {
                    notify("Veuillez choisir au moins un article svp!", "", "", "warning")
                }
            }
        });
    }

    btn_modifier_panier_achat();

    function btn_modifier_panier_achat() {
        $('body').delegate('#btn_modifier_panier_achat', 'submit', function (e) {
            e.preventDefault();
            
            var achat = $(this).serialize();
            modifier_panier_achat(achat);
        });
    }





    function modifier_panier_achat(achat) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: achat,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);  
                AddNewRowTable(data);
                $.notify("Produit ajouté dans la liste",'success')
            }
        });
    }

       function loadTotalRow() {

            var currow = $(".table_commande").closest('tr');
            total = 0
            var pu = currow.find('.pu').text();
            var qte = currow.find('.qte').text();

            var total = (!isNaN(pu) && !isNaN(qte)) ? Number(pu) * Number(qte) : 0;
            // // 
            currow.find('.total').text(total);

            totalAll();

    }

    totalRow()

    function totalRow() {
        $('.table_total').on('keyup', '.col', function () {

            var currow = $(this).closest('tr');
            total = 0
            var pu = currow.find('.pu').text();
            var qte = currow.find('.qte').text();

            var page_vente = $('#page_vente').val();
            if (page_vente != undefined) {
                var id_article = Number(currow.find('.d_none').text());
              

                $.ajax({
                    url: "../partials/rooter.php",
                    method: "POST",
                    data: {
                        id: id_article,
                        qte: qte,
                        btn_verifQteArticleVente: 1
                    },
                    success: function (data) {
                        
                        if (data != 'ok') {
                            notify('Desolé,sotock insuffisant a la quatité demandé il reste ' + data, '', 'alert', 'warning');
                            currow.find('.qte').text(data);
                            qte = data;
                        }
                    }
                });
            }

            var page_transfert = $('#page_transfert').val();
            if (page_transfert != undefined) {
                var id_article = Number(currow.find('.d_none').text());

                // $.ajax({
                //     url: "../partials/rooter.php",
                //     method: "POST",
                //     data: {
                //         id: id_article,
                //         qte: qte,
                //         btn_verifQteArticleTransfert: 1
                //     },
                //     success: function (data) {
                //         console.log(data);
                        
                     
                //         if (data != 'ok') {
                //             // notify('Desolé,sotock insuffisant a la quatité demandé il reste ' + data, '', 'alert', 'warning');
                //                notify('Desolé,sotock insuffisant a la quatité demandé il reste ' + data, '', 'alert', 'warning');
                //             currow.find('.qte').text('');
                //             // currow.find('.qte').text(data);
                //             qte = null;
                //             // qte = data;
                //         }
                //     }
                // });
            }

            var total = (!isNaN(pu) && !isNaN(qte)) ? Number(pu) * Number(qte) : 0;
            // // 
            currow.find('.total').text(total);

            totalAll();

        });
    }


    function totalAll() {
        var somme = 0;
        $('.table_total tbody tr').each(function () {
            var val = $(this).find('.total').text();
            somme += Number(val);
        });
        changerMontant(somme);
        console.log(taxe_global);
        
    }

    function pushData(selector) {
        let dataselector = [];
        $('.table_total tbody tr').each(function () {
            var el = $(this).find('.' + selector).text();
            dataselector.push(el);
        });
        return dataselector
    }


    // ACHAT

    btn_ajouter_achat();

    function btn_ajouter_achat() {
        $('body').delegate('#btn_ajouter_achat', 'click', function (e) {
            e.preventDefault();

            var fournisseur = $('#fournisseur').val();
            if (!fournisseur) {
                notify("Veuillez choisir un fournisseur", "", "alert", "warning");
                return;
            }

            var id = pushData("id");
            var qte = pushData("qte");
            var pu = pushData("pu");
            var total = pushData("total");

            ajouter_achat(fournisseur, id, qte, pu, total);

        });
    }

    function ajouter_achat(fournisseur, id, qte, pu, total) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                fournisseur: fournisseur,
                id: id,
                qte: qte,
                pu: pu,
                total: total,
                btn_ajouter_achat: 1
            },
            success: function (data) {
                console.log(data);

                // return
                var verif = data.split("&");
                if (verif[0] == 1) {

                    swal({
                        title: "Succès",
                        text: verif[1],
                        icon: "success",
                        button: true,

                    }).then(() =>
                        // document.location.href = ROOT_SIMPLE + "home.php/?pg=achat"

                        window.history.go(0)
                    );

                } else {
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }


     btn_modifier_achat();

    function btn_modifier_achat() {
        $('body').on('click','#btn_modifier_achat', function (e) {
            e.preventDefault();

            var fournisseur = $('#fournisseur').val();
            if (!fournisseur) {
                $.notify("Veuillez choisir un fournisseur");
                return;
            }

            var data = {
                id: articleSelected,
                qte: pushData("qte"),
                pu: pushData("pu"),
                total:pushData("total"),
                code_achat: $(this).data('code'),
                fournisseur: fournisseur,
                btn_modifier_achat: 1
            };
            console.log(data);
            
            modifier_achat(data);

        });
    }

    function modifier_achat(data) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);

                if (data.code == 200){
                    articleSelected = null;
                    $.notify(data.message, 'success');
                } else {
                    $.notify(data.message);
                }
            }
        });
    }

    function liste_achat() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_achat: 1
            },
            success: function (data) {
                // 
                $('.achat-table').html(data);
            }
        });
    }


    btn_update_achat();

    function btn_update_achat() {

        $('body').delegate('.btn_update_achat', 'click', function (e) {
            e.preventDefault();

            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_achat: id,
                    frm_upachat: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    $(".menu-modal").html(data);
                    $("#achat-modal").modal('show');
                }
            });
        });
    }

    btn_suprimer_achat();

    function btn_suprimer_achat() {
        $('body').delegate('.btn_remove_achat', 'click', function (e) {
            e.preventDefault();
            // alert("uuu");
            return
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_achat: id,
                            btn_supprimer_achat: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            // ;
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    btn_suprimer_achat_panier();

    function btn_suprimer_achat_panier() {
        $('body').delegate('.btn_remove_data_panier', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {
                    $('.row' + id).remove();
                    totalAll()

                }
            })
        });
    }

    btn_suprimer_modifier_achat_panier();
     function btn_suprimer_modifier_achat_panier() {
         $('body').on('click','.btn_remove_data_modifier_panier', function (e) {
            e.preventDefault();
            var element = $(this);
            var id_article = $(this).data('id');
            var id_achat = $(this).data('achat');

            // console.log(id_achat,id_article);
            // return
            

          swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_achat: id_achat,
                            id_article: id_article,
                            remove_modifier_panier_achat: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            console.log(data);
                            if (data.code = 200) {
                                element.closest('tr').remove();
                                articleSelected = articleSelected.filter(a => a != id_article);
                                $.notify(data.message, "success");
                                loadTotalRow();
                            } else {
                                $.notify("Erreur de suppression du produit!")
                            }
                        }
                    });
                }
            })
        });
    }


    btn_remove_achat_detail();

    function btn_remove_achat_detail() {
        $('body').delegate('.btn_remove_achat_detail', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_achat: id,
                            remove_achat_detail: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            // ;
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    open_achat_detail_fournisseur();

    function open_achat_detail_fournisseur() {
        $('body').delegate('.open_achat_detail', 'click', function (e) {
            e.preventDefault();
            var isTrue = $(this).attr('data-istrue');

            if (isTrue == "false") {

                isTrue = $(this).attr('data-istrue', "true");
                codeachat = $(this).attr('data-codeachat');

                $.ajax({
                    url: "../partials/rooter.php",
                    method: "POST",
                    data: {
                        codeachat: codeachat,
                        btn_achat_fournisseur: 1
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        console.table('retour', data);
                        $('#' + codeachat).html(data);

                    }
                });
            }

        });
    }



    // VERSEMENT
    btn_ajouter_versement();

    function btn_ajouter_versement() {
        $('body').delegate('#frm_ajouter_versement', 'submit', function (e) {
            e.preventDefault();
            var montant = $('#montant_versement').val();
            if (!montant) {
                notify("Veuillez remplir le champ montant", "", "alert", "warning");
                return;
            }

            var verement = $(this).serialize();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: verement,
                success: function (data) {

                    var verif = data.split("&");
                    if (verif[0] == 1) {
                        notify(verif[3]);
                        // resetForm();
                        $('#montant_versement').val("")
                        $('#versement-modal').modal('hide');
                        $(".h3").text(verif[2]);
                        $(".versement-table").html(verif[1]);

                    } else {
                        notify(verif[1], "", "alert", "warning");

                    }
                }
            });


        });
    }

    // COMMANDE

    btn_ajouter_commande();

    function btn_ajouter_commande() {
        $('body').delegate('#btn_ajouter_commande', 'click', function (e) {
            e.preventDefault();
            var client = $('#client').val();
            var id = pushData("id");
            var qte = pushData("qte");
            var pu = pushData("pu");

            ajouter_commande(id, qte, pu, client);

        });
    }

    function ajouter_commande(id, qte, pu, client) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                id: id,
                qte: qte,
                pu: pu,
                client: client,
                btn_ajouter_commande: 1
            },
            success: function (data) {
                // 
                var verif = data.split("&");
                if (verif[0] == 1) {
                    var code = verif[1].split("#");

                    notify(code[1]);
                    window.open(ROOT_SIMPLE + "views/print.php?id=" + code[0]);
                    window.history.go(0);

                } else {
                    notify(verif[1], "", "alert", "warning");


                }

            }
        });
    }

    btn_valider_commande();

    function btn_valider_commande() {
        $('body').delegate('.btn_valider_commande', 'click', function (e) {

            e.preventDefault();
            const code_vente = $(this).data('code_vente');
            const montant_vente = $(this).data('montant_vente');
            const client_vente = $(this).data('client');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    code: code_vente,
                    montant: montant_vente,
                    client: client_vente,
                    frm_valider_commande: 1
                },
                success: function (data) {

                    var verif = data.split("&");

                    if (verif[0] == 1) {

                        $('.row' + code_vente).remove();
                        notify(verif[4]);
                        $(".h3").text(verif[2]);
                        $(".client_contenue").html(verif[1]);
                        getCanvasClientData();
                        window.open(ROOT_SIMPLE + "views/print.php?id=" + verif[3]);

                    } else {
                        notify(verif[1], "", "alert", "warning");

                    }

                }
            });
        });
    }

    // VENTE
    // alert('Vente effectuée avec succes !');
    // window.open("pages/print.php?idv=<?= $idv ?>");
    // window.location.href = "rooter.php?page=vente"; 

    btn_ajouter_vente();

    function btn_ajouter_vente() {
        $('body').delegate('#btn_ajouter_vente', 'click', function (e) {
            e.preventDefault();
            var client = $('#client').val();
            var montant_encaisse = $('#montant_encaisse').val();
            var pay_mode = $('.pay_mode').val();
            if (!client) {
                notify("Veuillez choisir un client", "", "alert", "warning");
                return;
            }
            var id = pushData("id");
            var qte = pushData("qte");
            var pu = pushData("pu");

            ajouter_vente(id, qte, pu, client, montant_encaisse,pay_mode);

        });
    }

    function ajouter_vente(id, qte, pu, client, montant_encaisse,pay_mode) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                id: id,
                qte: qte,
                pu: pu,
                client: client,
                montant_encaisse: montant_encaisse,
                pay_mode: pay_mode,
                btn_ajouter_vente: 1
            },
            dataType: "json",
            success: function (data) {
                
                var verif = data;
                if (verif.status) {

                    swal({
                        title: "Succès",
                        text: verif.message,
                        icon: "success",
                        button: true,

                    }).then(() =>
                        // document.location.href = ROOT_SIMPLE + "home.php/?pg=achat"

                        window.history.go(0)
                    );

                } else {
                    notify(verif.message, "", "alert", "warning");


                }

            }
        });
    }

  

    function achat_ajax(achat) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: achat,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[2]);
                    resetForm();
                    $(".achat-table").html(verif[1]);
                    $('#achat-modal').modal('hide');

                } else {
                    notify(verif[1], "", "alert", "warning");

                }

            }
        });
    }


    btn_resoudre();

    function btn_resoudre() {
        $('body').delegate('.resoudre', 'click', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var id = $(this).attr('id');
            if (id == "") {
                return false;
            }
            document.location.href = ROOT_HOST+''+url;
            // verifDetail(vente);
        });
    }

    btn_detail();

    function btn_detail() {
        $('body').delegate('#btn_detail', 'submit', function (e) {
            e.preventDefault();

            var vente = $(this).serialize();
            var code_vent = $('#select_code_vente').val();

            if (code_vent) {
                verifDetail(vente);
            } else {
                notify('Vueillez selectionner un code', '', 'alert', 'warning');

            }
        });
    }


    function verifDetail(vente) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: vente,
            success: function (data) {
                var da = JSON.parse(data)[0];

                // if (data) {
                //     changerMontant();
                $('#nom').text(da['nom_client']);
                $('#prenom').text(da['prenom_client']);
                $('#telephone').text(da['telephone_client']);

                $('#code').text(da['code_vente']);
                $('#employe').text(da['tel']);
                $('#montant').text(da['montant']);
                $('#date_vente').text(da['created_at']);
                $('.resoudre').attr('id', da['code_vente']);
                $('.resoudre').data('url', ROOT_SIMPLE + 'home.php/?pg=detail&id=' + da['code_vente']);
                $('.d_none').removeClass('d_none');
                // alert(href)

                //     $('.row_montant').show();
                //     $('.panier_achat_content').show();
                // }else{
                //     notify("Veuillez choisir au moins un article svp!","","","warning")
                // }
            }
        });
    }


    function liste_vente() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_achat: 1
            },
            success: function (data) {
                // 
                $('.achat-table').html(data);
            }
        });
    }

    btn_update_vente();

    function btn_update_vente() {

        $('body').delegate('.btn_update_vente', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_sortie: id,
                    frm_upvente: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    // 
                    $(".menu-modal").html(data);
                    $("#vente-modal").modal('show');
                }
            });
        });
    }

    qte_vente_detail_change();

    function qte_vente_detail_change() {
        $('body').on('keyup', '.qte_vente_detail', function () {
            var qte_fiel = $(this);
            var qte = qte_fiel.val();
            var id_article = $('#article_id').val();
            if (qte <= 0 || isNaN(qte)) {
                return false;
            }
            console.log(qte);
            
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id: id_article,
                    qte: qte,
                    btn_verifQteArticleVente: 1
                },
                success: function (data) {
                    // console.log(data);
                    
                    if (data != 'ok') {
                        alert('yy')
                        swal('Desolé,sotock insuffisant à la quatité demandé, il reste ' + data, '', 'alert', 'warning');
                        qte_fiel.val(data);
                    }
                }
            });

        });
    }

    update_vente();

    function update_vente() {
        $('body').delegate('#btn_modifier_vente', 'submit', function (e) {
            e.preventDefault();

            var vente = $(this).serialize();

            vente_ajax(vente);

        });
    }

    function vente_ajax(vente) {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: vente,
            success: function (data) {
                var verif = data.split("&");
                if (verif[0] == 1) {
                    notify(verif[2]);
                    resetForm();
                    $(".achat-table").html(verif[1]);
                    $('#vente-modal').modal('hide');
                    // liste_mark();

                    // $(".message").html('<strong class="alert alert-success">Employé : Ajout réussi !</strong>');
                } else {
                    // // 
                    notify(verif[1], "", "alert", "warning");

                }

            }
        });
    }

    // espace clean 2

    btn_suprimer_vente();

    function btn_suprimer_vente() {
        $('body').delegate('.btn_remove_vente', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_vente: id,
                            btn_supprimer_vente: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            // ;
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }

    btn_remove_vente_detail();

    function btn_remove_vente_detail() {
        $('body').delegate('.btn_remove_vente_detail', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: "Etes vous sure",
                text: "de vouloir supprimer cet element ?",
                icon: "warning",
                buttons: ['Non', 'Oui'],
                dangerMode: true,
            }).then((a) => {
                if (a) {

                    $.ajax({
                        url: "../partials/rooter.php",
                        method: "POST",
                        data: {
                            id_vente: id,
                            remove_vente_detail: 1
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            // ;
                            $('.row' + id).remove();
                            notify("Element supprimé avec succès", "", "");
                        }
                    });
                }
            })
        });
    }


    // btn_suprimer_achat();

    // function btn_suprimer_achat() {
    //     $('body').delegate('.btn_remove_achat', 'click', function (e) {
    //         e.preventDefault();
    //         var id = $(this).data('id');
    //         swal({
    //             title: "Etes vous sure",
    //             text: "de vouloir supprimer cet element ?",
    //             icon: "warning",
    //             buttons: ['Non', 'Oui'],
    //             dangerMode: true,
    //         }).then((a) => {
    //             if (a) {

    //                 $.ajax({
    //                     url: "../partials/rooter.php",
    //                     method: "POST",
    //                     data: {
    //                         id_achat: id,
    //                         btn_supprimer_achat: 1
    //                     },
    //                     dataType: 'JSON',
    //                     success: function (data) {
    //                         // ;
    //                         $('.row' + id).remove();
    //                         notify("Element supprimé avec succès", "", "");
    //                     }
    //                 });
    //             }
    //         })
    //     });
    // }



    open_vente_detail_client();

    function open_vente_detail_client() {
        $('body').delegate('.open_vente_detail', 'click', function (e) {
            e.preventDefault();
            var isTrue = $(this).attr('data-istrue');

            if (isTrue == "false") {

                isTrue = $(this).attr('data-istrue', "true");
                codevente = $(this).attr('data-codevente');

                $.ajax({
                    url: "../partials/rooter.php",
                    method: "POST",
                    data: {
                        codevente: codevente,
                        btn_vente_client: 1
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        console.table('retour', data);
                        $('#' + codevente).html(data);

                    }
                });
            }

        });
    }

     //DASHBORD ADMIN
    dashboardAdmin();

    function dashboardAdmin(dateStart = "", dateEnd = "") {
        if ($(".dashboard_admin").length > 0) {
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    dashboard_admin: 1,
                    dateStart: dateStart,
                    dateEnd: dateEnd
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    // return
                    $("#total_montant_reste").text(((data.reliquat.montant_total)));
                    $("#total_montant_regler").text(formatMontant((data.totauxAchat.total_montant_regler)));
                    $("#nb_achats").text(data.totauxAchat.article);

                    $("#achat_attente").text(formatMontant((data.totalAchatAttente.total)));
                    $("#vente_attente").text(formatMontant((data.totalVenteAttente.total)));
                    $("#nombre_vente").text(data.ventes.nombre_ventes);
                    $("#montant_vente").text(formatMontant((data.ventes.montant_total)));
                    $("#nombre_reapprovisionnement").text(data.reapprovisionnements.nombre_achats);
                    $("#montant_reapprovisionnement").text(formatMontant((data.reapprovisionnements.montant_total)));

                    $("#nombre_depense").text(data.depenses.nombre_depense);
                    $("#montant_depense").text(formatMontant((data.depenses.montant_depense)));
                    
                    $("#nombre_dette_client").text(formatMontant((data.detteClient.nombre_total)));
                    $("#montant_dette_client").text(formatMontant((data.detteClient.montant_total)));
                    
                    $("#nombre_dette_fournisseur").text(formatMontant((data.detteFournisseur.nombre_total)));
                    $("#montant_dette_fournisseur").text(formatMontant((data.detteFournisseur.montant_total)));
                    
                    
                    $("#nombre_stock_dispo").text(formatMontant((data.stockDispo.total_quantite)));
                    $("#montant_stock_dispo").text(formatMontant((data.stockDispo.total_montant)));
                    
                    $("#nombre_stock_alert").text(formatMontant((data.stockAlert)));
                    let tresorerie = data.tresorerie.solde_tresorerie;
                    if(tresorerie >= 0){
                        $('#montant_tresorerie').addClass('text-success');
                    }else{
                        $('#montant_tresorerie').addClass('text-danger');
                    }
                    $("#montant_tresorerie").text(((tresorerie)) + ' FCFA');

                }
            });
        }
    }

    // CONFIGUE BOUTIQUE
    btnConfigInfo();

    function btnConfigInfo() {

        $('body').delegate('#frm_config_info', 'submit', function (e) {
            e.preventDefault();
            var info = $(this).serialize();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: info,
                success: function (data) {


                    var verif = data.split("&");
                    if (verif[0] == 1) {
                        notify(verif[1]);
                        //resetForm();

                    } else {
                        // 
                        notify(verif[1], "", "alert", "warning");

                    }

                }
            });
        });
    }


    btnConfigContact();

    function btnConfigContact() {
        $('body').delegate('#frm_config_contact', 'submit', function (e) {
            e.preventDefault();
            var contact = $(this).serialize();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: contact,
                success: function (data) {
                    // 

                    var verif = data.split("&");
                    if (verif[0] == 1) {
                        notify(verif[1]);
                        //resetForm();

                    } else {
                        // 
                        notify(verif[1], "", "alert", "warning");

                    }

                }
            });
        });
    }

    changeLogo();

    function changeLogo() {
        $('body').delegate('#change_logo', 'change', function (e) {
            e.preventDefault();
            var input = $(this);
            var propriete = document.getElementById("change_logo").files[0];
            var form_date = new FormData();
            form_date.append('file', propriete);

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: form_date,
                contentType: false,
                processData: false,
                cache: false,
                success: function (data) {

                    var verif = data.split("&");
                    if (verif[0] == 1) {
                        // input.attr('src',verif[1]);

                        notify(verif[2]);
                        $("#logo").attr('src', verif[1]);
                        $(".fr_image_visible").addClass('d_none');
                        $(".fr_image_hidden").removeClass('d_none');

                        //resetForm();

                    } else {
                        // 
                        notify(verif[1], "", "alert", "warning");

                    }

                }
            });
        });
    }


    btnChangeLogo();

    function btnChangeLogo() {
        $('body').delegate('#modifier_logo', 'click', function (e) {
            e.preventDefault();
            // alert('ghbjnk,l')
            $("#change_logo").trigger('click');
        });
    }

    switchClient();

    function switchClient() {
        $('body').delegate('#switch_client', 'change', function (e) {
            e.preventDefault();

            // var checked = $(this).prop('checked');
            let value = $(this).val();
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    state: value,
                    switch_client: 1
                },
                success: function (data) {
                    $("#switch_client").val(data);
                    history.go(0);

                }
            });

        });
    }

    switchDelete();

    function switchDelete() {
        $('body').delegate('#switch_delete', 'change', function (e) {
            e.preventDefault();
            let value = $(this).val();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    state: value,
                    switch_delete: 1
                },
                success: function (data) {

                    $("#switch_delete").val(data);
                    history.go(0);

                }
            });

        });
    }

    switchFournisseur();

    function switchFournisseur() {
        $('body').delegate('#switch_fournisseur', 'change', function (e) {
            e.preventDefault();
            // var checked = $(this).prop('checked');
            let value = $(this).val();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    state: value,
                    switch_fournisseur: 1
                },
                success: function (data) {

                    $("#switch_fournisseur").val(data);
                    history.go(0);
                }
            });

        });
    }

    switchUnite();

    function switchUnite() {
        $('body').delegate('#switch_unite', 'change', function (e) {
            e.preventDefault();
            // var checked = $(this).prop('checked');
            let value = $(this).val();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    state: value,
                    switch_unite: 1
                },
                success: function (data) {

                    $("#switch_unite").val(data);
                    history.go(0);

                }
            });

        });
    }


    // other

    historique();

    function historique() {
        $('body').delegate('#historique', 'click', function (e) {
            e.preventDefault();
            history.back();

        });
    }

    sauvegard();

    function sauvegard() {
        $('body').delegate('.sauvegard', 'click', function (e) {
            e.preventDefault();
            var sauve = $(this).data('id');
            window.open(ROOT_SIMPLE + "views/printer.php?pg=" + sauve + "&val=1234567890");

            // $.ajax({
            //     url: "../partials/rooter.php",
            //     method: "POST",
            //     data: {sauvegard:1},
            //     success: function (data) {
            //             

            // var verif = data.split("&");
            // if (verif[0] == 1) {
            //     notify(verif[1]);
            //     //resetForm();

            // } else {
            //     // 
            //     notify(verif[1],"","alert","warning");

            // }

            //     }
            // });
        });
    }


    $('.my-table').DataTable();



    // ----------CANVAS ------------------------------
    // -------------------------------------------------
    // ['Jan', 'Fer', 'Mars', 'Avr', 'Mai', 'Juin', 'Jui','Aout','Sep','Oct','Nov','Dec']


    // FOURNISSEUR
    selectYearfournisseur();

    function selectYearfournisseur() {
        $('body').delegate("#select_year_fournisseur", 'change', function (e) {
            e.preventDefault();
            var id_fournisseur = $('#canvas_fournisseur_id').val();


            var val = $(this).val();
            if (val != undefined || val != "") {
                ajaxfournisseur(id_fournisseur, val);
            }
        });

    }

    getCanvasfournisseurData();

    function getCanvasfournisseurData() {
        var id_fournisseur = $('#canvas_fournisseur_id').val();

        if (id_fournisseur != undefined) {
            getDateInterval();

            ajaxfournisseur(id_fournisseur);
        }
    }


    function ajaxfournisseur(id_fournisseur, select = '') {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                getCanvasFournisseurData: 1,
                fournisseur: id_fournisseur,
                select_year: select
            },
            // dataType: 'JSON',
            success: function (data) {
                // ***
                var res = JSON.parse(data);

                if (res.code == 400) {
                    // charts['canvas_fournisseur'].destroy();
                    swal("Notification", "Aucune donnée disponible", "warning", );
                    return;
                }

                var achat = res.achat;

                const total = achat.map(function (val) {
                    return val.total;
                });
                const mois = achat.map(function (val) {


                    return val.mois + " " + val.annee;
                });
                fournisseurCanvas('canvas_fournisseur', mois, total);

            }
        });
    }

    function fournisseurCanvas(canvasId, mois, total) {

        if (charts[canvasId]) {
            charts[canvasId].destroy();
        }

        const colors = randColors(mois.length);
        var canvas = $('#' + canvasId)[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(58,123,213,1)');
        gradient.addColorStop(1, 'rgba(0,210,255,0.5)');
        const labels = mois;
        // ['Jan', 'Fer', 'Mars', 'Avr', 'Mai', 'Juin'];
        const data = {
            labels,
            datasets: [{

                    backgroundColor: colors,
                    //   backgroundColor: gradient,
                    borderColor: "#c5c6c6",
                    data: total,
                    label: "Montant achat"
                },

            ],

        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }

        charts[canvasId] = new Chart(canvas, config);
    }



    // CLIENT INFO
    selectYearClient();

    function selectYearClient() {
        $('body').delegate("#select_year_client", 'change', function (e) {
            e.preventDefault();
            var id_client = $('#canvas_client_id').val();


            var val = $(this).val();
            if (val != undefined || val != "") {
                ajaxClient(id_client, val);
            }
        });

    }

    getCanvasClientData();

    function getCanvasClientData() {
        var id_client = $('#canvas_client_id').val();

        if (id_client != undefined) {
            getDateInterval();

            ajaxClient(id_client);
        }
    }


    function ajaxClient(id_client, select = '') {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                getCanvasClientData: 1,
                client: id_client,
                select_year: select
            },
            // dataType: 'JSON',
            success: function (data) {

                var res = JSON.parse(data);

                if (res.code == 400) {
                    // charts['canvas_client'].destroy();
                    swal("Notification", "Aucune donnée disponible", "warning", );
                    return;
                }

                var vente = res.vente;


                const total = vente.map(function (val) {
                    return val.total;
                });
                const mois = vente.map(function (val) {


                    return val.mois + " " + val.annee;
                });
                clientCanvas('canvas_client', mois, total);

            }
        });
    }

    function clientCanvas(canvasId, mois, total) {

        if (charts[canvasId]) {
            charts[canvasId].destroy();
        }

        const colors = randColors(mois.length);
        var canvas = $('#' + canvasId)[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(58,123,213,1)');
        gradient.addColorStop(1, 'rgba(0,210,255,0.5)');
        const labels = mois;
        // ['Jan', 'Fer', 'Mars', 'Avr', 'Mai', 'Juin'];
        const data = {
            labels,
            datasets: [{

                    backgroundColor: colors,
                    //   backgroundColor: gradient,
                    borderColor: "#c5c6c6",
                    data: total,
                    label: "Montant vente"
                },

            ],

        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }

        charts[canvasId] = new Chart(canvas, config);
    }

    // DASHBOARD WEEK
    getCanvasWeekhData();

    function getCanvasWeekhData() {
        var page = $('#canvas_page_dashbord').val();

        if (page != undefined) {
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    getCanvasWeekData: 1
                },
                dataType: 'JSON',
                success: function (vente) {
                    console.log(vente);
                    
                    // return
                    // var vente = JSON.parse(data);
                    const total = vente.map(function (val) {
                        return val.total;
                    })
                    const jours = vente.map(function (val) {
                        return val.jour;
                    })

                    weekCanvas(jours, total)
                }
            });
        }
    }


    function weekCanvas(jour, total) {

        var canvas = $('#week_canvas')[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(58,123,213,1)');
        gradient.addColorStop(1, 'rgba(0,210,255,0.5)');
        const colors = randColors(jour.length);
        const labels = jour;
        // ['LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI','DIMANCHE'];
        const data = {
            labels,
            datasets: [{
                backgroundColor: colors,
                //   backgroundColor: gradient,
                borderColor: "#c5c6c6",
                data: total,
                label: "Montant vente"
            }],
        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }
        const myChart = new Chart(canvas, config);
    }
    // DASHBOARD MONTH

    selectYearDashboard();

    function selectYearDashboard() {
        $('body').delegate("#select_year_dashboard", 'change', function (e) {
            e.preventDefault();

            var val = $(this).val();
            if (val != undefined || val != "") {

                ajaxDashboard(val);

            }
        });

    }

    getCanvasMonthData();

    function getCanvasMonthData() {
        var page = $('#canvas_page_dashbord').val();
        if (page != undefined) {
            getDateInterval();

            ajaxDashboard();
        }
    }

// tu est proble

    function ajaxDashboard(select = '') {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                getCanvasMonthData: 1,
                year_select: select
            },
            dataType: 'JSON',
            success: function (res) {
                console.log(res);
                

                if (res.code == 400) {
                    charts['month_canvas'].destroy();
                    swal("Notification", "Aucune donnée disponible", "warning", );
                    return;
                }

                var vente = res.vente;
                const total = vente.map(function (val) {
                    return val.total;
                });
                const mois = vente.map(function (val) {


                    return val.mois + " " + val.annee;
                });

                monthCanvas('month_canvas', mois, total);

            }
        });
    }


    function monthCanvas(canvasId, mois, total) {

        if (charts[canvasId]) {
            charts[canvasId].destroy();
        }

        var canvas = $('#' + canvasId)[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(58,123,213,1)');
        gradient.addColorStop(1, 'rgba(0,210,255,0.5)');
        const labels = mois;
        // ['Jan', 'Fer', 'Mars', 'Avr', 'Mai', 'Juin'];
        const data = {
            labels,
            datasets: [{

                    backgroundColor: gradient,
                    borderColor: "#c5c6c6",
                    data: total,
                    label: "Montant vente"
                },

            ],

        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }

        charts[canvasId] = new Chart(canvas, config);

    }

    // DASHBOARD MONTH ACHAT



    selectYearDashboardAchat();

    function selectYearDashboardAchat() {
        $('body').delegate("#select_year_dashboard_achat", 'change', function (e) {
            e.preventDefault();

            var val = $(this).val();
            if (val != undefined || val != "") {

                ajaxDashboardAchat(val);

            }
        });

    }

    getCanvasMonthAchatData();

    function getCanvasMonthAchatData() {
        var page = $('#canvas_page_dashbord').val();
        if (page != undefined) {
            getDateInterval();

            ajaxDashboardAchat();
        }
    }



    function ajaxDashboardAchat(select = '') {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                getCanvasMonthDataAchat: 1,
                year_select: select
            },
            dataType: 'JSON',
            success: function (res) {
                // return
                // var res = JSON.parse(data)

                if (res.code == 400) {
                    charts['month_achat_canvas'].destroy();
                    swal("Notification", "Aucune donnée disponible", "warning", );
                    return;
                }

                var achat = res.achat;

                const total = achat.map(function (val) {
                    return val.total;
                });
                const mois = achat.map(function (val) {
                    return val.mois + " " + val.annee;
                });

                monthCanvasAchat('month_achat_canvas', mois, total);

            }
        });
    }

    function monthCanvasAchat(canvasId, mois, total) {

        if (charts[canvasId]) {
            charts[canvasId].destroy();
        }

        var canvas = $('#' + canvasId)[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(199, 33, 21,1)');
        gradient.addColorStop(1, 'rgba(175, 165, 153,0.5)');
        const labels = mois;
        // ['Jan', 'Fer', 'Mars', 'Avr', 'Mai', 'Juin'];
        const data = {
            labels,
            datasets: [{

                    backgroundColor: gradient,
                    borderColor: "#c5c6c6",
                    data: total,
                    label: "Montant achat"
                },

            ],

        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }

        charts[canvasId] = new Chart(canvas, config);

    }


    // PROFILE EMPLOYE

    selectYearEmploye();

    function selectYearEmploye() {
        $('body').delegate("#select_year_employe", 'change', function (e) {
            e.preventDefault();
            var employe = $('#profile_employe ').val();


            var val = $(this).val();
            if (val != undefined || val != "") {
                ajaxEmployeAndAccueil(employe, val);
            }
        });

    }

    getCanvasEmployeMonth();

    function getCanvasEmployeMonth() {
        var page = $('#canvas_accueil_page ').val();
        var employe = $('#profile_employe ').val();

        if (page != undefined) {
            getDateInterval();

            ajaxEmployeAndAccueil(employe, );
        }
    }


    function ajaxEmployeAndAccueil(employe, select = "") {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                getCanvasEmployeMonth: 1,
                id_employe: employe,
                select_year: select
            },
            // dataType: 'JSON',
            success: function (data) {

                var res = JSON.parse(data);

                if (res.code == 400) {
                    // charts['canvas_employe'].destroy();
                    swal("Notification", "Aucune donnée disponible", "warning", );
                    return;
                }

                var vente = res.vente;

                var mois, total = "";
                total = vente.map(function (val) {
                    return val.total;
                });
                mois = vente.map(function (val) {

                    //return val.periode;
                    return val.periode + " " + val.annee;
                });
                monthCanvasEmploye('canvas_employe', mois, total);

            }
        });
    }

    // monthCanvasEmploye();
    function monthCanvasEmploye(canvasId, mois, total) {

        if (charts[canvasId]) {
            charts[canvasId].destroy();
        }


        const colors = randColors(mois.length);
        var canvas = $('#' + canvasId)[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(58,123,213,1)');
        gradient.addColorStop(1, 'rgba(0,210,255,0.5)');
        const labels = mois;
        // ['LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI','DIMANCHE'];
        const data = {
            labels,
            datasets: [{
                backgroundColor: colors,
                //   backgroundColor: gradient,
                borderColor: "#c5c6c6",
                data: total,
                label: "Montant vente"
            }],
        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }

        charts[canvasId] = new Chart(canvas, config);

    }



    function randColors(size) {
        const dataset = "456abc789de0f123";

        const tab = [];
        for (let index = 0; index < size; index++) {

            var string = "#";

            for (let i = 0; i < 6; i++) {
                const rand = Math.floor(Math.random() * 16);
                string += dataset[rand];
            }

            tab.push(string);

        }
        return tab;
    }

    // pieCanvas();
    function pieCanvas() {

        var canvas = $('#canvas_pie_test')[0].getContext('2d');
        let gradient = canvas.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(58,123,213,1)');
        gradient.addColorStop(1, 'rgba(0,210,255,0.5)');
        const labels = mois;
        // ['LUNDI', 'MARDI', 'MERCREDI', 'JEUDI', 'VENDREDI', 'SAMEDI','DIMANCHE'];
        const data = {
            labels,
            datasets: [{
                backgroundColor: gradient,
                borderColor: "#c5c6c6",
                data: total,
                label: "Montant vente"
            }],
        }

        const config = {
            type: "bar",
            data: data,
            option: {
                Responsive: true,
            }
        }
        const myChart = new Chart(canvas, config);
    }



    // pieChart()
    function pieChart() {
        var data = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [54, 687, 39, 745, 92],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Pie Chart'
                }
            } // init chart pie

        };
        var canvas = $('#canvas_pie_test')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }

    // pieChart2()
    function pieChart2() {
        var data = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [54, 687, 39, 745, 92],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Pie Chart'
                }
            } // init chart pie

        };
        var canvas = $('#canvas_pie2')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }

    getCanvasArticleVente();

    function getCanvasArticleVente() {
        var page = $('#canvas_page_dashbord').val();
        if (page != undefined) {
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    getCanvasMontantByArticle: 1
                },
                dataType: 'JSON',
                success: function (vente) {
                    // var vente = JSON.parse(data);
                    const total = vente.map(function (val) {
                        return val.total;
                    })
                    const article = vente.map(function (val) {

                        return val.article;
                    })
                    // console.table(article);
                    articleVenteMontantCanvas(article, total)
                }
            });
        }
    }

    function loading(selector, status, message) {
        $(selector).html(message);
        $(selector).attr('disabled', status);
    }

    function articleVenteMontantCanvas(article, total) {
        const colors = randColors(article.length)
        var data = {
            type: 'pie',
            data: {
                datasets: [{
                    data: total,
                    //   borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    //   backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    backgroundColor: colors,
                    label: 'Dataset 1'
                }],
                labels: article
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Montant total par article'
                }
            } // init chart pie

        };
        var canvas = $('#canvas_article_vente')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }

    // pieChart4()
    function pieChart4() {
        var data = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [554, 687, 391, 745, 932],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Pie Chart'
                }
            } // init chart pie

        };
        var canvas = $('#canvas_pie4')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }

    //   probleme zone //////******************* */

    // doughnutChart1()
    function doughnutChart1() {
        var data = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [554, 687, 391, 745, 932],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            } // init chart doughnut

        };
        var canvas = $('#canvas_dog1')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }


    // doughnutChart2()
    function doughnutChart2() {
        var data = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [554, 687, 391, 745, 932],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            } // init chart doughnut

        };
        var canvas = $('#canvas_dog2')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }

    // doughnutChart3()
    function doughnutChart3() {
        var data = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [554, 687, 391, 745, 932],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            } // init chart doughnut

        };
        var canvas = $('#canvas_dog3')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }


    // doughnutChart4()
    function doughnutChart4() {
        var data = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [554, 687, 391, 745, 932],
                    borderColor: ['#db8412', '#47a01d', '#626fdd', '#ba62dd', '#6d0303'],
                    backgroundColor: [Looper.colors.brand.red, Looper.colors.brand.purple, Looper.colors.brand.yellow, Looper.colors.brand.teal, Looper.colors.brand.indigo],
                    label: 'Dataset 1'
                }],
                labels: ['Red', 'Purple', 'Yellow', 'Green', 'Blue']
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            } // init chart doughnut

        };
        var canvas = $('#canvas_dog4')[0].getContext('2d');
        var chart = new Chart(canvas, data);
    }


    // no probleme 3

    function initGlobalLoader(loaderSelector = '#globalLoader') {
        // S'assure que le loader est à la fin du body
        if (!$(loaderSelector).parent().is('body')) {
            $(loaderSelector).appendTo('body');
        }

        $(document).ajaxStart(function () {
            $(loaderSelector).removeClass('hidden');
        });

        $(document).ajaxStop(function () {
            $(loaderSelector).addClass('hidden');
        });
    }

    function showLoader(options) {
        const settings = $.extend({
            target: 'global', // 'global' ou sélecteur (#btnSave)
            action: 'show' // 'show' ou 'hide'
        }, options);

        if (settings.target === 'global') {
            if (settings.action === 'show') {
                $('#globalLoader').removeClass('hidden');
            } else {
                $('#globalLoader').addClass('hidden');
            }
        } else {
            const btn = $(settings.target);
            if (settings.action === 'show') {
                btn.addClass('loading-btn').prop('disabled', true);
            } else {
                btn.removeClass('loading-btn').prop('disabled', false);
            }
        }
    }

    // Initialiser le loader global une fois
    $(document).ready(function () {
        initGlobalLoader();
    });


    // showLoader({ target: '#btnSave', action: 'show' }); // Exemple d'utilisation pour afficher le loader sur un bouton spécifique
    // showLoader({ target: '#btnSave', action: 'hide' }); // Exemple d'utilisation pour masquer le loader sur un bouton spécifique

    get_fournisseur_info();

    function get_fournisseur_info() {
        $('body').delegate('.fournisseur-link', 'click', function (e) {
            e.preventDefault();
            var fournisseurId = $(this).data('id');

            // Ouvre le modal
            $('#fournisseurModal').modal('show');
            $('#fournisseurContent').html('<p class="text-center">Chargement...</p>');

            // Requête AJAX pour récupérer les infos
            $.ajax({
                url: "../partials/rooter.php", // ton endpoint PHP
                method: "POST",
                data: {
                    id_fournisseur: fournisseurId,
                    btn_get_fournisseur: 1
                },
                dataType: 'html',
                success: function (data) {
                    $('#fournisseurContent').html(data);
                },
                error: function () {
                    $('#fournisseurContent').html('<p class="text-danger text-center">Erreur lors du chargement</p>');
                }
            });
        });
    }



    initDateRangeFilterAchat("datefilterAchatArticle", 2);
    initDateRangeFilterAchat("datefilterAchat", 1);

    initDateRangeFilterVente("datefilterVenteByARticle", 2);
    initDateRangeFilterVente("datefilterVente", 1);

    function initDateRangeFilterAchat(selector, type) {
        $('input[name="' + selector + '"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="' + selector + '"]').on('apply.daterangepicker', function (ev, picker) {
            let dateDebut = picker.startDate.format('YYYY-MM-DD');
            let dateFin = picker.endDate.format('YYYY-MM-DD');
            let dateD = picker.startDate.format('DD-MM-YYYY');
            let dateF = picker.endDate.format('DD-MM-YYYY');
            $(this).val(dateD + ' - ' + dateF);
            // Appeler la fonction de recherche avec les dates sélectionnées
            $('#activityDateRange').text("Activité du " + dateD + ' au ' + dateF);
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    dateDebut: dateDebut,
                    dateFin: dateFin,
                    btn_filter_achat: type
                },
                success: function (data) {
                    // console.log(data);return
                    
                    let res = JSON.parse(data);


                    $('#nb_achats').text(res.total_article);
                    $('#total_montant').text(money(res.montant_total_achat));
                    $(".achat-table").html(res.output);

                }
            });
        });

        $('input[name="' + selector + '"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    }

    // no probleme 2
    function initDateRangeFilterVente(selector, type) {
        $('input[name="' + selector + '"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="' + selector + '"]').on('apply.daterangepicker', function (ev, picker) {
            let dateDebut = picker.startDate.format('YYYY-MM-DD');
            let dateFin = picker.endDate.format('YYYY-MM-DD');
            let dateD = picker.startDate.format('DD-MM-YYYY');
            let dateF = picker.endDate.format('DD-MM-YYYY');
            $(this).val(dateD + ' - ' + dateF);
            // Appeler la fonction de recherche avec les dates sélectionnées
            $('#activityDateRange').text("Activité du " + dateD + ' au ' + dateF);
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    dateDebut: dateDebut,
                    dateFin: dateFin,
                    btn_filter_vente: type
                },
                success: function (data) {
                    console.log(data);
                    
                    let res = JSON.parse(data);


                    $('#nb_ventes').text(res.total_vente);
                    $('#total_montant').text(res.mont_vente + " FCFA");
                    $(".vente-table").html(res.output);

                }
            });
        });

        $('input[name="' + selector + '"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    }

    $('.search_depense').select2();

   function liste_depense() {
        $.ajax({
            url: "../partials/rooter.php",
            method: "POST",
            data: {
                btn_liste_depense: 1
            },
            success: function (data) {
                console.log(data);
                
                $('.depense-table').html(data);
            }
        });
    }

    btn_ajouter_depense();

    function btn_ajouter_depense() {
        $('body').delegate('#btn_ajouter_depense', 'submit', function (e) {
            e.preventDefault();

            var depense = $(this).serialize();

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: depense,
                dataType:"JSON",
                success: function (data) {
                    // console.log(data);return
                    
                    if (data.code == 200) {
                        $.notify(data.message, 'success');
                        // liste_depense();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                        //  $("#btn_ajouter_depense")[0].reset()
                        // resetForm();
                        $('#depense-modal').modal('hide');
                        
                    } else {
                        $.notify(data.message);
                    }

                }
            });

        });
    }

    btn_update_depense();

    function btn_update_depense() {
        $('body').delegate('.btn_update_depense', 'click', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    id_depense: id,
                    frm_updepense: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    // console.log(data);return
                    if (data.success) {
                        
                        $(".menu-modal").html(data.html);
                        $("#depense-modal").modal('show');
                    }else{
                        $.notify('Erreur lors de la récupération des données', 'error');
                    }
                }
            });
        });
    }

    // btn_suprimer_depense();

    // function btn_suprimer_depense() {
    //     $('body').delegate('.btn_remove_depense', 'click', function (e) {
    //         e.preventDefault();
    //         var id = $(this).data('id');
    //         swal({
    //             title: "Etes vous sure",
    //             text: "de vouloir supprimer cet element ?",
    //             icon: "warning",
    //             buttons: ['Non', 'Oui'],
    //             dangerMode: true,
    //         }).then((a) => {
    //             if (a) {

    //                 $.ajax({
    //                     url: "../partials/rooter.php",
    //                     method: "POST",
    //                     data: {
    //                         id_depense: id,
    //                         btn_supprimer_depense: 1
    //                     },
    //                     dataType: 'JSON',
    //                     success: function (data) {


    //                         $('.row' + id).remove();
    //                         swal("Notification", "Element supprimé avec succès", "success")
    //                             .then(function () {
    //                                 history.go(0);
    //                             });
    //                     }
    //                 });
    //             }
    //         })
    //     });
    // }

    initDateRangeFilterDepense(date_start_picker,date_end_picker);

    function initDateRangeFilterDepense(startDate, endDate) {
        
        $('#datefilterDepense').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            autoUpdateInput: true,
            locale: {
                // format: 'YYYY-MM-DD',
                format: 'DD-MM-YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('#datefilterDepense').on('apply.daterangepicker', function (ev, picker) {
            let dateDebut = picker.startDate.format('YYYY-MM-DD 00:00:00');
            let dateFin = picker.endDate.format('YYYY-MM-DD 23:59:59');
            let dateD = picker.startDate.format('DD-MM-YYYY');
            let dateF = picker.endDate.format('DD-MM-YYYY');
            $(this).val(dateD + ' - ' + dateF);
            // Appeler la fonction de recherche avec les dates sélectionnées
            $('#activityDateRange').text("Activité du " + dateD + ' au ' + dateF);

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    dateDebut: dateDebut,
                    dateFin: dateFin,
                    btn_filter_depense: 1
                },
                dataType: "JSON",
                success: function (data) {
                    console.log(data);

                    // $('#montant_depense_approuve').text("008888000");
                    $('#montant_depense_approuve').text(data.depense_approuve.montant_depense_approuve);
                    $('#nombre_depense_approuve').text(data.depense_approuve.nombre_depense_approuve);

                     $('#montant_depense_en_attente').text(data.depense_en_attente.montant_depense_en_attente);
                    $('#nombre_depense_en_attente').text(data.depense_en_attente.nombre_depense_en_attente);

                     $('#montant_depense_annule').text(data.depense_annule.montant_depense_annule);
                    $('#nombre_depense_annule').text(data.depense_annule.nombre_depense_annule);


                }
            });
        });

        $('#datefilterDepense').on('cancel.daterangepicker', function (ev, picker) {
            // $(this).val('');
        });

    }


    filterInventaire();

    function filterInventaire() {
        $('#filterInventaire').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#filterInventaire').on('apply.daterangepicker', function (ev, picker) {
            let dateDebut = picker.startDate.format('YYYY-MM-DD');
            let dateFin = picker.endDate.format('YYYY-MM-DD');
            let dateD = picker.startDate.format('DD-MM-YYYY');
            let dateF = picker.endDate.format('DD-MM-YYYY');
            $(this).val(dateD + ' - ' + dateF);
            // Appeler la fonction de recherche avec les dates sélectionnées
            $('#activityDateRange').text("Activité du " + dateD + ' au ' + dateF);

            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    dateDebut: dateDebut,
                    dateFin: dateFin,
                    btn_filter_inventaire: 1
                },
                dataType: "JSON",
                success: function (data) {
                    let res = data;

                    // console.log('res', res);return
                    $("#total_caisse").addClass(res.type)
                    $('#total_achat').text(res.achat_mois);
                    $('#total_depense').text(res.depenses_mois);
                    $('#total_vente').text(res.vente_mois);
                    $("#total_caisse").text(res.benefice);

                }
            });
        });

        $('#filterInventaire').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    }


   


    filterDashboardAdmin(date_start_picker, date_end_picker, dashboardAdmin);

    function filterDashboardAdmin(startDate, endDate, dashboardAdmin) {
        // console.log(start,end);

        // let date_start = moment().startOf('month'); // 1er du mois
        // let date_end = moment(); // aujourd’hui
        $('#filterDashboardAdmin').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            autoUpdateInput: true,
            locale: {
                // format: 'YYYY-MM-DD',
                format: 'DD-MM-YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('#filterDashboardAdmin').on('apply.daterangepicker', function (ev, picker) {
            let dateDebut = picker.startDate.format('YYYY-MM-DD');
            let dateFin = picker.endDate.format('YYYY-MM-DD');
            let dateD = picker.startDate.format('DD-MM-YYYY');
            let dateF = picker.endDate.format('DD-MM-YYYY');
            $(this).val(dateD + ' - ' + dateF);
            // Appeler la fonction de recherche avec les dates sélectionnées
            $('#activityDateRange').text("Activité du " + dateD + ' au ' + dateF);
            dashboardAdmin(dateDebut, dateFin)


        });

        $('#filterDashboardAdmin').on('cancel.daterangepicker', function (ev, picker) {
            // $(this).val('');
        });

}

    // }
});



function retour() {
    window.history.back();
}

function updateELement(btn_action,code) {
    let btn = btn_action.id;
    swal({
            title: "Etes vous sure",
            text: "de vouloir effectuer cette opération?",
            icon: "warning",
            buttons: ['Non', 'Oui'],
            dangerMode: true,
        }).then((a) => {
            if (a) {

                $.ajax({
                    url: "../partials/rooter.php",
                    method: "POST",
                    data: {
                        code: code,
                        btn_action: btn
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        
                        if (data.success) {
                            swal("Notification", data.msg, "success")
                            .then(function () {
                                history.go(0);
                            });
                        }else{
                            swal("Notification", data.msg, "error");
                            // .then(function () {
                            //     history.go(0);
                            // });
                        }

                        
                    }
                });
            }
    });
}

// =====================================================
// ============== GESTION DES DEPENSES ================
// =====================================================
function updateELementDepense(btn_action,code) {
    let btn = btn_action.id;
    swal({
            title: "Etes vous sure",
            text: "de vouloir effectuer cette opération?",
            icon: "warning",
            buttons: ['Non', 'Oui'],
            dangerMode: true,
        }).then((a) => {
            
            if (a) {
                $.ajax({
                    url: "../partials/rooter.php",
                    method: "POST",
                    data: {
                        id: code,
                        btn_action: btn
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        
                        if (data.success) {
                            $.notify(data.msg, "success")
                            setTimeout(function() {
                                history.go(0);
                            }, 2000);
                        }else{
                            $.notify(data.msg, "error");
                        }

                        
                    }
                });
            }
    });
}

    form_encaisser_vente();

    function form_encaisser_vente() {
        $('body').on('submit', '#form_encaisser_vente', function (e) {
            e.preventDefault();
            
            let data = $(this).serialize();
            
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    // console.log(data);return;
                    
                    if(data.status) {

                        swal("Notification", data.message, "success");
                        $("#encaisser-modal").modal('hide');
                    }else{
                        swal("Notification", data.message, "error");
                    }
                    
                }
            });
        });
    }
form_encaisser_achat();
    function form_encaisser_achat() {

        $('body').on('submit', '#form_encaisser_achat', function (e) {
            e.preventDefault();

            let data = $(this).serialize();
            
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    // console.log(data);return;
                    
                     if(data.status) {

                        swal("Notification", data.message, "success");
                        $("#encaisser-modal").modal('hide');
                    }else{
                        swal("Notification", data.message, "error");
                    }
                }
            });
        });
    }
    // modal_encaisser("#btn_encaisser_achat","#code_achat")
// modal_encaisser("#btn_encaisser_vente", "#code_vente")
    
// function modal_encaisser(selector,code_select) {    
//     $(document).on('click', selector, function () {
//         let code = $(this).data('code');
       
//         // injecter dans le champ hidden
//         $(code_select).val(code);

//         console.log(code); // pour vérifier
//     });
// }

modalEncaissementVente(".btn_encaisser_vente")

function modalEncaissementVente(selector) {    
    $(document).on('click', selector, function () {
        let code = $(this).data('code');
        let reste_a_payer = $(this).data('reste_a_payer');
        if(reste_a_payer <= 0) {
            swal("Notification", "Le reste à payer est déjà à zéro", "error");
            return;
        }
         $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    code: code,
                    reste_a_payer:reste_a_payer,
                    frm_encaissement: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    
                    $(".menu-modal-encaissement").html(data);
                    $("#encaisser-modal").modal('show');
                }
            });
    });
}

modalEncaissementAchat(".btn_encaisser_achat")

function modalEncaissementAchat(selector) {    
    $(document).on('click', selector, function () {
        let code = $(this).data('code');
        let reste_a_payer = $(this).data('reste_a_payer');
        if(reste_a_payer <= 0) {
            swal("Notification", "Le reste à payer est déjà à zéro", "error");
            return;
        }
         $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: {
                    code: code,
                    reste_a_payer:reste_a_payer,
                    frm_encaissement_achat: 1
                },
                dataType: 'JSON',
                success: function (data) {
                    
                    
                    $(".menu-modal-encaissement").html(data);
                    $("#encaisser-modal").modal('show');
                }
            });
    });
}


    btn_update_taxe();

    function btn_update_taxe() {
        $('body').delegate('.form_taxe', 'submit', function (e) {
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if(data.success) {
                        $.notify(data.message, "success");
                    }else{
                        $.notify(data.message, "error");
                    }
                }
            });
        });
    }
    calculReste('#montant_total_vente', '#montant_recu_vente', '#reste_a_payer_vente');
    calculReste('#montant_total_achat', '#montant_recu_achat', '#reste_a_payer_achat');
function calculReste(montantTotalSelector, montantRecuSelector, resteSelector) {

    $('body').on('input', montantRecuSelector, function() {

        let total = parseFloat($(montantTotalSelector).val()) || 0;
        let recu = parseFloat($(this).val()) || 0;

        let reste = total - recu;

        // éviter négatif
        if (reste < 0) {
            reste = 0;
        }

        $(resteSelector).val(reste);
    });
}

calculAfterRemise();
function calculAfterRemise() {

    $('body').on('input', '#montant_remise', function() {


        let total_ht = parseFloat($(".mtt").val()) || 0;
        let remise = parseFloat($("#montant_remise").val()) || 0;
// console.log(total_ht , remise);return

        // sécurité
        if (remise > total_ht) {
            remise = total_ht;
            $(".remise-input input").val(total_ht);
        }


        let reste = total_ht - remise;

        // éviter négatif
        if (reste < 0) {
            reste = 0;
        }

        $("#total_apres_remise").text(reste);
        $(".montant_total_ttc").text(reste);
        $("#total_ttc_hidden").val(reste);

    });
}

calculAfterEncaisse();
function calculAfterEncaisse() {

    $('body').on('input', '#montant_encaisse', function() {


        let total_ht = parseFloat($("#total_ttc_hidden").val()) || 0;
        let encaisse = parseFloat($("#montant_encaisse").val()) || 0;
console.log(total_ht, encaisse);

        let reliquat = total_ht - encaisse;

        $("#reliquat").val(reliquat);




$("#reliquat").val(reliquat);

// reset classes
$("#reliquat").removeClass("reliquat-ok reliquat-warning reliquat-danger");

// conditions
if (reliquat > 0) {
    $("#reliquat").addClass("reliquat-warning"); // reste à payer
}
else if (reliquat < 0) {
    $("#reliquat").addClass("reliquat-danger"); // trop payé
}
else {
    $("#reliquat").addClass("reliquat-ok"); // exact
}


    });
}
activeEntrepot();
function activeEntrepot() {  
$(document).on("click", ".entrepot-item", function(e) {
    e.preventDefault(); // bloque le reload

    // console.log('tttttt');::!
    
    let id = $(this).data("id");
            $.ajax({
                url: "../partials/rooter.php",
                method: "POST",
                data: { set_entrepot: 1, id_entrepot: id },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    // return;
                    if (data.success) {
                        swal({
                            title: "Notification",
                            text: data.message,
                            icon: "success"
                        }).then((a) => { 
                            history.go(0);
                        });
                    }else{
                        $.notify(data.message, "error");
                    }
                }
            });
});
}

// $(document).on("click", ".entrepot-item", function() {

//     let id = $(this).data("id");

//     // enlever ancien badge
//     $(".badge-active").remove();

//     // ajouter sur le nouveau
//     $(this).append('<span class="badge-active"></span>');
// });