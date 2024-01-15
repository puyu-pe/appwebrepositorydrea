'use strict';

 $(function()
 {
    $('body').on('keypress', function (e) {
      if (e.key === 'Enter' || e.keyCode === 13)
      {
        e.preventDefault();
      }
    });

    if(localStorage.getItem('collapseMenuAppBox')=='close')
    {
      $('body').addClass('sidebar-collapse');
    }

 });

 function openCloseMenu()
  {
    localStorage.setItem('collapseMenuAppBox', !$('body').hasClass('sidebar-collapse') ? 'close': 'open');
  }

 var _globalFunction=
  {
    clickLink: function(url)
    {
      $('#modalLoading').show();

      window.location.href=url;
    }
  }
