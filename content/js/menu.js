(function($){
  $(function() {
    $('.menu__icon').on('click', function() {
      $(this).closest('.b-menu')
        .toggleClass('menu_state_open');
    });

    $('.menu__links-item').on('click', function() {
      // do something

      $(this).closest('.b-menu')
        .removeClass('menu_state_open');
    });
  });
})(jQuery);
