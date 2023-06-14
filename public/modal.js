

$(document).ready(function() {
  var theHREF;

  $('#dialog-confirm').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-body p').text('Etes-vous sûr de vouloir supprimer cet élément ?');
    modal.find('#confirm-yes').click(function() {
      modal.modal('hide');
      window.setTimeout(function(){
        window.location.href = theHREF;
      }, 100);
    });
  });

  $("a.confirmModal").click(function(e) {
    e.preventDefault();
    theHREF = $(this).attr("href");
    $('#dialog-confirm').modal('show');
  });
});




//Possibilité d'évolution : TODO
//Non supprésion de la facture si elle a - de 5 ans (pour archiver)
//Correction modal.js
//Bloquer le stock qui sort de la bdd sur la facture pour empécher le négatif
//Réduire les 3 deletes a 1 seul avec $table
//Mettre des images de vélos, fond d'écran animé, etc
// Creer un input autosearch par name client pour trouver uniquement les factures qui lui appartienne
//Facture en pdf bien sur