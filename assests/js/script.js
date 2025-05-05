ScrollReveal({
    //reset:true,
    distance:'80px',
    duration:2000,
    delay:200
});

ScrollReveal().reveal('.hero h1,.heading,.card-item',{origin:'top'});
ScrollReveal().reveal('.home-img,.myskill-container,.portfolio-box,.contact form, .team-card-item',{origin:'bottom'});
ScrollReveal().reveal(' .about ,.about-img,.box2 .card',{origin:'left'});
ScrollReveal().reveal('.logo h1,.about p,.about-content h2,.about-content h3,.about-content p,.about-content .heading,.title',{origin:'right'});




var scrollToTopBtn = document.querySelector(".scrollToTopBtn")
var rootElement = document.documentElement

function handleScroll() {
  // Do something on scroll - 0.15 is the percentage the page has to scroll before the button appears
  // This can be changed - experiment
  var scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
  if ((rootElement.scrollTop / scrollTotal ) > 0.15) {
    // Show button
    scrollToTopBtn.classList.add("showBtn")
  } else {
    // Hide button
    scrollToTopBtn.classList.remove("showBtn")
  }
}

function scrollToTop() {
  // Scroll to top logic
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}
scrollToTopBtn.addEventListener("click", scrollToTop)
document.addEventListener("scroll", handleScroll)

