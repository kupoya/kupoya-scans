<script type="text/javascript">
//window.onload =  (function () {
$(document).ready(function() {
      var windowHeight = window.innerHeight;
      var windowWidth = window.innerWidth;
      
      var img = $("#logo > img");
      var imgWidth = img.css("width");
      var imgHeight = img.css("height");
      if ((windowHeight - 300) < imgHeight) {
      }
      else {
          $('#logo').css('height', ((windowHeight - 300)/windowHeight *100)+'%');
      }
  });
</script>