'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const allElements = document.querySelectorAll('*');
    allElements.forEach(element => {
        if (element.tagName.toLowerCase() !== 'th' || element.tagName.toLowerCase() !== 'td') {
            const style = window.getComputedStyle(element);
            const fontSize = style.getPropertyValue('font-size');
            const fontSizeNumber = parseFloat(fontSize);
            const newFontSize = fontSizeNumber + 1;

            element.style.fontSize = `${newFontSize}px`;
        }
    });
});

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
