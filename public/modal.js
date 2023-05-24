

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
