document.addEventListener('DOMContentLoaded', function () {
  var xmasMusicAudio = document.createElement('audio'),
      xmasMusicCurrentTime = Cookies.get('xmasMusicProCurrentTime') || 0.0,
      xmasMusicPaused = Cookies.get('xmasMusicProPaused') || '',
      playerClasses = [],
      playerButtonClasses = [];

  /**
   * Audio settings
   */

  // Set audio current time
  xmasMusicAudio.currentTime = xmasMusicCurrentTime;

  // Enable audio loop
  xmasMusicAudio.setAttribute('loop', 'loop');

  // Audio file
  xmasMusicAudio.setAttribute('src', xmasMusicSettings.audioFileUrl);

  // Volume
  xmasMusicAudio.volume = xmasMusicSettings.volume / 100;

  // Autoplay
  if (xmasMusicSettings.autoplay && !xmasMusicPaused) {
    var promise = xmasMusicAudio.play();

    if (promise !== undefined) {
      promise.then(_ => {
        // Autoplay started!
      }).catch(error => {
        // Autoplay was prevented.
        if ( xmasMusicSettings.enableTooltip && !Cookies.get('xmasMusicProTooltipClosed') ) {
          document.querySelector('.xmas-music-tooltip-wrapper').classList.add('tooltip-visible');
        }
      });
    }
  }

  // Player position
  if (xmasMusicSettings.position) {
    playerClasses.push('xmas-' + xmasMusicSettings.position);
  }

  // Player style
  if (xmasMusicSettings.style) {
    playerButtonClasses.push('xmas-' + xmasMusicSettings.style);
  }

  // Enable player animation
  if (xmasMusicSettings.animation) {
    playerButtonClasses.push('xmas-animation');

    var head = document.head || document.getElementsByTagName('head')[0],
        styleTag = document.createElement('style'),
        color = xmasMusicSettings.buttonBackground;

    var css = `
              #xmas-music-player.xmas-animation {
                box-shadow: 0 0 0 0 rgba(${hexToRgb(color).r}, ${hexToRgb(color).g}, ${hexToRgb(color).b}, 1);
              }
              @keyframes xmas-pulse {
                0% {
                  transform: scale(0.95);
                  box-shadow: 0 0 0 0 rgba(${hexToRgb(color).r}, ${hexToRgb(color).g}, ${hexToRgb(color).b}, 0.7);
                }
                
                70% {
                  transform: scale(1);
                  box-shadow: 0 0 0 10px rgba(${hexToRgb(color).r}, ${hexToRgb(color).g}, ${hexToRgb(color).b}, 0);
                }
                
                100% {
                  transform: scale(0.95);
                  box-shadow: 0 0 0 0 rgba(${hexToRgb(color).r}, ${hexToRgb(color).g}, ${hexToRgb(color).b}, 0);
                }
              }`;

    styleTag.appendChild(document.createTextNode(css));
    head.appendChild(styleTag);
  }

  /**
   * Audio events
   */
  xmasMusicAudio.addEventListener('playing', function () {
    document.getElementById('xmas-music-button').classList.add('plays');
    Cookies.set('xmasMusicProPaused', '');
  });

  xmasMusicAudio.addEventListener('pause', function () {
    document.getElementById('xmas-music-button').classList.remove('plays');
  });

  window.addEventListener('beforeunload', function () {
    Cookies.set('xmasMusicProCurrentTime', xmasMusicAudio.currentTime);
  });

  /**
   * Player markup
   */
  playerClasses = playerClasses.join(' ');
  playerButtonClasses = playerButtonClasses.join(' ');

  document.body.insertAdjacentHTML(
    'beforeend',
    `<div id="xmas-music-player" class="${playerClasses}">
      <div class="xmas-music-tooltip-wrapper">
        <div class="xmas-music-tooltip"></div>
        <button class="xmas-music-tooltip-close" type="button"></button>
      </div>
      <button id="xmas-music-button" class="${playerButtonClasses}" style="background: ${xmasMusicSettings.buttonBackground};" type="button">
        <span style="border-left-color: ${xmasMusicSettings.iconColor};"></span>
      </button>
     </div>`
  );

  /**
   * Player events
   */
  document.addEventListener('click', function (e) {
    var el = e.target;

    // Click on play/pause button
    if (el.id == 'xmas-music-button' || el.parentNode.id == 'xmas-music-button') {
      if (xmasMusicAudio.paused == false) {
        xmasMusicAudio.pause();
        Cookies.set('xmasMusicProPaused', 'true');
      } else {
        xmasMusicAudio.play();
      }

    // Click on tooltip content
    } else if (el.classList.contains('xmas-music-tooltip')) {
      xmasMusicAudio.play();
      document.querySelector('.xmas-music-tooltip-wrapper').classList.remove('tooltip-visible');
    
    // Click on tooltip close button
    } else if (el.classList.contains('xmas-music-tooltip-close')) {
      document.querySelector('.xmas-music-tooltip-wrapper').classList.remove('tooltip-visible');
      Cookies.set('xmasMusicProTooltipClosed', 'true');
    }
  });

  /**
   * Document events
   */
  document.addEventListener('visibilitychange', function() {
    if (document.visibilityState == 'visible') {
      xmasMusicAudio.currentTime = Cookies.get('xmasMusicProCurrentTime') || 0.0;
      if (!Cookies.get('xmasMusicProPaused')) {
        xmasMusicAudio.play();
      }
    } else {
      xmasMusicAudio.pause();
      Cookies.set('xmasMusicProCurrentTime', xmasMusicAudio.currentTime);
    }
  });

  /**
   * Helper functions
   */
  function hexToRgb(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
      return r + r + g + g + b + b;
    });
  
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
  }
});
