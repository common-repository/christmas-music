/* Range */
function updateInputRangeProgress(el) {
  if (el instanceof Element)
    var el = el;
  else
    var el = el.target;

  var min = +el.min,
      max = +el.max,
      value = +el.value;

  el.style.background = 'linear-gradient(to right, #FD517A 0%, #FD517A ' + (value-min)/(max-min)*100 + '%, #555555 ' + (value-min)/(max-min)*100 + '%, #555555 100%)';
}

var range = document.querySelector('.christmas-music-range-setting');
updateInputRangeProgress(range);
range.addEventListener('input', function(){
  updateInputRangeProgress(this);
  document.querySelector('.christmas-music-volume-value span').innerHTML = this.value;
});
/* -- Range -- */