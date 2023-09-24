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

 $('[data-toggle="tooltip"]').tooltip();

 function openCloseMenu()
  {
    localStorage.setItem('collapseMenuAppBox', !$('body').hasClass('sidebar-collapse') ? 'close': 'open');
  }

  function fixRenderEditor()
  {
    $('.wysihtml5-toolbar').each((index, element) =>
    {
      $($(element).find(' > li:nth-child(3)').find('span')[0]).attr('class','glyphicon glyphicon-gbp');
      $($(element).find(' > li:nth-child(2)').find('a')[0]).css('font-weight','bold');
      $($(element).find(' > li:nth-child(2)').find('a')[1]).css('font-style','italic');
      $($(element).find(' > li:nth-child(2)').find('a')[2]).css('text-decoration','underline');
    });
  }

  var _globalFunction=
  {
    clickLink: function(url)
    {
      $('#modalLoading').show();

      window.location.href=url;
    }
  }
