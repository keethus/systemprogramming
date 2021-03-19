$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 20) {
            $('.navbar').addClass('sticky');
        } else {
            $('.navbar').removeClass('sticky');
        }
    })
});

$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 110) {
            $('.text-1').addClass('hidden');
        } else {
            $('.text-1').removeClass('hidden');
        }
    })
});
$(document).ready(function(){
  $(window).scroll(function(){
      if(this.scrollY > 110) {
          $('.projects-title').addClass('hidden');
      } else {
          $('.projects-title').removeClass('hidden');
      }
  })
});

$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 90) {
            $('.homeline').addClass('hidden');
        } else {
            $('.homeline').removeClass('hidden');
        }
    })
});

$(document).ready(function(){
    $(window).scroll(function(){
        if(this.scrollY > 60) {
            $('.under-text').addClass('hidden');
        } else {
            $('.under-text').removeClass('hidden');
        }
    })
});

$(document).ready(function(){
  $(window).scroll(function(){
      if(this.scrollY > 50) {
          $('.social').addClass('hidden');
      } else {
          $('.social').removeClass('hidden');
      }
  })
});

// Typewriter Effect
const TypeWriter = function(txtElement, words, wait = 3000) {
  this.txtElement = txtElement;
  this.words = words;
  this.txt = '';
  this.wordIndex = 0;
  this.wait = parseInt(wait, 10);
  this.type();
  this.isDeleting = false;

}

// Type Method
TypeWriter.prototype.type = function () {
  // Current index of word
  const current = this.wordIndex % this.words.length;

  // Get full text of current word
  const fullTxt = this.words[current];

  // Check if deleting
  if(this.isDeleting) {
    // Remove char
    this.txt = fullTxt.substring(0, this.txt.length - 1);
  } else {
    // Add char
    this.txt = fullTxt.substring(0, this.txt.length + 1);
  }

  // Insert txt into element
  this.txtElement.innerHTML = `<span class="txt">${this.txt}</span>`

  // Initial Type Speed
  let typeSpeed = 150;

  if(this.isDeleting) {
    typeSpeed /= 1.5;
  }

  // Check if word is complete.
  if(!this.isDeleting && this.txt === fullTxt) {
    // Make pause at end
    typeSpeed = this.wait;
    // Set delete to true
    this.isDeleting = true;
  } else if(this.isDeleting && this.txt == '') {
    this.isDeleting = false;
    // Move to next word
    this.wordIndex++;
    // Pause before typing
    typeSpeed = 500;
  }

  setTimeout(() => this.type(), typeSpeed);
}

// Init on DOM load
document.addEventListener('DOMContentLoaded', init);

// Init App
function init() {
  const txtElement = document.querySelector('.txt-type');
  const words = JSON.parse(txtElement.getAttribute('data-words'));
  const wait = txtElement.getAttribute('data-wait');
  
  // Init TypeWriter
  new TypeWriter(txtElement, words, wait);

}

// Background Parallax.
(function(){

    var parallax = document.querySelectorAll(".home"),
        speed = 0.3;
  
    window.onscroll = function(){
      [].slice.call(parallax).forEach(function(el,i){
  
        var windowYOffset = window.pageYOffset,
            elBackgrounPos = "50% " + (-windowYOffset * speed) + "px";
  
        el.style.backgroundPosition = elBackgrounPos;
  
      });
    };
  
})();
(function(){

  var parallax = document.querySelectorAll(".projects-header"),
      speed = 0.3;

  window.onscroll = function(){
    [].slice.call(parallax).forEach(function(el,i){

      var windowYOffset = window.pageYOffset,
          elBackgrounPos = "50% " + (-windowYOffset * speed) + "px";

      el.style.backgroundPosition = elBackgrounPos;

    });
  };

})();
