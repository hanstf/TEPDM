<head>
    <meta charset="utf-8">
    <title>TEPDM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="style/custom.css">
    <link href="img/favicon.ico" rel="icon" type="image/x-icon">
</head>
<body>
<form action="" method="POST">
<nav class="navbar navbar-default navbar navbar-fixed-top navbar-longer">
  <div class="container-fluid">
      <div class="navbar-header">
          <a class="navbar-brand" href="#"><img class="img-small" alt="Brand" src="img/logo.png"></a>
      </div>
       
       
       <div class="menu-contain">
            <ul class="nav navbar-nav">
                <li class="<?php if ($curPage==='matchTrx'){echo 'active';}?>"><a href="main.php">Match Trx </a></li>
        <li class="<?php if ($curPage==='searchPBB'){echo 'active';}?>"><a href="search.php">Search PBB</a></li>
           </ul>
       </div>
          
       
       <div class="navbar-right">
           <p class="navbar-text"> <?php
        echo 'Welcome, '.getUserDetails('user_name').'';
                 ?></p>   
    <button class="btn btn-default navbar-btn logout-btn" type="submit" name="logout">Logout</button>
       </div>
  </div>
</nav>