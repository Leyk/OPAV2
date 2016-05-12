    
    <footer>
      <div class="row">
        <div class="large-12 columns">
          <h1 class="logo">Forces<span>Vives</span></h1>
        </div>
      </div>
    </footer>
    <script>
      $(document).foundation();

      $(function() {

        $('header .logo').animate({ letterSpacing: '10px' }, 500);
        setTimeout(function() { $('header .logo').removeAttr("style"); }, 1000);

      });      
    </script>
</html>