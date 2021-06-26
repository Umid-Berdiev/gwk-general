document.addEventListener("DOMContentLoaded", () => {
  let wrapped = document.getElementById("wrapped");
  if (wrapped)
    wrapped.addEventListener("scroll", function () {
      let translate = `translate(0, ${this.scrollTop}px)`;
      this.querySelector("thead").style.transform = translate;
      this.querySelector("thead").style.zIndex = 2;
    });
});
