<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Fakebook</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Mon Mur<span class="sr-only">(current)</span></a></li>
        <li><a href="#">Profil<span class="sr-only"></span></a></li>
      </ul>
  		<div class="nav navbar-nav navbar-right">
  			<button class="btn btn-danger" onClick="logout()">Déconnexion</button>
  		</div>
    </div>
  </div>
</nav>



<?php 
  /*if(isset($context->message))*/ echo $context->message;
?>

<script type="text/javascript">
  function logout()
  {
    $.ajax({
      type:'POST',
      url:'Afakebook.php?action=logout',
      cache:'false',
      succces: function(returnHtml) {
      }, 
    })
    window.location.replace("fakebook.php");
  }
</script>
