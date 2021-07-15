$(".header").click(function () {
    var $this = $(this);
    $this.closest(".whole").find(".content").slideToggle();
  });
  
  $(".whole").on("click", "a", function () {
    event.preventDefault();
    $(".plan").removeClass("selected");
    $(this).closest(".whole").find(".plan").addClass("selected");
  });
  