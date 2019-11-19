<?php define('VER', '1.7.2');
  if(!file_exists('config.nogit.php')){ session_start(); session_destroy(); die(header('Location: installation/?v='.VER)); }
  require_once('resources/server/libraries.php');
  if($config['version'] != VER) {
    require_once('installation/installation.php');
    confupdater($config, VER);
    die(header("Refresh:0"));
  }
  session_start();

  /* Set username session for non-authme system */
  if(empty($_SESSION['username']) && $config['am']['enabled'] == false){ $_SESSION['username'] = 'SkinSystemUser'; }
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>R3D MC | Giriş</title>
    <!-- Libraries -->
    <link rel="shortcut icon" type="image png" href="../images/logo.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="../ionicons/css/ionicons.min.css">
    <link rel="stylesheet" text="text/css" href="../css/my-login.css">
    <?php if (isset($_COOKIE['theme']) and is_file('resources/themes/'.$_COOKIE['theme'].'.css')) { $theme = $_COOKIE['theme']; }
    else { $theme = $config['def_theme']; }
    echo '<link id="stylesheetSelector" rel="stylesheet" name="'.$theme.'" href="resources/themes/'.$theme.'.css">'; 
    // pick theme from cookie; if cookie invalid, pick default theme from config ?>
    <script type="text/javascript">
      function setCookie(cname, cvalue) {
        var d = new Date(); d.setTime(d.getTime() + (365*24*60*60*1000)); // cookies will last a year
        document.cookie = cname + "=" + cvalue + ";expires="+ d.toUTCString() + ";path=/";
      } 
      var theme = document.getElementById("stylesheetSelector").getAttribute("name");
      setCookie("theme", theme); // swap that stale cookie for a new one!
      function rotateTheme() { // move a metaphorical carousel by one item
        $.getJSON("resources/themes/",{}, function(lst){ 
          setCookie("theme", lst[((lst.indexOf(theme+".css")+1)%lst.length)].slice(0, -4));
          location.reload();
        });
      }
      var l = {};
      l.uplty1_lbl = "<?php echo L::upl_uplty1_lbl; ?>";
    </script>
    <?php foreach ([
      'https://code.jquery.com/jquery-3.3.1.min.js' => 'f8da8f95b6ed33542a88af19028e18ae3d9ce25350a06bfc3fbf433ed2b38fefa5e639cddfdac703fc6caa7f3313d974b92a3168276b3a016ceb28f27db0714a',
      'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js' => 'f43dfd388488b509a66879608c35d7c1155f93dcec33ca875082f59f35552740d65e9a344a044d7ec534f0278a6bb6f0ed81047f73dcf615f7dcd76e0a482009',
      'https://cdnjs.cloudflare.com/ajax/libs/three.js/94/three.min.js' => '64681777a4c1e6a8edbd353a439a3f2c9338a702cdcbc53c5d7261faf2590d7a76c02f004ab97858e7a2bdaab67e961cdd39d308bcf20ef56363c621bcd61a5e',
      'https://raw.githubusercontent.com/InventivetalentDev/MineRender/v1.1.0/dist/skin.min.js' => '5acd05d47d28928779a88a13126a396fc1a57cda55fb82180db9e69dba009ad466156e1ca75562026c2ebcdf195adcfc178c78602468eafe3303b726706447b0',
      'https://cdn.jsdelivr.net/npm/sweetalert2@8.8.5' => '2d90ae300e9e37ef219afa3c50f2261e220f83424a83d30286d53492becce0ea6f1dc1749b0cd47eec37c6a008f877b79e40ab48638efd1462f4aeff2a288c96'
    ] as $url => $sha512){
      $expl = explode('/', $url);
      echo '<script src="'.cacheGrab($url, end($expl), './', false, ['sha512', $sha512]).'"></script>';
    } ?>
  </head>
  <body class="my-login-page">
    <!-- Main Container -->
    <section class="h-100" >
      <div class="container h-100">
	<div class="row justify-content-start">
	<div class="col-4">
	<a href="../index.php"><button type="button" name="back-to-page" class="btn btn-primary" style="margin-top:35px;"><i class="ion-chevron-left"></i>    Anasayfaya Dön</button></a>
	</div>
	</div>
        <div class="row h-100">
          <div class="col-lg-<?php echo(!empty($_SESSION['username']) ? 8 : 6); ?> m-auto">
            <div class="card border-0 shadow">
              <div class="card-header text-white" style="background-color:#ff0027">
                <div class="row mx-2 align-items-center">
			<div>
				Bir hesabın yok mu ? <a href="../authme/register.php" style="color:#ffffff">Oluşturmak için tıkla!</a>
			</div>
                  </h5>
                  <h6 class="mb-0 ml-auto">
                    <?php if($config['am']['enabled'] == true && !empty($_SESSION['username'])){ 
                      $SkullURL = 'resources/server/skinRender.php?vr=0&hr=0&headOnly=true&ratio=4&user='.$_SESSION['username'];
                      echo '<a class="skinDownload" id="skinDownloadUrl" title="'.L::mn_dlhov.'" name="'.$_SESSION['username'].'" href="resources/server/skinRender.php?format=raw&dl=true&user='.$_SESSION['username'].
                      '"><img class="skinDownload" style="max-height:29px!important;" src="'.$SkullURL.'">    '.htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></a>
                      <a class="btn btn-sm btn-light ml-2 rounded-circle" title="<?php echo L::mn_lgout;?>" href="resources/server/authenCore.php?logout"><i class="fas fa-sign-out-alt"></i></a>
                    <?php } ?>
                  </h6>
                </div>
              </div>
              <div class="card-body">
                <?php if(!empty($_SESSION['username'])){ ?>
                  <script src="resources/js/skinCore.js"></script>
                  <div class="row">
                    <!-- Uploader -->
                    <div class="col-lg-8 pr-lg-2 mb-lg-0 mb-3">
                      <div class="card border-0 shadow">
                        <h6 class="card-header bg-info text-white"><i class="fas fa-file-upload text-dark"></i> <?php echo L::upl_title;?></h6>
                        <div class="card-body">
                          <form id="uploadSkinForm">
                            <?php if($config['am']['enabled'] == false){ ?>
                              <div class="form-group row">
                                <h5 class="col-lg-3"><span class="badge badge-success"><?php echo L::upl_usrnm;?></span></h5>
                                <div class="col-lg-9">
                                  <input id="input-username" class="form-control form-control-sm" name="username" type="text" required>
                                </div>
                              </div>
                            <?php } ?>
                            <div class="form-group">
                              <h5 class="mb-0 mr-3 custom-control-inline"><span class="badge badge-info"><?php echo L::upl_sknty;?></</span></h5>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input id="skintype-steve" class="custom-control-input" name="isSlim" value="false" type="radio">
                                <label class="custom-control-label" for="skintype-steve"><?php echo L::upl_sknty1;?></label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input id="skintype-alex" class="custom-control-input" name="isSlim" value="true" type="radio">
                                <label class="custom-control-label" for="skintype-alex"><?php echo L::upl_sknty2;?></label>
                              </div>
                            </div>
                            <div class="form-group mb-4">
                              <h5 class="mb-0 mr-3 custom-control-inline"><span class="badge badge-info"><?php echo L::upl_uplty;?></span></h5>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input id="uploadtype-file" class="custom-control-input" name="uploadtype" value="file" type="radio" checked>
                                <label class="custom-control-label" for="uploadtype-file"><?php echo L::upl_uplty1;?></label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input id="uploadtype-url" class="custom-control-input" name="uploadtype" value="url" type="radio">
                                <label class="custom-control-label" for="uploadtype-url"><?php echo L::upl_uplty2;?></label>
                              </div>
                            </div>
                            <div id="form-input-file" class="form-group">
                              <div class="custom-file">
                                <input id="input-file" class="custom-file-input" name="file" type="file" accept="image/*" required>
                                <label class="custom-file-label text-truncate"><?php echo L::upl_uplty1_lbl;?></label>
                              </div>
                            </div>
                            <div id="form-input-url" class="form-group row" style="display: none;">
                              <div class="col-lg-12">
                                <input id="input-url" class="form-control form-control-sm" name="url" type="text" placeholder="<?php echo L::upl_uplty2_lbl;?>">
                              </div>
                            </div>
                            <button class="btn btn-primary w-100"><strong><?php echo L::upl_buttn;?></strong></button>
			    
                            <small class="form-text text-muted" id="uploadDisclaimer"<?php 
                              if ($config['data_warn'] === 'no' or ($config['data_warn'] === 'eu' and file_get_contents(cacheGrab('https://ipapi.co/'.IP.'/in_eu', 'in_eu-'.IP)) !== 'True')) {
                                echo ' style="display: none;"';
                              }
                            ?>><?php echo str_replace("%h%", $_SERVER['HTTP_HOST'], L::mn_discl);?></small>
                          </form>
                        </div>
                      </div>
                    </div>
                    <!-- Skin Viewer -->
                    <div class="col-lg-4">
                      <div class="card border-0 shadow">
                        <h6 class="card-header bg-info text-white"><i class="fas fa-eye text-dark"></i> Önizleme</h6>
                        <div class="card-body">
                          <div id="skinViewerContainer"></div>
                          <script type="text/javascript">
                            window.onresize = function () { // skinViewer height shall match uploadSkin
                              document.getElementById('skinViewerContainer').style.height = document.getElementById('uploadSkinForm').clientHeight+'px'; }
                            window.onresize();
                          </script>
                        </div>
                      </div>
                    </div>
                    <?php if(false){ ?>
                      <!-- Skin History -->
                      <div class="col-lg-12 mt-3">
                        <div class="card border-0 shadow">
                          <h6 class="card-header bg-info text-white"><i class="fas fa-history text-dark"></i> <?php echo L::mn_hstry;?></h6>
                          <div class="card-body">
                            <a id="mineskin-recent" href="<?php echo cacheGrab('https://api.mineskin.org/get/list/0?size=6','mineskin-recent','./',(10*60)); ?>" style="display:none;"></a>
                            <div class="row" id="skinlist"></div>
                            <script type="text/javascript">
                              setCookie('skinHistoryType', 'mineskin');
                              function getCookie(cname) {
                                var value = "; " + document.cookie;
                                var parts = value.split("; " + cname + "=");
                                if (parts.length == 2) return parts.pop().split(";").shift();
                              }
                              var historytype = getCookie('skinHistoryType');
                              if (historytype == 'personal') {
                                
                              } else if (historytype == 'server') {
                                
                              } else if (historytype == 'mineskin') {
                                $.getJSON($('#mineskin-recent')[0].href,{}, function( lst ){ 
                                  $.each( lst.skins.slice(0,6), function( key, val ) {
                                    skinid = val.url.match(/\w+$/);
                                    $('#skinlist').append('<div class="col-2 skinlist-mineskin"><img class="skinlistitem" style="max-width:75px;width:inherit;cursor:pointer;" title="'+
                                      ('Select skin '+val.name).trim()+'" onclick="skinURL(\'resources/server/skinRender.php?format=raw&mojang='+skinid+'\');" src="resources/server/skinRender.php?mojang='+skinid+'"></div>');
                                  });
                                });
                              }
                              function skinURL(url) {
                                $('#uploadtype-url').prop('checked', true).change();
                                $('#input-url').val(url);
                              }
                            </script>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                <?php } else { ?>
                  <script src="resources/js/authenCore.js"></script>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card border-0 shadow">
                        <h6 class="card-header text-white" style="background-color:#ff0027"><i class="fas fa-sign-in-alt"></i> <?php echo L::auth_title;?></h6>
                        <div class="card-body">
                          <form id="loginForm">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                              <input id="login-username" class="form-control" name="username" type="text" placeholder="<?php echo L::auth_usrnm;?>" required>
                            </div>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                              <input id="login-password" class="form-control" name="password" type="password" placeholder="<?php echo L::auth_psswd;?>" required>
                            </div>
                            <button class="btn w-100" style="background-color:#94000c;color:white"><?php echo L::auth_login;?></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
