let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
   inputNumber.oninput = () =>{
      if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
   };
});





// homepage filter
  document.addEventListener("DOMContentLoaded", function() {
    var filterOptions = document.querySelectorAll(".hfilter");
    var filterActive = document.querySelector(".hfilter-active");

    filterOptions.forEach(function(option) {
      option.addEventListener("click", function() {
        var filterValue = option.getAttribute("data-filter");

        filterOptions.forEach(function(option) {
          option.classList.remove("active");
        });

        option.classList.add("active");

        filterActive.style.transition = "transform 0.3s ease-out, width 0.3s ease-out";
        filterActive.style.transform = `translate(${option.offsetLeft}px, 0px)`;
        filterActive.style.width = `${option.offsetWidth}px`;
      });
    });
  });



// recipes page filter


document.addEventListener("DOMContentLoaded", function() {
  var filterOptions = document.querySelectorAll(".filter");
  var filterActive = document.querySelector(".filter-active");
  var recipesCards = document.querySelectorAll(".recipes_card");

  filterOptions.forEach(function(option) {
    option.addEventListener("click", function() {
      var filterValue = option.getAttribute("data-filter");

      filterOptions.forEach(function(option) {
        option.classList.remove("active");
      });

      option.classList.add("active");

      filterActive.style.transform = `translate(${option.offsetLeft}px, 0px)`;
      filterActive.style.width = `${option.offsetWidth}px`;

      recipesCards.forEach(function(card) {
        card.style.display = "none";

        if (filterValue === ".all" || card.classList.contains(filterValue.slice(1))) {
          card.style.display = "block";
        }
      });
    });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  var filtersContainer = document.querySelector(".filters");
  var containerWidth = filtersContainer.parentElement.offsetWidth;
  var scrollStep = 300; // Scroll one container width at a time
  var scrollDuration = 400; // Duration of scroll animation (in milliseconds)
  var scrollTimeout;

  function scrollContainer(scrollAmount) {
    filtersContainer.scrollTo({
      left: scrollAmount,
      behavior: "smooth"
    });
  }

  function scrollToLeft() {
    var scrollAmount = Math.max(filtersContainer.scrollLeft - scrollStep, 0);
    scrollContainer(scrollAmount);
    scrollTimeout = setTimeout(scrollToLeft, scrollDuration);
  }

  function scrollToRight() {
    var scrollAmount = Math.min(filtersContainer.scrollLeft + scrollStep, filtersContainer.scrollWidth - containerWidth);
    scrollContainer(scrollAmount);
    scrollTimeout = setTimeout(scrollToRight, scrollDuration);
  }

  document.getElementById("left").addEventListener("mousedown", scrollToLeft);
  document.getElementById("right").addEventListener("mousedown", scrollToRight);
  document.addEventListener("mouseup", function() {
    clearTimeout(scrollTimeout);
  });
});



  const tabsBox = document.querySelector(".filter_menu ");
  arrowIcons = document.querySelector(".icon i")

  let isDragging = false;

  arrowIcons.forEach(icon =>{
    icon.addEventListener("click", ()=>{
      tabsBox.scrollLeft += icon.id === "left" ? -350 : 350;
    })
  })
        const dragging = (e) => {
          if(!isDragging) return;
          tabsBox.classList.add("dragging")
          tabsBox.scrollLeft -= e.movementX;
        }
  const dragStop = () => {
    isDragging = false
    tabsBox.classList.remove("dragging");
  }      
    tabsBox.addEventlistner("mousedown", () => isDragging = true);
    tabsBox.addEventlistner("mousemove", dragging);
    tabsBox.addEventlistner("mouseup", dragStop);



    document.querySelector("#show-form").addEventListner("click",function(){
      document.querySelector(".update_form").classList.add("active");
      });
   
      document.querySelector(".update_form .close-btn").addEventListner("click",function(){
      document.querySelector(".update_form").classList.remove("active");
       });
