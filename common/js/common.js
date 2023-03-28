$(document).ready(function () {
  // nav-link
  const widtScreen = window.innerWidth;
  let topMenu = 250;
  if (widtScreen < 968) {
    topMenu = 100;
  }

  $(".js-toggle-navi").click(function () {
    $(".header").toggleClass("on-nav");
    $("body").toggleClass("overflow-hidden");
  });

  $(window).scroll(function () {
    if ($(this).scrollTop()) {
      $(".backtotop").fadeIn();
      $(".header").addClass("fixed");
    } else {
      $(".backtotop").fadeOut();
      $(".header").removeClass("fixed");
    }
  });

  $('.js-loaddetail').click(function(event) {
      let idPost = $(this).data('id');
      $('.loader').addClass('active');
      $.ajax({
          type : "post",
          dataType : "html",
          async: false,
          url : '/wp-admin/admin-ajax.php',
          data : {
              action: "idPost",
              idPost: idPost
          },
          success: function(response) {
              if(response){
                  setTimeout(function(){
                      let idModal = $('#modal_detail');
                      idModal.addClass('modal-on').find('.modal-content').empty();
                      idModal.addClass('modal-on').find('.modal-content').html(response);
                      $('body').addClass('overflow-hidden');
                      setTimeout(function(){
                          idModal.addClass('modal-fade');
                          $('.loader').removeClass('active');
                      },200); 
                  },1000)
              }
          },
          error: function( jqXHR, textStatus, errorThrown ){
              console.log( 'The following error occured: ' + textStatus, errorThrown );
          }
      });
  });
  $(document).on('click', '.modal-overlay, .modal .close', function(){
      let idModal = $(this).parents('.modal');
      idModal.removeClass('modal-fade');
      setTimeout(function(){
          idModal.removeClass('modal-on');
          $('body').removeClass('overflow-hidden');
      },300);
  });
});
